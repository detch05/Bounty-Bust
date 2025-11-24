

@extends('layouts.app')

@section('content')
     <div class="container-fluid">
        <div class="row">
                @include('partials.aside')
        </div>
     </div class="col-12 col-md-10 p-1 me-2"id="profile">
        <section id="profile_header">
            <div>
                <div id="pfp">
                    <img src="{{ asset('image/users/default.jpg') }}" id="profile_picture">  
                </div>
                <div id="profile_content">
                    <div class="name_container">
                        <h2>{{$user->name}}</h2>
                        <p>@<span class="grayedout"><?={{ $user->username }}?></span></p>
                    </div>
                    <p><i class="bi bi-map-fill fs-5"></i>{{ $user->location }}</p>
                    <p><i class="bi bi-brightness-alt-high-fill  fs-5"></i> {{ $user->points }}</p>
                </div>
            </div>
            @if (Auth::id() == $user->id)
                <nav>
                    <button type="button" class="btn btn-primary">Edit Profile</button>
                    <button type="button" class="btn btn-warning">Delete Account</button>
                </nav>
            @endif
    </div>
    </section>
@endsection 