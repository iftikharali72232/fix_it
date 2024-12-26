<?php
namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceOffer;
use App\Models\ServiceOrder;
use App\Models\ServicePhase;
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

        return view('service_order.create', compact('services', 'serviceData', 'variables'));
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

        // Check for an active offer
        $activeOffer = ServiceOffer::where('service_id', $serviceOrder->service_id)
            ->where('status', 1)
            ->first();
        // print_r($phases); exit;
        return view('service_orders.show', compact('serviceOrder', 'variables', 'activeOffer', 'phases'));
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
        // Validate the form data
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'service_cost' => 'required',
            'tax' => 'required',
            'discount' => 'required',
            'variables' => 'required|array',
        ]);

        // Create the service order
        $order = new ServiceOrder();
        $order->service_id = $validated['service_id'];
        $order->service_cost = $validated['service_cost'];
        $order->tax = $validated['tax'];
        $order->discount = $validated['discount'];
        
        // Prepare variables JSON
        $variablesJson = [];
        foreach ($validated['variables'] as $label => $value) {
            $variablesJson[] = [
                'label' => $label,
                'value' => $value,
            ];
        }

        $order->variables_json = json_encode($variablesJson);
        $order->status = 'pending'; // You can customize the status
        $order->save();

        return redirect()->route('service_order.create')->with('success', 'Service order created successfully');
    }
}
