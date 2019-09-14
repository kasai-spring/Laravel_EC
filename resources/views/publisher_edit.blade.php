@extends("template")

@section("title","商品編集")

@section("head")
    <link rel="stylesheet" href="{{asset("css/management.css")}}">
@endsection

@section("main")
    <div id="good_edit_form">
        <form action="{{url("publisher/edit/".$good_data->good_id)}}" method="post" id="main_content" class="good_edit">
            @csrf
                <table>
                    <tr>
                        <th>商品名</th>
                        <td><input type="text" name="good_name" value="{{$good_data->good_name}}" placeholder="商品名"></td>
                    </tr>
                    <tr>
                        <th>価格</th>
                        <td><input type="tel" name="good_price" value="{{$good_data->good_price}}" placeholder="価格"></td>
                    </tr>
                    <tr>
                        <th>在庫</th>
                        <td><input type="tel" name="good_stock" value="{{$good_data->good_stock}}" placeholder="在庫"></td>
                    </tr>
                </table>
            <input type="button" value="更新" class="form_button submit_button" onclick="onEditButtonClicked()">
        </form>
    </div>
    <script src="{{asset("js/publisher_edit.js")}}"></script>
@endsection
