@extends("template")

@section("title","カート")

@section("head")
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@endsection

@section("main")
    <div id="cart_message">
    @if (session('flash_message'))
        {{ session('flash_message') }}
    @endif
    </div>
    @isset($cart_data)
        @foreach($cart_data as $cart)
            <div class="good" id="{{$cart->good_id}}">
                <h2>商品名:{{$cart->good_name}}</h2>
                <h3>商品価格:{{$cart->good_price}}</h3>
                <label>
                    購入個数:
                    <select name="quantity" class="cart_quantity">
                        @for($i = 1;$i<=min($cart->good_stock, 30);$i++)
                            @if($i == $cart->quantity)
                                <option value="{{$i}}" selected>{{$i}}</option>
                            @else
                                <option value="{{$i}}" >{{$i}}</option>
                            @endif
                        @endfor
                    </select>
                </label>
                <input type="button" class="cart_delete_button" value="削除する">
            </div>
        @endforeach
        @if(count($cart_data) == 0)
            <div id="no_cart_message">
                <h3>カート内に商品がありません</h3>
            </div>
        @else
            <div id="no_cart_message" style="display: none">
                <h3>カート内に商品がありません</h3>
            </div>
            <form action="{{url("settlement/address")}}" id="settlement" method="post">
                @csrf
                <input type="submit" value="レジに進む">
            </form>
        @endif
    @endisset

    <script src="{{asset("js/cart.js")}}" type="text/javascript"></script>
@endsection
