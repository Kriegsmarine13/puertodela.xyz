@extends('layouts.admin_main')

@section('add_news_form')
    <div class="add-news-form">
        <form action="add-news" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            Заголовок: <input type="text" name="title"><br>
            <br>url: <input type="text" name="url"><br>
            <br>Изображение: <input type="file" name="image"><br>
            <br>Описание: <textarea name="maintext" cols="25" rows="4"></textarea><br>
            @yield('timestamp')
            <br><input name="submit" type="submit" value="Отправить">
        </form>
    </div>
@endsection

@section('timestamp')
    <br>Время создания:<br>
    <br>Обновить время на текущее?<input type="checkbox" name="new_time"><br>
@endsection