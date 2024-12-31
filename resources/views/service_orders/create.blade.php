@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Service Order</h2>

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('service_orders.create') }}" method="GET">
            @csrf

            <!-- Service Dropdown -->
            <div class="form-group">
                <label for="service_dropdown">Select Service</label>
                <select id="service_dropdown" name="service_id" class="form-control" onchange="this.form.submit()">
                    <option value="">Select a Service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->service_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        @if(request('service_id') && isset($serviceData))
            <form action="{{ route('service_orders.store') }}" method="POST">
                @csrf

                <!-- Dynamic Form Fields -->
                <div id="dynamic_form">
                    @foreach($variables as $variable)
                        @if($variable['type'] === 'dropdown')
                            <div class="form-group">
                                <label>{{ $variable['label'] }}</label>
                                <select name="variables[{{ $variable['label'] }}]" class="form-control">
                                    @foreach(explode(',', $variable['dropdown_values']) as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif($variable['type'] === 'text')
                            <div class="form-group">
                                <label>{{ $variable['label'] }}</label>
                                <input type="text" name="variables[{{ $variable['label'] }}]" class="form-control" />
                            </div>
                        @elseif($variable['type'] === 'date')
                            <div class="form-group">
                                <label>{{ $variable['label'] }}</label>
                                <input type="date" name="variables[{{ $variable['label'] }}]" class="form-control" />
                            </div>
                        @elseif($variable['type'] === 'checkbox')
                            <div class="form-group">
                                <label>{{ $variable['label'] }}</label>
                                <input type="checkbox" name="variables[{{ $variable['label'] }}]" value="1" class="form-check-input" />
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Service Cost, Tax, Discount -->
                 <input type="hidden" name="service_id" value="{{$serviceData->id}}">
                <div class="form-group">
                    <label for="service_cost">Service Cost</label>
                    <input type="text" id="service_cost" name="service_cost" class="form-control" value="{{ $serviceData->actual_cost }}" readonly />
                </div>
                <div class="form-group">
                    <label for="service_date">Service Cost</label>
                    <input type="date" id="service_date" name="service_date" class="form-control" value="{{ date('Y-m-d'); }}" readonly />
                </div>

                <div class="form-group">
                    <label for="tax">Tax</label>
                    <input type="text" id="tax" name="tax" class="form-control" value="{{ $serviceData->tax }}" readonly />
                </div>

                <div class="form-group">
                    <label for="discount">Discount</label>
                    <input type="text" id="discount" name="discount" class="form-control" value="{{ $serviceData->discount }}" readonly />
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create Order</button>
                </div>
            </form>
        @endif
    </div>
@endsection
