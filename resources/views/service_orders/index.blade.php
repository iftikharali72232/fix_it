@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Service Orders</h2>
    <table class="table table-bordered">
        <thead>
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
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->service_name }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->service_cost }}</td>
                    <td>{{ $order->service_date }}</td>
                    <td>
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
                    <td>
                        <a href="{{ route('service_orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
