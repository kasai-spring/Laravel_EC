@extends("template")

@section("title","住所選択")

@section("main")
    <form action="">
        @csrf
        @if(count($address_data) == 0)
            <h3>登録されてる住所がありません</h3>
        @else
            @foreach($address_data as $data)
                <h4>〒:{{$data->postcode}}</h4>
                <h4>{{$data->prefecture}}</h4>
                <h4>{{$data->city_street}}</h4>
                <h4>{{$data->building}}</h4>
                <h3>差出人:{{$data->addressee}}</h3>
            @endforeach
        @endif
        <label>
            郵便番号(ハイフン抜き):
            <input type="tel" name="postcode" maxlength="7" required>
        </label>
        <label>
            都道府県:
            <input type="text" name="prefecture" required>
        </label>
        <label>
            住所(番地まで):
            <input type="text" name="address" required>
        </label>
        <label>
            アパート、建物(任意):
            <input type="text" name="building">
        </label>


            <input type="submit" value="送信する">
    </form>

@endsection
