@extends("template")

@section("title", "管理者画面")

@section("head")
    <link rel="stylesheet" href="{{asset("css/dashboard.css")}}">
@endsection

@section("main")
    <form action="{{url("admin")}}" class="dashboard_form" method="post">
        @csrf
        <div id="side_bar">
            <div>
                <input id="user_edit_radio" class="sidebar_radio" type="radio" name="mode" value="0"
                       onchange="onSidebarButtonChange()" @if($select_mode == 0) checked @endif>
                <label for="user_edit_radio"><h2>ユーザー編集</h2> <i class="fas fa-angle-double-right"></i></label>
            </div>
            <div>
                <input id="user_register_radio" class="sidebar_radio" type="radio" name="mode" value="1"
                       onchange="onSidebarButtonChange()" @if($select_mode == 1) checked @endif>
                <label for="user_register_radio"><h2>ユーザー登録</h2> <i class="fas fa-angle-double-right"></i></label>
            </div>
            <div>
                <input id="good_edit_radio" class="sidebar_radio" type="radio" name="mode" value="2"
                       onchange="onSidebarButtonChange()" @if($select_mode == 2) checked @endif>
                <label for="good_edit_radio"><h2>商品編集</h2> <i class="fas fa-angle-double-right"></i></label>
            </div>
            <div>
                <input id="inquiry_check_radio" class="sidebar_radio" type="radio" name="mode" value="3"
                       onchange="onSidebarButtonChange()" @if($select_mode == 3) checked @endif>
                <label for="inquiry_check_radio"><h2>問い合わせ</h2> <i class="fas fa-angle-double-right"></i></label>
            </div>
        </div>
        <div id="main_content">
            <div id="user_edit_form" class="view_content">
                <table>
                    <tr>
                        <th>ユーザーID</th>
                        <th>メールアドレス</th>
                        <th>ユーザー名</th>
                        <th>登録日</th>
                        <th>最終ログイン日</th>
                        <th>管理者</th>
                        <th>パブリッシャー</th>
                        <th>編集</th>
                        <th>削除</th>
                    </tr>
                    @foreach($user_data as $user)
                        <tr id="{{$user->email}}">
                            <td>{{$user->id}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->user_name}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->last_logined_at}}</td>
                            <td>@if($user->Admin == 1) ○ @else × @endif</td>
                            <td>@if($user->Publisher == 1) ○ @else × @endif</td>
                            <td><a href="{{url("admin/user_edit/".$user->id)}}"><input type="button" class="form_button edit_button" value="編集" @if($user->id == Session("login_id")) disabled @endif></a></td>
                            <td><input type="button" class="user_delete_button form_button edit_button" value="削除" @if($user->id == Session("login_id")) disabled @endif></td>
                        </tr>
                    @endforeach
                </table>
                <div id="pagination">
                    {{$user_data->appends(["mode" => 0])->links()}}
                </div>
            </div>
            <div id="user_register_form" class="view_content">
                <table>
                    <tr>
                        <th>メールアドレス</th>
                        <td>
                            <div class="table_input">
                                @if(!empty($errors->first("email"))) <p
                                    class="form_error_message">{{$errors->first("email")}}</p> @endif
                                <input type="text" name="email" class="text_input_form @if(!empty($errors->first("email"))) has-error @endif" value="{{old("email")}}" placeholder="メールアドレス" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>パスワード</th>
                        <td>
                            <div class="table_input">
                                @if(!empty($errors->first("password"))) <p
                                    class="form_error_message">{{$errors->first("password")}}</p> @endif
                                <input type="password" name="password" class="text_input_form @if(!empty($errors->first("password"))) has-error @endif" placeholder="パスワード" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>再入力用パスワード</th>
                        <td>
                            <div class="table_input">
                                <input type="password" name="password_confirmation" class="text_input_form @if(!empty($errors->first("password"))) has-error @endif" placeholder="パスワード" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>ユーザー名</th>
                        <td>
                            <div class="table_input">
                                @if(!empty($errors->first("user_name"))) <p
                                    class="form_error_message">{{$errors->first("user_name")}}</p> @endif
                                <input type="text" name="user_name" class="text_input_form @if(!empty($errors->first("user_name"))) has-error @endif" placeholder="ユーザー名" value="{{old("user_name")}}" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>ユーザーの種類</th>
                        <td>
                            <select id="user_role_edit" name="user_type" onchange="onUserRoleEditChange()" class="select_form">
                                <option value="0" @if(old("user_type") == 0) selected @endif>通常ユーザー</option>
                                <option value="1" @if(old("user_type") == 1) selected @endif>パブリッシャー</option>
                                <option value="2" @if(old("user_type") == 2) selected @endif>管理者</option>
                                <option value="3" @if(old("user_type") == 3) selected @endif>管理者&パブリッシャー</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>会社名</th>
                        <td>
                            <div class="table_input">
                                @if(!empty($errors->first("company_name"))) <p
                                    class="form_error_message">{{$errors->first("company_name")}}</p> @endif
                                <input type="text" id="company_name" name="company_name" required disabled class="text_input_form @if(!empty($errors->first("company_name"))) has-error @endif" value="{{old("company_name")}}" placeholder="会社名">
                            </div>
                        </td>
                    </tr>
                </table>
                <input type="submit" class="form_button submit_button" value="送信">
            </div>
            <div id="edit_good_form" class="view_content">
                <table>
                    <tr>
                        <th>商品ID</th>
                        <th>商品名</th>
                        <th>製造会社</th>
                        <th>販売会社</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>カテゴリー</th>
                        <th>登録日</th>
                        <th>編集</th>
                        <th>削除</th>
                    </tr>
                    @foreach($goods_data as $good)
                        <tr id="{{$good->good_name}}">
                            <td>{{$good->good_id}}</td>
                            <td>{{$good->good_name}}</td>
                            <td>{{$good->good_producer}}</td>
                            <td>{{$good->publisher->publisher_name}}</td>
                            <td>{{$good->good_price}}円</td>
                            <td>{{$good->good_stock}}</td>
                            <td>{{$good->goodscategory->category_name}}</td>
                            <td>{{$good->created_at}}</td>
                            <td><a href="{{url("admin/good_edit/".$good->good_id)}}"><input type="button" value="編集" class="form_button edit_button"></a></td>
                            <td><input type="button" id="{{$good->good_id}}" class="good_delete_button form_button edit_button" value="削除" ></td>
                        </tr>
                    @endforeach
                </table>
                <div id="pagination">
                    {{$goods_data->appends(["mode" => 2])->links()}}
                </div>
            </div>
            <div id="inquiry_check_form" class="view_content">
                <table>
                    <tr>
                        <th>ユーザー名</th>
                        <th>名前</th>
                        <th>メールアドレス</th>
                        <th>種類</th>
                        <th>件名</th>
                        <th>内容</th>
                        <th>登録日</th>
                    </tr>
                    @foreach($inquiry_data as $inquiry)
                        <tr>
                            <td>@if(is_null($inquiry->user_id)) 未登録ユーザー @else {{$inquiry->user->user_name}} @endif</td>
                            <td>@if(is_null($inquiry->user_id)) {{$inquiry->user_name}} @endif</td>
                            <td>@if(is_null($inquiry->user_id)) {{$inquiry->email}} @else {{$inquiry->user->email}} @endif</td>
                            <td>{{$inquiry->option}}</td>
                            <td>{{$inquiry->subject}}</td>
                            <td>{{$inquiry->content}}</td>
                            <td>{{$inquiry->created_at}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
    <script src="{{asset("js/admin.js")}}"></script>
@endsection
