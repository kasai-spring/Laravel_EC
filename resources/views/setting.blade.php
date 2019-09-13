@extends("template")

@section("title", "アカウント設定")

@section("head")
    <link rel="stylesheet" href="{{asset("css/mypage.css")}}">
@endsection

@section("main")
    <div id="setting_menu">
        <h2>アカウント設定</h2>
        <ul>
            <li><a href="{{url("account/setting/name")}}">名前変更</a></li>
            <li><a href="{{url("account/setting/email")}}">メールアドレス変更</a></li>
            <li><a href="{{url("account/setting/password")}}">パスワード変更</a></li>
        </ul>
    </div>
@endsection

