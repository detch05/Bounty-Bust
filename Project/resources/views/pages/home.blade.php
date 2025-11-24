@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row ">
            <aside class="col col-md-2 bg-light border-end min-vh-100 p-3">
                <nav class="nav flex-column">
                    <section id="mainFeatures">
                        <div>
                            <i></i>
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </div>
                        <div>
                            <a class="nav-link" href="#">Bounties</a>
                        </div>
                        <div>
                            <a class="nav-link" href="#">Tags</a>
                        </div>
                    </section>
                    <section id="AboutUs">
                        <div>
                            <a class="nav-link active" aria-current="page" href="#">Tour</a>
                        </div>
                        <div>
                            <a class="nav-link" href="#">About Us</a>
                        </div>
                        <div>
                            <a class="nav-link" href="#">Contacts</a>
                        </div>
                    </section>
                </nav>
            </aside>

        </div>

    </div>

@endsection