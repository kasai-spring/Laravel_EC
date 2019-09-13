@extends("template")

@section("title", "メールアドレス変更")

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
        <h2>メールアドレス変更</h2>
        <form action="{{url("account/setting/email")}}" method="post">
            @csrf
            <table>
                <tr>
                    <th>現在のメールアドレス</th>
                    <td>{{$email}}</td>
                </tr>
                <tr>
                    <th>新しいメールアドレス</th>
                    <td>
                        <label>
                            @if(!empty($errors->first("email"))) <p
                                class="form_error_message">{{$errors->first("email")}}</p> @endif
                            <input type="text" class="input_form @if(!empty($errors->first("email"))) has-error @endif" name="email" value="{{old("email")}}" placeholder="新しいメールアドレス" required>
                        </label>
                    </td>
                </tr>
            </table>
            <input type="submit" class="fas" value="&#xf101;">
        </form>
    </div>
@endsection
