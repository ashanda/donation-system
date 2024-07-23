@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Good Issues</h4>
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
             <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3 float-end ms-2">Back</a>
             @can('create good issue')
                 <a href="{{ route('good-issues.create') }}" class="btn btn-primary mb-3 float-end">Create New Issue</a>
             @endcan
             
           
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
                    @foreach ($issues as $issue)
                    <tr>
                        <td>{{ $issue->id }}</td>
                        <td>{{ $issue->product->name }}</td>
                        <td>{{ $issue->quantity }}</td>
                        <td>
                            @can('edit / update good issue')
                            <a href="{{ route('good-issues.edit', $issue->id) }}" class="btn btn-warning">Edit</a>
                            @endcan
                            @can('delete good issue')
                            <form action="{{ route('good-issues.destroy', $issue->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-button">Delete</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
