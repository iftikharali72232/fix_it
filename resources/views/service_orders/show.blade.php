@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Service Order Details</h2>
    <div class="card">
        <div class="card-header">
            Service Order #{{ $serviceOrder->id }}
        </div>
        <div class="card-body">
            <p><strong>Service Name:</strong> {{ $serviceOrder->service->service_name }}</p>
            <p><strong>Customer Name:</strong> {{ $serviceOrder->customer->name }}</p>
            <p><strong>Service Cost:</strong> {{ $serviceOrder->service_cost }}</p>
            <p><strong>Service Date:</strong> {{ $serviceOrder->service_date }}</p>
            <p><strong>Status:</strong>
                @switch($serviceOrder->status)
                    @case(0)
                        Pending
                        @break
                    @case(1)
                        Processing
                        @break
                    @case(2)
                        Complete
                        @break
                    @case(3)
                        Cancelled
                        @break
                    @case(4)
                        Deleted
                        @break
                    @default
                        Unknown
                @endswitch
            </p>
            <a href="{{ route('service_orders.index') }}" class="btn btn-primary">Back to Orders</a>
        </div>
    </div>
</div>
@endsection
