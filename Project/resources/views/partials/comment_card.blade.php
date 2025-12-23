@foreach ($comments as $comment)
    <article class="comment_card border p-2 m-3 d-flex flex-column align-items-start">
        <div class="commentHeader d-flex align-items-center gap-2">
            <img src="{{ Storage::url('users/' . (optional($comment->content->user)->id ?: 'default') . '.jpg') }}"
                class="profileIcon">
            <p class="fw-bold mb-0">{{ optional($comment->content->user)->username ?? 'Unknown' }}</p>
            <span class="text-secondary">&bull;</span>
            @if ($comment->content->isEdited())
                <p class="mb-0">{{ $comment->content->updated_at->diffForHumans() }}<i
                        class="bi bi-pencil-fill ms-2"></i>
                </p>
            @else
                <p class="mb-0">{{ $comment->content->created_at->diffForHumans() }}</p>
            @endif
        </div>
        <p class="mt-2">{{ $comment->content->description }}</p>
        @auth
            <div class="d-flex align-items-center gap-3">
                <div class="voteZone d-flex flex align-items-center" data-content-id="{{ $comment->content->id }}"
                    data-user-vote="{{ auth()->user()->getVoteOnContent($comment->content->id) }}">
                    <button class="upvoteBtn btn btn-light btn-sm ">
                        <i class="bi bi-arrow-up-circle fs-6"></i>
                    </button>
                    <span class="rating fs-6 mx-2 me-1">{{ $comment->content->rating() }}</span>
                    <button class="downvoteBtn btn btn-light btn-sm ">
                        <i class="bi bi-arrow-down-circle fs-6"></i>
                    </button>
                </div>
                <button class="btn btn-sm btn-light replyBtn" data-comment-id="{{ $comment->id_content }}"
                    data-username="{{ optional($comment->content->user)->username }}">
                    <i class="bi bi-reply-fill"></i> Reply
                </button>
                @if (auth()->user()->id === optional($comment->content->user)->id || auth()->user()->role->name === 'Admin')
                    <div class="dropdown">
                        <i class="bi bi-three-dots toggle-icon dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="cursor:pointer"></i>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <form method="POST" action="{{ route('comments.delete', $comment->id_content) }}">
                                @csrf
                                @method('DELETE')
                                <li><button class="dropdown-item" type="submit">Delete</button></li>
                            </form>

                            <li><a href="{{ route('comments.editForm', $comment->id_content) }}"
                                    class="dropdown-item">Edit</a></li>
                        </ul>
                    </div>
                @endif
            </div>
        @endauth
    </article>
@endforeach
