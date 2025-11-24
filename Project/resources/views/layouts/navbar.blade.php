<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid d-flex justify-content-between align-items-center ">
        <button class="btn btn-light d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#contentNav"
            aria-expanded="false" aria-controls="sidebar">
            ☰ 
        </button>

        @include('partials.logo')

        <form class="search" role="search">
            <div>
                <i class="bi bi-search"></i>
                <input placeholder="Search BountyBust..." type="text" maxlength="150" method="get">

            </div>
        </form>

        @auth
            <ul class="navbar-nav d-flex align-items-center gap-1 me-3">
                <button class="btn btn-primary"><i class="bi bi-plus-circle"></i> Create</button>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-bell-fill fs-5"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-person-lines-fill fs-5"></i></a>
                </li>

                <li class="nav-item">
                    <form method="POST" action="/logout">
                        @csrf
                        <button class="border-0 bg-transparent p-0 fs-5" type="submit">
                            <i class="bi bi-door-open-fill"></i>
                        </button>
                    </form>
                </li>
            </ul>
        @else
            <div class="form-links d-flex align-items-center gap-3 me-4">
                <a class="nav-link " href="\login">SignIn</a>
                <a class="nav-link" href="\register">Join</a>
            </div>
        @endauth

    </div>
</nav>