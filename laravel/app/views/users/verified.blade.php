@extends('layouts/basic')

@section('pagetitle')
    <title>Verified</title>
@stop

@section('headers')

@stop

@section('maincontent')
    <h1>You're verified</h1>
    <p>Thanks for registering, you can now login.</p>
    <button type="button" onclick="window.location='{{ url("login") }}'">Login</button>
    <!-- window.location='login' works just as well -->
@stop