<?php

namespace App\Http\Controllers;

use Validator;
use App\Product;
use App\Order;
use Illuminate\Http\Request;

class ProductController extends Controller {

    public function __construct() {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $products = Product::allProducts();
        return response()->json($products);
    }

    /**
     * Show the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {
        return response()->json($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = $this->productValidation($request);
        if ($validator->fails()) {
            $data['status'] = 5;
            $data['errors'] = $validator->errors();
            return response()->json($data);
        } else {
            $product = $this->setProductValues($request);
            Product::create($product);
            $data['status'] = 2;
            $data['products'] = Product::allProducts();
            return response()->json($data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $validator = $this->productValidation($request);
        if ($validator->fails()) {
            $data['status'] = 5;
            $data['errors'] = $validator->errors();
            return response()->json($data);
        } else {
            $product = Product::find($request->product_id);
            $productData = $this->setProductValues($request, $product);
            $productData->update();
            $data['status'] = 2;
            $data['products'] = Product::allProducts();
            return response()->json($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $product = Product::findOrFail($request->product_id);
        $order = Order::where('product_id', $product->id)->first();
        if (isset($order->id)) {
            $data['status'] = 5;
        } else {
            $product->delete();
            $data['status'] = 2;
        }
        return response()->json($data);
    }

    private function productValidation($request) {
        $rules = array(
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required|numeric'
        );
        return Validator::make($request->all(), $rules);
    }

    private function setProductValues($request, $product = []) {
        $product['name'] = $request->input('name');
        $product['price'] = $request->input('price');
        $product['stock'] = $request->input('stock');
        $product['description'] = $request->input('description');
        return $product;
    }

}
