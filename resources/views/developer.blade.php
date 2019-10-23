@extends("template")

@section("title", "開発用ツール")

@section("head")
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@endsection

@section("main")
    <h1>開発者用ツール</h1>
    <form action="{{url("developer/add_random_goods")}}" method="post">
        @csrf
        <input type="submit" value="実行">
    </form>
    <a href="{{url("developer/test_module")}}"><input type="button" value="テストモジュール"></a>

    <input type="button" value="ajax" onclick="onAjaxClick()">
    <script src="{{asset("js/cart.js")}}" type="text/javascript"></script>
@endsection
