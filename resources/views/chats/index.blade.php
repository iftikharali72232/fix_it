@extends('layouts.app')

@section('content')
<h1>Customer Chats</h1>

<table border="1" style="width:100%; text-align:left;">
    <thead>
        <tr>
            <th>#</th>
            <th>Chat ID</th>
            <th>Customer Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($chats as $key => $chat)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $chat->id }}</td>
            <td>{{ $chat->customer->name }}</td>
            <td>
                <a href="{{ route('chats.show', $chat->customer_id) }}">View Chat</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
