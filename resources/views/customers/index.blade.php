@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
        <h2>Team Users</h2>
        </div>
        <div class="col d-flex justify-content-end">
            <a  href="{{ route('team_users.create') }}">
                <button type="button" class="cssbuttons-io">
                    <span>
                    <i class="fa-solid fa-plus me-2"></i>
                    Add Customer
                    </span>
                </button>
            </a>
        </div>
    </div>
    
    <!-- <a href="{{ route('team_users.create') }}" class="btn btn-primary">Add User</a> -->
    <table class="table pretty-table mt-3">
        <thead class="thead">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <!-- <th>Team</th> -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="tbody">
                    <td class="align-middle">{{ $user->id }}</td>
                    <td class="align-middle">{{ $user->name }}</td>
                    <td class="align-middle">{{ $user->mobile }}</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <!-- <td class="align-middle">{{ $user->team->name ?? 'No Team Assigned' }}</td> -->
                    <td class="align-middle">
                        <a href="{{ route('customers.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('customers.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
