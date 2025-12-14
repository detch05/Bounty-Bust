@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

@section('content')
    <div id="editProfile" class="container justify-content-center d-flex flex-column gap-3 ">
        <h2>Edit Profile</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('partials.register_fields', [
                ($isEdit = true),
                'firstName' => $firstName,
                'lastName' => $lastName,
                'username' => $User->username,
                'email' => $User->email,
                'location' => $User->location,
                'bio' => $User->bio,
                'userId' => $User->id,
            ])
        </form>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('js/forms.js') }}"></script>
