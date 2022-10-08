<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

use Validator;
class OrdersController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|between:2,100',
            'quantity' => 'required|integer',
            'product_id' => 'required|integer',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $order = Order::create(array_merge(
            $validator->validated(),
            ['user_id' => auth()->user()['id']],
            ['shipping_date' => $request->get('shipping_date') ?? date('Y-m-d')],
        ));
        return response()->json([
            'message' => 'Order successfully created',
            'order' => $order
        ], 201);
    }

    public function searchById(Request $request)
    {
        $orders = Order::where('user_id', auth()->user()['id'])->where('id', $request->get('id'))->first();

        return response()->json([
            'message' => 'Order finded',
            'orders' => $orders ?? array()
        ], 201);
    }

    public function getAllOrders(Request $request)
    {
        $orders = Order::where('user_id', auth()->user()['id'])->get();

        return response()->json([
            'message' => 'Order list successfully created',
            'orders' => $orders ?? array()
        ], 201);
    }

    public function edit(Request $request)
    {
        if (auth()->user()['user_role'] != 1) {
            return response()->json([
                'message' => 'User Role is not right access',
            ], 400);
        }

        $order = Order::where('id', $request->get('id'))->first();
        if ($order == null) {
            return response()->json([
                'message' => 'Order not found',
            ], 400);
        }

        $order->product_id = $request->get('product_id');
        $order->quantity = $request->get('quantity');
        $order->address = $request->get('address');
        $order->shipping_date = date('Y-m-d', strtotime($request->get('shipping_date')));

        if ($order->save()) {
            return response()->json([
                'message' => 'Order updated',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Order not updated',
            ], 400);
        }
    }
}
