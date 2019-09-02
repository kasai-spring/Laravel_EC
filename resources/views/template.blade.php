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
        @if(!session("login_id"))
        <li><h2><a href="{{url("login")}}">ログイン</a></h2></li>
        <li><h2><a href="{{url("register")}}">登録</a></h2></li>
        @endif
        <li><h2><a href="{{url("cart")}}">カート</a></h2></li>
        @if(session("login_id"))
        <li><h2>マイページ</h2></li>
        <li><h2><a href="{{url("logout")}}">ログアウト</a></h2></li>
        @endif
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
