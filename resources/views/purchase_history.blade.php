@extends("template")

@section("title","購入履歴")

@section("main")
    @foreach($transaction_data as $transaction)
        購入日{{$transaction->created_at}}<br>
        @foreach($history_data[$transaction->id] as $history)
            商品名:{{$history->good->good_name}}
            購入個数:{{$history->quantity}}<br>
        @endforeach
        <br>
    @endforeach

    <a href="{{$transaction_data->previousPageUrl()}}">前のページ</a>
    <a href="{{$transaction_data->nextPageUrl()}}">次のページ</a>
    <h3>{{$transaction_data->lastPage()}}</h3>
@endsection
