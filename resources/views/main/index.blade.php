@extends('layouts.main_page')

@section('content')
        @foreach($data as $articleItem)
            <div class="article_main neon glow">
                {{ $articleItem->id }}<br>
                <a href="/main/news/{{ $articleItem->url }}">{{ $articleItem->title }}</a><br>
                <br>
                <img src="/{{ $articleItem->img }}">
            </div>
        @endforeach
@endsection