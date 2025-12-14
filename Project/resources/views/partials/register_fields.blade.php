@php

    $firstName = $firstName ?? '';
    $lastName = $lastName ?? '';
    $username = $username ?? '';
    $email = $email ?? '';
    $location = $location ?? '';
    $bio = $bio ?? '';

@endphp
<div class="row">
    <div class="form-group col-md-6 d-flex flex-column">
        <label for="firstName">First name</label>
        <input type="text" name="firstName" maxlength="30" value="{{ old('firstName', $firstName) }}" required>
    </div>

    <div class="form-group col-md-6 d-flex flex-column">
        <label for="lastName">Last name</label>
        <input type="text" name="lastName" maxlength="30" value="{{ old('lastName', $lastName) }}" required>
    </div>
</div>
<div class="form-group d-flex flex-column">
    <label for="username">Username</label>
    <input type="text" name="username" maxlength="40" value="{{ old('username', $username) }}" required>
</div>
<div class="form-group d-flex flex-column">
    <label for="email">Email</label>
    <input type="email" name="email" maxlength="60" value="{{ old('email', $email) }}" required>
</div>

<div class="form-group d-flex flex-column">
    <label for="password">{{ $isEdit ? 'CurrentPassword' : 'Password' }}</label>
    <input type="password" name="password" maxlength="50" {{ $isEdit ? '' : 'required' }} placeholder="{{ $isEdit ? 'Enter your current password' : ''}}" id="{{ $isEdit ? '' : 'checkMe' }}">
</div>

@if ($isEdit)
    <div class="form-group d-flex flex-column">
        <label for="new_password">New Password</label>
        <input type="password" name="new_password" maxlength="50" id="checkMe">
    </div>
@endif

<div class="mb-0 form-check d-flex align-items-center" id="checkField">
    <input type="checkbox" class="form-check-input" id="check">
    <label class="form-check-label mb-0" for="check">Check me out</label>
</div>

<div class="form-group d-flex flex-column">
    <label for="location">Location</label>
    <input type="text" name="location" maxlength="50" value="{{ old('location',$location) }}">
</div>

<div class="form-group d-flex flex-column">
    <label for="bio">Bio</label>
    <textarea name="bio" rows="10" cols="30" maxlength="300" placeholder="Write something about you!"
        required>{{ old('bio', $bio) }}</textarea>
</div>

<div class="form-group d-flex flex-column mb-3 mt-3">
    <label for="profilePicture">Profile Picture</label>
    <input type="file" id="imageSelection" name="profilePicture">
</div>

<div class="imagePreview d-flex justify-content-center">
    <img id="preview" src="" alt="Image preview" width="200" height="200">
</div>

<div class="d-flex align-items-center gap-3">
    <a href="{{ $isEdit ? route('profile',$userId) : route('homepage')}}" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Submit</button>
</div>


