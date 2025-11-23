@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">


@section('content')

    <div id="register" class="container justify-content-center d-flex flex-column gap-3 ">
        <h2>Welcome to Bounty Bust!</h2>
        <form method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-md-6 d-flex flex-column">
                    <label for="firstName">First name</label>
                    <input type="text" name="firstName" maxlength="30">
                </div>

                <div class="form-group col-md-6 d-flex flex-column">
                    <label for="lastName">Last name</label>
                    <input type="text" name="lastName" maxlength="30">
                </div>
            </div>
            <div class="form-group d-flex flex-column">
                <label for="username">Username</label>
                <input type="text" name="username" maxlength="40" required>
            </div>
            <div class="form-group d-flex flex-column">
                <label for="email">Email</label>
                <input type="email" name="email" maxlength="60" required>
            </div>

            <div class="form-group d-flex flex-column">
                <label for="password">Password</label>
                <input type="password" name="password" maxlength="50" required>
            </div>

            <div class="form-group d-flex flex-column">
                <label for="location">Location</label>
                <input type="text" name="location" maxlength="50">
            </div>

            <div class="form-group d-flex flex-column">
                <label for="Bio">Bio</label>
                <textarea name="Bio" rows="10" cols="30" maxlength="300"
                    placeholder="Write something about you!" required></textarea>
            </div>
        </form>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

@endsection