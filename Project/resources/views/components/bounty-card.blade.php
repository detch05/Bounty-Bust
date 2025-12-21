<article class="bounty-card p-3 position-relative border">
    <div class="d-flex gap-3 align-items-center">
        <a href="{{ route('bounties.show', $bounty->id_content) }}" class="stretched-link text-decoration-none"></a>
        <div class="d-none d-xl-block">
            <img src="{{ Storage::url($bounty->getImagePath(true)) }}" class="bountyImg"
                onerror="this.onerror=null; this.src='{{ Storage::url('bounties/default.jpg') }}';">
        </div>
        <div class="cardContent">
            <h3>{{ $bounty->title }}</h3>
            <div class="d-flex align-items-center justify-content-between">
                <p class="text-truncate">{{ $bounty->content->description }}</p>
                <p class="me-3">Reward: <span>{{ $bounty->reward }}</span></p>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @foreach ($bounty->tags->take(3) as $tag)
                        <span class="badge"
                            style="background-color: {{ $tag->color ?? '#007bff' }}; color: white;">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <div class="d-flex align-items-center gap-2 me-3">
                    <img src="{{ Storage::url('users/' . $bounty->user->id . '.jpg') }}" class="profileIcon"
                        onerror="this.onerror=null; this.src='{{ Storage::url('users/default.jpg') }}';">
                    <p class="mt-3">{{ $bounty->user->name }}</p>
                </div>
            </div>
        </div>
    </div>
</article>
