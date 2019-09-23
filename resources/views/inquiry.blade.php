@extends("template")

@section("title","お問い合わせ")

@section("head")
    <link rel="stylesheet" href="{{asset("css/l_r_form.css")}}">
@endsection

@section("main")
    <div id="l_r_form">
        <h3>お問い合わせフォーム</h3>
        <form action="{{url("inquiry/confirm")}}" method="post">
            @csrf
            @if(!session("login_id"))
                @if(!empty($errors->first("user_name"))) <p
                    class="form_error_message">{{$errors->first("user_name")}}</p> @endif
                <label>
                    <input class="l_r_form @if(!empty($errors->first("user_name"))) has-error @endif" type="text"
                           name="user_name" placeholder="名前" value="{{old("user_name",@$user_name ?: "")}}"
                           required>
                    <i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>
                </label>
                @if(!empty($errors->first("email"))) <p
                    class="form_error_message">{{$errors->first("email")}}</p> @endif
                <label>
                    <input class="l_r_form @if(!empty($errors->first("email"))) has-error @endif" type="text"
                           name="email"
                           placeholder="メールアドレス" value="{{old("email",@$email ?: "")}}" required>
                    <i class="fa fa-envelope fa-lg fa-fw" aria-hidden="true"></i>
                </label>
            @endif
            <div id="inquiry_header">
                <label id="select_option">
                    <select name="option" required>
                        <option value="0">ご意見・ご要望</option>
                        <option value="1" @if(old("option",@$option ?: "") == 1) selected @endif>アカウントについて</option>
                        <option value="2" @if(old("option",@$option ?: "") == 2) selected @endif>決済について</option>
                        <option value="3" @if(old("option",@$option ?: "") == 3) selected @endif>その他</option>
                    </select>
                </label>
                <div id="inquiry_subject">
                    @if(!empty($errors->first("subject"))) <p
                        class="form_error_message_subject">{{$errors->first("subject")}}</p> @endif
                    <label id="subject_input">
                        件名
                        <input type="text" class="@if(!empty($errors->first("subject"))) has-error @endif" name="subject" value="{{old("subject",@$subject ?: "")}}" required placeholder="10文字以内">
                    </label>
                </div>
            </div>

            <p id="inquiry_content_topic">内容(1000文字以内)</p>
            @if(!empty($errors->first("content"))) <p
                class="form_error_message_content">{{$errors->first("content")}}</p> @endif
            <label>
                <textarea name="content" class="@if(!empty($errors->first("subject"))) has-error @endif" cols="30" rows="35" required>{{old("content",@$content ?: "")}}</textarea>
            </label>
            <input type="submit" class="fas" value="&#xf101;">
        </form>
    </div>
@endsection
