@extends("template")

@section("title","購入履歴")

@section("main")
    @if(count($transaction_data) == 0)
        <h2>購入履歴がありません</h2>
    @else
        @foreach($transaction_data as $transaction)
            購入日{{$transaction->created_at}}<br>
            @foreach($history_data[$transaction->id] as $history)
                商品名:{{$history->good->good_name}}
                購入個数:{{$history->quantity}}<br>
            @endforeach
            <br>
        @endforeach
        {{$transaction_data->links()}}
    @endif



@endsection
