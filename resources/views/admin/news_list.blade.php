@extends('layouts.admin_main')

@section('news_list')
    <div class="admin_news_list">
        @foreach($data as $item)
            <div class="admin_news_list_item">
                <div class="admin_news_list_item_inner">
                    id Статьи: {{$item->id}}<br>
                    Заголовок: {{$item->title}}<br>
                    URL Статьи: {{$item->url}}<br>
                </div>
                <div class="admin_news_list_item_inner">
                    <a href="edit-news/{{$item->url}}">Изменить</a><br>
                    <a href="deactivate-news">Деактивировать</a><br>
                    <a href="delete-news">(!!!ЗОНА РИСКА!!!)<br>Удалить новость<br>(!!!ЗОНА РИСКА!!!)</a><br>
                </div>
                <div class="admin_news_list_item_inner">
                    <img src="/{{$item->img}}"><br>
                </div>
            </div>
        @endforeach
    </div>
@endsection