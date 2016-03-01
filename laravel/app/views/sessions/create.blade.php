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

    <button type="button" onclick="window.location='{{ url("forgot_password") }}'">Forgot password?</button>

    <div>
        {{$errors->first('credentials') . "<br>"}}
        {{Form::submit('Log in')}}
    </div>
    {{Form::close() }}
@stop