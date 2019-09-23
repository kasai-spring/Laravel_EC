@extends("template")

@section("title", "パスワード変更")

@section("head")
    <link rel="stylesheet" href="{{asset("css/mypage.css")}}">
@endsection

@section("main")
    <div id="setting_form">
        @if (session('setting_message'))
            <div class="flash_message">
                <h2>{{ session('setting_message') }}</h2>
            </div>
        @endif
        <h2>パスワード変更</h2>
        <form action="{{url("account/setting/password")}}" method="post">
            @csrf
            <table>
                <tr>
                    <th>新しいパスワード</th>
                    <td>
                        <label>
                            @if(!empty($errors->first("password"))) <p
                                class="form_error_message">{{$errors->first("password")}}</p> @endif
                            <input type="password"
                                   class="input_form @if(!empty($errors->first("password"))) has-error @endif"
                                   name="password" placeholder="新しいパスワード" required>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th>再入力してください</th>
                    <td>
                        <label>
                            <input type="password"
                                   class="input_form @if(!empty($errors->first("password"))) has-error @endif"
                                   name="password_confirmation" placeholder="もう一度パスワードを入力してください" required>
                        </label>
                    </td>
                </tr>
            </table>
            <input type="submit" class="fas" value="&#xf101;">
        </form>
    </div>
@endsection
