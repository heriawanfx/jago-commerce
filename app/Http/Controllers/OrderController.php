<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Midtrans\CreatePaymentUrlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Redirect;

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

        $midtrans = new CreatePaymentUrlService();
        $orderWithUserItems = $order->load('user', 'orderItems');

        //return $orderWithUserItems;

        $paymentUrl = $midtrans->getPaymentUrl($orderWithUserItems);

        //dd($paymentUrl);

        $order->update([
            'total_price' => $total_price,            
            'payment_url' => $paymentUrl,
        ]);
        
        return response()->json([
            'data' => $order,
        ], status: 201, options: JSON_UNESCAPED_SLASHES);
    }
}
