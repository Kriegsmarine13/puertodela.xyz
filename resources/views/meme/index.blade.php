@extends('layouts.meme')

@section('meta')
    <meta property="og:image" content="http://puertodela.xyz/{{$pic}}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="og:title" content="Создай свою картиночку!">
    <meta name="og:description" content="Я не знаю что написать в og:description, простите :(">
    <meta property="twitter:image" content="http://puertodela.xyz/{{$pic}}">
    <link rel="image_src" href="http://puertodela.xyz/{{$pic}}"/>
@endsection

@section('picture')
<div style="display:block;float:left;">
    <img src="/{{ $pic }}">
    <br>
</div>
@endsection
