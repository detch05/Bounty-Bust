@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.aside')
            <div class="col-12 col-md-9 p-sm-5 me-2" id="profile">
                <div class="row p-3">
                    <section class="col-12" id="profile_header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div id="pfp">
                                    <img src="{{asset('img/users/'.$user->id.'.jpg')}}" width="200" height="200"
                                        id="profile_picture"  onerror="this.onerror=null; this.src='{{ asset('img/users/default.jpg') }}';">
                                </div>
                                <div id="profile_content" class="ms-3">
                                    <div class="name_container d-flex align-items-center gap-3 p-0 pb-1">
                                        <h2 class="fs-4 p-0 m-0 fw-semibold">{{ $user->name}}</h2>
                                        <p class="fs-6 m-0"><span class="text-muted">@ {{ $user->username}}</span></p>
                                    </div>
                                    <div>
                                        <p class="mt-2 mb-0">{{$user->getDate()}}</p>
                                    </div>
                                    <div class="d-flex gap-2 align-items-center mt-0 ">
                                        <i class="bi bi-map-fill fs-5"></i>
                                        <p class="pt-2 pb-0">{{ $user->location}}</p>
                                    </div>
                                </div>
                            </div>


                            @if (Auth::id() == $user->id)
                                <nav class="mt-3 d-flex flex-column align-items-center gap-1">
                                    <button type="button" class="p-1">Edit Profile</button>
                                    <form action="{{ route('account.destroy') }}" method="POST"
                                        onsubmit="return confirm('Are you sure of deleting your account?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1">Delete Account</button>
                                    </form>
                                </nav>
                            @endif
                        </div>
                    </section>
                </div>

                <div class="row min-vh-75">
                    <div class="col-md-3">
                        <aside class="p-3">
                            <div>
                                <p class="fw-bold mb-0">{{ $user->points}}</p>
                                <p class="fs-6 text-muted mt-0">Points</p>
                            </div>
                            <div>
                                <p class="fw-bold mb-0">{{$user->bounties()->count()}}</p>
                                <p class="fs-6 text-muted mt-0">Nº of Bounties</p>
                            </div>
                            <div>
                                <p class="fw-bold mb-0">{{ $user->answers()->count()}}</p>
                                <p class="fs-6 text-muted mt-0">Nº of Answers</p>
                            </div>
                        </aside>
                    </div>
                    <div class="profile_main col-md-9">
                        <section class="about_me mt-4">
                            <h4>About Me</h4>
                            <p class="ps-3">{{ $user->bio}}</p>
                        </section>
                        <section class="activity mt-2">
                            <h4>Activity</h4>
                            <nav class="userOwned d-flex gap-3 ms-3 mb-3">
                                <a class="btn btn-outline-secondary btn-sm" href="#">Bounties</a>
                                <a class="btn btn-outline-secondary btn-sm" href="#">Answers</a>
                                <a class="btn btn-outline-secondary btn-sm" href="#">Saved</a>
                            </nav>

                        </section>
                    </div>
                </div>
            </div>
        </div>
    @endsection
