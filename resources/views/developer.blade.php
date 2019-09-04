@extends("template")

@section("title", "開発用ツール")

@section("main")
    <h1>開発者用ツール</h1>
    <form action="{{url("developer/add_random_goods")}}" method="post">
        @csrf
        <input type="submit" value="実行">
    </form>
@endsection
