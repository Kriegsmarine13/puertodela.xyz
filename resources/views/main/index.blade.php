@extends('layouts.main_page')

@section('content')
        @foreach($data as $articleItem)
            <div class="article_main">
                {{ $articleItem->id }}<br>
                {{ $articleItem->url }}<br>
                {{ $articleItem->title }}<br>
                {!! $articleItem->news_text !!}<br>
                <img src="{{ $articleItem->img }}"><br><br><br>
            </div>
        @endforeach
@endsection