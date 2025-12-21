<div class="d-inline-flex flex-column justify-content-start mb-3" id="tagUtils">
    <h3 class="tagHeading me-3">Tag Utils:</h3>
    <a href="{{ route('tags.create') }}" class="btn btn-primary ms-3"><i class="bi bi-plus-circle"></i> Create Tag</a>
</div>
<div class="d-flex flex-column justify-content-start">
    <h3 class="tagHeading me-3">Tags List:</h3>
    @foreach ($tags as $tag)
        <article class="tag_card m-2 p-3 d-flex flex-column align-items-start"
            style="border: 1px solid #dee2e6; border-left: 5px solid {{ $tag->color ?? '#ffffff' }};"> {{-- Using inline css in an exceptionally to show off the tag color instead of js --}}
            <div class="d-flex flex-column mb-2">
                <h4>{{ $tag->name }}</h4>
                <p class="mb-0">{{ $tag->description }}</p>
            </div>
            <div class="d-flex justify-content-center align-items-center gap-3">
                <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-sm btn-secondary">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" class="d-inline m-0 p-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
        </article>
    @endforeach
</div>
