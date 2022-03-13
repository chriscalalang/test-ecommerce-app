<?php

namespace Database\Seeders;

use App\Domains\Product\Models\Product;
use App\Domains\Product\Models\ProductInventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class ProductInventoryTableSeeder
 * @package Database\Seeders
 */
class ProductInventoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        foreach ($products as $product) {
            for ($i = 0; $i < 30; $i++) {
                $inventory = new ProductInventory();
                $inventory->product_id = $product->id;

                $inventory->save();
            }
        }
    }
}
