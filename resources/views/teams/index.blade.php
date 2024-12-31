@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Teams</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <a href="{{ route('teams.create') }}" class="btn btn-primary mb-3">Add Team</a>
        <table class="table pretty-table">
            <thead class="thead">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                    <tr class="tbody">
                        <td class="align-middle">{{ $team->id }}</td>
                        <td class="align-middle">{{ $team->name }}</td>
                        <td class="align-middle">{{ $team->description }}</td>
                        <td class="align-middle">{{ $team->category->name ?? 'N/A' }}</td>
                        <td class="align-middle">
                            <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-warning">Edit</a>
                            <!-- Delete Button -->
                            <form action="{{ route('teams.destroy', $team->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


