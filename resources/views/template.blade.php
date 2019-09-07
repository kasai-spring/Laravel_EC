<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <title><?php echo config("app.name")?> | @yield("title")</title>
    <link href="{{ asset('css/template.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
@yield("head")
<body>
<header>
    <a id="site_logo" href="{{url("/")}}"><h1><?php echo config("app.name")?></h1></a>
    <ul id="header_bar">
        <form action="{{url("goods/search")}}">
            <input type="text" name="q">
            <input type="submit" value="検索する">
        </form>
        @if(session("login_id"))
            <li><a href="{{url("mypage")}}"><h2>マイページ</h2></a></li>
            <li><h2><a href="{{url("logout")}}">ログアウト</a></h2></li>
        @else
            <li><h2><a href="{{url("login")}}">ログイン</a></h2></li>
            <li><h2><a href="{{url("register")}}">登録</a></h2></li>
        @endif
        @if(session("Admin"))
            <li><h2><a href="{{url("admin")}}">管理者ページ</a></h2></li>
        @endif
        <li><h2><a href="{{url("cart")}}">カート</a></h2></li>

    </ul>
    @yield("header")
</header>
<main>
    @yield("main")
</main>
<footer>
    @yield("footer")
</footer>
<script src="{{ asset('js/template.js') }}" type="text/javascript"></script>
</body>
</html>
