@extends('layouts/basic')

@section('headers')
    {{ HTML::style('css/login.css') }}
@endsection

@section('maincontent')
    <div id="main-content-wrapper">
        <h1>Login</h1>
        {{-- Changed default action to post to our collection of students --}}
        {{Form::open(['route'=>'sessions.store']) }}
        <div>
            {{Form::label('email', 'Email Address: ')}}
            {{Form::text('email')}}
            {{$errors->first('email', '<span class="error">:message<span>')}}
        </div>

        <hr>

        <div>
            {{Form::label('password', 'Password: ')}}
            {{Form::password('password')}}
            {{$errors->first('password')}}
        </div>
        {{ HTML::link('/forgotPassword', 'Forgot password?')}}

        <hr>

        <div>
            {{Form::submit('Log in', array('class'=>'buttons')) }}
            <button type="button" onclick="window.location='{{ url("register") }}'" class="buttons">Sign-up</button>
            {{$errors->first('credentials') . "<br>"}}

        </div>
        {{Form::close() }}
    </div>
@stop