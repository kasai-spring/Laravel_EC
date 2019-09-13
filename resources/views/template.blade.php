<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <title><?php echo config("app.name")?> | @yield("title")</title>
    <link href="{{ asset('css/template.css') }}" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=M+PLUS+1p&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@yield("head")
<body>
<header>
    <a id="site_logo" href="{{url("/")}}"><h1><?php echo config("app.name")?></h1></a>
    <div id="header_search">
        <form action="{{url("goods/search")}}">
            <input id="form" type="text" name="q" placeholder="検索ワード">
            <input id="button" type="submit" value="&#xf002;" class="fas">
        </form>
    </div>
    <ul id="header_bar">
        <li><h2><a href="{{url("cart")}}">カート</a></h2></li>
        @if(session("Admin"))
            <li><h2><a href="{{url("admin")}}">管理者</a></h2></li>
        @endif
        @if(session("PublisherController"))
            <li><h2><a href="{{url("publisher")}}">商品管理</a></h2></li>
        @endif
        @if(session("login_id"))
            <div id="header_mypage">
                <input type="checkbox" id="mypage_check" class="pull_down_menu_check">
                <label for="mypage_check" class="pull_down_menu_label" id="header_mypage_label"><h2>{{Session::get("login_name")}} <i
                            class="far fa-caret-square-down"></i><i class="far fa-caret-square-up" style="display: none"></i></h2></label>
                <div id="header_mypage_menu" class="pull_down_menu">
                    <ul>
                        <li><h2><a href="{{url("account/history")}}">購入履歴</a></h2></li>
                        <li><h2><a href="{{url("account/setting")}}">設定</a></h2></li>
                        <li><h2><a href="{{url("logout")}}">ログアウト</a></h2></li>
                    </ul>
                </div>
            </div>
        @else
            <li><h2><a href="{{url("register")}}">登録</a></h2></li>
            <li><h2><a href="{{url("login")}}">ログイン</a></h2></li>
        @endif
    </ul>
    @yield("header")
</header>
<main>
    @yield("main")
</main>
<footer>
    <ul>
        <li><h2><a href="{{url("inquiry")}}">お問い合わせ</a></h2></li>
    </ul>
    @yield("footer")
</footer>
<script src="{{ asset('js/template.js') }}" type="text/javascript"></script>
</body>
</html>
