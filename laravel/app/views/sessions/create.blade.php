@extends('layouts/basic')

@section('headers')
    <script src="js/jquery-1.12.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/login.js"></script>
    {{ HTML::style('css/theme.css') }}
    {{ HTML::style('css/login.css') }}
@endsection

@section('maincontent')
    <div id="main-content-wrapper">
        <h1>Login</h1>
        {{-- Changed default action to post to our collection of students --}}
        {{Form::open(['action'=>'SessionsController@store']) }}
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
        {{ HTML::link('/forgotPassword', 'Forgot password?')}}

        {{$errors->first('credentials', '<span class="error">:message<span>') . "<br>"}}

        <hr>

        <div class="center-children">
            {{Form::submit('Log in', array('class'=>'buttons')) }}
            {{--  }}<button type="button" onclick="window.location='{{ url("register") }}'" class="buttons">Sign-up</button> --}}
            {{ HTML::link('register', "Sign-up") }}
        </div>
        {{Form::close() }}
    </div>
@stop