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
                    @if($item->active == 1)
                        <a href="deactivate/{{$item->url}}">Деактивировать</a><br>
                    @else
                        <a href="activate/{{$item->url}}">Активировать</a><br>
                    @endif
                    <br><br><a href="delete/{{$item->url}}">(!!!ЗОНА РИСКА!!!)<br>Удалить новость<br>(!!!ЗОНА РИСКА!!!)</a><br>
                </div>
                <div class="admin_news_list_item_inner">
                    <img src="/{{$item->img}}"><br>
                </div>
            </div>
        @endforeach
    </div>
@endsection