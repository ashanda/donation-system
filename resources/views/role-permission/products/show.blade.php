@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Details
                            <a href="{{ route('products.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">Product Name</label>
                            <input type="text" id="name" class="form-control" value="{{ $product->name }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Product Description</label>
                            <textarea id="description" class="form-control" rows="4" readonly>{{ $product->description }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="price">Product Price</label>
                            <input type="text" id="price" class="form-control" value="{{ $product->price }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="product_code">Product Code</label>
                            <input type="text" id="product_code" class="form-control" value="{{ $product->product_code }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
