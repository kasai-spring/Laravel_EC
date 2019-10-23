@extends("template")

@section("title","カート")

@section("head")
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset("css/cart.css")}}">
@endsection

@section("main")
    <div id="cart_form">
        <div id="cart_message">
            @if (session('flash_message'))
                <h2>{{ session('flash_message') }}</h2>
            @endif
        </div>
        @isset($cart_data)
            @if(count($cart_data) == 0)
                <div id="cart_message">
                    <h2>カート内に商品がありません</h2>
                </div>
            @else
                <div id="cart_message" class="no_cart" style="display: none">
                    <h2>カート内に商品がありません</h2>
                </div>
                <div id="table_top_obj">
                    <h2>カート</h2>
                    <a href="{{url("settlement/address")}}" id="settlement"><input type="button" value="レジに進む"></a>
                </div>
            @endif
            <table class="good_table">
                @foreach($cart_data as $cart)
                    <tr id="{{$cart->good_id}}">
                        <td>
                            <div class="good">
                                <img src="{{asset("storage/goods_images/".$cart->picture_path)}}"
                                     alt="{{$cart->good_name}}のイメージ">
                                <div class="good_detail">
                                    <h2>{{$cart->good_name}}</h2>
                                    <h3 id="good_price">{{$cart->good_price}}円</h3>
                                </div>
                                <label>
                                    <select id="quantity" name="quantity" class="cart_quantity">
                                        @for($i = 1;$i<=min($cart->good_stock, 30);$i++)
                                            @if($i == $cart->quantity)
                                                <option value="{{$i}}" selected>{{$i}}</option>
                                            @else
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endif
                                        @endfor
                                    </select>
                                </label>
                                <input type="button" class="fas cart_delete_button" value="&#xf1f8;">
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if(count($cart_data) != 0)
                    <tr>
                        <th>
                            <h2>合計金額:<span id="total_price"></span>円</h2>
                        </th>
                    </tr>
                @endif
            </table>
        @endisset
    </div>

    <script src="{{asset("js/cart.js")}}" type="text/javascript"></script>
@endsection
