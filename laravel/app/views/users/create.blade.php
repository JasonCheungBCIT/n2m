@extends('layouts/basic')

@section('pagetitle')
    <title>reCAPTCHA demo: Register</title>
@stop

@section('headers')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@stop

@section('maincontent')
    <h1>Register</h1>
    {{-- Changed default action to post to our collection of students --}}
    {{Form::open(['route'=>'users.store']) }}
    <div>
        {{Form::label('email', 'Email Address: ')}}
        {{Form::text('email')}}
        {{$errors->first('email', '<span class="error">:message<span>')}}
    </div>
    <div>
        {{Form::label('password', 'Password: ')}}
        {{Form::password('password')}}
        {{$errors->first('password', '<span class="error">:message<span>')}}
    </div>
    <div>
        {{Form::label('password_confirmation', 'Confirm Password: ')}}
        {{Form::password('password_confirmation')}}
        {{$errors->first('password_confirmation', '<span class="error">:message<span>')}}
    </div>

    <div class="g-recaptcha" data-sitekey="6LetOBgTAAAAAIHZSMLj3ytAS7VE-zDSOeDUA1id"></div>

    <div>
        {{Form::submit('Register')}}
    </div>
    {{Form::close() }}
@stop