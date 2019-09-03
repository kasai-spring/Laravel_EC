@extends("template")

@section("title","住所選択")

@section("main")
    <form action="{{url("settlement/confirm")}}" method="post">
        @csrf
        @foreach($address_data as $data)
            <label>
                この住所を使用する
                <input type="radio" name="select_address" value="{{$loop->iteration}}" onchange="address_select_checker()" @if($loop->first) checked @endif>
            </label>
            <h4>〒:{{$data->postcode}}</h4>
            <h4>{{$data->prefecture}}</h4>
            <h4>{{$data->city_street}}</h4>
            <h4>{{$data->building}}</h4>
            <h3>差出人:{{$data->addressee}}</h3>
        @endforeach
        <label>
            <input type="radio" name="select_address" id="do_input" value="0" onchange="address_select_checker()" @if(count($address_data) == 0) checked @endif>
            住所を入力する
        </label>
        <label>
            郵便番号(ハイフン抜き):
            <input type="tel" name="postcode" class="address_form" maxlength="7" required>
        </label>
        <label>
            都道府県:
            <input type="text" name="prefecture" class="address_form" required>
        </label>
        <label>
            住所(番地まで):
            <input type="text" name="address" class="address_form" required>
        </label>
        <label>
            アパート、建物(任意):
            <input type="text" name="building" class="address_form">
        </label>
        <label>
            差出人:
            <input type="text" name="addressee" class="address_form" required>
        </label>
        <input type="submit" value="送信する">
    </form>

    <script src="{{asset("js/settlement_address.js")}}" type="text/javascript"></script>

@endsection
