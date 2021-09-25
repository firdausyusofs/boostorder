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
                            alert("Done")
                        }
                    })
                }
            })
        })
    </script>
</head>
<body>
    <div class="catalog_wrapper">
        <h1 class="main_title">Orders</h1>

        <div class="cart_holder">
            @if (count($orders) == 0)
                <div class="empty">
                    <h1>Order is empty</h1>
                    <a href="{{ URL::route('catalog') }}">Back to catalog</a>  
                </div>
            @else

            <table class="order_table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Order ID</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ sprintf("%04d", $order['id']) }}</td>
                            <td>{{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}</td>
                            <td>
                                <a href="">Update</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @endif
        </div>
    </div>
</body>
</html>
