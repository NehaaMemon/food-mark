@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Invoice</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Invoice</div>
            </div>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">Order #{{ $order->invoice_id }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Deliver To:</strong><br>
                                        <strong>Name : {{ @$order->userAddress->first_name }}
                                            {{ @$order->userAddress->last_name }}</strong>
                                        <br>
                                        <strong>Address</strong> : {{ @$order->userAddress->address }}
                                        <br>
                                        <strong>Area</strong> : {{ @$order->userAddress->deliveryArea->area_name }}
                                        <br>
                                        <strong>Phone</strong> : {{ @$order->userAddress->phone }}


                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        September 19, 2018{{ date('F d,Y \ H:i', strtotime($order->created_by)) }}
                                        <br><br>
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Payment Method:</strong><br>
                                        {{ $order->payment_method }}<br>
                                        <strong>Payment Status:</strong><br>
                                        @if (strtoupper($order->payment_status) == 'COMPLETED')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif(strtoupper($order->payment_status) == 'PENDING')
                                            <span class="badge badge-danger">Pending</span>
                                        @else
                                            <span class="badge badge-warning">{{ $order->payment_status }}</span>
                                        @endif
                                        <br>

                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Status:</strong><br>
                                        @if (strtoupper($order->order_status) == 'PENDING')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif(strtoupper($order->order_status) == 'COMPLETED')
                                            <span class="badge badge-success">Completed</span>
                                        @else
                                            <span class="badge badge-info">{{ $order->order_status }}</span>
                                        @endif
                                        <br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <p class="section-lead">All items here cannot be deleted.</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>Item</th>
                                        <th>Product Size</th>
                                        <th>Product Option</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Totals</th>
                                    </tr>
                                    @foreach ($order->orderItems as $orderItem)
                                        @php
                                            $size = json_decode($orderItem->product_size);
                                            $option = json_decode($orderItem->product_option);
                                            //    dd($option);

                                            $proqty = $orderItem->qty;
                                            $proPrice = $orderItem->unit_price;
                                            $proSize = $size->price;
                                            $proOption = 0;
                                            foreach ($option as $optionItem) {
                                                $proOption += $optionItem->price;
                                            }
                                            $prototal = ($proPrice + $proSize + $proOption) * $proqty;

                                        @endphp
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $orderItem->product_name }}</td>
                                            <td>{{ @$size->name }}- {{ currencyPosition($size->price) }}</td>
                                            @foreach ($option as $options)
                                                <td>{{ @$options->name }} - {{ currencyPosition($options->price) }}</td>
                                            @endforeach
                                            <td class="text-center">{{ currencyPosition($orderItem->unit_price) }}</td>
                                            <td class="text-center">{{ $orderItem->qty }}</td>
                                            <td class="text-right">{{ currencyPosition($prototal) }}</td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="col-md-4 d-print-none">
                                        <form action="{{ route('admin.orders.status-update', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="">Payment Status</label>
                                                <select name="payment_status" class="form-control" id="">
                                                    <option value="pending" @selected($order->payment_status === 'pending')>Pending</option>
                                                    <option value="completed" @selected($order->payment_status === 'completed')>Completed
                                                    </option>

                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label for="">Order Status</label>
                                                <select name="order_status" class="form-control" id="">
                                                    <option value="pending" @selected($order->order_status === 'pending')>Pending</option>
                                                    <option value="in_process" @selected($order->order_status === 'in_process')>In Process</option>
                                                    <option value="delivered" @selected($order->order_status === 'delivered')>Delivered</option>
                                                    <option value="declined" @selected($order->order_status === 'declined')>Declined</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-info">Update</button>
                                        </form>


                                    </div>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">{{ currencyPosition($order->subtotal) }}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Shipping</div>
                                        <div class="invoice-detail-value">{{ currencyPosition($order->delivery_charge) }}
                                        </div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            {{ currencyPosition($order->grand_total) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <div class="float-lg-left mb-lg-0 mb-3">
                    </div>
                    <button class="btn btn-warning btn-icon icon-left" id="btn_print"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $('#btn_print').on('click',function(){
            let printContent = $('.invoice-print').html();

            let printWindow = window.open('','','width=600,height=600');
            printWindow.document.open();
            printWindow.document.write('<html>');
            printWindow.document.write(' <link rel="stylesheet" href={{ asset("admin/assets/modules/bootstrap/css/bootstrap.min.css") }}>');
            printWindow.document.write('<body>');
            printWindow.document.write(printContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            printWindow.print();
            printWindow.close();

          

        })


    })
</script>

@endpush
