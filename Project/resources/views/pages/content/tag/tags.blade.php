@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- Inclui a barra lateral no layout da coluna --}}
            @include('partials.aside')
                <div class="col-md-9">
                    <div class="p-4">
                    <div class="mb-4">
                        <form method="GET" action="{{ route('tags.index') }}">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <select class="form-select" id="sortSelect" name="sort" onchange="this.form.submit()">
                                        <option value="popularity" {{ request('sort') === 'popularity' ? 'selected' : '' }}>Most Popular</option>
                                        <option value="bounties" {{ request('sort') === 'bounties' ? 'selected' : '' }}>Most Bounties</option>
                                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Tags Grid -->
                    @if ($tags && count($tags) > 0)
                        <div class="row g-4">
                            @foreach ($tags as $tag)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 shadow-sm border-0 transition-hover"
                                        style="cursor: pointer; border-left: 5px solid {{ $tag->color ?? '#007bff' }} !important;">
                                        <!-- Card Header with Color Badge -->
                                        <div class="card-header border-0 d-flex justify-content-between align-items-start"
                                            style="background-color: {{ $tag->color ?? '#007bff' }}20;">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title mb-0">{{ $tag->name }}</h5>
                                            </div>
                                            <div class="rounded px-2 py-1"
                                                style="background-color: {{ $tag->color ?? '#007bff' }}; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <span
                                                    style="color: white; font-weight: bold; font-size: 12px;">{{ strtoupper(substr($tag->name, 0, 2)) }}</span>
                                            </div>
                                        </div>

                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <p class="card-text text-muted"
                                                style="height: 60px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
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
                                            {{-- <a href="{{ route('tags.show', $tag->id) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                                <i class="bi bi-eye"></i> View
                                            </a> --}}
                                            @auth
                                                <button
                                                    class="btn btn-sm {{ auth()->user()->isFollowingTag($tag->id) ? 'btn-danger' : 'btn-outline-success' }} follow-btn"
                                                    data-tag-id="{{ $tag->id }}">
                                                    <i class="bi {{ auth()->user()->isFollowingTag($tag->id) ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                    {{ auth()->user()->isFollowingTag($tag->id) ? 'Following' : 'Follow' }}
                                                </button>
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



@section('scripts')
    <script src="{{ asset('js/tags.js') }}"></script>
@endsection