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
            <label>
                <input type="text" value="{{old("email")}}" class="l_r_form" name="email" placeholder="メールアドレス"
                       required autofocus>
                <i class="fa fa-envelope fa-lg fa-fw" aria-hidden="true"></i>
            </label>
            <label>
                <input type="password" class="l_r_form" placeholder="パスワード" name="password" required>
                <i class="fa fa-key fa-lg fa-fw" aria-hidden="true"></i>
            </label>
            <input type="submit" id="l_r_button" class="fas" value="&#xf101;">
        </form>
        <a href="{{url("login/forget")}}">パスワードを忘れた場合</a>
    </div>


@endsection
