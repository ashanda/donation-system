@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Product
                            <a href="{{ route('products.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('products.update', $product->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="name">Product Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Product Description</label>
                                <textarea name="description" id="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="price">Product Price</label>
                                <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ $product->price }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="product_code">Product Code</label>
                                <input type="text" name="product_code" id="product_code" class="form-control" value="{{ $product->product_code }}" readonly>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Update Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
