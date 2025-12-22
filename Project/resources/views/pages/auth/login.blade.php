@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">


@section('content')

    <div id="login" class="container justify-content-center d-flex flex-column m-3 gap-3 ">
        <h2>Welcome Back Bounty Hunter!</h2>
        <form method="POST" action="/login" class="mb-0">
            @csrf
            <div class="form-group d-flex flex-column ">
                <label for="exampleFormControlInput1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" maxlength="40" required>
            </div>
            <div class="form-group d-flex flex-column">
                <label for="exampleFormControlInput1">Password</label>
                <input type="password" name="password" maxlength="50" id="checkMe" required>
            </div>
            <div class="mb-3 form-check d-flex align-items-center" id="checkField">
                <input type="checkbox" class="form-check-input" id="check">
                <label class="form-check-label mb-0" for="check">Check me out</label>
            </div>
            <div class="mt-2 mb-3">
                <a href="{{ route('password.request') }}" class="text-decoration-none small">Forgot your password?</a>
            </div>
            <button type="submit" class="btn btn-primary mt-0">Submit</button>
        </form>
        <p>Don't have an account? </p>
        <a href="\register">Join us</a>
    </div>

@endsection


@section('scripts')
<script src="{{ asset('js/forms.js') }}"></script>
@endsection