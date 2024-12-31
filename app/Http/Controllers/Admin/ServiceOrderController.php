<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceOrderController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|integer',
            'variables_json' => 'required',
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

    public function userOrders()
    {
        $user = auth()->user();
        if($user->user_type == 1)
        {
            $orders = ServiceOrder::where('customer_id', $user->id)->get();
        } else {
            $orders = ServiceOrder::where('team_user_id', $user->id)->get();
        }

        $res = [];
        foreach($orders as $order)
        {
            $order['service'] = Service::where('id', $order->service_id)->first();
            $res[] = $order;
        }
        return response()->json($res);
    }
    public function singleOrder($id)
    {
        $order = ServiceOrder::find($id);
        $order['team'] = Team::find($order->team_id);
        $order['team_user'] = User::find($order->team_user_id);
        $order['service'] = Service::with(['category', 'servicePhases'])->find($order->service_id);
        return response()->json($order);
    }
    public function updateOrderDate(Request $request, $id)
    {
        $request->validate([
            'date' => 'required', // Ensure a valid date is provided
        ]);

        $order = ServiceOrder::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        $order->service_date = $request->input('date');
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order date updated successfully',
            'order' => $order,
        ]);
    }
}
