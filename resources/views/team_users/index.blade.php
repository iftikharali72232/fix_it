@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Team Users</h2>
    <a href="{{ route('team_users.create') }}" class="btn btn-primary">Add User</a>
    <table class="table pretty-table mt-3">
        <thead class="thead">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Team</th>
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
                    <td class="align-middle">{{ $user->team->name ?? 'No Team Assigned' }}</td>
                    <td class="align-middle">
                        <a href="{{ route('team_users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('team_users.destroy', $user->id) }}" method="POST" style="display:inline;">
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
