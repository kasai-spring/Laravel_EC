@extends("template")

@section("title", "ユーザー登録確認")

@section("main")
    <h2>この内容で登録してもよろしいですか?</h2>
    <p>ユーザー名:{{$user_name}}</p>
    <p>メールアドレス:{{$email}}</p>
    <form id="confirm_form" method="post">
        @csrf
        <input type="button" value="戻る" onclick="onClickConfirmFormButton('{{url("register")}}')">
        <input type="button" value="登録" onclick="onClickConfirmFormButton('{{url("register/complete")}}')">
    </form>
@endsection
