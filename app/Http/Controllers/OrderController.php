<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\CartProduct;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::get();

        return view('order', ['order_count' => 0, 'orders' => $orders, 'cart_id' => 0]);
    }

    public function submitOrder(Request $request)
    {

        $order = Order::create([
            'total_amount' => $request->total
        ]);

        $cartProducts = CartProduct::where(['cart_id' => $request->cart_id])->get();

        foreach ($cartProducts as $product)
        {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'product_json' => $product['product_json']
            ]);
        }

        Cart::where('id', $request->cart_id)->update(['status' => 'Ordered']);

        return true;

    }

    public function order_update_show($id)
    {
        $order = Order::where('id', $id)->first();

        return view('order_update', ['order' => $order, 'products' => $order->products()->get()]);
    }

    public function order_update(Request $request)
    {

        Order::where('id', $request->order_id)->update(['status' => $request->status]);
        Notification::create([
            'message' => 'Your order '. sprintf("%04d", $request->order_id) .' has been '. strtolower($request->status),
        ]);

    }
}
