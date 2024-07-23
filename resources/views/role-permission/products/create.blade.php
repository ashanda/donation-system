@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Product
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
                        <form action="{{ route('products.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Product Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Product Description</label>
                                <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="price">Product Price</label>
                                <input type="number" name="price" id="price" min="0" class="form-control" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Create Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
