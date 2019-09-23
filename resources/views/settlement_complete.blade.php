@extends("template")

@section("title", "購入完了")

@section("head")
    <link rel="stylesheet" href="{{asset("css/settlement.css")}}">
@endsection

@section("main")
    <div class="settlement_form">
        <div id="shipping_data">
            <h2>購入が完了しました</h2>
            <table>
                <tr>
                    <th>購入商品</th>
                </tr>
                @foreach(Session::get("cart_data") as $cart)
                    <tr>
                        <td class="good">
                            <img src="{{asset("storage/goods_images/".$cart->picture_path)}}"
                                 alt="{{$cart->good_name}}のイメージ">
                            <div class="good_detail">
                                <p>{{$cart->good_name}}</p>
                                <p>￥{{$cart->good_price}}</p>
                                <p>数量:{{$cart->quantity}}</p>
                            </div>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th id="total_price">合計金額:{{Session::get("total_price")}}円</th>
                </tr>
            </table>
        </div>
    </div>
@endsection
