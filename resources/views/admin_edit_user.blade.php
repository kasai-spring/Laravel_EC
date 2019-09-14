@extends("template")

@section("title", "ユーザー編集")

@section("head")
    <link rel="stylesheet" href="{{asset("css/management.css")}}">
@endsection

@section("main")
    <div class="edit_form">
        <form action="{{url("admin/user_edit/".$user_id)}}" method="post" id="main_content">
            @csrf
            <table>
                <tr>
                    <th>メールアドレス</th>
                    <td>
                        @if(!empty($errors->first("email"))) <p
                            class="form_error_message">{{$errors->first("email")}}</p> @endif
                        <input type="text" name="email" class="text_input_form @if(!empty($errors->first("email"))) has-error @endif" value="{{old("email",@$user_data->email ?: "")}}" placeholder="メールアドレス" required>
                    </td>
                </tr>
                <tr>
                    <th>ユーザー名</th>
                    <td>
                        @if(!empty($errors->first("user_name"))) <p
                            class="form_error_message">{{$errors->first("user_name")}}</p> @endif
                        <input type="text" name="user_name" class="text_input_form @if(!empty($errors->first("user_name"))) has-error @endif" value="{{old("user_name",@$user_data->user_name ?: "")}}" placeholder="ユーザー名" required>
                    </td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td>
                        @if(!empty($errors->first("password"))) <p
                            class="form_error_message">{{$errors->first("password")}}</p> @endif
                        <input type="password" class="text_input_form @if(!empty($errors->first("password"))) has-error @endif" name="password" placeholder="パスワード">
                    </td>
                </tr>
                <tr>
                    <th>再入力用パスワード</th>
                    <td>
                        <input type="password" class="text_input_form @if(!empty($errors->first("password"))) has-error @endif" name="password_confirmation" placeholder="パスワード">
                    </td>
                </tr>
                <tr>
                    <th>管理者を有効にする</th>
                    <td>
                        <input type="checkbox" name="admin" @if($user_type == 2||$user_type == 3 || !is_null(old("admin"))) checked @endif>
                    </td>
                </tr>
                @if($user_type == 0 || $user_type == 2)
                    <tr>
                        <th>パブリッシャーを有効にする</th>
                        <td>
                            <input type="checkbox" name="publisher" @if(!is_null(old("publisher"))) checked @endif id="publisher_change" onchange="onChangePublisherCheck()">
                        </td>
                    </tr>
                    <tr>
                        <th>会社名</th>
                        <td>
                            @if(!empty($errors->first("company_name"))) <p
                                class="form_error_message">{{$errors->first("company_name")}}</p> @endif
                            <input type="text" id="company_name" class="text_input_form @if(!empty($errors->first("company_name"))) has-error @endif" name="company_name" value="{{old("company_name")}}" required disabled placeholder="会社名">
                        </td>
                    </tr>
                @else
                    <tr>
                        <th>会社名</th>
                        <td>
                            @if(!empty($errors->first("company_name"))) <p
                                class="form_error_message">{{$errors->first("company_name")}}</p> @endif
                            <input type="text" class="text_input_form @if(!empty($errors->first("company_name"))) has-error @endif" name="company_name" value="{{old("company_name",@$publisher_name ?: "")}}"
                                   required placeholder="会社名">
                        </td>
                    </tr>
                @endif
            </table>
            <input type="submit" class="form_button submit_button">
        </form>
    </div>

    <script src="{{asset("js/admin_edit.js")}}"></script>
@endsection
