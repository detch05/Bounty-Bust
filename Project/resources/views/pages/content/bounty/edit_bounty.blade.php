@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container my-3">
        <div class="row justify-content-center" id="Bounty">
                <h2>Edit Bounty</h2>
                <form action="{{ route('bounties.update', $bounty->id_content) }}" method="POST" enctype="multipart/form-data">
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
@endsection


@section('scripts')
<script src="{{ asset('js/forms.js') }}"></script>
@endsection
  