<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('orders');
    }

    public function suppliers() {
        $suppliers = User::select('id', 'name')->where('is_admin', 0)->get();
        return response()->json($suppliers);
    }

    public function getOrders() {
        $userData = Auth::user();
        if ($userData->is_admin) {
            $orders = Order::allOrders();
        } else {
            $orders = Order::supplierOrders($userData->id);
        }
        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = $this->orderValidation($request);
        if ($validator->fails()) {
            $data['status'] = 5;
            $data['errors'] = $validator->errors();
            return response()->json($data);
        } else {
            $order = $this->setOrderValues($request);
            Order::create($order);
            $data['status'] = 2;
            $data['orders'] = Order::allOrders();
            return response()->json($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order) {
        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $validator = $this->orderValidation($request);
        if ($validator->fails()) {
            $data['status'] = 5;
            $data['errors'] = $validator->errors();
            return response()->json($data);
        } else {
            $order = Order::find($request->order_id);
            $orderData = $this->setOrderValues($request, $order);
            $orderData->update();
            $data['status'] = 2;
            $data['orders'] = Order::allOrders();
            return response()->json($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $order = Order::findOrFail($request->order_id);
        $order->delete();
        return response()->json(array('status' => 2));
    }

    public function delivered(Request $request) {
        $order = Order::findOrFail($request->order_id);
        $order->is_delivered = 1;
        $order->update();
        $product = Product::find($order->product_id);
        $product->stock = $product->stock + $order->quantity;
        $product->update();
        return response()->json(array('status' => 2));
    }

    private function orderValidation($request) {
        $rules = array(
            'product_id' => 'required',
            'user_id' => 'required',
            'quantity' => 'required|numeric'
        );
        return Validator::make($request->all(), $rules);
    }

    private function setOrderValues($request, $order = []) {
        $order['product_id'] = $request->input('product_id');
        $order['user_id'] = $request->input('user_id');
        $order['quantity'] = $request->input('quantity');
        return $order;
    }

}
