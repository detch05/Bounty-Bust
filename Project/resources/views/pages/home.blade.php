@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
                @include('partials.aside')
                <div class="col-12 col-md-9 p-sm-5 me-2">
                    <div class="row">
                        <section class="col-md-10 d-flex d-column justify-content-center align-items-center">
                            <div class="d-flex flex-column align-items-center p-3 mb-5" id="mostWanted">
                                <h2 class="mb-3">Most Wanted</h2>
                                @include('partials.homepage.mostWanted')
                            </div>
                        </section>
                        <section class="col-md-2">
                            <p>Hello</p>
                        </section>
                    </div>
                </div >
        </div>
    </div>
@endsection




