@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Create Bounty</h1>
                
                <form action="{{ route('bounties.store') }}" method="POST">
                    @csrf
                    @include('partials.bounty_fields',['isEdit'=>false])
                </form>
            </div>
        </div>
    </div>
@endsection
