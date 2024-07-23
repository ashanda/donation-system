@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Donations</h4>
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @can('create donation')
            <a href="{{ route('donations.create') }}" class="btn btn-primary mb-3 float-end ms-2">Create New Donation</a>
            @endcan
            @if($donations->isEmpty())
                <p>No donations to display.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donations as $donation)
                        <tr>
                            <td>{{ $donation->id }}</td>
                            <td>{{ $donation->product->name }}</td>
                            <td>{{ $donation->quantity }}</td>
                            <td>
                                @can('edit / update donation items')
                                <a href="{{ route('donations.edit', $donation->id) }}" class="btn btn-warning">Edit</a>
                                @endcan
                                @can('delete donation items')
                                <form action="{{ route('donations.destroy', $donation->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection