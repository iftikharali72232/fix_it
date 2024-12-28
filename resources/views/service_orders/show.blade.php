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
                <p><strong>Active Offer:</strong> {{ $activeOffer->discount }} Off</p>
            @else
                <p><strong>Active Offer:</strong> No active offers</p>
            @endif

            <div class="mb-3">
    <label class="form-label">Teams</label>
    <select class="form-select" id="team" onchange="team_users();" {{ $serviceOrder->team_id > 0 && $serviceOrder->team_user_id > 0 ? '' : 'disabled' }}>
        <option value="0" {{ $serviceOrder->team_id == 0 ? 'selected' : '' }}>SELECT</option>
        @foreach($teams as $team)
            <option value="{{ $team->id }}" {{ $serviceOrder->team_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3" id="team_users">
    @if ($serviceOrder->team_id > 0 && $serviceOrder->team_user_id > 0)
        <label class="form-label">Select a User</label>
        <select class="form-select" name="user_id" id="user_id">
            @foreach($users as $user) {{-- Pass users associated with the selected team --}}
                <option value="{{ $user->id }}" {{ $serviceOrder->team_user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    @endif
</div>

@if (!($serviceOrder->team_id > 0 && $serviceOrder->team_user_id > 0))
    <script>
        document.getElementById('team').disabled = false;
        document.getElementById('team_users').innerHTML = '<p class="text-muted">Please select a team to load users.</p>';
    </script>
@endif

            <button onclick="update();">Confirm</button>
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
<script>
    function team_users() {
        const teamId = document.getElementById('team').value;

        // Clear previous users
        const usersContainer = document.getElementById('team_users');
        usersContainer.innerHTML = '<p class="text-muted">Loading users...</p>';

        const BASE_URL = "{{ url('/') }}";
        console.log(BASE_URL); // Outputs the base URL

        // Make AJAX request to fetch team users
        fetch(BASE_URL+`/team/${teamId}/users`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(users => {
                if (users.length > 0) {
                    let userHtml = `
                        <label class="form-label">Select a User</label>
                        <select class="form-select" name="user_id" id="user_id">
                            <option selected disabled>SELECT</option>`;
                    users.forEach(user => {
                        userHtml += `<option value="${user.id}">${user.name} (${user.email})</option>`;
                    });
                    userHtml += '</select>';
                    usersContainer.innerHTML = userHtml;
                } else {
                    usersContainer.innerHTML = '<p class="text-muted">No users found for this team.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching team users:', error);
                usersContainer.innerHTML = '<p class="text-danger">Failed to load users. Please try again.</p>';
            });
    }
function update() {
    const teamId = document.getElementById('team').value;
    const userId = document.getElementById('user_id')?.value || "0"; // Default to "0" if user_id is not selected
    const orderId = "{{ $serviceOrder->id }}"; // Get the order ID

    if (teamId === "0" || userId === "0") {
        alert("Please select both a valid team and a user.");
        return;
    }

    const BASE_URL = "{{ url('/') }}";

    // Send the POST request
    fetch(BASE_URL + '/service-order/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include CSRF token
        },
        body: JSON.stringify({
            order_id: orderId,
            team_id: teamId,
            user_id: userId
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to update the order.');
        }
        return response.json();
    })
    .then(data => {
        alert(data.success || 'Order updated successfully!');
        location.reload(); // Reload to reflect changes
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update the order. Please try again.');
    });
}


</script>

@endsection
