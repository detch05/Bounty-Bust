<div id="mostWanted" class="carousel slide p-3" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mostWanted" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#mostWanted" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#mostWanted" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
            
    </div>
    <h1>WANTED</h1>
    <div class="carousel-inner">
        @foreach($featured_bounties as $index => $bounty)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }} p-3">
            <article class="border-dark d-flex flex-column align-items-center">
                <h3>{{$bounty->title}}</h3>
                <img src="{{ Storage::url($bounty->getImagePath(true)) }}" class="wantedImg"
                onerror="this.onerror=null; this.src='{{ Storage::url('bounties/default.jpg') }}';">
                <div class="d-flex align-items-center gap-2 me-3">
                    <img src="{{ Storage::url('users/' . $bounty->user->id . '.jpg') }}" class="profileIcon"
                        onerror="this.onerror=null; this.src='{{ Storage::url('users/default.jpg') }}';">
                    <p class="mt-3">{{ $bounty->user->name }}</p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <p class="mb-0">Reward:</p>
                    <p class="mt-0">{{ $bounty->reward }}</p>
                </div>    
            </article>
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mostWanted"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mostWanted"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
