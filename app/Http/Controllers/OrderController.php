<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'seller_id' => $request->seller_id,
            'number' => time(),
            'delivery_address' => $request->delivery_address,
            'total_price' => $request->total_price
        ]);

        $total_price = 0.00;

        foreach($request->items as $item){
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);

            //Sum all product price
            $product = Product::find($item['id']);
            $total_price += $item['quantity'] * $product->price;
        }

        $order->update([
            'total_price' => $total_price,
        ]);

        return response()->json([
            'data' => $order,
        ], status: 201);
    }
}
