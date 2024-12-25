@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Team Users</h2>
    <a href="{{ route('team_users.create') }}" class="btn btn-primary">Add User</a>
    <table class="table table-bordered mt-3">
        <thead>
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
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td>{{ $user->email }}</td>
                    <!-- <td>{{ $user->team->name ?? 'No Team Assigned' }}</td> -->
                    <td>
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
