@extends("template")

@section("title")
    {{$good_data->good_name}}の詳細
@endsection

@section("main")
    <h2>商品名:{{$good_data->good_name}}</h2>
    <h3>商品価格:{{$good_data->good_price}}円</h3>
    <h4>製造会社:{{$good_data->good_producer}}</h4>
    <h4>販売会社:{{$good_data->good_publisher}}</h4>
    <h5>カテゴリー:{{$good_data->goodscategory->category_name}}</h5>

    @if($good_data->good_stock > 0)
        <form action="{{url("goods/add_cart/".$good_data->good_id)}}" method="post">
            @csrf
            <label>
                購入個数:
                <select name="quantity">
                    @for($i = 1;$i<=min($good_data->good_stock, 30);$i++)
                        <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </label>
            <input type="submit" value="購入する">
        </form>
    @else
        <h2>在庫切れです</h2>
    @endif

    <h1>関連商品</h1>

    @foreach($relate_goods as $relate_good)
        <a href="{{url("goods/detail/".$relate_good->good_id)}}">
            <h2>{{$relate_good->good_name}}</h2>
            <h3>{{$relate_good->good_price}}円</h3>
            <h4>{{$good_data->goodscategory->category_name}}</h4>
        </a>
    @endforeach
@endsection
