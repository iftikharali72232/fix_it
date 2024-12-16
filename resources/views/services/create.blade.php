@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Service</h1>
    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Service Name -->
        <div class="mb-3">
            <label for="service_name" class="form-label">Service Name</label>
            <input type="text" class="form-control" id="service_name" name="service_name" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>

        <!-- Thumbnail -->
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail">
        </div>

        <!-- Images -->
        <div class="mb-3">
            <label for="images" class="form-label">Images</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple>
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="">Select a Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Estimated Time -->
        <div class="mb-3">
            <label for="estimated_time" class="form-label">Estimated Time (minutes)</label>
            <input type="text" class="form-control" id="estimated_time" name="estimated_time">
        </div>

        <!-- Start Time -->
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="text" class="form-control" id="start_time" name="start_time">
        </div>

        <!-- Service Cost -->
        <div class="mb-3">
            <label for="service_cost" class="form-label">Service Cost Range</label>
            <input type="text" class="form-control" id="service_cost" name="service_cost" step="0.01" required>
        </div>

        <!-- Service Cost -->
        <div class="mb-3">
            <label for="actual_cost" class="form-label">Actual Cost</label>
            <input type="text" class="form-control" id="actual_cost" name="actual_cost" step="0.01" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Create Service</button>
    </form>
</div>
@endsection
