@extends('layouts.app')

@section('content')

    <div class="container mt-5">

        <div class="container mt-2">
            <div class="row">
                <div class="col-md-12">

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <div class="card mt-3">
                        <div class="card-header">
                            <h4>Products
                                <a href="{{ route('products.create') }}" class="btn btn-primary float-end">Create Product</a>
                                <a href="{{ route('products.restoreItems') }}" class="btn btn-info float-end mx-2">Restore All Products</a>
                            </h4>
                        </div>
                        <div class="card-body">

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th width="40%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">View</a>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success mx-2">Edit</a>
                                                @can('delete permission')
                                                <a href="{{ url('products/'.$product->id.'/delete') }}" class="btn btn-danger mx-2 delete-button">Delete</a>
                                                @endcan
                                                

                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
