@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">

@section('content')
    <div class="container my-3">
        <div class="row justify-content-center" id="Tag">
                <h2>Edit Tag</h2>
                <form action="{{ route('tags.update', $tag->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('partials.tag_fields',[
                        'isEdit'=>true,
                        'name'=>$tag->name,
                        'description'=>$tag->description,
                        'color'=>$tag->color,])
                </form>
        </div>
    </div>
@endsection


