@extends('layouts.main_page')

@section('header')
    <div class="top-feed">
        Сегодня в меню:
        @foreach($top as $topItem)
            <div class="top-feed-item">
                <div class="top-feed-item-section"><a href="/main/news/{{$topItem->url}}"><span>${{$topItem->rating}}.00</span><span>{{$topItem->title}}</span></a></div>
            </div>
        @endforeach
    </div>
@endsection