<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceOrderController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|integer',
            'variables_json' => 'required|json',
            'service_cost' => 'required|numeric',
            'service_date' => 'required|date',
            'tax' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
        ]);

        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.',
            ], 401);
        }

        $data['customer_id'] = $user->id;
        $order = ServiceOrder::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Service order created successfully.',
            'data' => $order,
        ], 201);
    }

    public function createOrder(Request $request)
    {
        $serviceId = $request->input('service_id');
        $service = Service::find($serviceId);
        return response()->json($service);
    }

}
