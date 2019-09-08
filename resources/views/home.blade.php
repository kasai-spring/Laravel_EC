@extends("template")

@section("title","ホーム")

@section("head")
    <link rel="stylesheet" href="{{asset("css/home.css")}}">
@endsection

@section("main")
    @if(isset($data))
        <div id="goods_box">
        @foreach($data as $good)
            <div id="good">
                <a href="{{url("goods/detail/".$good->good_id)}}">
                    <img src="{{asset("storage/goods_images/".$good->picture_path)}}" alt="{{$good->good_name}}のイメージ">
                    <h3>{{$good->good_name}}</h3>
                    <h5>￥{{$good->good_price}}</h5>
                </a>
            </div>
        @endforeach
    @endif
        </div>
@endsection
