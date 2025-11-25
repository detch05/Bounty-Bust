@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.aside') 
            <div class="col-md-9">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="mb-0">Tags</h1>
                        @auth
                            {{--@if(auth()->user()->isAdmin())
                                <a href="{{ route('tags.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Create Tag
                                </a>
                            @endif--}}
                        @endauth
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Search tags..." id="searchInput">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="sortSelect">
                                    <option value="popularity">Most Popular</option>
                                    <option value="bounties">Most Bounties</option>
                                </select>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Tags Grid -->
                    @if($tags && count($tags) > 0)
                        <div class="row g-4">
                            @foreach($tags as $tag)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 shadow-sm border-0 transition-hover" style="cursor: pointer; border-left: 5px solid {{ $tag->color ?? '#007bff' }} !important;">
                                        <!-- Card Header with Color Badge -->
                                        <div class="card-header border-0 d-flex justify-content-between align-items-start" style="background-color: {{ $tag->color ?? '#007bff' }}20;">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title mb-0">{{ $tag->name }}</h5>
                                            </div>
                                            <div class="rounded px-2 py-1" style="background-color: {{ $tag->color ?? '#007bff' }}; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <span style="color: white; font-weight: bold; font-size: 12px;">{{ strtoupper(substr($tag->name, 0, 2)) }}</span>
                                            </div>
                                        </div>

                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <p class="card-text text-muted" style="height: 60px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                                {{ $tag->description ?? 'No description available' }}
                                            </p>

                                            <!-- Tag Stats -->
                                            <div class="row text-center text-muted small mb-3">
                                                <div class="col-6">
                                                    <i class="bi bi-bullseye"></i>
                                                    <br><strong>{{ $tag->bountiesCount ?? 0 }}</strong>
                                                    <br><small>Bounties</small>
                                                </div>
                                                <div class="col-6">
                                                    <i class="bi bi-people-fill"></i>
                                                    <br><strong>{{ $tag->followersCount ?? 0 }}</strong>
                                                    <br><small>Followers</small>
                                                </div>
                                            </div>

                                            <!-- Color Badge -->
                                            
                                        </div>

                                        <!-- Card Footer -->
                                        <div class="card-footer bg-white border-top d-flex gap-2">
                                            {{--<a href="{{ route('tags.show', $tag->id) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                                <i class="bi bi-eye"></i> View
                                            </a>--}}
                                            @auth
                                                {{--@if(auth()->user()->isFollowingTag($tag->id))
                                                    <button class="btn btn-sm btn-danger" onclick="unfollowTag({{ $tag->id }})">
                                                        <i class="bi bi-star-fill"></i> Following
                                                    </button>
                                                @elsẹ--}}
                                                    <button class="btn btn-sm btn-outline-success" onclick="followTag({{ $tag->id }})">
                                                        <i class="bi bi-star"></i> Follow
                                                    </button>
                                                {{--@endif--}}
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <nav class="mt-4" aria-label="Page navigation">
                            {{ $tags->links() }}
                        </nav>
                    @else
                        <div class="alert alert-info text-center py-5" role="alert">
                            <i class="bi bi-info-circle fs-3"></i>
                            <h4 class="mt-3">No tags found</h4>
                            <p class="text-muted mb-0">No tags available at the moment. Check back later!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

