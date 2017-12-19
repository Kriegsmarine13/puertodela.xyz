@extends('layouts.main_page')

@section('single')
    @foreach($data as $item)
        <div class="single-title">{{$item->title}}</div>
        <div class="single-text">
            {!!$item->news_text!!}
        </div>
        <div class="single-image">
            <img src="/{{$item->img}}"><br>
        </div>
        <br>
        <a href="/main">Вернуться назад</a><br>
        <br>Оцените статью<br>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <script>
            function post()
            {
                var data = event.target.id;
                var id = '{{Auth::id()}}';
                $.ajax({
                    type: "post",
                    url: "/main/vote/{{$item->url}}",
                    data: {
                        data:data,
                        id:id
                    },
                    cache: false,
                    success: function(html){
                        $('#rating').html(html);
                    },error:function(){
                        console.log("failed");
                    }
                });
                return false;
            }
        </script>
        <div id="1234">
            <form id="voting">
                <br><br>
                <button form="voting" id="upvote" name="upvote" value="upvote" onclick="return post()">+</button>
                <span id="rating">{{$item->rating}}</span>
                <button form="voting" id="downvote" name="downvote" value="downvote" onclick="return post()">-</button><br>
            </form>
        </div>
    @endforeach
@endsection