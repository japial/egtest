<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $fillable = [
        'name', 'price', 'description', 'stock'
    ];

    public static function allProducts() {
        $allProducts = (new static)::select('id', 'name', 'description', 'stock', 'price')
                ->orderBy('id', 'DESC')
                ->get();
        return $allProducts;
    }
    public function orders() {
        return $this->hasMany(Order::class);
    }

}
