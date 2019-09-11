@extends("template")

@section("title", "パスワード再設定")

@section("head")
    <link rel="stylesheet" href="{{asset("css/l_r_form.css")}}">
@endsection

@section("main")
    <div id="l_r_form">
        <h2>パスワード再設定用のURLを、入力されたメールアドレスに送信しました</h2>
        <h4>メールのURLから次の手順に移ってください</h4>
    </div>
@endsection
