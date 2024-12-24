<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'service_id' => 'required|integer',
            'variables_json' => 'required|json',
            'service_cost' => 'required|numeric',
            'service_date' => 'required|date',
            'tax' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
        ]);

        $order = ServiceOrder::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Service order created successfully.',
            'data' => $order,
        ], 200);
    }
    public function createOrder(Request $request)
    {
        $serviceId = $request->input('service_id');
        $service = Service::find($serviceId);
        return response()->json($service);
    }

}
