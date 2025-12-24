@foreach ($users as $user)
    <article class="user_card border p-2 m-3 d-flex justify-content-between align-items-center">
        <div class="profilePreview ms-3">
            <a href="{{ route('profile', $user->id) }}" class="d-flex gap-2">
                <img src="{{ Storage::url('users/' . $user->id . '.jpg') }}"
                    onerror="this.onerror=null; this.src='{{ Storage::url('users/default.jpg') }}';" class="profileIconL">
                <div class="d-flex flex-column gap-0">
                    <p class="mb-0">{{ $user->name }}</p>
                    <p class="text-muted fs-6 mt-0">@<span>{{ $user->username }}</span></p>
                </div>
            </a>
        </div>
        <div class="d-flex flex-column align-items-center">
            <p class="user_role">{{ $user->role->name }}</p>
            <div class="btn-group">
                <div class="d-flex align-items-center gap-2 me-3">
                    <form action="{{ route('users.destroy', $user->id) }}" class="mb-0" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-sliders2 fs-5"></i>
                    </button>
                </div>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Promote</a></li>
                    <li><a class="dropdown-item" href="#">Demote</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Ban Account</a></li>
                </ul>
            </div>
        </div>
    </article>
@endforeach
