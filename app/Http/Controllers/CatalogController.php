<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Notification;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    //

    public function index(Request $request)
    {
        $page = $request->page??1;

        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://mangomart-autocount.myboostorder.com/wp-json/wc/v1/products?page='.$page, [
            'auth' => [
                'ck_2682b35c4d9a8b6b6effac126ac552e0bfb315a0',
                'cs_cab8c9a729dfb49c50ce801a9ea41b577c00ad71'
            ]
        ]);

        $response = json_decode($request->getBody(), true);

        // dd($response);

        $pages = $request->getHeaders()['X-WP-TotalPages'][0];

        $cart = Cart::where([
            'status' => 'New'
        ])->first();

        $cartProducts = [];
        $carts = [];

        if ($cart != null) {
            $cartProducts = CartProduct::where('cart_id', $cart->id)->get();
            foreach($cartProducts as $cartProduct)
            {
                $carts[] = $cartProduct['product_id'];
            }
        }

        $notifications = Notification::orderBy('id', 'desc')->get();


        return view('catalog', ['products' => $response, 'cart_count' => count($cartProducts), 'carts' => $carts, 'pages' => $pages, 'page' => $page, 'notifications' => $notifications]);
    }
}
