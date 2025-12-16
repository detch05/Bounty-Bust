@php 

$title = $title ?? '';
$description = $description ?? '';
$reward = $reward ?? '';

@endphp

<div class="mb-3">
    <label for="title" class="form-label mb-0">Title</label>
    <input type="text" class="form-control mt-0 @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $title) }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label mb-0">Description</label>
    <textarea class="form-control mt-0 @error('description') is-invalid @enderror" id="description" name="description"
        rows="5" required>{{ old('description', $description) }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="reward" class="form-label mb-0">Reward</label>
    <input type="number" min="0" class="form-control mt-0 @error('reward') is-invalid @enderror" id="reward" name="reward"
        value="{{ old('reward',$reward) }}" required>
    @error('reward')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group d-flex flex-column mb-3 mt-3">
    <label for="bountyImage"></label>
    <input type="file" id="imageSelection" name="bountyImage">
</div>

<div class="bountyImagePreview d-flex justify-content-center">
    <img id="preview" src="" alt="Image preview" width="320" height="240">
</div>

<button type="submit" class="btn btn-primary">Submit</button>