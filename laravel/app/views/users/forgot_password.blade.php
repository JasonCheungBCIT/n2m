@extends('layouts/basic')

@section('pagetitle')
    <title>Forgot Password</title>
@stop

@section('headers')
    {{ HTML::style('css/theme.css') }}
@stop

@section('maincontent')

    <div id="main-content-wrapper">
        <h1>Change Password</h1>
        {{Form::open(['action'=>'UsersController@sendPasswordChange']) }}
        {{-- Above equivalent to ['route'=>'SendPwEmail'] --}}
        <div>
            {{Form::label('email', 'Email Address: ')}}
            {{Form::text('email')}}
            {{$errors->first('email', '<span class="error">:message<span>')}}
        </div>
        <br>
        <div class="center-children">
            {{Form::submit('Send')}}
        </div>
        {{Form::close() }}
    </div>

@stop

