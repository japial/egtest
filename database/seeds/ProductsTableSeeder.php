<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $products = [
            [
                'name' => "Product One",
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua consequat.',
                'stock' => 21,
                'price' => 100.50,
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ],
            [
                'name' => "Product Two",
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua consequat.',
                'stock' => 10,
                'price' => 200.50,
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ],
            [
                'name' => "Product Three",
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua consequat.',
                'stock' => 15,
                'price' => 500.50,
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ]
         
        ];

        DB::table('products')->insert($products);
    }

}
