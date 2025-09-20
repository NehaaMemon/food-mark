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
// use Stripe\Service\Climate\OrderService as ClimateOrderService; // This line seems unused and might be from a typo

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
                'status' => 'completed'
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
            'status' => 'completed'
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

    /**
     * Updates the order status to failed and dispatches an event if order_id is available.
     * @param string $gatewayName The name of the payment gateway.
     * @return void
     */
    function transectionFailUpdateStatus($gatewayName) : void {

        $orderId = session()->get('order_id');

        if (!$orderId) {
            \Log::warning('Payment: Order ID not found in session for transaction failure update.', ['gateway' => $gatewayName]);
            // If orderId is not present, we cannot update a specific order.
            // You might want to log this more severely or notify an admin.
            return; // Exit the function gracefully
        }

        $paymentInfo = [
            'transection_id' => '',
            'currency' => '',
            'status' => "Failed"
        ];

        \Log::info('Payment: Dispatching failure update for Order ID.', ['order_id' => $orderId, 'gateway' => $gatewayName]);
        OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, $gatewayName);
    }




// ========================== //
// JazzCash Flow
// ========================== //

public function payWithJazzcash(orderService $orderService)
{
    \Log::info('JazzCash: Initiating payWithJazzcash function.');

    $orderId = session()->get('order_id');
    if (!$orderId) {
        \Log::error('JazzCash: Order ID not found in session.');
        throw ValidationException::withMessages(['Order ID not found for JazzCash payment.']);
    }

    $order = \App\Models\Order::findOrFail($orderId);
    \Log::info('JazzCash: Fetched order details for payment.', ['order_id' => $order->id, 'grand_total' => $order->grand_total]);

    $txnRefNumber = 'T' . time() . rand(1000, 9999);
    $ppAmount = (string)intval(round($order->grand_total * 100)); // Ensure integer string

    $DateTime = new \DateTime();
    $pp_TxnDateTime = $DateTime->format('YmdHis');
    $ExpiryDateTime = clone $DateTime;
    $ExpiryDateTime->modify('+1 hours');
    $pp_TxnExpiryDateTime = $ExpiryDateTime->format('YmdHis');

    $data = [
        "pp_Version"           => "2.0",
        "pp_TxnType"           => "MPAY",
        "pp_Language"          => "EN",
        "pp_MerchantID"        => config('jazzcash.merchant_id'),
        "pp_Password"          => config('jazzcash.password'),
        "pp_TxnRefNo"          => $txnRefNumber,
        "pp_Amount"            => $ppAmount,
        "pp_TxnCurrency"       => "PKR",
        "pp_TxnDateTime"       => $pp_TxnDateTime,
        "pp_TxnExpiryDateTime" => $pp_TxnExpiryDateTime,
        "pp_BillReference"     => "order_" . $order->id,
        "pp_Description"       => "Order #{$order->id}",
        "pp_ReturnURL"         => config('jazzcash.return_url'),
        "pp_SecureHashType"    => "SHA256",
        "pp_IsRegisteredCustomer" => "No",
    ];

    // Log the raw data before hash
    \Log::info('JazzCash: Data array prepared before hash generation:', $data);

    $data['pp_SecureHash'] = $this->generateHash($data);

    // Log the final data sent to JazzCash
    \Log::info('JazzCash: Final data array with SecureHash for redirect:', $data);

    // Extra debug: log the form action URL
    $formAction = config('jazzcash.environment') === 'sandbox' ? config('jazzcash.sandbox_url') : config('jazzcash.live_url');
    \Log::info('JazzCash: Form action URL for POST:', ['form_action' => $formAction]);

    return view('frontend.pages.jazzcash_redirect', ['data' => $data]);
}

private function generateHash(array $data)
{
    $password = config('jazzcash.password');
    $integerity_salt = config('jazzcash.integerity_salt');

    // JazzCash required field order for hash string (excluding pp_Password)
    $fields = [
        "pp_Version",
        "pp_TxnType",
        "pp_Language",
        "pp_MerchantID",
        // "pp_Password", // Exclude from hash string
        "pp_TxnRefNo",
        "pp_Amount",
        "pp_TxnCurrency",
        "pp_TxnDateTime",
        "pp_TxnExpiryDateTime",
        "pp_BillReference",
        "pp_Description",
        "pp_ReturnURL",
        "pp_SecureHashType",
        "pp_IsRegisteredCustomer"
    ];

    $hashString = '';
    foreach ($fields as $field) {
        if (!empty($data[$field])) {
            $hashString .= $data[$field] . '&';
        }
    }
    $hashString = rtrim($hashString, '&');
    $hashStringWithSalt = $integerity_salt . '&' . $hashString;

    \Log::info('JazzCash Hash: Ordered hash string before final Hmac:', ['hashStringForHmac' => $hashStringWithSalt]);

    $finalHash = hash_hmac('sha256', $hashStringWithSalt, $password);
    \Log::info('JazzCash Hash: Final generated SecureHash:', ['hash' => $finalHash]);

    return $finalHash;
}


public function jazzcashResponse(Request $request, orderService $orderService)
{
    $response = $request->all();
    \Log::info('JazzCash Response: Received callback from JazzCash.', $response); // Debugging line (existing)

    $orderId = session()->get('order_id');
    if (!$orderId) {
        \Log::error('JazzCash Response: Order ID not found in session for response processing.'); // Debugging line
        // Handle this case, perhaps redirect to a generic error or home page.
        $this->transectionFailUpdateStatus('JazzCash'); // Call to updated function
        return redirect()->route('payment.cancel')->withErrors(['error' => 'Order ID session lost during JazzCash response.']);
    }

    \Log::info('JazzCash Response: Processing response for Order ID.', ['order_id' => $orderId, 'pp_ResponseCode' => $response['pp_ResponseCode'] ?? 'N/A']); // Debugging line

    // Verify SecureHash if required by JazzCash documentation for response validation
    // This is a critical step for security to ensure the response hasn't been tampered with.
    // You might need to generate hash from the received $response data and compare it with pp_SecureHash.
    // For debugging the blank page, we'll focus on the request to JazzCash first.

    if (isset($response['pp_ResponseCode']) && $response['pp_ResponseCode'] == '000') {
        $paymentInfo = [
            'transection_id' => $response['pp_TxnRefNo'] ?? null,
            'currency' => $response['pp_TxnCurrency'] ?? 'PKR',
            'status' => 'Completed'
        ];

        OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'JazzCash');
        OrderPlacedNotificationEvent::dispatch($orderId);
        $orderService->clearSession();

        \Log::info('JazzCash Response: Payment successful for Order ID.', ['order_id' => $orderId, 'transection_id' => $paymentInfo['transection_id']]); // Debugging line
        return redirect()->route('payment.success');
    } else {
        $errorMessage = $response['pp_ResponseMessage'] ?? 'Payment Failed (Unknown JazzCash error)';
        $this->transectionFailUpdateStatus('JazzCash'); // Call to updated function
        \Log::error('JazzCash Response: Payment failed for Order ID.', ['order_id' => $orderId, 'response' => $response, 'error_message' => $errorMessage]); // Debugging line

        return redirect()->route('payment.cancel')->withErrors(['error' => $errorMessage]);
    }
}

public function jazzcashSuccess(): View
{
    return view('frontend.pages.payment-success');
}

public function jazzcashCancel(): View
{
    return view('frontend.pages.payment-cancel');
}

}
