@extends('layouts/basic')

@section('pagetitle')
    <title>{{$title}}</title>
@stop

@section('headers')
    {{ HTML::style('css/theme.css') }}
@stop

@section('maincontent')
    <div id="main-content-wrapper">
        <h1>{{$header}}</h1>
        {{$message}}
                <!-- window.location='login' works just as well -->
    </div>
@stop