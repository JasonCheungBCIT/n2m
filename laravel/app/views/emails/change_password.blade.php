@extends('layouts.mail')

@section('maincontent')
    <h1>Change your Notes to Myself password</h1>
    <p>To change your Notes to Myself password click on the following link. If you didn't issue
    a password change you can safely ignore this email.</p>
    {{ URL::to('user/check_password_code/' . $password_code) }}
@stop