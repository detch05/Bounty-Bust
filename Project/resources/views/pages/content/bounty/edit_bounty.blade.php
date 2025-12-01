@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Edit Bounty</h1>
                <form action="{{ route('bounties.update', $bounty->id_content) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('partials.bounty_fields', [
                        'isEdit' => true,
                        'title' => $bounty->title,
                        'description' => $bounty->content->description,
                        'reward' => $bounty->reward,
                    ])
                    </form>
                </div>
            </div>
        </div>
@endsection