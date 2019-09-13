@extends("template")

@section("title","商品管理ページ")

@section("head")
    <link rel="stylesheet" href="{{asset("css/publisher.css")}}">
@endsection

@section("main")
    <form action="" id="publisher_form" method="post">
        <div id="side_bar">
            <div>
                <input id="sales_history_select" class="sidebar_radio" type="radio" name="mode" value="0"
                       onchange="onSidebarButtonChange()" checked>
                <label for="sales_history_select"><h2>販売履歴</h2> <i class="fas fa-angle-double-right"></i></label>
            </div>
            <div>
                <input id="good_edit_select" class="sidebar_radio" type="radio" name="mode" value="1"
                       onchange="onSidebarButtonChange()">
                <label for="good_edit_select"><h2>出品商品編集</h2> <i class="fas fa-angle-double-right"></i></label>
            </div>
            <div>
                <input id="good_display_select" class="sidebar_radio" type="radio" name="mode" value="2"
                       onchange="onSidebarButtonChange()">
                <label for="good_display_select"><h2>新規出品</h2> <i class="fas fa-angle-double-right"></i></label>
            </div>
        </div>
        <div id="main_content">
            <div id="sales_history">
                <h2>sales_history</h2>
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
                                    〒{{$sale->address->postcode}} {{$sale->address->prefecture}}{{$sale->address->city_street}}{{$sale->address->building}}</td>
                                <td>{{$sale->address->addressee}}</td>
                                <td>{{$sale->quantity}}</td>
                                <td>{{$sale->created_at}}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
            <div id="good_edit">
                <h2>good_edit</h2>
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
                        </tr>
                        @foreach($goods_data as $good)
                            <tr>
                                <td>{{$good->good_name}}</td>
                                <td>{{$good->good_id}}</td>
                                <td>{{$good->good_price}}円</td>
                                <td>{{$good->good_stock}}個</td>
                                <td>{{$good->goodscategory->category_name}}</td>
                                <td><input type="button" value="編集"></td>
                                <td><input type="button" value="削除"></td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
            <div id="good_display">
                <h2>good_display</h2>
                <table>
                    <tr>
                        <th>商品名</th>
                        <td><input type="text" name="good_name" required></td>
                    </tr>
                    <tr>
                        <th>製造会社</th>
                        <td><input type="text" name="good_producer" required></td>
                    </tr>
                    <tr>
                        <th>価格</th>
                        <td><input type="tel" name="good_price" required></td>
                    </tr>
                    <tr>
                        <th>在庫数</th>
                        <td><input type="tel" name="good_stock" required></td>
                    </tr>
                    <tr>
                        <th>カテゴリー</th>
                        <td>
                            <select name="good_category">
                                <option value="0">カテゴリー</option>
                            </select>
                        </td>
                    </tr>

                </table>
                <input type="submit">
            </div>
        </div>

    </form>
    <script src="{{asset("js/publisher.js")}}"></script>
@endsection
