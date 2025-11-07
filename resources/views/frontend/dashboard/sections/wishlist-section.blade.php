  <div class="tab-pane fade " id="v-pills-messages2" role="tabpanel"
                        aria-labelledby="v-pills-messages-tab2">
    <div class="fp_dashboard_body">
        <h3>Wishlist</h3>
        <div class="fp_dashboard_order">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr class="t_header">
                            <th>No</th>
                            <th style="width: 40%">Product</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($wishlist as $item)
                        <tr>
                            <td>
                                <h5>{{ ++$loop->index }}</h5>
                            </td>

                            <td style="width: 40%">
                                <p>{{ $item->product->name}}</p>
                            </td>
                            <td>
                                @if ($item->product->quantity > 0)
                                    <h5 class="text-success">In Stock</h5>
                                @else
                                 <h5 class="text-danger">Out of Stock</h5>
                                @endif

                            </td>
                             <td>
                               <a href="{{ 'product.show',$item->product->slug }}" class="view_invoice">View Product</a>
                            </td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($orders as $order)

        <div class="fp__invoice invoiceDetails{{ $order->id }}">
            <a class="go_back d-print-none"><i class="fas fa-long-arrow-alt-left"></i> go back</a>
            <div class="fp__track_order d-print-none">
                <ul>
                    @if ($order->order_status === 'declined')
                    <li  class=

                    "declined_status {{ in_array($order->order_status,['declined']) ? 'active' : '' }}"
                    >Order Declined</li>
                    @else
                    <li class=
                    "{{ in_array($order->order_status,['pending','in_process','delivered','declined']) ? 'active' : '' }}">
                    Order Pending</li>
                    <li class=
                    "{{ in_array($order->order_status,['in_process','delivered','declined']) ? 'active' : '' }}">
                    Order In Process</li>
                     <li class=
                    "{{ in_array($order->order_status,['delivered']) ? 'active' : '' }}"
                    >Order Delivered</li>
                    @endif
                    {{-- <li>Declined</li> --}}

                </ul>
            </div>
            <div class="fp__invoice_header">
                <div class="header_address">
                    <h4>invoice to</h4>
                    <p>{{ @$order->userAddress->first_name }}</p>
                    <p>{{ @$order->address }}</p>
                    <p>{{ @$order->userAddress->phone }}</p>
                     <p>{{ @$order->userAddress->email }}</p>
                </div>
                <div class="header_address">
                    <p><b style="width: 140px">invoice no: </b><span>{{ @$order->invoice_id }}</span></p>
                    <p><b style="width: 140px">Payment Status:</b> <span> {{ @$order->payment_status }}</span></p>
                    <p><b style="width: 140px">Payment Method:</b> <span>  {{ @$order->payment_method}}</span></p>
                    <p><b style="width: 140px">Transaction Id:</b> <span>  {{ @$order->transection_id ? $order->transection_id : 'N/A'}}</span></p>
                    <p><b style="width: 140px">date:</b> <span>{{ date('d-m-y', strtotime($order->created_at)) }}</span></p>
                </div>
            </div>
            <div class="fp__invoice_body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr class="border_none">
                                <th class="sl_no">SL</th>
                                <th class="package">item description</th>
                                <th class="price">Price</th>
                                <th class="qnty">Quantity</th>
                                <th class="total">Total</th>
                            </tr>

                            @foreach ($order->orderItems as $item)
                            @php
                            $size = json_decode($item->product_size);
                            $option = json_decode($item->product_option);


                            $proqty = $item->qty;
                            $proPrice = $item->unit_price;
                            $proSize = $size->price ?? 0;
                            $proOption = 0;
                            foreach ($option as $optionItem) {
                                $proOption += $optionItem->price;
                            }
                            $prototal = ($proPrice + $proSize + $proOption) * $proqty;
                            @endphp
                            <tr>
                                <td class="sl_no">{{ ++$loop->index }}</td>
                                <td class="package">
                                    <p>{{ @$item->product_name }}</p>
                                    <span class="size">{{ @$size->name}} - {{ @$size->price
                                    ?  currencyPosition(@$size->price) : '' }}|</span>
                                    @foreach ($option as $options)

                                    <span class="coca_cola">{{ @$options->name }}  - {{ @$options->price ? currencyPosition(@$options->price) : '' }}</span>
                                    @endforeach

                                </td>
                                <td class="price">
                                    <b>{{ currencyPosition($item->unit_price) }}</b>
                                </td>
                                <td class="qnty">
                                    <b>{{ $item->qty }}</b>
                                </td>
                                <td class="total">
                                    <b>{{ currencyPosition($prototal) }}</b>
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="package" colspan="3">
                                    <b>sub total</b>
                                </td>
                                <td class="qnty">
                                    <b>-</b>
                                </td>
                                <td class="total">
                                    <b>{{ currencyPosition($prototal) }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="package coupon" colspan="3">
                                    <b>(-) Discount coupon</b>
                                </td>
                                <td class="qnty">
                                    <b></b>
                                </td>
                                <td class="total coupon">
                                    <b>{{ currencyPosition($order->discount) }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="package coast" colspan="3">
                                    <b>(+) Shipping Cost</b>
                                </td>
                                <td class="qnty">
                                    <b></b>
                                </td>
                                <td class="total coast">
                                    <b>{{ currencyPosition($order->delivery_charge) }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="package" colspan="3">
                                    <b>Total Paid</b>
                                </td>
                                <td class="qnty">
                                    <b></b>
                                </td>
                                <td class="total">
                                    <b>{{ currencyPosition($order->grand_total) }}</b>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <a class="print_btn common_btn d-print-none" href="javascript:;" onclick="printInvoice('{{ $order->id }}')"><i class="far fa-print"></i> print
                PDF</a>

        </div>
        @endforeach

    </div>
</div>


@push('scripts')
<script>
        function viewInvoice(id){
            $(".fp_dashboard_order").fadeOut();
             $(".invoiceDetails" + id).fadeIn();
        }

        function printInvoice(id){
            let printContent = $('.invoiceDetails'+id).html();

            let printWindow = window.open('','','width=600,height=600');
            printWindow.document.open();
            printWindow.document.write('<html>');
            printWindow.document.write(' <link rel="stylesheet" href={{ asset("frontend/css/bootstrap.min.css") }}>');
            printWindow.document.write('<body>');
            printWindow.document.write(printContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            printWindow.print();
            printWindow.close();


        }
    </script>

@endpush
