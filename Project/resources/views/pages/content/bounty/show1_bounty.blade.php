@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/bounty.css') }}" rel="stylesheet">
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.aside')
            <div class="col-12 col-lg-9 py-sm-5 me-2">
                <div class="row">
                    <div class="col-xl-2 d-none d-xl-block"></div>
                    <div class="col-12 col-xl-10">
                        <div class="bountyHeader d-flex gap-2 align-items-center">
                            <button class="btn btn-secondary rounded-circle btn-sm" onclick="history.back()">
                                <i class="bi bi-arrow-left fs-6"></i>
                            </button>
                            <div class="d-flex align-items-center gap-2 ms-2 py-0">
                                <img src="{{ Storage::url('users/' . $bounty->user->id . '.jpg') }}" class="profileIcon"
                                    onerror="this.onerror=null; this.src='{{ Storage::url('users/default.jpg') }}';">
                                <p class="mt-3 fw-bold">{{ $bounty->user->name }}</p>
                            </div>
                            <span class="text-secondary">&bull;</span>
                            <p class=" mb-0">{{ $bounty->content->created_at->diffForHumans() }}</p>
                            <span class="text-secondary">&bull;</span>
                            <p class=" mb-0">{{ $bounty->content->views }}
                                {{ $bounty->content->views != 1 ? 'views' : 'view' }}
                            </p>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <aside class="utils me-3 d-flex flex-column align-items-center gap-3">
                                <div class="voteZone d-flex flex-column align-items-center"
                                    data-content-id="{{ $bounty->content->id }}"
                                    data-user-vote="{{ auth()->user()->getVoteOnContent($bounty->content->id) }}">
                                    <button class="upvoteBtn btn btn-light btn-sm ">
                                        <i class="bi bi-arrow-up-circle fs-4"></i>
                                    </button>
                                    <span class="rating fs-5 fw-bold my-2">{{ $bounty->content->rating() }}</span>
                                    <button class="downvoteBtn btn btn-light btn-sm ">
                                        <i class="bi bi-arrow-down-circle fs-4"></i>
                                    </button>
                                </div>
                                <button class="followBtn btn btn-light btn-sm" data-content-id="{{ $bounty->content->id }}" data-is-following="{{ auth()->user()->isFollowingContent($bounty->content->id) }}"><i class="bi bi-bookmark fs-5"></i></button>
                            </aside>
                            <div class="bountyMain d-flex flex-column gap-2">
                                <div>
                                    <h3 class="mb-0">{{ $bounty->title }}</h3>
                                    @foreach ($bounty->tags->take(3) as $tag)
                                        <span class="badge mt-0"
                                            style="background-color: {{ $tag->color ?? '#007bff' }}; color: white;">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                                <div id="bountyImg" class="d-flex align-items-center justify-content-center">
                                    <img src="{{ Storage::url($bounty->getImagePath(true)) }}"
                                        onerror="this.onerror=null; this.src='{{ Storage::url('bounties/default.jpg') }}';">
                                </div>
                                <p class="mt-2">{{ $bounty->content->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('js/content.js') }}"></script>
@endsection
