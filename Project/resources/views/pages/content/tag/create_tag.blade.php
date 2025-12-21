@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">

@section('content')
    <div class="container my-3">
        <div class="row justify-content-center" id="Tag">
                <h2>Create Tag</h2>
                <form action="{{ route('tags.store') }}" method="POST">
                    @csrf
                    @include('partials.tag_fields',['isEdit'=>false])
                </form>
        </div>
    </div>
@endsection



  