@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">


@section('content')

    <div id="login" class="container justify-content-center d-flex flex-column m-3 gap-3 ">
        <h2>Welcome Back Bounty Hunter!</h2>
        <form type="POST" action="/login">
            @csrf
            <div class="form-group d-flex flex-column ">
                <label for="exampleFormControlInput1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" maxlength="40" required>
            </div>
            <div class="form-group d-flex flex-column">
                <label for="exampleFormControlInput1">Password</label>
                <input type="password" name="password" maxlength="50" required>
            </div>
            <div id="rememberMe">
                <input type="checkbox" name="remember">
                <label for="rememberMe">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <p>Don't have an account? </p>
        <a href="\register">Join us</a>
    </div>

@endsection