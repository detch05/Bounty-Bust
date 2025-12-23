@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/bounty.css') }}" rel="stylesheet">
    <link href="{{ asset('css/answer.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.aside')
            <div class="col-12 col-lg-9 p-sm-5 me-2">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn btn-secondary rounded-circle btn-sm me-2" id="answerBack" onclick="history.back()">
                        <i class="bi bi-arrow-left fs-6"></i>
                    </button>
                    <h2 class="mb-0">Answer Details</h2>
                </div>

                @include('partials.answer_card', ['answer' => $answer, 'disableCommentsButton' => true])
                <section id="answerComments" class="mt-4">
                    <h3>Comments</h3>
                    <form method="POST" action="{{ route('comments.store') }}">
                        @csrf
                        <input type="hidden" name="bounty_id" value="{{ $answer->bounty_id }}">
                        <input type="hidden" name="answer_id" value="{{ $answer->id_content }}">
                        <input type="hidden" name="parent_id" id="comment_parent_id" value="">
                        <div class="mb-3">
                            <textarea name="text" class="form-control" rows="3" minlength="15" required></textarea>
                        </div>
                        <button class="btn btn-primary">Add comment</button>
                    </form>
                    <hr>
                    @include('partials.comment_card', ['comments' => $comments])
                </section>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('js/content.js') }}"></script>
@endsection
