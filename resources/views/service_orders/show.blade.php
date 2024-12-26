@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Service Order Details</h2>

    <!-- Service Order Details -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Order Details</h5>
        </div>
        <div class="card-body">
            <p><strong>Customer Name:</strong> {{ $serviceOrder->customer->name ?? 'N/A' }}</p>
            <p><strong>Customer Mobile:</strong> {{ $serviceOrder->customer->mobile ?? 'N/A' }}</p>
            <p><strong>Customer Email:</strong> {{ $serviceOrder->customer->email ?? 'N/A' }}</p>
            <p><strong>Service Name:</strong> {{ $serviceOrder->service->service_name ?? 'N/A' }}</p>
            <p><strong>Service Cost:</strong> {{ $serviceOrder->service_cost }}</p>
            <p><strong>Service Date:</strong> {{ $serviceOrder->service_date }}</p>
            <p><strong>Status:</strong> 
                @php
                    $statuses = ['Pending', 'Processing', 'Completed', 'Cancelled', 'Deleted'];
                @endphp
                <span class="badge bg-{{ $serviceOrder->status == 1 ? 'warning' : ($serviceOrder->status == 2 ? 'success' : 'danger') }}">
                    {{ $statuses[$serviceOrder->status] ?? 'Unknown' }}
                </span>
            </p>
            @if ($activeOffer)
                <p><strong>Active Offer:</strong> {{ $activeOffer->discount }}% Off</p>
            @else
                <p><strong>Active Offer:</strong> No active offers</p>
            @endif
        </div>
    </div>

    <!-- Variables Section -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="card-title mb-0">Dynamic Form Variables</h5>
        </div>
        <div class="card-body">
            @if (!empty($variables))
                <div id="dynamic_form">
                    @foreach ($variables as $variable)
                        @if (!empty($variable['value']))
                            @if($variable['type'] === 'dropdown')
                                <div class="mb-3">
                                    <label class="form-label">{{ $variable['label'] }}</label>
                                    <select class="form-select" disabled>
                                        @foreach(explode(',', $variable['dropdown_values']) as $option)
                                            <option value="{{ $option }}" {{ $option == $variable['value'] ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif($variable['type'] === 'text')
                                <div class="mb-3">
                                    <label class="form-label">{{ $variable['label'] }}</label>
                                    <input type="text" value="{{ $variable['value'] }}" class="form-control" disabled />
                                </div>
                            @elseif($variable['type'] === 'date')
                                <div class="mb-3">
                                    <label class="form-label">{{ $variable['label'] }}</label>
                                    <input type="date" value="{{ $variable['value'] }}" class="form-control" disabled />
                                </div>
                            @elseif($variable['type'] === 'checkbox')
                                <div class="mb-3">
                                    <label class="form-label">{{ $variable['label'] }}</label>
                                    <input type="checkbox" {{ $variable['value'] ? 'checked' : '' }} disabled />
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-muted">No variables available.</p>
            @endif
        </div>
    </div>

    <!-- Service Phases -->
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">Service Phases</h5>
        </div>
        <div class="card-body">
            @if (!empty($phases) && $phases->isNotEmpty())
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Phase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($phases as $phase)
                            <tr>
                                <td>{{ $phase->phase }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No phases available for this service.</p>
            @endif
        </div>
    </div>
</div>
@endsection
