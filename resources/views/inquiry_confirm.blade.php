@extends("template")

@section("title", "お問い合わせ確認")

@section("head")
    <link rel="stylesheet" href="{{asset("css/l_r_form.css")}}">
@endsection

@section("main")
    <div id="l_r_form">
        <h2>この内容で送信してもよろしいですか?</h2>
        <table id="confirm_table">
        @if(!Session::has("login_id"))
            <tr>
                <th>お名前</th>
                <td>{{Session::get("inquiry_user_name")}}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{Session::get("inquiry_email")}}</td>
            </tr>
        @endif
            <tr>
                <th>お問い合わせ内容</th>
                <td>{{Session::get("inquiry_option")}}</td>
            </tr>
            <tr>
                <th>件名</th>
                <td>{{Session::get("inquiry_subject")}}</td>
            </tr>
            <tr>
                <th>内容</th>
                <td>{{Session::get("inquiry_content")}}</td>
            </tr>
        </table>
        <form id="confirm_form" method="post">
            @csrf
            <input type="button" class="fas" value="&#xf100;" onclick="onClickConfirmFormButton('{{url("inquiry")}}')">
            <input type="button" class="fas" value="&#xf101;" onclick="onClickConfirmFormButton('{{url("inquiry/complete")}}')">
        </form>

    </div>
@endsection
