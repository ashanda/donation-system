@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        
    

    
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>
                            Roles
                            @can('create role')
                            <a href="{{ url('roles/create') }}" class="btn btn-primary float-end ms-2">Add Role</a>
                            @endcan

                             @can('restore role')
                            <a href="{{ route('roles.restoreAll') }}" class="btn btn-info float-end">Restore role</a>
                            @endcan
                        </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th width="40%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @can('role permission')
                                        <a href="{{ url('roles/'.$role->id.'/give-permissions') }}" class="btn btn-warning">
                                            Add / Edit Role Permission
                                        </a>
                                        @endcan

                                        @can('update role')
                                        <a href="{{ url('roles/'.$role->id.'/edit') }}" class="btn btn-success">
                                            Edit
                                        </a>
                                        @endcan
                                        
                                        @can('delete role')
                                        @if ($role->id != 1)
                                        <a href="{{ url('roles/'.$role->id.'/delete') }}" class="btn btn-danger mx-2 delete-button">
                                            Delete
                                        </a>
                                        @endif
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