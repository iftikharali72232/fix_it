@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Service Offer</h2>
    <form action="{{ route('service_offers.update', $serviceOffer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="service_id" class="form-label">Service ID</label>
            <input type="text" class="form-control" id="service_id" name="service_id" value="{{ $serviceOffer->service_id }}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <img src="{{ asset('storage/' . $serviceOffer->image) }}" alt="Offer Image" width="100" class="mt-2">
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
@endsection
