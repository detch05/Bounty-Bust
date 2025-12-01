<aside class="collapse d-md-block col col-md-2 border-end min-vh-100 ms-0 ms-lg-3 p-3" id="contentNav">
    <nav class="nav flex-column">
        <section id="mainFeatures">
            <div class="d-flex align-items-center">
                <i class="bi bi-house-door-fill fs-4"></i>
                <a class="nav-link" href="/">Home</a>
            </div>
            <div class="d-flex align-items-center">
                <i class="bi bi-bullseye fs-4"></i>
                <a class="nav-link" href="{{ route('bounties.index') }}">Bounties</a>
            </div>
            <div class="d-flex align-items-center">
                <i class="bi bi-tags-fill fs-4"></i>
                <a class="nav-link" href="{{ route('tags.index') }}">Tags</a>
            </div>
        </section>
        <section id="misc">
            <div class="d-flex align-items-center">
                <i class="bi bi-question-circle-fill fs-4"></i>
                <a class="nav-link" aria-current="page" href="#">Tour</a>
            </div>
            <div class="d-flex align-items-center">
                <i class="bi bi-briefcase-fill fs-4"></i>
                <a class="nav-link" href="#">About Us</a>
            </div>
            <div class="d-flex align-items-center">
                <i class="bi bi-envelope-fill fs-4"></i>
                <a class="nav-link" href="#">Contacts</a>
            </div>
        </section>
        <section id="adminPanel">
            <div class="d-flex align-items-center">
                <i class="bi bi-tools fs-4"></i>
                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Panel</a>
            </div>
        </section>
    </nav>
</aside>


