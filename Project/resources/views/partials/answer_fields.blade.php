@php
    $title = $title ?? '';
    $description = $description ?? '';
@endphp

<input type="hidden" name="bounty_id" value="{{ $bounty_id }}">

<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $title) }}">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
        rows="5" minlength="15" required>{{ old('description', $description) }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group d-flex flex-column mb-3 mt-3">
    <label for="answerImage"></label>
    <input type="file" id="imageSelection" name="answerImage">
</div>

<div class="answerImagePreview d-flex justify-content-center">
    <img id="preview" src="" alt="Image preview" width="320" height="240">
</div>


<div class="d-flex align-items-center gap-3">
    <a href="{{ route('bounties.show', $bounty_id) }}" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
