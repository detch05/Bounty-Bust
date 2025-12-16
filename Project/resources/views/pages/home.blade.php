@extends('layouts.app')



@section('styles')
    <link href="{{ asset('css/cards.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.aside')
            <div class="col-12 col-md-9 p-sm-5 me-2">
                <div class="row">
                    <section class="col-md-10 d-flex flex-column justify-content-center">
                        <div class="p-3 mb-5">
                            
                        </div>
                        <div>
                            @foreach ($bounties as $bounty)
                                <x-bounty-card :bounty="$bounty" />
                            @endforeach
                        </div>
                    </section>
                    <section class="col-md-2">
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

