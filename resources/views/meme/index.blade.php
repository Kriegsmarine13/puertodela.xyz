@extends('layouts.meme')

@section('meta')
    <meta property="og:image" content="http://puertodela.xyz/{{$pic}}">
    <link rel="image_src" href="http://puertodela.xyz/{{$pic}}"/>
@endsection

@section('picture')
<div style="display:block;float:left;">
    <img src="/{{ $pic }}">
    <br>
</div>
@endsection
