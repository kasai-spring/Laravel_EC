@extends("template")

@section("title","購入確認")

@section("main")
    @foreach(Session::get("cart_data") as $cart)
        <h2>商品名:{{$cart->good_name}}</h2>
        <h3>商品価格:{{$cart->good_price}}</h3>
        <h3>商品数:{{$cart->quantity}}</h3>
    @endforeach
    <h2>配送先</h2>
    <h4>〒{{Session::get("address_postcode")}}</h4>
    <h3>{{Session::get("address_prefecture")}} {{Session::get("address_city_street")}}</h3>
    <h3>{{Session::get("address_building")}}</h3>
    <h3>宛先人:{{Session::get("address_addressee")}}</h3>
    <form action="{{url("settlement/process")}}" method="post">
        @csrf
        <input type="submit" value="決済する">
    </form>

@endsection
