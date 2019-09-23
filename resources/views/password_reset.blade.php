@extends("template")

@section("title", "パスワード再設定")

@section("head")
    <link rel="stylesheet" href="{{asset("css/l_r_form.css")}}">
@endsection

@section("main")
    <div id="l_r_form">
        <form action="{{url("login/forget/reset")}}" method="post">
            @csrf
            @if(!empty($errors->first("email"))) <p class="form_error_message">{{$errors->first("email")}}</p> @endif
            <label>
                <input class="l_r_form @if(!empty($errors->first("email"))) has-error @endif" type="text" name="email" placeholder="メールアドレス" value="{{old("email")}}" required>
                <i class="fa fa-envelope fa-lg fa-fw" aria-hidden="true"></i>
            </label>
            @if(!empty($errors->first("password"))) <p class="form_error_message">{{$errors->first("password")}}</p> @endif
            <label>
                <input class="l_r_form @if(!empty($errors->first("password"))) has-error @endif" type="password" name="password" placeholder="パスワード" required>
                <i class="fa fa-key fa-lg fa-fw" aria-hidden="true"></i>
            </label>
            <label>
                <input class="l_r_form @if(!empty($errors->first("password"))) has-error @endif" type="password" name="password_confirmation" placeholder="もう一度パスワードを入力してください" required>
                <i class="fa fa-key fa-lg fa-fw" aria-hidden="true"></i>
            </label>
            <input type="submit" class="fas" value="&#xf101;">
        </form>
    </div>

@endsection
