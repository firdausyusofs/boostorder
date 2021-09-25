<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    //

    public function index()
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://mangomart-autocount.myboostorder.com/wp-json/wc/v1/products', [
            'auth' => [
                'ck_2682b35c4d9a8b6b6effac126ac552e0bfb315a0',
                'cs_cab8c9a729dfb49c50ce801a9ea41b577c00ad71'
            ]
        ]);

        $response = json_decode($request->getBody(), true);

        return view('catalog', ['products' => $response]);
    }
}
