@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Service Offers</h2>
    <a href="{{ route('service_offers.create') }}" class="btn btn-primary mb-3">Add New Offer</a>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table pretty-table">
        <thead class="thead">
            <tr>
                <th>ID</th>
                <th>Service Name</th>
                <th>Image</th>
                <th>Discount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($serviceOffers as $offer)
                <tr class="tbody">
                    <td class="align-middle">{{ $offer->id }}</td>
                    <td class="align-middle">{{ $offer->service->service_name ?? 'N/A' }}</td>
                    <td class="align-middle"><img src="{{ asset('images/' . $offer->image) }}" alt="" width="100"></td>
                    <td class="align-middle">{{ $offer->discount }}</td>
                    <td class="align-middle">{{ $offer->status ? 'Active' : 'Inactive' }}</td>
                    <td class="align-middle">
                        <a href="{{ route('service_offers.edit', $offer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('service_offers.destroy', $offer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
