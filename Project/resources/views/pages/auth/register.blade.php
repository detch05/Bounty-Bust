@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">


@section('content')

    <div id="register" class="container justify-content-center d-flex flex-column gap-3 ">
        <h2>Welcome to Bounty Bust!</h2>
        <form method="POST" action="/register" enctype="multipart/form-data">
            @csrf
            @include('partials.register_fields',['isEdit'=>false])
        </form>
    </div>

@endsection


@section('scripts')
<script src="{{ asset('js/forms.js') }}"></script>
@endsection