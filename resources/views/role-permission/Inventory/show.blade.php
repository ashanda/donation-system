@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Inventory Details
                            <a href="{{ route('inventories.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="product_name">Product Name</label>
                            <input type="text" id="product_name" class="form-control" value="{{ $inventory->product->name }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="quantity">Quantity</label>
                            <input type="number" id="quantity" class="form-control" value="{{ $inventory->quantity }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
