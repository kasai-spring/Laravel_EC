@extends("template")

@section("title", "検索結果")

@section("head")
    <link rel="stylesheet" href="{{asset("css/search_result.css")}}">
@endsection

@section("main")
    <div id="search_result_form">
        <form action="{{url("goods/search")}}">
            <select name="category">
                <option value="0">全てのカテゴリー</option>
                @foreach($category_data as $category)
                    <option value="{{$category->id}}" @if($category_id == $category->id) selected @endif >
                        {{$category->category_name}}
                    </option>
                @endforeach
            </select>
            <select name="sort">
                <option value="0">登録の新しい順</option>
                <option value="1" @if($sort == 1) selected @endif>登録の古い順</option>
                <option value="2" @if($sort == 2) selected @endif>価格の安い順</option>
                <option value="3" @if($sort == 3) selected @endif>価格の高い順</option>
            </select>
            <input type="text" name="q" value="{{$q}}">
            <input type="submit" value="&#xf002;" class="fas">
        </form>

        <div id="search_result_goods">
            @if(count($goods_data) == 0)
                <span id="search_result_message">
                    <h2>検索結果がありませんでした</h2>
                </span>
            @else
                @if(!is_null($q))
                    <span id="search_result_message">
                        <h2>{{$q}}の検索結果</h2>
                    </span>
                @endif
                @foreach($goods_data as $good)
                    <div class="good">
                        <a href="{{url("goods/detail/".$good->good_id)}}">
                            <img src="{{asset("storage/goods_images/".$good->picture_path)}}"
                                 alt="{{$good->good_name}}のイメージ">
                            <h3>{{$good->good_name}}</h3>
                            <h3>{{$good->good_price}}円</h3>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div id="pagination">
        {{$goods_data->appends(["sort" => $sort, "category" => $category_id, "q" => $q])->links()}}
    </div>
@endsection
