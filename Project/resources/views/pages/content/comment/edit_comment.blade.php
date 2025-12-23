@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">

@section('content')
    <div class="container my-3">
        <div class="row justify-content-center" id="commentEdit">
                <h2>Edit Comment</h2>
                <form action="{{ route('comments.edit', $comment->id_content) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="text" class="form-label">Description</label>
                    <textarea name="text" class="form-control" rows="5">{{ $comment->content->description }}</textarea>
                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                </form>
        </div>
    </div>
@endsection


