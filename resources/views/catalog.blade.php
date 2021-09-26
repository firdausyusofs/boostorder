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
    <script src="{{ asset("js/app.js") }}"></script>
    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.noti svg').click(function() {
                $('.noti_list').toggleClass('show')
            });

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
        <div class="top_bar">
            <h1 class="main_title">Products</h1>

            <div class="right">
                <div class="noti">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15.137 3.945c-.644-.374-1.042-1.07-1.041-1.82v-.003c.001-1.172-.938-2.122-2.096-2.122s-2.097.95-2.097 2.122v.003c.001.751-.396 1.446-1.041 1.82-4.667 2.712-1.985 11.715-6.862 13.306v1.749h20v-1.749c-4.877-1.591-2.195-10.594-6.863-13.306zm-3.137-2.945c.552 0 1 .449 1 1 0 .552-.448 1-1 1s-1-.448-1-1c0-.551.448-1 1-1zm3 20c0 1.598-1.392 3-2.971 3s-3.029-1.402-3.029-3h6z"/></svg>
                    <div class="noti_list">
                        <div class="noti_title">Notifications</div>
                        <div class="noti_inner">
                            @foreach($notifications as $notifcation)
                                <div>
                                    <p>{{ $notifcation['message'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <a href="{{ URL::route('cart') }}">
                    <button class="order_btn">
                        Cart
                        <div class="counter">{{ $cart_count }}</div>
                    </button>
                </a>
            </div>
        </div>

        <div class="product_holder">
            @foreach ($products as $key => $product)
                <div class="product">
                    <div class="product_img" style="background-image:url({{ $product['images'][0]['src'] }})">
                        <div class="product_overlay"></div>
                        <div class="product_price">RM {{ number_format($product['variations'][0]['regular_price']??0, 2, '.', ',') }}</div>
                        <button class="bulk_order_btn {{in_array($product['id'], $carts) ? 'show' : ''}}" data-product-id="{{ $product['id'] }}" data-json="{{ json_encode($product) }}" data-index="{{ $key }}">
                            {{ in_array($product['id'], $carts) ? "In Cart" : "Add to Cart" }}
                        </button>
                    </div>
                    <h3 class="product_title">{{$product['name']}}</h3>
                </div>
            @endforeach
        </div>

        <div class="pagination_holder">
            @for($i = 1; $i <= $pages; $i++)
                <a href="{{ URL::route('catalog', ['page' => $i]) }}"><div class="page {{$page == $i ? 'active' : ''}}">{{$i}}</div></a>
            @endfor
        </div>
    </div>
</body>
</html>
