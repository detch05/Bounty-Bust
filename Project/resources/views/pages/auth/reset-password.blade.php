@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div id="login" class="container justify-content-center d-flex flex-column m-3 gap-3 ">
        <h2>Create New Password</h2>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="mb-0">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group d-flex flex-column">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" required minlength="6">
                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
                <small class="text-muted mt-1">At least 6 characters</small>
            </div>

            <div class="form-group d-flex flex-column mt-3">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="6">
                @error('password_confirmation')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-4">Reset Password</button>
        </form>

        <p class="mt-3">
            <a href="{{ route('login') }}">Back to Login</a>
        </p>
    </div>

@endsection

@section('scripts')
<script src="{{ asset('js/forms.js') }}"></script>
@endsection
