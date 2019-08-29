@extends("template")

@section("title", "ユーザー登録")

@section("main")
    @if(isset($errors))
        @foreach($errors->all() as $error_message)
            <h2>{{$error_message}}</h2>
        @endforeach
    @endif
    <form action="{{url("register/confirm")}}" method="post">
        @csrf
        <label>
            ユーザー名:
            <input type="text" name="user_name" placeholder="ユーザーID" value="{{old("user_name",@$user_name ?: "")}}" required>
        </label>
        <label>
            メールアドレス:
            <input type="text" name="email" placeholder="メールアドレス" value="{{old("email",@$email ?: "")}}" required>
        </label>
        <label>
            パスワード:
            <input type="password" name="password" placeholder="パスワード" required>
        </label>
        <label>
            もう一度パスワードを入力してください:
            <input type="password" name="re_password" placeholder="パスワード" required>
        </label>
        <input type="submit" value="送信">
    </form>
@endsection
