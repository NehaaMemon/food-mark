@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Gallery ({{ $product->name }})</h1>
        </div>
        <div>
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary my-3">Go Back</a>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Images</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.product-gallery.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="file" name="image" class="form-control">
                            <input type="hidden" name="product_id" value="{{ $product->id}}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card card-primary">

            <div class="card-body">
                <table class= "table table-bordered">
                    <thead>
                        <tr>
                            <th>Images</th>
                            <th>Action</th>

                            </tr>

                    </thead>
                    <tbody>
                        @foreach ($images  as $image )

                        <tr>
                            <td><img src="{{ asset($image->image) }}" alt="" width="150px" ></td>
                            <td><a href='{{ route('admin.product-gallery.destroy',$image->id) }}' class ='btn btn-danger delete-item mx-2'><i class='fas fa-trash'></i></a></td>
                        </tr>
                        @endforeach
                        @if (count($images)=== 0)
                        <tr>
                            <td colspan='2' class="text-center">No data found</td>

                        </tr>
                        @endif
                    </tbody>

                </table>
            </div>
        </div>
    </section>
@endsection
