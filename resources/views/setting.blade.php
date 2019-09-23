@extends("template")

@section("title", "アカウント設定")

@section("head")
    <link rel="stylesheet" href="{{asset("css/mypage.css")}}">
@endsection

@section("main")
    <div id="setting_menu">
        <h2>アカウント設定</h2>
        <ul>
            <li><a href="{{url("account/setting/name")}}"><span>名前変更</span><i class="fas fa-angle-double-right"></i></a></li>
            <li><a href="{{url("account/setting/email")}}"><span>メールアドレス変更</span><i class="fas fa-angle-double-right"></i></a></li>
            <li><a href="{{url("account/setting/password")}}"><span>パスワード変更</span><i class="fas fa-angle-double-right"></i></a></li>
        </ul>
    </div>
@endsection

