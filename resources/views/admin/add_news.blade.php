@extends('layouts.admin_main')

@section('add_news_form')
    <div class="add-news-form">
        @if(isset($data))
            @foreach($data as $item)
        <form action="add-news" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            Заголовок: <input type="text" name="title" value="{{$item->title or ''}}"><br>
            <br>url: <input type="text" name="url" value="{{$item->url or ''}}"><br>
            <br>Изображение: <input type="file" name="image"><br>
            <br>Описание: <textarea name="maintext" cols="25" rows="4">{{$item->news_text or ''}}</textarea><br>
            <br>ТУТ НАДО СДЕЛАТЬ ГАЛОЧКУ ДЛЯ АКТИВНОСТИ
            <br>И ВЫБОР ТЕМЫ ИЗ СЕЛЕКТА
            <br><input name="submit" type="submit" value="Отправить">
        </form>
            @endforeach
        @else
            <form action="add-news" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                Заголовок: <input type="text" name="title" value=""><br>
                <br>url: <input type="text" name="url" value=""><br>
                <br>Изображение: <input type="file" name="image"><br>
                <br>Описание: <textarea name="maintext" cols="25" rows="4"></textarea><br>
                <br>ТУТ НАДО СДЕЛАТЬ ГАЛОЧКУ ДЛЯ АКТИВНОСТИ
                <br>И ВЫБОР ТЕМЫ ИЗ СЕЛЕКТА
                <br><input name="submit" type="submit" value="Отправить">
            </form>
        @endif
    </div>
@endsection

@section('timestamp')
    <br>Время создания:<br>
    <br>Обновить время на текущее?<input type="checkbox" name="new_time"><br>
@endsection