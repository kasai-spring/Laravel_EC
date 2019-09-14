@extends("template")

@section("title","商品編集")

@section("head")
    <link rel="stylesheet" href="{{asset("css/management.css")}}">
@endsection

@section("main")
    <div class="edit_form">
        <form action="{{url("publisher/edit/".$good_data->good_id)}}" method="post" id="main_content" class="good_edit">
            @csrf
                <table>
                    <tr>
                        <th>商品名</th>
                        <td>
                            @if(!empty($errors->first("good_name"))) <p
                                class="form_error_message">{{$errors->first("good_name")}}</p> @endif
                            <input type="text" class="text_input_form @if(!empty($errors->first("good_name"))) has-error @endif" name="good_name" value="{{old("good_name",@$good_data->good_name ?: "")}}" placeholder="商品名">
                        </td>
                    </tr>
                    <tr>
                        <th>価格</th>
                        <td>
                            @if(!empty($errors->first("good_price"))) <p
                                class="form_error_message">{{$errors->first("good_price")}}</p> @endif
                            <input type="tel" class="text_input_form @if(!empty($errors->first("good_price"))) has-error @endif" name="good_price" value="{{old("good_price",@$good_data->good_price ?: "")}}" placeholder="価格">
                        </td>
                    </tr>
                    <tr>
                        <th>在庫</th>
                        <td>
                            @if(!empty($errors->first("good_stock"))) <p
                                class="form_error_message">{{$errors->first("good_stock")}}</p> @endif
                            <input type="tel" class="text_input_form @if(!empty($errors->first("good_stock"))) has-error @endif" name="good_stock" value="{{old("good_stock",@$good_data->good_stock ?: "")}}" placeholder="在庫">
                        </td>
                    </tr>
                </table>
            <input type="button" value="更新" class="form_button submit_button" onclick="onEditButtonClicked()">
        </form>
    </div>
    <script src="{{asset("js/publisher_edit.js")}}"></script>
@endsection
