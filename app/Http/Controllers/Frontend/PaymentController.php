<?php

namespace App\Http\Controllers\Frontend;

use App\Events\OrderPaymentUpdateEvent;
use App\Events\OrderPlacedNotificationEvent;
use App\Http\Controllers\Controller;
use App\Services\orderService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\Checkout\Session  as StripeSession;
use Stripe\Service\Climate\OrderService as ClimateOrderService;

class PaymentController extends Controller
{
    function index(): View
    {
        if (!session()->has('delivery_fee') || !session()->has('address')) {
            throw ValidationException::withMessages(['Something Went Wrong']);
        }
        $subTotal = cartTotal();
        $delivery = session()->get('delivery_fee') ?? 0;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $grandTotal = grandCartTotal($delivery);
        return view('frontend.pages.payment', compact(
            'subTotal',
            'delivery',
            'discount',
            'grandTotal'
        ));
    }
    public function makePayment(Request $request, orderService $orderServices)
    {
        try {
            $request->validate([
                'payment_gateway' => ['required', 'string', 'in:paypal,stripe,jazzcash']
            ]);

            if ($orderServices->CreateOrder()) {
                switch ($request->payment_gateway) {
                    case 'paypal':
                        return response()->json([
                            'redirect_url' => route('paypal.payment')
                        ]);
                        break;
                          case 'stripe':
                        return response()->json([
                            'redirect_url' => route('stripe.payment')
                        ]);
                        break;
                          case 'jazzcash':
                         return response()->json([
                            'redirect_url' => route('jazzcash.payment')
                       ]);

                    default:
                        return response()->json([
                            'error' => 'Invalid Payment Gateway'
                        ], 400);
                }
            }

            return response()->json([
                'error' => 'Order failed'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Exception occurred',
                'message' => $e->getMessage() // 👈 helpful for debugging
            ], 500);
        }
    }


    function paymentSuccess(): View
    {
        return view('frontend.pages.payment-success');
    }

    function paymentCancel(): View
    {
        return view('frontend.pages.payment-cancel');
    }


    function setPaypalConfigure(): array
    {
        $config = [
            'mode'    => config('paymentSettings.paypal_account_mode'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => config('paymentSettings.paypal_api_key'),
                'client_secret'     => config('paymentSettings.paypal_secret_key'),
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => config('paymentSettings.paypal_api_key'),
                'client_secret'     => config('paymentSettings.paypal_secret_key'),
                'app_id'            => config('paymentSettings.paypal_app_id'),
            ],

            'payment_action' =>  'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => config('paymentSettings.paypal_currency_name'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
            'locale'         =>  'en_US', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => true, // Validate SSL when creating api client.
        ];
        return $config;
    }
    function payWithPaypal()
    {

        $config = $this->setPaypalConfigure();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        //calculate payable amount with paypal currency//

        $grandTotal = session()->get('grand_total');
        $payableAmount = round($grandTotal * config('paymentSettings.paypal_rate'));

        $response = $provider->createOrder([
            'intent' => "CAPTURE",
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel')
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('paymentSettings.paypal_currency_name'),
                        'value' =>  $payableAmount
                    ]
                ]

            ]

        ]);
        if (isset($response['id']) && $response != Null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('payment.cancel')->withErrors(['error' => $response['error']['message']]);
        }
    }
    function paypalSuccess(Request $request,orderService $orderService)
    {
        $config = $this->setPaypalConfigure();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        // dd($response);
        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $orderId = session()->get('order_id');
            $capture = $response['purchase_units'][0]['payments']['captures'][0];
            $paymentInfo = [
                'transection_id' => $capture['id'],
                'currency' => $capture['amount']['currency_code'],
                'status' => $capture['status']
            ];

            OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'PayPal');
            OrderPlacedNotificationEvent::dispatch($orderId);
            $orderService->clearSession();
            return redirect()->route('payment.success');
        } else {
              $this->transectionFailUpdateStatus('Paypal');

            return redirect()->route('payment.cancel')->withErrors(['error' => $response['error']['message']]);
        }
    }
    function paypalCancel()
    {
       $this->transectionFailUpdateStatus('Paypal');
        return redirect()->route('payment.cancel');
    }

    //stripe payment//

    function payWithStripe()  {

        Stripe::setApiKey(config('paymentSettings.stripe_secret_key'));
        //   dd("hello");

           //calculate payable amount with stripe currency//

        $grandTotal = session()->get('grand_total');
        $payableAmount = round($grandTotal * config('paymentSettings.stripe_rate')) * 100;


        $response = StripeSession::create([
            'line_items' => [
             [
                   'price_data' => [
                    'currency' => config('paymentSettings.stripe_currency_name'),
                    'product_data' => [
                        'name' => 'Product',
                    ],
                    'unit_amount' => $payableAmount
                ],
                'quantity' => 1
               ]
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel')

        ]);
      return redirect()->away($response->url);
    }

    function stripeSuccess(Request $request,orderService $orderService) {
        // dd($request->all());
       $sessionId = $request->session_id;
       Stripe::setApiKey(config('paymentSettings.stripe_secret_key'));
       $response = StripeSession::retrieve($sessionId);

       if($response-> payment_status === 'paid'){
        $orderId = session()->get('order_id');
        $paymentInfo = [
            'transection_id' => $response->payment_intent,
            'currency' => $response->currency,
            'status' => $response->status
        ];

           OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'Stripe');
            OrderPlacedNotificationEvent::dispatch($orderId);
            $orderService->clearSession();
            return redirect()->route('payment.success');

       }else{
        $this->transectionFailUpdateStatus('Stripe');
        return redirect()->route('payment.cancel');
       }

    }
        function stripeCancel() {
          $this->transectionFailUpdateStatus('Stripe');
        return redirect()->route('payment.cancel');
    }
    function transectionFailUpdateStatus($gatewayName) : void {

         $orderId = session()->get('order_id');
        $paymentInfo = [
            'transection_id' => '',
            'currency' => '',
            'status' => "Failed"
        ];

           OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, $gatewayName);
    }



public function payWithJazzcash(orderService $orderService)
    {
        $orderId = session()->get('order_id');
        $order = \App\Models\Order::findOrFail($orderId);

        $txnRefNumber = 'T' . time(); // keep <= ~20 chars ideally
        // Ensure amount is in paisa integer: (e.g. 43.94 PKR => 4394)
        $ppAmount = number_format($order->grand_total * 100, 0, '', '');

        $DateTime 		= new \DateTime();
		$pp_TxnDateTime = $DateTime->format('YmdHis');
		//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN

		//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
		//3.
		//to make expiry date and time add one hour to current date and time
		$ExpiryDateTime = $DateTime;
		$ExpiryDateTime->modify('+' . 1 . ' hours');
		$pp_TxnExpiryDateTime = $ExpiryDateTime->format('YmdHis');
		//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN





        $data = [
            "pp_Version"           => "2.0",
            "pp_TxnType"           => "MPAY", // use MPAY for card payments
            "pp_Language"          => "EN",
            "pp_MerchantID"        => config('jazzcash.merchant_id'),
            "pp_Password"          => config('jazzcash.password'),
            "pp_TxnRefNo"          => $txnRefNumber,
            "pp_Amount"            => $ppAmount,
            "pp_TxnCurrency"       => "PKR",
            "pp_TxnDateTime"       => $pp_TxnDateTime,
            "pp_TxnExpiryDateTime" => $pp_TxnExpiryDateTime,
            "pp_BillReference"     => "order_" . $order->id,
            "pp_Description"       => "FoodPark Order #{$order->id}",
            "pp_ReturnURL"         => config('jazzcash.return_url'),
            "pp_SecureHashType"    => "SHA256",
             "pp_IsRegisteredCustomer" => "No",
            // optional add customer fields: pp_CustomerEmail, pp_CustomerMobile, ppmpf_1...
        ];

        // generate & attach secure hash
        $data['pp_SecureHash'] = $this->generateHash($data);

        // optionally log request being sent
        \Log::info('JazzCash Request Data: ', $data);
        // dd($data);
        return view('frontend.pages.jazzcash_redirect', ['data' => $data]);
    }
     private function generateHash(array $data)
    {
    //     // Password ko hash se exclude karna hai
        unset($data['pp_Password']);

        ksort($data);

        $hashString = config('jazzcash.integerity_salt') . '&';

        foreach ($data as $key => $value) {
            if (!empty($value)) {
                $hashString .= $value . '&';
            }
        }

        $hashString = rtrim($hashString, '&');

        // return hash_hmac('sha256', $hashString, config('jazzcash.integrity_salt'));
        return strtoupper(hash_hmac('sha256', $hashString, config('jazzcash.integerity_salt')));

    }



public function jazzcashResponse(Request $request)
{
    $response = $request->all();

    // Debugging ke liye log aur print
    \Log::info('JazzCash Response:', $response);
    echo '<pre>';
    print_r($response);
    echo '</pre>';

    if ($response['pp_ResponseCode'] == '000') {
        $response['pp_ResponseMessage'] = 'Your Payment has been Successful';

        // ✅ Order fetch from session
        $orderId = session()->get('order_id');
        $order = \App\Models\Order::findOrFail($orderId);

        // ✅ Order status update
        $order->status = 'completed';
        $order->txn_ref_no = $response['pp_TxnRefNo'] ?? null; // agar chaho to save kar sakte ho
        $order->save();
    } else {
        $response['pp_ResponseMessage'] = 'Payment Failed: ' . ($response['pp_ResponseMessage'] ?? 'Unknown Error');
    }

    return view('payment-status', ['response' => $response]);
}






    public function jazzcashSuccess(): View
    {
        return view('frontend.pages.payment-success');
    }

    public function jazzcashCancel(): View
    {
        return view('frontend.pages.payment-cancel');
    }

    // helper used earlier in conversation (keep as you already have)
    // public function transectionFailUpdateStatus($gatewayName): void
    // {
    //     $orderId = session()->get('order_id');
    //     $paymentInfo = [
    //         'transection_id' => '',
    //         'currency' => '',
    //         'status' => "Failed"
    //     ];
    //     OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, $gatewayName);
    // }



}
