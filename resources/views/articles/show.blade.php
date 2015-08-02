@extends('app')

@section('content')

    <h1>{{ $article->title }}</h1>

    {{ $article->body }}

    <p><a class="btn btn-primary" href="{{ action('ArticlesController@index') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></p>
@stop