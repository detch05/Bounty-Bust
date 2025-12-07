@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.aside')
            <div class="col-12 col-md-9 p-5">
                <div>
                    <h2>Admin Dashboard</h2>
                    <p class="mb-0 ms-3"><span>Name: </span>{{ $admin->name }}</p>
                    <p class="mt-0 ms-3"><span>Email: </span>{{ $admin->email }}</p>
                </div>
                <div class="btn-group" role="group" aria-label="Admin Tabs">
                    <button type="button" class="btn btn-outline-primary tab-btn active" data-url="{{ route('admin.users') }}">Users</button>
                    <button type="button" class="btn btn-outline-primary tab-btn" data-url="{{ route('admin.tags') }}">Tags</button>
                    <button type="button" class="btn btn-outline-primary tab-btn" data-url="{{ route('admin.appeals') }}">Account Appeals</button>
                </div>
                <section class="m-3 p-3" id="admin_content">

                </section>  
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/admin.js') }}"></script>
