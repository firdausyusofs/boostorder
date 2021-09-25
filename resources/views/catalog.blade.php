<!DOCTYPE html>
<html lang="en">
<head>
    <!--
         ______ _         _                  __     __               __
        |  ____(_)       | |                 \ \   / /              / _|
        | |__   _ _ __ __| | __ _ _   _ ___   \ \_/ _   _ ___  ___ | |_
        |  __| | | '__/ _` |/ _` | | | / __|   \   | | | / __|/ _ \|  _|
        | |    | | | | (_| | (_| | |_| \__ \    | || |_| \__ | (_) | |
        |_|    |_|_|  \__,_|\__,_|\__,_|___/    |_| \__,_|___/\___/|_|

    -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Boostorder - Catalog</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset("css/app.css") }}" rel="stylesheet" />
    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            var products = []

            $('.bulk_order_btn').click(function() {
                var index = $(this).data('index')
                var button = $(this)
                $.ajax({
                    url: "{{ url('add_to_cart') }}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        product: $(this).data('json'),
                        "product_id": $(this).data('product-id'),
                    },
                    success: function(data) {
                        if (data) {
                            button.html("In Cart")
                            button.addClass("show")
                            $('.counter').html(data)
                        }
                        // products.push(index)
                    }
                })
                // console.log(products.find(a => a === index))
                // if (products.find(a => a === index) === undefined) {
                //     products.push(index)
                //     $(this).html("Remove from Cart")
                //     $(this).addClass("show")
                // } else {
                    // products.splice(products.indexOf(index), 1)
                    // $(this).html("Add to Cart")
                    // $(this).removeClass("show")
                // }
            })
        })
    </script>
</head>
<body>
    <div class="catalog_wrapper">
        <h1 class="main_title">Products</h1>

        <div class="product_holder">
            @foreach ($products as $key => $product)
                <div class="product">
                    <div class="product_img" style="background-image:url({{ $product['images'][0]['src'] }})">
                        <div class="product_overlay"></div>
                        <div class="product_price">RM {{ number_format($product['variations'][0]['regular_price'], 2, '.', ',') }}</div>
                        <button class="bulk_order_btn {{in_array($product['id'], $carts) ? 'show' : ''}}" data-product-id="{{ $product['id'] }}" data-json="{{ json_encode($product) }}" data-index="{{ $key }}">
                            {{ in_array($product['id'], $carts) ? "In Cart" : "Add to Cart" }}
                        </button>
                    </div>
                    <h3 class="product_title">{{$product['name']}}</h3>
                </div>
            @endforeach
        </div>
        <a href="{{ URL::route('cart') }}">
            <button class="order_btn">
                Cart
                <div class="counter">{{ $cart_count }}</div>
            </button>
        </a>
    </div>
</body>
</html>
