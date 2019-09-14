@extends("template")

@section("title", "管理者画面")

@section("head")
    <link rel="stylesheet" href="{{asset("css/management.css")}}">
    <link rel="stylesheet" href="{{asset("css/admin.css")}}">
@endsection

@section("main")
    <form action="{{url("admin")}}" id="publisher_form" method="post">
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
                       onchange="onSidebarButtonChange()" @if($select_mode == 3) checked @endif>
                <label for="good_edit_radio"><h2>商品編集</h2> <i class="fas fa-angle-double-right"></i></label>
            </div>
            <div>
                <input id="inquiry_check_radio" class="sidebar_radio" type="radio" name="mode" value="3"
                       onchange="onSidebarButtonChange()" @if($select_mode == 4) checked @endif>
                <label for="inquiry_check_radio"><h2>問い合わせ</h2> <i class="fas fa-angle-double-right"></i></label>
            </div>
        </div>
        <div id="main_content">
            <div id="user_edit_form">
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
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->user_name}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->last_logined_at}}</td>
                            <td>@if($user->Admin == 1) ○ @else × @endif</td>
                            <td>@if($user->Publisher == 1) ○ @else × @endif</td>
                            <td><input type="button" value="編集"></td>
                            <td><input type="button" value="削除"></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div id="user_register_form">
                <table>
                    <tr>
                        <th>メールアドレス</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <th>パスワード</th>
                        <td><input type="password"></td>
                    </tr>
                    <tr>
                        <th>再入力用パスワード</th>
                        <td><input type="password"></td>
                    </tr>
                    <tr>
                        <th>ユーザー名</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <th>ユーザーの種類</th>
                        <td>
                            <select name="" id="">
                                <option value="0">通常ユーザー</option>
                                <option value="1">パブリッシャー</option>
                                <option value="2">管理者</option>
                                <option value="3">管理者&パブリッシャー</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="good_edit_form">
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
                        <tr>
                            <td>{{$good->good_id}}</td>
                            <td>{{$good->good_name}}</td>
                            <td>{{$good->good_producer}}</td>
                            <td>{{$good->publisher->publisher_name}}</td>
                            <td>{{$good->good_price}}円</td>
                            <td>{{$good->good_stock}}</td>
                            <td>{{$good->goodscategory->category_name}}</td>
                            <td>{{$good->created_at}}</td>
                            <td><input type="button" value="編集"></td>
                            <td><input type="button" value="削除"></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div id="inquiry_check_form">
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
