@extends("template")

@section("title","購入履歴")

@section("head")
    <link rel="stylesheet" href="{{asset("css/history.css")}}">
@endsection

@section("main")
    <div id="history_form">

        @if(count($transaction_data) == 0)
            <div id="no_history_info">
                <h2>購入履歴がありません</h2>
            </div>
        @else
            @foreach($transaction_data as $transaction)
                <div id="transaction">
                    <input id="history_pull_check_{{$loop->iteration}}" class="pull_down_menu_check" type="checkbox">
                    <label for="history_pull_check_{{$loop->iteration}}" class="pull_down_menu_label">
                        <span>購入日:{{$transaction->created_at}}</span>
                        <span><i class="far fa-caret-square-down"></i><i class="far fa-caret-square-up"></i></span>
                    </label>
                    <table class="pull_down_menu">
                        @foreach($history_data[$transaction->id] as $history)
                            <tr class="history_good">
                                <td>
                                    <img src="{{asset("storage/goods_images/".$history->good->picture_path)}}"
                                         alt="{{$history->good->good_name}}のイメージ">
                                    <a href="{{url("goods/detail/".$history->good->good_id)}}"><span>{{$history->good->good_name}}</span></a>
                                    <span>価格:{{$history->good->good_price}}円 購入個数:{{$history->quantity}}</span>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th>合計金額:{{$transaction->total_price}}円</th>
                        </tr>
                    </table>
                </div>
            @endforeach
            <div id="pagination">
                {{$transaction_data->links()}}
            </div>

        @endif
    </div>



@endsection
