@extends('layouts/mail')

@section('maincontent')
    <h1>Change your Notes to Myself password</h1>
    <p>To change your Notes to Myself password click on the following link. If you didn't issue
    a password change you can safely ignore this email.</p>
    <br>
    {{ URL::to('user/change_password/' . $password_code) }}
@stop