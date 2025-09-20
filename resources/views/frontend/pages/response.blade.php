@extends('layouts.master')
@section('content')
 <div class="container">
    <div class="status">
	<?php $post_data = Session::get('post_data');?>

        @if($response['pp_ResponseCode'] == '000')
		<!-- --------------------------------------------------------------------------- -->
		<!-- Payment successful -->
            <h1 class="success">Your Payment has been Successful</h1>
            <h4>Payment Information</h4>
            <p><b>Reference Number:</b> {{ $response['pp_RetreivalReferenceNo'] ?? 'N/A' }}</p>
            <p><b>Transaction ID:</b> {{ $response['pp_TxnRefNo'] ?? 'N/A' }}</p>
            <p><b>Paid Amount:</b> {{ $response['pp_Amount'] ?? 'N/A' }}</p>
            <p><b>Payment Status:</b> Success</p>
		<!-- --------------------------------------------------------------------------- -->


		<!-- --------------------------------------------------------------------------- -->
        <!-- Payment not successful -->
		@elseif(isset($response['pp_ResponseCode']) && $response['pp_ResponseCode'] == '124')
            <h1 class="error">Your Payment has been on Waiting state</h1>
			<p><b>Message: </b>{{ $response['pp_ResponseMessage'] ?? 'N/A' }}</p>
			<p><b>Voucher Number: </b>{{ $response['pp_RetreivalReferenceNo'] ?? 'N/A' }}</p>
		<!-- --------------------------------------------------------------------------- -->


		<!-- --------------------------------------------------------------------------- -->
        <!-- Payment not successful -->
		@else
            <h1 class="error">Your Payment has Failed</h1>
			<p><b>Message: </b>{{ $response['pp_ResponseMessage'] ?? 'N/A' }}</p>
        @endif
		<!-- --------------------------------------------------------------------------- -->


    </div>
    <a href="{{ url('/') }}" class="btn-link">Back to Products</a> {{-- Changed index.php to url('/') for Laravel --}}
</div>
@stop
