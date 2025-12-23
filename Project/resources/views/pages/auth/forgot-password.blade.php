@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div id="login" class="container justify-content-center d-flex flex-column m-3 gap-3 ">
        <h2>Reset Your Password</h2>

        @if (session('status'))
            <div class="alert alert-info alert-dismissible fade show" role="alert" style="font-size: 0.9rem; opacity: 0.85;">
                {{ session('status') }}
            </div>
            <p class="text-center text-muted mt-4">Check your email for the reset link. It will expire in 24 hours.</p>
            <a href="{{ route('login') }}">Back to Login</a>
        @else
            <form method="POST" action="{{ route('password.email') }}" class="mb-0">
                @csrf
                <div class="form-group d-flex flex-column">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" maxlength="255" required>
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <p class="mt-3 text-muted small">
                    We'll send you a link to reset your password. The link will expire in 24 hours.
                </p>

                <button type="submit" class="btn btn-primary mt-3">Send Reset Link</button>
            </form>
            <a href="{{ route('login') }}">Back to Login</a>
        @endif
    </div>

@endsection

@section('scripts')
<script src="{{ asset('js/forms.js') }}"></script>
@endsection
