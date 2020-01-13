<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $fillable = [
        'product_id', 'user_id', 'quantity', 'is_delivered'
    ];

    public static function allOrders() {
        $allOrders = (new static)::join('products', 'products.id', '=', 'orders.product_id')
                        ->join('users', 'users.id', '=', 'orders.user_id')
                        ->select('orders.id','orders.quantity', 'orders.created_at', 'products.name', 'products.price', 'users.name as supplier')
                        ->orderBy('orders.id', 'DESC')->get();
        return $allOrders;
    }

    public static function supplierOrders($userID) {
        $allOrders = (new static)::where('orders.user_id', $userID)
                        ->join('products', 'products.id', '=', 'orders.product_id')
                        ->select('orders.id','orders.quantity', 'orders.created_at', 'products.name', 'products.price', 'products.description')
                        ->orderBy('orders.id', 'DESC')->get();
        return $allOrders;
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
