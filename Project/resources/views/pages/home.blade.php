@extends('layouts.app')



@section('styles')
    <link href="{{ asset('css/cards.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.aside')
            <div class="col-12 col-lg-9 p-sm-5 me-2">
                <div class="row">
                    <section class="col-xl-9 col-lg-10 d-flex flex-column align-items-center justify-content-center gap-5">
                        @include('partials.homepage.mostWanted',['featured_bounties'=>$featured_bounties])
                        <div>
                            @foreach ($bounties as $bounty)
                                <x-bounty-card :bounty="$bounty" />
                            @endforeach
                        </div>
                    </section>
                    <section class="col-xl-3 col-lg-2 d-none d-lg-block">
                        <p>Test</p>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

