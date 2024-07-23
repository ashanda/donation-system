@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Donation</h4>
             <a href="{{ route('donations.index') }}" class="btn btn-primary float-end">Back</a>
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
            <form action="{{ route('donations.update', $donation->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="product_id">Product</label>
                    <select name="product_id" class="form-control">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ $product->id == $donation->product_id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" min="1" class="form-control" value="{{ $donation->quantity }}">
                </div>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('donations.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection