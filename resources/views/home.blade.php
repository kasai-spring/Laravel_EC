@extends("template")

@section("title","ホーム")

@section("main")
    @if(isset($data))
        @foreach($data as $good)
            <div>
                <h3>{{$good->good_name}}</h3>
                <h5>{{$good->good_price}}</h5>
            </div>
        @endforeach
    @endif
@endsection
