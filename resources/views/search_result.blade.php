@extends("template")

@section("title", "検索結果")

@section("main")
    <form action="{{url("goods/search")}}">
        <select name="category">
            <option value="0">全てのカテゴリー</option>
            @foreach($category_data as $category)
                <option value="{{$category->id}}" @if($category_id == $category->id) selected @endif >{{$category->category_name}}</option>
            @endforeach
        </select>
        <input type="text" value="{{$q}}" name="q">
        <select name="sort">
            <option value="0">登録の新しい順</option>
            <option value="1" @if($sort == 1) selected @endif>登録の古い順</option>
            <option value="2" @if($sort == 2) selected @endif>価格の安い順</option>
            <option value="3" @if($sort == 3) selected @endif>価格の高い順</option>
        </select>
        <input type="submit" value="検索">
    </form>


    @if(count($goods_data) == 0)
        検索結果がありませんでした
    @else
        @if(!is_null($q))
            <h2>{{$q}}の検索結果</h2>
        @endif
        @foreach($goods_data as $good)
            <div>
                <a href="{{url("goods/detail/".$good->good_id)}}">
                    <h3>{{$good->good_name}}</h3>
                    <h3>{{$good->good_price}}</h3>
                    <h3>{{$good->goodscategory->category_name}}</h3>
                </a>
            </div>
        @endforeach
    @endif
    {{$goods_data->appends(["sort" => $sort, "category" => $category_id])->links()}}
@endsection
