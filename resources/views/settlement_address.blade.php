@extends("template")

@section("title","支払い方法&住所選択")

@section("main")
    <form action="{{url("settlement/confirm")}}" method="post">
        @csrf
        @isset($errors)
            @foreach($errors->all() as $error_message)
                <h2>{{$error_message}}</h2>
            @endforeach
        @endisset
        <div>
            <label>
                クレジットカード
                <input type="radio" name="payment" value="1">
            </label>
            <label>
                口座振替
                <input type="radio" name="payment" value="2">
            </label>
            <label>
                代金引換
                <input type="radio" name="payment" value="3">
            </label>
        </div>
        @foreach($address_data as $data)
            <label>
                この住所を使用する
                <input type="radio" name="select_address" value="{{$loop->iteration}}"
                       onchange="address_select_checker()">
            </label>
            <h4>〒:{{$data->postcode}}</h4>
            <h4>{{$data->prefecture}}</h4>
            <h4>{{$data->city_street}}</h4>
            <h4>{{$data->building}}</h4>
            <h3>差出人:{{$data->addressee}}</h3>
        @endforeach
        <label>
            <input type="radio" name="select_address" id="do_input" value="0" onchange="address_select_checker()"
                   checked>
            住所を入力する
        </label>
        <label>
            郵便番号(ハイフン抜き):
            <input type="tel" name="postcode" class="address_form" maxlength="7" value="{{old("postcode")}}" required>
        </label>
        <label>
            都道府県:
            <input type="text" name="prefecture" class="address_form" value="{{old("prefecture")}}" required>
        </label>
        <label>
            住所(番地まで):
            <input type="text" name="city_street" class="address_form" value="{{old("city_street")}}" required>
        </label>
        <label>
            アパート、建物(任意):
            <input type="text" name="building" class="address_form" value="{{old("building")}}">
        </label>
        <label>
            差出人:
            <input type="text" name="addressee" class="address_form" value="{{old("addressee")}}" required>
        </label>
        <input type="submit" value="送信する">
    </form>

    <script src="{{asset("js/settlement_address.js")}}" type="text/javascript"></script>

@endsection
