@extends('layouts.app')

@auth
@php 
$user = Auth::user();
$user_bounties = $user->bounties;
@endphp
@endauth

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.aside')       
            <div class="col-12 col-md-9">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="mb-0">Bounties</h1>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select class="form-select" id="sortSelect">
                                    <option value="recent">Security</option>
                                    <option value="reward">Java</option>
                                    <option value="popular">Linux</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="sortSelect">
                                    <option value="recent">Most Recent</option>
                                    <option value="reward">Highest Reward</option>
                                    <option value="popular">Most Popular</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="filterSelect">
                                    <option value="all">All Bounties</option>
                                    <option value="open">Open</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Bounties Grid -->
                    @if($bounties && count($bounties) > 0)
                        <div class="row g-4">
                            @foreach($bounties as $bounty)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 shadow-sm border-0 transition-hover" style="cursor: pointer;">
                                        <!-- Card Header with Reward Badge -->
                                        <div class="card-header bg-light border-0 d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="card-title mb-2">{{ $bounty->title }}</h5>
                                                <small class="text-muted">
                                                    <i class="bi bi-person-circle"></i>
                                                    {{ $bounty->content->user->name ?? 'Anonymous' }} 
                                                </small>
                                            </div>
                                            <span class="badge bg-success fs-6">{{ $bounty->reward }} pts</span>
                                        </div>

                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <p class="card-text text-muted text-truncate" style="max-height: 60px; overflow: hidden;">
                                                {{ substr($bounty->content->description, 0, 100) }}...
                                            </p>

                                            <!-- Tags -->
                                            <div class="mb-3">
                                                @if($bounty->tags && count($bounty->tags) > 0)
                                                    @foreach($bounty->tags->take(3) as $tag)
                                                        <span class="badge" style="background-color: {{ $tag->color ?? '#007bff' }}; color: white;">
                                                            {{ $tag->name }}
                                                        </span>
                                                    @endforeach
                                                    @if(count($bounty->tags) > 3)
                                                        <span class="badge bg-secondary">+{{ count($bounty->tags) - 3 }}</span>
                                                    @endif
                                                @endif
                                            </div>

                                            <!-- Stats -->
                                            <div class="row text-center text-muted small mb-3">
                                                <div class="col-4">
                                                    <i class="bi bi-chat-dots"></i>
                                                    <br>{{ $bounty->commentsCount ?? 0 }} Comments
                                                </div>
                                                <div class="col-4">
                                                    <i class="bi bi-check-circle"></i>
                                                    <br>{{ $bounty->answersCount ?? 0 }} Answers
                                                </div>
                                                <div class="col-4">
                                                    <i class="bi bi-eye"></i>
                                                    <br>{{ $bounty->viewsCount ?? 0 }} Views
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card Footer -->
                                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="bi bi-calendar"></i>
                                                {{ $bounty->content->created_at->format('d-m-Y')}}
                                            </small>
                                            <a href="{{ route('bounties.show', $bounty->id_content) }}" class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>̣
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <nav class="mt-4" aria-label="Page navigation">
                            {{ $bounties->links() }}
                        </nav>
                    @else
                        <div class="alert alert-info text-center py-5" role="alert">
                            <i class="bi bi-info-circle fs-3"></i><a class="nav-link" href="{{ route('tags.index') }}">Tags</a>
                            <h4 class="mt-3">No bounties found</h4>
                            <p class="text-muted mb-0">Check back later or create your own bounty to get started!</p>
                            @auth
                                {{--<a href="{{ route('bounties.create') }}" class="btn btn-primary mt-3">
                                    Create the First Bounty
                                </a>--}}
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection