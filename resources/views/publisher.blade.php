@extends("template")

@section("title","商品管理ページ")

@section("head")
    <link rel="stylesheet" href="{{asset("css/dashboard.css")}}">
@endsection

@section("main")
    <form action="{{url("publisher")}}" class="dashboard_form" method="post" enctype="multipart/form-data">
        @csrf
        <div id="side_bar">
            <div>
                <input id="sales_history_select" class="sidebar_radio" type="radio" name="mode" value="0"
                       onchange="onSidebarButtonChange()" @if($select_mode == 0) checked @endif>
                <label for="sales_history_select"><h2>販売履歴</h2> <i class="fas fa-angle-double-right"></i></label>
            </div>
            <div>
                <input id="good_edit_select" class="sidebar_radio" type="radio" name="mode" value="1"
                       onchange="onSidebarButtonChange()" @if($select_mode == 1) checked @endif>
                <label for="good_edit_select"><h2>出品商品編集</h2> <i class="fas fa-angle-double-right"></i></label>
            </div>
            <div>
                <input id="good_display_select" class="sidebar_radio" type="radio" name="mode" value="2"
                       onchange="onSidebarButtonChange()" @if($select_mode == 2) checked @endif>
                <label for="good_display_select"><h2>新規出品</h2> <i class="fas fa-angle-double-right"></i></label>
            </div>
        </div>
        <div id="main_content">
            <div id="sales_history" class="view_content">
                <h2>販売履歴</h2>
                @if(count($sales_history) == 0)
                    <h2>まだ購入されてません</h2>
                @else
                    <table>
                        <tr>
                            <th>商品名</th>
                            <th>商品ID</th>
                            <th>配送先</th>
                            <th>宛先人</th>
                            <th>購入数</th>
                            <th>購入日</th>
                        </tr>
                        @foreach($sales_history as $sale)
                            <tr>
                                <td>{{$sale->good->good_name}}</td>
                                <td>{{$sale->good->good_id}}</td>
                                <td>
                                    〒{{$sale->address->postcode}} {{$sale->address->prefecture}}{{$sale->address->city_street}} {{$sale->address->building}}
                                </td>
                                <td>{{$sale->address->addressee}}</td>
                                <td>{{$sale->quantity}}</td>
                                <td>{{$sale->created_at}}</td>
                            </tr>
                        @endforeach
                    </table>
                    <div id="pagination">
                        {{$sales_history->appends(["mode" => "0"])->links()}}
                    </div>
                @endif
            </div>
            <div id="good_edit" class="view_content">
                <h2>出品商品編集</h2>
                @if(count($goods_data) == 0)
                    <h2>まだ出品されてません</h2>
                @else
                    <table>
                        <tr>
                            <th>商品名</th>
                            <th>商品ID</th>
                            <th>価格</th>
                            <th>在庫</th>
                            <th>カテゴリー</th>
                            <th>編集</th>
                            <th>削除</th>
                        </tr>
                        @foreach($goods_data as $good)
                            <tr id="{{$good->good_name}}">
                                <td>{{$good->good_name}}</td>
                                <td>{{$good->good_id}}</td>
                                <td>{{$good->good_price}}円</td>
                                <td>{{$good->good_stock}}個</td>
                                <td>{{$good->goodscategory->category_name}}</td>
                                <td><a href="{{url("publisher/edit/".$good->good_id)}}"><input
                                            type="button" class="form_button edit_button" value="編集"></a></td>
                                <td><input id="{{$good->good_id}}" class="good_delete_button form_button edit_button"
                                           type="button" value="削除"></td>
                            </tr>
                        @endforeach
                    </table>
                    <div id="pagination">
                        {{$goods_data->appends(["mode" => "1"])->links()}}
                    </div>
                @endif
            </div>
            <div id="good_display" class="good_edit view_content">
                <h2>新規出品</h2>
                <table>
                    <tr>
                        <th>商品名</th>
                        <td>
                            <div class="table_input">
                                @if(!empty($errors->first("good_name"))) <p
                                    class="form_error_message">{{$errors->first("good_name")}}</p> @endif
                                <input type="text" name="good_name" class="text_input_form @if(!empty($errors->first("good_name"))) has-error @endif" value="{{old("good_name")}}" placeholder="商品名" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>製造会社</th>
                        <td>
                            <div class="table_input">
                                @if(!empty($errors->first("good_producer"))) <p
                                    class="form_error_message">{{$errors->first("good_producer")}}</p> @endif
                                <input type="text" name="good_producer" class="text_input_form @if(!empty($errors->first("good_producer"))) has-error @endif" value="{{old("good_producer")}}" placeholder="製造会社"
                                       required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>価格</th>
                        <td>
                            <div class="table_input">
                                @if(!empty($errors->first("good_price"))) <p
                                    class="form_error_message">{{$errors->first("good_price")}}</p> @endif
                                <input type="tel" name="good_price" class="text_input_form @if(!empty($errors->first("good_price"))) has-error @endif" value="{{old("good_price")}}" placeholder="価格" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>在庫数</th>
                        <td>
                            <div class="table_input">
                                @if(!empty($errors->first("good_stock"))) <p
                                    class="form_error_message">{{$errors->first("good_stock")}}</p> @endif
                                <input type="tel" name="good_stock" class="text_input_form @if(!empty($errors->first("good_stock"))) has-error @endif" value="{{old("good_stock")}}" placeholder="在庫数"
                                       required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>カテゴリー</th>
                        <td>
                            <select name="good_category" id="good_category" class="select_form">
                                @foreach($category_data as $category)
                                    <option value="{{$category->id}}"
                                            @if(old("good_category") == $category->id) selected @endif>
                                        {{$category->category_name}}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>商品画像</th>
                        <td>
                            @if(!empty($errors->first("good_picture"))) <p
                                class="form_error_message">{{$errors->first("good_picture")}}</p> @endif
                            <input type="file" name="good_picture" accept='.jpg,.png'>
                        </td>
                    </tr>
                </table>
                <input type="submit" class="form_button submit_button" value="登録">
            </div>
        </div>

    </form>
    <script src="{{asset("js/publisher.js")}}"></script>
@endsection
