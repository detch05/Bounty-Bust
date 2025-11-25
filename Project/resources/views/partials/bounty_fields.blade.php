@php 

$title = $title ?? '';
$description = $description ?? '';
$reward = $reward ?? '';

@endphp

<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $title) }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
        rows="5" required>{{ old('description', $description) }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="reward" class="form-label">Reward</label>
    <input type="number" class="form-control @error('reward') is-invalid @enderror" id="reward" name="reward"
        value="{{ old('reward',$reward) }}" required>
    @error('reward')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary"> {{ ($isEdit ?? false) ? 'Update Profile' : 'Submit' }}</button>