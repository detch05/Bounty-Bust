@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.aside')

        <div class="col-12 col-md-9 p-4">
            <h2>{{ $user->name }}'s Bounties</h2>

            @if($bounties->count())
                <div class="row g-3 mt-3">
                    @foreach($bounties as $bounty)
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $bounty->title }}</h5>
                                    <p class="card-text text-truncate">{{ $bounty->content->description ?? '' }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <a href="{{ route('bounties.show', $bounty->id_content) }}" class="btn btn-sm btn-primary">View</a>
                                        <span class="text-muted">{{ $bounty->reward }} pts</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $bounties->links() }}
                </div>
            @else
                <div class="alert alert-info">This user has no bounties yet.</div>
            @endif
        </div>
    </div>
</div>
@endsection
