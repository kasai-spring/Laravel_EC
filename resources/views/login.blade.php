@extends("template")

@section("title", "ログイン")

@section("head")
    <link rel="stylesheet" href="{{asset("css/l_r_form.css")}}">
@endsection

@section("main")

    <div id="l_r_form">
        <h3>ログイン</h3>
        @isset($errors)
            <div id="login_error">
                @foreach($errors->all() as $error_message)
                    <h2>{{$error_message}}</h2>
                @endforeach
            </div>
        @endisset
        @if (session('flash_message'))
            <div id="login_message">
                <h2>{{ session('flash_message') }}</h2>
            </div>
        @endif
        <form action="{{url("login")}}" method="post">
            @csrf
            <label class="icon_input">
                <i class="fa fa-envelope fa-lg fa-fw" aria-hidden="true"></i>
                <input type="text" value="{{old("email",@$email ?: "")}}" class="l_r_form" name="email"
                       placeholder="メールアドレス"
                       required autofocus>
            </label>
            <label class="icon_input">
                <i class="fa fa-key fa-lg fa-fw" aria-hidden="true"></i>
                <input type="password" class="l_r_form" placeholder="パスワード" name="password" required>
            </label>

            <input id="login_remember_check" name="remember_me" type="checkbox">
            <label id="login_remember" for="login_remember_check">ログイン状態を保存する</label>

            <input type="submit" class="fas" value="&#xf101;">
        </form>
        <a href="{{url("login/forget")}}">パスワードを忘れた場合</a>
    </div>


@endsection
