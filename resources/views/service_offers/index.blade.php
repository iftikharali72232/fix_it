@extends('layouts.app')

@section('content')
<div class="container">
    <!-- <h2>Service Offers</h2>
    <a href="{{ route('service_offers.create') }}" class="btn btn-primary mb-3">Add New Offer</a> -->
    <div class="row">
        <div class="col-md-6">
        <h2 class="text-sm-start text-center">Service Offers</h2>
        </div>
        <div class="col-md-6 d-flex justify-content-md-end justify-content-center">
            <a href="{{ route('service_offers.create') }}">
                <button type="button" class="cssbuttons-io">
                    <span>
                    <i class="fa-solid fa-plus {{ app()->getLocale() == 'en' ? 'me-2' : 'ms-2' }}"></i>
                    Add New Offer
                    </span>
                </button>
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
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
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('service_offers.edit', $offer->id) }}" class="editBtn">
                                <svg height="1em" viewBox="0 0 512 512">
                                    <path
                                    d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"
                                    ></path>
                                </svg>
                            </a>

                            <form action="{{ route('service_offers.destroy', $offer->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bin-button" onclick="return confirm('Are you sure?')">
                                    <img src="{{asset('img/trash-open.svg')}}" class="bin-top" alt="">
                                    <img src="{{asset('img/trash-close.svg')}}" class="bin-bottom" alt="">
                                </button>
                            </form>
                        </div>

                        <!-- <a href="{{ route('service_offers.edit', $offer->id) }}" class="btn btn-warning btn-sm">Edit</a> -->
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
