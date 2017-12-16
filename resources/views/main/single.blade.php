@extends('layouts.main_page')

@section('single')
    @foreach($data as $item)
        {{$item->id}}
        <h1>{{$item->title}}</h1>
        {!!$item->news_text!!}
        <img src="/{{$item->img}}"><br>
        <a href="javascript:history.go(-1)">Вернуться назад</a>
    @endforeach
@endsection