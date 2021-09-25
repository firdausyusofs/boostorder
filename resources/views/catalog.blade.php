<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Boostorder - Catalog</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset("css/app.css") }}" rel="stylesheet" />
</head>
<body>
    <div class="catalog_wrapper">
        <h1 class="main_title">Products</h1>
        
        <div class="product_holder">
            @foreach ($products as $product)
                <div class="product">
                    <div class="product_img">
                        <div class="product_price">RM {{ number_format($product['variations'][0]['regular_price'], 2, ',', '.') }}</div>
                        <button class='bulk_order_btn'>Select</button>
                    </div>
                    <h3 class="product_title">{{ $product['name'] }}</h3>
                </div>
            @endforeach
            {{-- <div class="product">
                <div class="product_img"></div>
                <h3 class="product_title">Colgate</h3>
            </div>
            <div class="product">
                <div class="product_img"></div>
                <h3 class="product_title">Colgate</h3>
            </div>
            <div class="product">
                <div class="product_img"></div>
                <h3 class="product_title">Colgate</h3>
            </div>
            <div class="product">
                <div class="product_img"></div>
                <h3 class="product_title">Colgate</h3>
            </div> --}}
        </div>

        <button class="order_btn">Order</button>
    </div>
</body>
</html>