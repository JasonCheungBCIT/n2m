@extends('layouts/mail')

@section('maincontent')
    <h1>Verify Your Email Address</h1>
    <p>Thanks for creating an account with "Notes to Myself - Jason Cheung Edition!"
    Please follow the link below to verify your email address</p>
    <br>
    {{ URL::to('register/verify/' . $confirmation_code) }}
@stop