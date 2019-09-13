@extends("template")

@section("title", "名前変更")

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
        <h2>名前変更</h2>
        <form action="{{url("account/setting/name")}}" method="post">
            @csrf
            <table>
                <tr>
                    <th>現在の名前</th>
                    <td>{{$user_name}}</td>
                </tr>
                <tr>
                    <th>新しい名前</th>
                    <td>
                        <label>
                            @if(!empty($errors->first("user_name"))) <p
                                class="form_error_message">{{$errors->first("user_name")}}</p> @endif
                            <input type="text" class="input_form @if(!empty($errors->first("user_name"))) has-error @endif" name="user_name" value="{{old("user_name")}}" placeholder="新しい名前" required>
                        </label>
                    </td>
                </tr>
            </table>
            <input type="submit" class="fas" value="&#xf101;">
        </form>
    </div>
@endsection
