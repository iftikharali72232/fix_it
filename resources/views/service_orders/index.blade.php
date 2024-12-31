@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Service Orders</h2>
    <table class="table pretty-table">
        <thead class="thead">
            <tr>
                <th>ID</th>
                <th>Service Name</th>
                <th>Customer Name</th>
                <th>Service Cost</th>
                <th>Service Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($serviceOrders as $order)
                <tr class="tbody">
                    <td class="align-middle">{{ $order->id }}</td>
                    <td class="align-middle">{{ $order->service_name }}</td>
                    <td class="align-middle">{{ $order->customer_name }}</td>
                    <td class="align-middle">{{ $order->service_cost }}</td>
                    <td class="align-middle">{{ $order->service_date }}</td>
                    <td class="align-middle">
                        @switch($order->status)
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
                    </td>
                    <td class="align-middle">
                        <!-- <a href="{{ route('service_orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a> -->
                        <a href="{{ route('service_orders.show', $order->id) }}" class="view-button">
                            <div class="eye-filled">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path 
                                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    stroke-width="2" 
                                    class="blink" 
                                />
                                <circle cx="12" cy="12" r="3" fill="currentColor" />
                                </svg>
                            </div>
                            <div class="eye-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
