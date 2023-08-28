<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Database\Factories\OrderItemFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order = Order::find(1);
        $products = Product::paginate(5);

        for ($i = 0; $i < 5; $i++) {
            $product = $products->random();

            OrderItem::factory()->create([
                'order_id' => $order->id,
                'product_id' => $product->id
            ]);
        }
        
    }
}
