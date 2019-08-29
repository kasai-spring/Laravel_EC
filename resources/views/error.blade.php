@extends("template")

@section("title", "エラー")

@section("main")
    <h2>エラーが発生しました</h2>
    <h4><a href="{{url('/')}}">ホーム画面に戻る</a></h4>
    @if(session("login_id"))
        <h3>{{session("login_id")}}</h3>
        @else
        <h3>ゲストだよ</h3>
    @endif
@endsection
