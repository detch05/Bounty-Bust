<article class="answer-card p-3 mb-4 border">
    <div class="answerHeader d-flex gap-2 align-items-center">
            <div class="d-flex align-items-center gap-2 ms-2 py-0">
            <img src="{{ Storage::url('users/' . (optional($answer->content->user)->id ?: 'default') . '.jpg') }}" class="profileIcon"
                onerror="this.onerror=null; this.src='{{ Storage::url('users/default.jpg') }}';">
            <p class="mt-3 fw-bold">{{ $answer->content->user->username }}</p>
        </div>
        <span class="text-secondary">&bull;</span>
        <p class=" mb-0">{{ $answer->content->created_at->diffForHumans() }}</p>
        @if ($answer->content->isEdited())
            <span class="text-secondary">&bull;</span>
            <p class="mb-0">modified {{ $answer->content->updated_at->diffForHumans() }}</p>
        @endif
    </div>
    <div class="answerBody mt-1">
        <h4>{{ $answer->title ?? '' }}</h4>
        <p>{{ $answer->content->description }}</p>
        @if ($answer->hasImage())
            <div class="d-flex align-items-center justify-content-center mt-3 mb-3">
                <img src="{{ Storage::url($answer->getImagePath()) }}" alt="Answer Image" class="img-fluid rounded">
            </div>
        @endif
        <div class="d-flex align-items-center gap-3">
            <div class="voteZone d-flex flex align-items-center" data-content-id="{{ $answer->content->id }}"
                data-user-vote="{{ optional(auth()->user())->getVoteOnContent($answer->content->id) ?? 0 }}">
                <button class="upvoteBtn btn btn-light btn-sm ">
                    <i class="bi bi-arrow-up-circle fs-6"></i>
                </button>
                <span class="rating fs-6 mx-2 me-1">{{ $answer->content->rating() }}</span>
                <button class="downvoteBtn btn btn-light btn-sm ">
                    <i class="bi bi-arrow-down-circle fs-6"></i>
                </button>
            </div>
            @if (!empty($disableCommentsButton))
                <button class="btn btn-sm btn-light rounded" disabled>{{ $answer->comments()->count() }} <i class="bi bi-chat ms-1"></i></button>
            @else
                <a href="{{ route('answers.show', $answer->id_content) }}" class="btn btn-sm btn-light rounded">{{ $answer->comments()->count() }} <i class="bi bi-chat ms-1"></i></a>
            @endif
            <button class="followBtn btn btn-light btn-sm rounded" data-content-id="{{ $answer->content->id }}"
            @auth
                data-is-following="{{ auth()->user()->isFollowingContent($answer->content->id) }}"><i
                    class="bi bi-bookmark fs-6"></i></button>
                @if(auth()->user()->id === $answer->content->user->id || auth()->user()->role->name === 'Admin')
                    <div class="dropdown">
                    <i class="bi bi-three-dots toggle-icon dropdown-toggle" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" style="cursor:pointer"></i>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <form method="POST" action="{{ route('answers.delete', $answer->id_content) }}">
                            @csrf
                            @method('DELETE')
                            <li><button class="dropdown-item" type="submit">Delete</button></li>
                        </form>
                        <li><a href="{{ route('answers.editForm', $answer->id_content) }}" class="dropdown-item">Edit</a>
                        </li>
                    </ul>
                </div>
                @endif
                @if(auth()->user()->id === $bounty->content->user->id && !$answer->isCorrect())
                    <form method="POST" action="{{ route('answers.markCorrect', $answer->id_content) }}" class="mark-correct-form d-inline" data-answer-id="{{ $answer->id_content }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success ms-2">Mark as Correct</button>
                    </form>
                @endif
            @endauth
            @if($answer->isCorrect())
                    <span class="badge bg-success ms-3">Correct Answer<i class="bi bi-check"></i></span>
            @endif
        </div>
</article>
