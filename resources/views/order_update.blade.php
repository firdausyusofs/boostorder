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
    <title>Boostorder - Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset("css/app.css") }}" rel="stylesheet" />
    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {

            $('.submit-btn').click(function() {
                if (confirm('Are you sure?')) {
                    $.ajax({
                        url: "{{ url('update_order') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            status: $('.status-select').val(),
                            order_id: $(this).data('order-id')
                        },
                        success: function(data) {
                            window.location.href = "{{ URL::route('order') }}"
                        }
                    })
                }
            })
        })
    </script>
</head>
<body>
    <div class="catalog_wrapper">
        <h1 class="main_title">Order: {{ sprintf("%04d", $order['id']) }}</h1>

        <div class="cart_holder">
            @if (count($products) == 0)
                <div class="empty">
                    <h1>Cart is empty</h1>
                    <a href="{{ URL::route('catalog') }}">Back to catalog</a>
                </div>
            @else

            <h2>Total Products: {{ count($products) }}</h2>

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
                                        </div>
                                        <p>{!! $desc??"No description" !!}</p>
                                    </div>
                                    <p class="price">RM {{ number_format($price, 2, '.', ',') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <select class="status-select">
                        <option value="">Please select Status</option>
                        <option value="Processed">Processed</option>
                        <option value="Shipped">Shipped</option>
                        <option value="Delivered">Delivered</option>
                    </select>
                </div>

                <p>Total amount: <b>RM {{ number_format($total, 2, '.', ',') }}</b></p>

                <div class="button_holder">
                    <a href="{{ URL::route('order') }}">Back to order</a>
                    <button class="submit-btn" data-order-id="{{ $order['id'] }}">Update</button>
                </div>
            </div>

            @endif
        </div>
    </div>
</body>
</html>
