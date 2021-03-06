<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Notification;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where([
            'status' => 'New'
        ])->first();

        $cartProducts = [];
        $carts = [];

        $notifications = Notification::orderBy('id', 'desc')->get();

        if ($cart != null) {
            $cartProducts = CartProduct::where('cart_id', $cart->id)->get();
            foreach($cartProducts as $cartProduct)
            {
                $carts[] = $cartProduct['product_id'];
            }

            return view('cart', [
                'cart_count' => count($cartProducts),
                'products' => $cartProducts,
                'cart_id' => $cart->id,
                'notifications' => $notifications
            ]);
        }

        return view('cart', ['cart_count' => 0, 'products' => [], 'cart_id' => 0, 'notifications' => $notifications]);
    }


    public function addToCart(Request $request)
    {
        $cart = Cart::firstOrCreate([
            'status' => 'New'
        ]);

        CartProduct::firstOrCreate([
            'product_id' => $request->product_id
        ], [
            'cart_id' => $cart->id,
            'product_json' => json_encode($request->product),
        ]);

        $cartProduct = CartProduct::where('cart_id', $cart->id)->get();

        return count($cartProduct);
    }

    public function deleteFromCart(Request $request)
    {

        $cartProduct = CartProduct::where([
            'product_id' => $request->product_id
        ])->first();

        $cartProduct->delete();

        $cartProducts = CartProduct::where('cart_id', $cartProduct->cart_id)->get();

        $html = "";

        $total = 0;

        foreach($cartProducts as $product)
        {
            $prod = json_decode($product['product_json'], true);
            $desc = strlen($prod['description']) > 250 ? substr($prod['description'], 0, 250)."..." : $prod['description'];
            $price = $prod['variations'][0]['regular_price'];
            $total += $price;

            $html .= '
                <div class="cart">
                    <div class="product_img" style="background-image: url('.$prod['images'][0]['src'] .')"></div>
                    <div class="right_holder">
                        <div class="inner_right">
                            <div class="info">
                                <div class="top">
                                    <h3>' . $prod['name'] . '</h3>
                                    <a class="delete-btn" data-product-id="' . $product['product_id'] . '" href="javascript:void()">Delete</a>
                                </div>
                                <p>'. html_entity_decode($desc)??"No description" .'}</p>
                            </div>
                            <p class="price">RM '. number_format($price, 2, '.', ',') .'</p>
                        </div>
                    </div>
                </div>
            ';
        }

        return json_encode([
            'count' => count($cartProducts),
            'products' => $html,
            'total' => $total
        ]);
    }
}
