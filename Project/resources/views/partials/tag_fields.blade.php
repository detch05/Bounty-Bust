@php 

$name = $name ?? '';
$description = $description ?? '';
$color = $color ?? '#ffffff';

@endphp

<div class="form-group d-flex flex-column">
    <label for="name">Name</label>
    <input type="text" name="name" maxlength="45" value="{{ old('name', $name) }}" required>
</div>


<div class="form-group d-flex flex-column">
    <label for="description">Description</label>
    <textarea name="description" rows="10" cols="16" maxlength="150" required>{{ old('description', $description) }}</textarea>
</div>

<div class="form-group d-flex flex-column">
    <label for="color">Color</label>
    <input type="color" name="color" value="{{ old('color', $color) }}" required>
</div>

<div class="d-flex align-items-center gap-3">
    <a href="{{route('admin.dashboard')}}" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Submit</button>
</div>