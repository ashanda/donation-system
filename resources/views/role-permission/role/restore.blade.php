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
                            Deleted Roles
                            @can('restore role')
                                <form action="{{ route('roles.restoreAll') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-info float-end">Restore All Deleted Roles</button>
                                </form>
                            @endcan
                        </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Deleted At</th>
                                    <th width="30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deletedRoles as $deletedRole)
                                    <tr>
                                        <td>{{ $deletedRole->id }}</td>
                                        <td>{{ $deletedRole->name }}</td>
                                        <td>{{ $deletedRole->deleted_at }}</td>
                                        <td>
                                            @can('restore role')
                                                <form action="{{ route('roles.restore', $deletedRole->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-primary">Restore</button>
                                                </form>
                                            @endcan

                                            @can('force delete role')
                                                <form action="{{ route('roles.forceDelete', $deletedRole->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger mx-2">Force Delete</button>
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
        </div>
    </div>

@endsection
