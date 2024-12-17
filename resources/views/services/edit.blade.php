@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Service</h1>
    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Service Name -->
        <div class="mb-3">
            <label for="service_name" class="form-label">Service Name</label>
            <input type="text" class="form-control" id="service_name" name="service_name" value="{{ $service->service_name }}" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $service->description }}</textarea>
        </div>

        <!-- Thumbnail -->
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail">
            @if ($service->thumbnail)
                <div class="mt-2 position-relative d-inline-block">
                    <img src="{{ asset('thumbnails/' . $service->thumbnail) }}" alt="Thumbnail" width="100">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-thumbnail" data-url="{{ route('services.deleteThumbnail', $service->id) }}">×</button>
                </div>
            @endif
        </div>

        <!-- Images -->
        <div class="mb-3">
            <label for="images" class="form-label">Images</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple>
            @if ($service->images)
                @foreach (json_decode($service->images) as $image)
                    <div class="mt-2 position-relative d-inline-block">
                        <img src="{{ asset('images/' . $image) }}" alt="Image" width="100" class="me-2">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-image" data-url="{{ route('services.deleteImage', [$service->id, $image]) }}">×</button>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="">Select a Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $service->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Estimated Time -->
        <div class="mb-3">
            <label for="estimated_time" class="form-label">Estimated Time (minutes)</label>
            <input type="text" class="form-control" id="estimated_time" name="estimated_time" value="{{ $service->estimated_time }}">
        </div>

        <!-- Start Time -->
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="text" class="form-control" id="start_time" name="start_time" value="{{ $service->start_time }}">
        </div>

        <!-- Service Cost -->
        <div class="mb-3">
            <label for="service_cost" class="form-label">Service Cost Range</label>
            <input type="text" class="form-control" id="service_cost" name="service_cost" value="{{ $service->service_cost }}" required>
        </div>

        <!-- Actual Cost -->
        <div class="mb-3">
            <label for="actual_cost" class="form-label">Actual Cost</label>
            <input type="text" class="form-control" id="actual_cost" name="actual_cost" value="{{ $service->actual_cost }}" required>
        </div>

        <!-- Service Variables -->
        <h5>Service Variables</h5>
        <div id="service-variables-container">
            @if ($service->serviceVariables->isNotEmpty())
                @foreach ($service->serviceVariables as $variable)
                    <div class="mb-3 d-flex">
                        <input type="text" class="form-control" name="service_variables[]" value="{{ $variable->variable }}" placeholder="Enter variable">
                        <button type="button" class="btn btn-danger ms-2 remove-input">-</button>
                    </div>
                @endforeach
            @endif
                <div class="mb-3 d-flex">
                    <input type="text" class="form-control" name="service_variables[]" placeholder="Enter variable">
                    <button type="button" class="btn btn-success ms-2 add-service-variable">+</button>
                </div>
        </div>

        <!-- Service Phases -->
        <h5>Service Phases</h5>
        <div id="service-phases-container">
            @if ($service->servicePhases->isNotEmpty())
                @foreach ($service->servicePhases as $phase)
                    <div class="mb-3 d-flex">
                        <input type="text" class="form-control" name="service_phases[]" value="{{ $phase->phase }}" placeholder="Enter phase">
                        <button type="button" class="btn btn-danger ms-2 remove-input">-</button>
                    </div>
                @endforeach
            @endif
                <div class="mb-3 d-flex">
                    <input type="text" class="form-control" name="service_phases[]" placeholder="Enter phase">
                    <button type="button" class="btn btn-success ms-2 add-service-phase">+</button>
                </div>
            
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Service</button>
    </form>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Add Service Variable
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('add-service-variable')) {
            let container = document.getElementById('service-variables-container');
            let newInput = `
                <div class="mb-3 d-flex">
                    <input type="text" class="form-control" name="service_variables[]" placeholder="Enter variable">
                    <button type="button" class="btn btn-danger ms-2 remove-input">-</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newInput);
        }
    });

    // Add Service Phase
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('add-service-phase')) {
            let container = document.getElementById('service-phases-container');
            let newInput = `
                <div class="mb-3 d-flex">
                    <input type="text" class="form-control" name="service_phases[]" placeholder="Enter phase">
                    <button type="button" class="btn btn-danger ms-2 remove-input">-</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newInput);
        }
    });

    // Remove Input Field
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-input')) {
            e.target.parentElement.remove();
        }
    });

    // Delete Thumbnail
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-thumbnail')) {
            let url = e.target.getAttribute('data-url');
            if (confirm('Are you sure you want to delete this thumbnail?')) {
                fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            e.target.parentElement.remove();
                        } else {
                            alert('Error deleting thumbnail.');
                        }
                    });
            }
        }
    });

    // Delete Image
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-image')) {
            let url = e.target.getAttribute('data-url');
            if (confirm('Are you sure you want to delete this image?')) {
                fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            e.target.parentElement.remove();
                        } else {
                            alert('Error deleting image.');
                        }
                    });
            }
        }
    });
});
</script>
@endsection
