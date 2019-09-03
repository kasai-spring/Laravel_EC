@extends("template")

@section("title","マイページ")

@section("main")
    <h1>MyPage</h1>
    <h2>{{$user_data->id}}</h2>
    <h2>{{$user_data->user_name}}</h2>
    <h2>{{$user_data->email}}</h2>
@endsection
