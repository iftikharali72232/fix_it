<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\Team;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        'wallet_id' => 'required'
    ]);

    $user = auth()->user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not authenticated.',
        ], 401);
    }

    $wallet_id = explode('-', base64_decode($request->wallet_id))[0];
    $user_id = explode('-', base64_decode($request->wallet_id))[1];

    $wallet = Wallet::where('id', $wallet_id)->where('user_id', $user_id)->first();
    if (empty($wallet)) {
        return response()->json(['msg' => "Your Voucher ID is invalid", 'status' => 0]);
    }

    if ($data['service_cost'] > $wallet->amount) {
        return response()->json(['msg' => "Your Voucher ID does not have enough points to get this service", 'status' => 0]);
    }

    // Transaction Start
    DB::beginTransaction();

        try {
            // Deduct amount from wallet
            $wallet->amount -= $data['service_cost'];
            $wallet->save();

            // Create Wallet History
            $history = WalletHistory::create([
                'wallet_id' => $wallet->id,
                'amount' => $data['service_cost'],
                'is_expanse' => 1,
                'description' => 'Charge your Voucher ID against your Service request (' . $data['service_id'] . ') with Points ' . $data['service_cost']
            ]);

            // Create Service Order
            $data['customer_id'] = $user->id;
            $order = ServiceOrder::create($data);

            // Commit transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Service order created successfully.',
                'data' => $order,
            ], 201);

        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create service order. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
        
        $order['service'] = Service::with(['category',
                                'servicePhases.orderPhases' => function ($query) use ($order) {
                                    $query->where('order_id', $order->id);
                                }
                            ])->find($order->service_id);
        
        return response()->json($order);
    }
    public function cancelOrder($id)
    {
        $order = ServiceOrder::find($id);
        if(!empty($order) && $order->status == 0)
        {
            $order = ServiceOrder::where('id', $id)->update(['status' => 3]);
            return response()->json(['msg' => 'Order cancel successfully', 'status' => 1]);
        } elseif($order->status == 1){
            
            return response()->json(['msg' => 'You can never cancel order now, because the order in processing']);
        }
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
