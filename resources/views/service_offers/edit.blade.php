@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Service Offer</h2>
    <form action="{{ route('service_offers.update', $serviceOffer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="service_id" class="form-label">Service</label>
            <select class="form-control" id="service_id" name="service_id" required>
                <option value="" disabled>Select a service</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ $serviceOffer->service_id == $service->id ? 'selected' : '' }}>
                        {{ $service->service_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            @if ($serviceOffer->image)
                <div class="position-relative">
                    <img src="{{ asset('images/' . $serviceOffer->image) }}" alt="Offer Image" width="100" class="mt-2">
                    <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 0; right: 0;"
                        onclick="deleteImage()">X</button>
                </div>
            @endif
            <input type="file" class="form-control mt-2" id="image" name="image">
        </div>
        <div class="mb-3">
            <label for="discount" class="form-label">Discount</label>
            <input type="text" class="form-control" id="discount" name="discount" value="{{ $serviceOffer->discount }}" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="1" {{ $serviceOffer->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$serviceOffer->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script>
    function deleteImage() {
        if (confirm('Are you sure you want to delete the current image?')) {
            fetch('{{ route('service_offers.delete_image', $serviceOffer->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    alert('Image deleted successfully.');
                    location.reload(); // Reload the page to update the UI
                } else {
                    alert('Failed to delete the image.');
                }
            });
        }
    }
</script>
@endsection
