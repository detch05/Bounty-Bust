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
                            @if ($bounty->content->isEdited())
                                <p class="mb-0">modified {{ $bounty->content->updated_at->diffForHumans() }}</p>
                                <span class="text-secondary">&bull;</span>
                            @endif
                            <p class=" mb-0">{{ $bounty->content->views }}
                                {{ $bounty->content->views != 1 ? 'views' : 'view' }}
                            </p>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            @auth
                                <aside class="utils me-3 d-flex flex-column align-items-center gap-3 mt-5">
                                    <div class="voteZone d-flex flex-column align-items-center"
                                        data-content-id="{{ $bounty->content->id }}"
                                        data-user-vote="{{ auth()->user()->getVoteOnContent($bounty->content->id) }}">
                                        <button class="upvoteBtn btn btn-light btn-sm ">
                                            <i class="bi bi-arrow-up-circle fs-3"></i>
                                        </button>
                                        <span class="rating fs-5 fw-bold my-2 me-1">{{ $bounty->content->rating() }}</span>
                                        <button class="downvoteBtn btn btn-light btn-sm ">
                                            <i class="bi bi-arrow-down-circle fs-3"></i>
                                        </button>
                                    </div>
                                    <button class="followBtn btn btn-light btn-sm" data-content-id="{{ $bounty->content->id }}"
                                        data-is-following="{{ auth()->user()->isFollowingContent($bounty->content->id) }}"><i
                                            class="bi bi-bookmark fs-5"></i></button>
                                </aside>
                            @endauth
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
                                <nav class="d-flex align-items-center justify-content-between" id="InteractNav">
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn btn-warning btn-sm fw-bold rounded" data-bs-toogle="popover"
                                            data-bs-trigger="hover focus" data-bs-placement ="top" title ="Bounty Reward"
                                            data-bs-content="Bounty points if your answer is marked as correct">
                                            {{ $bounty->reward }} <i class="bi bi-award fs-6"></i></button>
                                        <a href="#"
                                            class="btn btn-sm btn-outline-secondary rounded">{{ $bounty->answers()->count() }}
                                            <i class="bi bi-crosshair2"></i></a>
                                        <a href="#commentHeader"
                                            class="btn btn-sm btn-outline-secondary rounded">{{ $bounty->comments()->count() }}
                                            <i class="bi bi-chat-fill"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        @auth
                                            @if (Auth::id() === $bounty->content->user_id || !Auth::user()->hasRole('user'))
                                                <form action="{{ route('bounties.destroy', $bounty->id_content) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                                <a class="navlink text-dark fs-5"
                                                    href="{{ route('bounties.edit', $bounty->id_content) }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endif
                                        @endauth
                                    </div>
                                </nav>
                                <section class="mt-3" id="commentSection">
                                    <h3 class="mb-3" id="commentHeader">Comments</h3>
                                    <form method="POST" action="{{ route('comments.store') }}">
                                        @csrf
                                        <input type="hidden" name="bounty_id" value="{{ $bounty->id_content }}">
                                        <input type="hidden" name="answer_id" id="comment_answer_id" value="">
                                        <input type="hidden" name="parent_id" id="comment_parent_id" value="">
                                        <div class="mb-3">
                                            <textarea class="form-control" id="commentText" name="text" rows="3" minlength="15" required></textarea>
                                        </div>
                                        <div class="d-flex gap-2 align-items-center">
                                            <button type="submit" class="btn btn-primary">Add Comment</button>
                                        </div>    
                                    </form>
                                    <hr>
                                    @include('partials.comment_card', ['comments' => $comments])
                                </section>
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
