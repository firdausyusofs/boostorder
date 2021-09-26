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
    <title>Boostorder - Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset("css/app.css") }}" rel="stylesheet" />
    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.noti svg').click(function() {
                $('.noti_list').toggleClass('show')
            });

            $('document').mouseup(function(e){
                var container = $(".noti_list");

                if ($(e.target).closest(".noti_list").length === 0)
                {
                    $('.noti_list').removeClass('show')
                }
            })

            $('body').on('click', '.delete-btn', function() {
                if (confirm('Are you sure to delete this product from cart?')) {
                    $.ajax({
                        url: "{{ url('delete_from_cart') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "product_id": $(this).data('product-id'),
                        },
                        dataType: "JSON",
                        success: function(data) {
                            // $('.counter').html(data["count"])

                            // $('.cart-list').html(data['products'])
                            window.location.reload()
                        }
                    })
                }
            })

            $('.submit-btn').click(function() {
                if (confirm('Are you sure?')) {
                    $.ajax({
                        url: "{{ url('submit_order') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            cart_id: $(this).data('cart-id'),
                            total: $(this).data('total')
                        },
                        success: function(data) {
                            window.location.href = "{{ URL::route('catalog') }}"
                        }
                    })
                }
            })
        })
    </script>
</head>
<body>
    <div class="catalog_wrapper">
        <div class="top_bar">
            <h1 class="main_title">Cart</h1>

            <div class="right">
                <div class="noti">
                    <div class="red-dot {{ count($notifications) > 0 ? "show" : "" }}"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15.137 3.945c-.644-.374-1.042-1.07-1.041-1.82v-.003c.001-1.172-.938-2.122-2.096-2.122s-2.097.95-2.097 2.122v.003c.001.751-.396 1.446-1.041 1.82-4.667 2.712-1.985 11.715-6.862 13.306v1.749h20v-1.749c-4.877-1.591-2.195-10.594-6.863-13.306zm-3.137-2.945c.552 0 1 .449 1 1 0 .552-.448 1-1 1s-1-.448-1-1c0-.551.448-1 1-1zm3 20c0 1.598-1.392 3-2.971 3s-3.029-1.402-3.029-3h6z"/></svg>
                    <div class="noti_list">
                        <div class="noti_title">Notifications</div>
                        <div class="noti_inner">
                            @if(count($notifications) == 0)
                                <h4 class="no-noti">No notifications</h4>
                            @else
                                @foreach($notifications as $notifcation)
                                    <div>
                                        <p>{{ $notifcation['message'] }}</p>
                                    </div>
                                @endforeach
                            @endif
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

        <div class="cart_holder">
            @if (count($products) == 0)
                <div class="empty">
                    <h1>Cart is empty</h1>
                    <a href="{{ URL::route('catalog') }}">Back to catalog</a>
                </div>
            @else

            <h2>Total Products: {{ $cart_count }}</h2>

            <div class="flex">
                @php
                    $total = 0
                @endphp
                <div class="cart-list">
                    @foreach($products as $product)
                        @php
                            $prod = json_decode($product['product_json'], true);
                            $desc = strlen($prod['description']) > 250 ? substr($prod['description'], 0, 250)."..." : $prod['description'];
                            $price = $prod['variations'][0]['regular_price'];
                            $total += $price;
                        @endphp
                        <div class="cart">
                            <div class="product_img" style="background-image: url({{ $prod['images'][0]['src'] }})"></div>
                            <div class="right_holder">
                                <div class="inner_right">
                                    <div class="info">
                                        <div class="top">
                                            <h3>{{ $prod['name'] }}</h3>
                                            <a class="delete-btn" data-product-id="{{ $product['product_id'] }}" href="javascript:void();">Delete</a>
                                        </div>
                                        <p>{!! $desc??"No description" !!}</p>
                                    </div>
                                    <p class="price">RM {{ number_format($price, 2, '.', ',') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <p>Total amount: <b>RM {{ number_format($total, 2, '.', ',') }}</b></p>

                <div class="button_holder">
                    <a href="{{ URL::route('catalog') }}">Back to catalog</a>
                    <button class="submit-btn" data-total="{{ $total }}" data-cart-id="{{ $cart_id }}">Submit Order</button>
                </div>
            </div>

            @endif
        </div>
    </div>
</body>
</html>
