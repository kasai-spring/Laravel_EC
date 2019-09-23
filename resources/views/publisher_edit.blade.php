@extends("template")

@section("title","商品編集")

@section("head")
    <link rel="stylesheet" href="{{asset("css/dashboard.css")}}">
@endsection

@section("main")

    <form action="{{url("publisher/edit/".$good_data->good_id)}}" method="post" id="main_content" class="edit_form">
        <div class="edit_form">
            @csrf
            <table>
                <tr>
                    <th>商品名</th>
                    <td>
                        <div class="table_input">
                            @if(!empty($errors->first("good_name"))) <p
                                class="form_error_message">{{$errors->first("good_name")}}</p> @endif
                            <input type="text"
                                   class="text_input_form @if(!empty($errors->first("good_name"))) has-error @endif"
                                   name="good_name" value="{{old("good_name",@$good_data->good_name ?: "")}}"
                                   placeholder="商品名">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>価格</th>
                    <td>
                        <div class="table_input">
                            @if(!empty($errors->first("good_price"))) <p
                                class="form_error_message">{{$errors->first("good_price")}}</p> @endif
                            <input type="tel"
                                   class="text_input_form @if(!empty($errors->first("good_price"))) has-error @endif"
                                   name="good_price" value="{{old("good_price",@$good_data->good_price ?: "")}}"
                                   placeholder="価格">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>在庫</th>
                    <td>
                        <div class="table_input">
                            @if(!empty($errors->first("good_stock"))) <p
                                class="form_error_message">{{$errors->first("good_stock")}}</p> @endif
                            <input type="tel"
                                   class="text_input_form @if(!empty($errors->first("good_stock"))) has-error @endif"
                                   name="good_stock" value="{{old("good_stock",@$good_data->good_stock ?: "")}}"
                                   placeholder="在庫">
                        </div>
                    </td>
                </tr>
            </table>
            <input type="button" value="更新" class="form_button submit_button" onclick="onEditButtonClicked()">
        </div>
    </form>

    <script src="{{asset("js/publisher_edit.js")}}"></script>
@endsection
