<?php
namespace App\Http\Controllers;

use App\Models\OrderPhase;
use App\Models\Service;
use App\Models\ServiceOffer;
use App\Models\ServiceOrder;
use App\Models\ServicePhase;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
    public function index()
    {
        // Fetch service orders with the related service name and customer name
        $serviceOrders = ServiceOrder::join('users', 'service_orders.customer_id', '=', 'users.id')
            ->join('services', 'service_orders.service_id', '=', 'services.id') // Join the services table to get service name
            ->where('users.user_type', 1)
            ->select('service_orders.*', 'users.name as customer_name', 'services.service_name as service_name')
            ->get();

        return view('service_orders.index', compact('serviceOrders'));
    }
    // Show the service order creation form
    public function create(Request $request)
    {
        $services = Service::all(); // Fetch all services
        $serviceData = null; // Default to null
        $variables = []; // Default to empty array

        if ($request->has('service_id')) {
            // Fetch service data
            $serviceData = Service::find($request->service_id);

            if ($serviceData && $serviceData->variables_json) {
                // Decode JSON if it exists
                $variables = json_decode($serviceData->variables_json, true);
            }
        }

        return view('service_orders.create', compact('services', 'serviceData', 'variables'));
    }
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:service_orders,id',
            'team_id' => 'required|exists:teams,id',
            'user_id' => 'required|exists:users,id',
        ]);
    
        $order = ServiceOrder::find($request->order_id);
    
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
    
        $order->team_id = $request->team_id;
        $order->team_user_id = $request->user_id;
        $order->status = 1;
        $order->save();
    
        return response()->json(['success' => 'Order updated successfully']);
    }
    
    public function show($id)
    {
        $serviceOrder = ServiceOrder::with(['service', 'customer'])
            ->where('id', $id)
            ->firstOrFail();

        // Decode variables_json
        $variables = $serviceOrder->variables_json ? json_decode($serviceOrder->variables_json, true) : [];

        // Fetch service phases
        $phases = ServicePhase::where('service_id', $serviceOrder->service_id)
        ->get();
        foreach($phases as $pk => $phase)
        {
            $phases[$pk]['response'] = OrderPhase::where('order_id', $id)->where('phase_id', $phase->id)->first();
        }
        // Check for an active offer
        $activeOffer = ServiceOffer::where('service_id', $serviceOrder->service_id)
            ->where('status', 1)
            ->first();
        $service = Service::where('id', $serviceOrder->service_id)->first();
        $teams = Team::where('category_id', $service->category_id)->get();
        $users = $serviceOrder->team_id > 0 ? User::where('team_id', $serviceOrder->team_id)->get() : [];
        // echo "<pre>";print_r($phases); exit;
        return view('service_orders.show', compact('serviceOrder', 'variables', 'activeOffer', 'phases', 'teams', 'users'));
    }

    public function getTeamUsers($id)
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json(['error' => 'Team not found'], 404);
        }

        $users = User::where('team_id', $id)->get(); // Assuming a one-to-many relationship exists between Team and User
        return response()->json($users);
    }



    // Fetch service data based on selected service
    public function fetchServiceData(Request $request)
    {
        $serviceId = $request->input('service_id');
        $service = Service::find($serviceId);

        if ($service) {
            return response()->json($service);
        }

        return response()->json(['error' => 'Service not found'], 404);
    }

    // Store the service order in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_id' => 'required|integer|exists:services,id',
            'variables' => 'required|array',
            'service_cost' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'service_date' => 'required|date',
        ]);
        $serviceData = Service::find($request->service_id);
        $variables = [];
        foreach ($request->variables as $label => $value) {
            $variable = collect(json_decode($serviceData->variables_json, true))
                ->firstWhere('label', $label);

            $variables[] = [
                'label' => $label,
                'type' => $variable['type'] ?? '',
                'dropdown_values' => $variable['dropdown_values'] ?? null,
                'value' => $value,
            ];
        }

        // echo "<pre>";print_r($variables); exit;
        $validatedData['variables_json'] = json_encode($variables);

        ServiceOrder::create($validatedData);

        return redirect()->route('service_orders.index')->with('success', 'Order created successfully.');
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2,3,4',
        ]);

        $serviceOrder = ServiceOrder::findOrFail($id);
        $serviceOrder->status = $request->status;
        $serviceOrder->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

}
