@extends('layouts/basic')

@section('pagetitle')
    <title>Forgot Password</title>
@stop

@section('headers')

@stop

@section('maincontent')
    <h1>Change Password</h1>
    {{Form::open(['action'=>'UsersController@sendPasswordChange']) }}
    {{-- Above equivalent to ['route'=>'SendPwEmail'] --}}
    <div>
        {{Form::label('email', 'Email Address: ')}}
        {{Form::text('email')}}
        {{$errors->first('email', '<span class="error">:message<span>')}}
    </div>
    <div>
        {{Form::submit('Send')}}
    </div>
    {{Form::close() }}
@stop

