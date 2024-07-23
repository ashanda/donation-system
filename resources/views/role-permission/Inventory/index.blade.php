@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Inventory
                            @can('add inventory')
                            <a href="{{ route('inventories.create') }}" class="btn btn-primary float-end ms-2">Add Inventory</a>
                            @endcan
                            @can('restore inventory iteams')
                            <a href="{{ route('inventories.restoreItems') }}" class="btn btn-info float-end mx-2">Restore Inventory</a>
                            @endcan
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th width="30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventories as $inventory)
                                    <tr>
                                        <td>{{ $inventory->id }}</td>
                                        <td>{{ $inventory->product->name }}</td>
                                        <td>{{ $inventory->quantity }}</td>
                                        <td>
                                             @can('view inventory item')
                                            <a href="{{ route('inventories.show', $inventory->id) }}" class="btn btn-info">View</a>
                                            @endcan
                                             @can('edit / update inventory items')
                                            <a href="{{ route('inventories.edit', $inventory->id) }}" class="btn btn-success mx-2">Edit</a>
                                            @endcan
                                             @can('delete inventory item')
                                                <a href="{{ url('inventories/'.$inventory->id.'/delete') }}" class="btn btn-danger mx-2 delete-button">Delete</a>
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
@endsection
