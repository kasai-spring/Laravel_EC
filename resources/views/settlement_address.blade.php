@extends("template")

@section("title","支払い方法&住所選択")

@section("head")
    <link rel="stylesheet" href="{{asset("css/settlement.css")}}">
@endsection

@section("main")
    <div class="settlement_form">
        <form action="{{url("settlement/confirm")}}" method="post">
            @csrf
            <h3>1.支払い方法を選択してください</h3>
            <div class="select_radio payment_radio">
                <label>
                    <input type="radio" name="payment" value="1" @if(!@$payment_method || $payment_method == 1) checked @endif>
                    <span class="radio_option">
                        <i class="fas fa-credit-card"></i>
                        <span>クレジットカード</span>
                    </span>
                </label>
                <label>
                    <input type="radio" name="payment" value="2" @isset($payment_method) @if($payment_method == 2) checked @endif @endisset>
                    <span class="radio_option">
                        <i class="fas fa-university"></i>
                        <span>口座振替</span>
                    </span>
                </label>
                <label>
                    <input type="radio" name="payment" value="3" @isset($payment_method) @if($payment_method == 3) checked @endif @endisset>
                    <span class="radio_option">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>代金引換</span>
                    </span>
                </label>
            </div>
            <h3>2.住所を選択してください</h3>
            <div class="select_radio address_select">
                @foreach($address_data as $data)
                    <label>
                        <input type="radio" name="select_address" value="{{$loop->iteration}}"
                               onchange="address_select_checker()"
                        @isset($iteration_id) @if($loop->iteration == $iteration_id) checked @endif @endisset>
                        <span class="radio_option">
                            <span>〒:{{$data->postcode}}</span>
                            <span>{{$data->prefecture}}</span>
                            <span>{{$data->city_street}}</span>
                            <span>{{$data->building}}</span>
                            <span>差出人:{{$data->addressee}}</span>
                        </span>
                    </label>
                @endforeach
            </div>
            <div class="address_input_form select_radio">
                <label>
                    <input type="radio" name="select_address" id="do_input" value="0"
                           onchange="address_select_checker()"
                           @if(!@$iteration_id || $iteration_id == 0) checked @endif>
                        <span class="radio_option">
                            <span>住所を入力する</span>
                        </span>
                </label>

                <label>
                    <span>郵便番号(ハイフン抜き)</span>
                    @if(!empty($errors->first("postcode"))) <p
                        class="form_error_message">{{$errors->first("postcode")}}</p> @endif
                    <input type="tel" name="postcode" class="address_form @if(!empty($errors->first("postcode"))) has-error @endif" maxlength="7" value="{{old("postcode",@$postcode ?: "")}}"
                           required>
                </label>
                <label>
                    <span>都道府県</span>
                    @if(!empty($errors->first("prefecture"))) <p
                        class="form_error_message">{{$errors->first("prefecture")}}</p> @endif
                    <input type="text" name="prefecture" class="address_form @if(!empty($errors->first("prefecture"))) has-error @endif" value="{{old("prefecture",@$prefecture ?: "")}}" required>
                </label>

                <label>
                    <span>市町村番地</span>
                    @if(!empty($errors->first("city_street"))) <p
                        class="form_error_message">{{$errors->first("city_street")}}</p> @endif
                    <input type="text" name="city_street" class="address_form @if(!empty($errors->first("city_street"))) has-error @endif" value="{{old("city_street",@$city_street ?: "")}}" required>
                </label>
                <label>
                    <span>アパート、建物名</span>
                    @if(!empty($errors->first("building"))) <p
                        class="form_error_message">{{$errors->first("building")}}</p> @endif
                    <input type="text" name="building" class="address_form @if(!empty($errors->first("building"))) has-error @endif" value="{{old("building",@$building ?: "")}}">
                </label>
                <label>
                    <span>差出人</span>
                    @if(!empty($errors->first("addressee"))) <p
                        class="form_error_message">{{$errors->first("addressee")}}</p> @endif
                    <input type="text" name="addressee" class="address_form @if(!empty($errors->first("addressee"))) has-error @endif" value="{{old("addressee",@$addressee ?: "")}}" required>
                </label>
                <input type="submit" value="&#xf101;" class="move_button fas">
            </div>
        </form>
    </div>

    <script src="{{asset("js/settlement_address.js")}}" type="text/javascript"></script>

@endsection
