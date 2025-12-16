@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">

@section('content')
    <div class="container my-3">
        <div class="row justify-content-center" id="Bounty">
                <h2>Create Bounty</h2>
                <form action="{{ route('bounties.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('partials.bounty_fields',['isEdit'=>false])
                </form>
        </div>
    </div>
@endsection




@section('scripts')
<script src="{{ asset('js/forms.js') }}"></script>
@endsection
  