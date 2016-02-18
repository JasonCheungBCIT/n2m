@extends('layouts/basic')

@section('maincontent')
    <h1>Login</h1>
    {{-- Changed default action to post to our collection of students --}}
    {{Form::open(['route'=>'sessions.store']) }}
    <div>
        {{Form::label('email', 'Email Address: ')}}
        {{Form::text('email')}}
        {{$errors->first('email', '<span class="error">:message<span>')}}
    </div>
    <div>
        {{Form::label('password', 'Password: ')}}
        {{Form::password('password')}}
        {{$errors->first('password')}}
    </div>
    <div>
        {{$errors->first('credentials') . "<br>"}}
        {{Form::submit('Log in')}}
    </div>
    {{Form::close() }}
@stop