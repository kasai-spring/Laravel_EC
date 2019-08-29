@extends("template")

@section("title", "ログイン")

@section("main")
    @if(isset($errors))
        @foreach($errors->all() as $error_message)
            <h2>{{$error_message}}</h2>
        @endforeach
    @endif
    <h3>ログイン</h3>
    <form action="{{url("login")}}" method="post">
        @csrf
        <label>
            メールアドレス:
            <input type="text" value="{{old("email")}}" name="email" placeholder="メールアドレス" required>
        </label>
        <label>
            パスワード:
            <input type="password" value="" placeholder="パスワード" name="password" required>
        </label>
        <input type="submit" value="送信">
    </form>
    <a href="{{url('/register')}}">新規アカウントを作成する</a>
@endsection
