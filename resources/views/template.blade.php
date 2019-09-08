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
        @if(session("login_id"))
            <li><h2><a href="{{url("mypage")}}">マイページ</a></h2></li>
            <li><h2><a href="{{url("logout")}}">ログアウト</a></h2></li>
        @else
            <li><h2><a href="{{url("register")}}">登録</a></h2></li>
            <li><h2><a href="{{url("login")}}">ログイン</a></h2></li>
        @endif
        @if(session("Admin"))
            <li><h2><a href="{{url("admin")}}">管理者ページ</a></h2></li>
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
