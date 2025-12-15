@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.aside')

        <div class="col-12 col-md-9 p-4">
            <h2>{{ $user->name }}'s Answers</h2>

            @if($answers->count())
                <div class="list-group mt-3">
                    @foreach($answers as $answer)
                        <div class="list-group-item">
                            <p class="mb-1">{{ $answer->content->description ?? '' }}</p>
                            <div class="d-flex justify-content-between small text-muted">
                                <div>
                                    On bounty: <a href="{{ route('bounties.show', $answer->bounty->id_content ?? '#') }}">{{ $answer->bounty->title ?? '—' }}</a>
                                </div>
                                <div>
                                    <a href="{{ route('bounties.show', $answer->bounty->id_content ?? '#') }}" class="btn btn-sm btn-outline-primary">View Bounty</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">{{ $answers->links() }}</div>
            @else
                <div class="alert alert-info">This user has not posted any answers yet.</div>
            @endif
        </div>
    </div>
</div>
@endsection
