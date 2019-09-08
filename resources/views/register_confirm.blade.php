@extends("template")

@section("title", "ユーザー登録確認")

@section("head")
    <link rel="stylesheet" href="{{asset("css/l_r_form.css")}}">
@endsection

@section("main")
    <div id="l_r_form">
        <h2>この内容で登録してもよろしいですか?</h2>
        <table id="confirm_table">
            <tr>
                <th>ユーザー名</th>
                <td>{{$user_name}}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{$email}}</td>
            </tr>
        </table>
        <form id="confirm_form" method="post">
            @csrf
            <input type="button" class="fas" id="l_r_button" value="&#xf100;" onclick="onClickConfirmFormButton('{{url("register")}}')">
            <input type="button" class="fas" id="l_r_button" value="&#xf101;" onclick="onClickConfirmFormButton('{{url("register/complete")}}')">
        </form>
    </div>
@endsection
