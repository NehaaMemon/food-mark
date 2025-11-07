@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Products Reviews</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4> Product Reviews</h4>
                {{-- <div class="card-header-action">
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                        Create new
                    </a>
                </div> --}}
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>

    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}


    <script>
        $(document).ready(function(){
            $('body').on('change','.review_status',function(){
                let status = $(this).val();
                let id = $(this).data('id');
                $.ajax({
                    method : 'POST',
                    url: '{{ route("admin.product-review.update") }}',
                    data: {
                        _token : "{{ csrf_token() }}",
                        status : status,
                        id : id
                    },
                    success:function(response){
                        toastr.success(response.message);
                    },
                    error : function(xhr,status,error){}
                })
            })
        })
    </script>
@endpush
