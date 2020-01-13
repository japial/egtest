<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $fillable = [
        'name', 'price', 'description', 'stock'
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }

}
