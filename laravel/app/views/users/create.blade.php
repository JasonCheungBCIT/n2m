@extends('layouts/basic')

@section('pagetitle')
    <title>reCAPTCHA demo: Register</title>
@stop

@section('headers')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="js/jquery-1.12.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/register.js"></script>
    {{ HTML::style('css/theme.css') }}
    {{ HTML::style('css/register.css') }}
@stop

@section('maincontent')

    <div id="main-content-wrapper">
        <h1>Register</h1>
        {{-- Changed default action to post to our collection of students --}}
        {{Form::open(['route'=>'users.store']) }}
        <div>
            {{Form::label('email', 'Email Address: ')}}
            {{Form::text('email')}}
            <span class="indicator" id="validEmailIndicator"></span>
            {{$errors->first('email', '<span class="error">:message<span>')}}
        </div>
        <div>
            {{Form::label('password', 'Password: ')}}
            {{Form::password('password')}}
            <span class="indicator" id="validPassIndicator"></span>
            {{$errors->first('password', '<span class="error">:message<span>')}}
        </div>
        <div>
            {{Form::label('password_confirmation', 'Confirm Password: ')}}
            {{Form::password('password_confirmation')}}
            <span class="indicator" id="validPassConfIndicator"></span>
            {{$errors->first('password_confirmation', '<span class="error">:message<span>')}}
        </div>

        <div class="g-recaptcha" data-sitekey="6LetOBgTAAAAAIHZSMLj3ytAS7VE-zDSOeDUA1id"></div>

        <hr>

        <div class="center-children">
            {{Form::submit('Register', array('class'=>'buttons'))}}
            <br>
            <p> or</p> {{ HTML::link('login', "Login") }}
        </div>
        {{Form::close() }}
    </div>
@stop