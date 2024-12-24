<?php
namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
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
