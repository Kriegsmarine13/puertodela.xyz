@extends('layouts.admin_main')

@section('add_news_form')
    <div class="add-news-form">
        @if(isset($data))
            @foreach($data as $item)
        <form action="/admin/edit-news" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{$item->id}}">
            Заголовок: <input type="text" name="title" value="{{$item->title or ''}}"><br>
            <br>url: <input type="text" name="url" value="{{$item->url or ''}}"><br>
            <br>Изображение: <input type="file" name="image"><br>
            <br>Описание: <textarea name="maintext" cols="25" rows="4">{{$item->news_text or ''}}</textarea><br>
            <br>Активность: <input type="checkbox" name="active" @if($item->active == 1)checked @endif><br>
            <br>Выбрать тему<select name="theme"><br>
                <option value="1">Программирование</option>
                <option value="2">Дизайн</option>
                <option value="3">Музыка</option>
                <option value="4">Отдых</option>
                <option value="5">Хобби</option>
                <option value="6">Мемесы</option>
            </select>
            <br>Дата создания новости: {{$item->time}}<br>
            <br>Обновить дату?<input type="checkbox" name="time_renew"><br>
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
                <br>Сделать активной после создания: <input type="checkbox" name="active"><br>
                <br>Выбрать тему<select name="theme">
                    <option value="1">Программирование</option>
                    <option value="2">Дизайн</option>
                    <option value="3">Музыка</option>
                    <option value="4">Отдых</option>
                    <option value="5">Хобби</option>
                    <option value="6">Мемесы</option>
                </select><br>
                <br><input name="submit" type="submit" value="Отправить">
            </form>
        @endif
    </div>
@endsection

@section('timestamp')
    <br>Время создания:<br>
    <br>Обновить время на текущее?<input type="checkbox" name="new_time"><br>
@endsection