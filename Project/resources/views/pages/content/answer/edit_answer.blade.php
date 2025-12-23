@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">

@section('content')
    <div class="container my-3">
        <div class="row justify-content-center" id="Answer">
                <h2>Edit Answer</h2>
                <form action="{{ route('answers.update', $answer->id_content) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('partials.answer_fields',[
                        'isEdit'=>true,
                        'title' => $answer->title,
                        'bounty_id' => $answer->bounty_id,
                        'description' => $answer->content->description,
                        ])
                </form>
        </div>
    </div>
@endsection


@section('scripts')
<script src="{{ asset('js/forms.js') }}"></script>
@endsection
