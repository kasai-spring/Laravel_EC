@extends("template")

@section("title","カート")

@section("main")
    @isset($cart_data)
        @foreach($cart_data as $cart)
            <h2>商品名:{{$cart->good_name}}</h2>
            <h3>商品価格:{{$cart->good_price}}</h3>
            <h3>商品数:{{$cart->quantity}}</h3>
        @endforeach
        @if(count($cart_data) == 0)
            <h3>カート内に商品が存在しません</h3>
        @else
            <a href="{{url("settlement/address")}}">決済する</a>
        @endif
    @endisset

@endsection
