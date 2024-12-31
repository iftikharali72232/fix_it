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
                        <a href="{{ route('service_orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
