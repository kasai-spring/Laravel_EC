@extends("template")

@section("title","カート")

@section("main")
    @isset($cart_data)
        @foreach($cart_data as $cart)
            <h2>商品名:{{$cart->good->good_name}}</h2>
            <h3>商品価格:{{$cart->good->good_price}}</h3>
            <h3>商品数:{{$cart->good_count}}</h3>
        @endforeach
        @if(count($cart_data) == 0)
            <h3>カート内に商品が存在しません</h3>
        @else
            <form action="{{url("settlement/address")}}" method="post">
                @csrf
                <input type="submit" value="決済する">
            </form>
            <h4>決済する</h4>
        @endif
    @endisset

@endsection
