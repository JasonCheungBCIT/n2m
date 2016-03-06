@extends('layouts/basic')

@section('pagetitle')
    <title>Change Password</title>
@stop

@section('headers')
    {{ HTML::style('css/theme.css') }}
@stop

@section('maincontent')
    <div id="main-content-wrapper">
        <h1>Enter new password</h1>
        {{Form::open(['action'=>'UsersController@changePassword']) }}
        <div>
            {{Form::label('password', 'New Password: ')}}
            {{Form::password('password')}}
            {{$errors->first('password', '<span class="error">:message<span>')}}
        </div>
        <div>
            {{Form::label('password_confirmation', 'Confirm Password: ')}}
            {{Form::password('password_confirmation')}}
            {{$errors->first('password_confirmation', '<span class="error">:message<span>')}}
        </div>
        <div>
            {{Form::hidden('p_code', $p_code)}}
        </div>
        <div class="center-children">
            {{Form::submit('Change password')}}
        </div>

        {{Form::close() }}
    </div>
@stop

