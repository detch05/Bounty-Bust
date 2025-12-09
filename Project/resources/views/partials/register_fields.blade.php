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
    <label for="password">Password</label>
    <input type="password" name="password" maxlength="50" required>
</div>

<div class="form-group d-flex flex-column">
    <label for="password_confirmation">Confirm password</label>
    <input type="password" name="password_confirmation" maxlength="50" required>
</div>

<div class="form-group d-flex flex-column">
    <label for="location">Location</label>
    <input type="text" name="location" maxlength="50">
</div>

<div class="form-group d-flex flex-column">
    <label for="bio">Bio</label>
    <textarea name="bio" rows="10" cols="30" maxlength="300" placeholder="Write something about you!"
        required></textarea>
</div>

<div class="form-group d-flex flex-column mb-3 mt-3">
    <label for="profilePicture">Profile Picture</label>
    <input type="file" id="imageSelection" name="profilePicture">
</div>

<div class="imagePreview d-flex justify-content-center">
    <img id="preview" src="" alt="Image preview" width="200" height="200">
</div>

<button type="submit" class="btn btn-primary">Submit</button>
