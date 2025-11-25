@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Edit Bounty</h1>
                
                <form action="{{ route('bounties.edit') }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('partials.bounty_fields',[
                        'isEdit' => true,
                        'title' => $bounty->title,
                        'description' => $bounty->description,
                        'reward' => $bounty->reward,
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection