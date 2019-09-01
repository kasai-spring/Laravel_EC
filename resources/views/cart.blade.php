@extends("template")

@section("title","カート")

@section("main")
    @isset($cart_data)
        @foreach($cart_data as $good)

        @endforeach
    @endisset
@endsection
