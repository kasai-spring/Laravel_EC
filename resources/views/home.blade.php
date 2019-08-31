@extends("template")

@section("title","ホーム")

@section("main")
    @if(isset($data))
        @foreach($data as $good)
            <div>
                <a href="{{url("goods/detail/".$good->id)}}">
                    <h3>{{$good->good_name}}</h3>
                    <h5>{{$good->good_price}}</h5>
                </a>

            </div>
        @endforeach
    @endif
@endsection
