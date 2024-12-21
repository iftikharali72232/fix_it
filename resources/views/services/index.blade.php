@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Service Listing</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Thumbnail</th>
                <th>Service Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Service Cost</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>
                        @if($service->thumbnail)
                            <img src="{{asset('thumbnails').'/'.$service->thumbnail }}" alt="" width="80" height="80">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{ $service->service_name }}</td>
                    <td>{{ $service->category->name ?? 'N/A' }}</td> <!-- Category Name -->
                    <td>{{ $service->description }}</td>
                    <td>${{ $service->service_cost }}</td>
                    <td>
                        <!-- View Button -->
                        <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-info">View</a>
                        <!-- Edit Button -->
                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        
                        <!-- Delete Button -->
                        <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div>
        {{ $services->links() }}
    </div>
</div>
@endsection
