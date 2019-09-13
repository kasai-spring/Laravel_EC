@extends("template")

@section("title")
    {{$good_data->good_name}}の詳細
@endsection

@section("head")
    <link rel="stylesheet" href="{{asset("css/good_detail.css")}}">
@endsection

@section("main")
    <div id="good_detail_form">
        <img src="{{asset("storage/goods_images/".$good_data->picture_path)}}"
             alt="{{$good_data->good_name}}のイメージ">
        <table>
            <tr>
                <th>商品名</th>
                <td>{{$good_data->good_name}}</td>
            </tr>
            <tr>
                <th>商品価格</th>
                <td>{{$good_data->good_price}}円</td>
            </tr>
            <tr>
                <th>製造会社</th>
                <td>{{$good_data->good_producer}}</td>
            </tr>
            <tr>
                <th>販売会社</th>
                <td>{{$good_data->publisher->publisher_name}}</td>
            </tr>
            <tr>
                <th>カテゴリー</th>
                <td>{{$good_data->goodscategory->category_name}}</td>
            </tr>
        </table>
        <div id="add_cart">
            @if($good_data->good_stock > 0)
                <form action="{{url("goods/add_cart/".$good_data->good_id)}}" method="post">
                    @csrf
                    <input type="submit" value="購入する">
                    <label>
                        購入個数:
                        <select name="quantity">
                            @for($i = 1;$i<=min($good_data->good_stock, 30);$i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </label>
                </form>
            @else
                <h2>在庫切れです</h2>
            @endif
        </div>
    </div>
    <div id="relate_goods">
        <h1>関連商品</h1>
        <div id="good_list">
            @foreach($relate_goods as $relate_good)
                <div id="good">
                    <a href="{{url("goods/detail/".$relate_good->good_id)}}">
                        <img src="{{asset("storage/goods_images/".$relate_good->picture_path)}}"
                             alt="{{$relate_good->good_name}}のイメージ">

                    </a>
                    <a href="{{url("goods/detail/".$relate_good->good_id)}}"><h2>{{$relate_good->good_name}}</h2></a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
