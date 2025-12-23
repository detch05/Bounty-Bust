@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">

@section('content')
    <div class="container my-3">
        <div class="row justify-content-center" id="Answer">
                <h2>Create Answer</h2>
                <form action="{{ route('answers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('partials.answer_fields',['isEdit'=>false,'bounty_id' => $bounty_id])
                </form>
        </div>
    </div>
@endsection


@section('scripts')
<script src="{{ asset('js/forms.js') }}"></script>
@endsection
