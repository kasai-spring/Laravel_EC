@extends("template")

@section("title","購入確認")

@section("head")
    <link rel="stylesheet" href="{{asset("css/settlement.css")}}">
@endsection

@section("main")
    <div class="settlement_confirm_form">
        <form id="confirm_form" method="post">
            @csrf
            <input type="hidden" name="cart_token" value="{{Session::get("cart_token")}}">
            <input type="button" class="fas move_button" id="l_r_button" value="&#xf100;"
                   onclick="onClickConfirmFormButton('{{url("settlement/address")}}')">
            <input type="button" class="fas move_button" id="l_r_button" value="決済する"
                   onclick="onClickConfirmFormButton('{{url("settlement/process")}}')">
        </form>
        <div id="shipping_address">
            <table>
                <tr>
                    <th colspan="2">決済方法と配送先住所</th>
                </tr>
                <tr>
                    <th>決済方法</th>
                    <td>{{Session::get("payment_method")}}</td>
                </tr>
                <tr>
                    <th>郵便番号</th>
                    <td>{{Session::get("address_postcode")}}</td>
                </tr>
                <tr>
                    <th>都道府県</th>
                    <td>{{Session::get("address_prefecture")}}</td>
                </tr>
                <tr>
                    <th>市町村番地</th>
                    <td>{{Session::get("address_city_street")}}</td>
                </tr>
                <tr>
                    <th>アパート、建物名</th>
                    <td>{{Session::get("address_building")}}</td>
                </tr>
                <tr>
                    <th>宛先人</th>
                    <td>{{Session::get("address_addressee")}}</td>
                </tr>
            </table>
        </div>
        <div id="shipping_address">
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
