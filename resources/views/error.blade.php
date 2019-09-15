@extends("template")

@section("title", "エラー")

@section("head")
    <link rel="stylesheet" href="{{asset("css/error.css")}}">
@endsection

@section("main")
    <div id="error_page">
        <h1>エラーが発生しました</h1>
        <h3>時間をおいてもう一度試してください</h3>
    </div>
@endsection
