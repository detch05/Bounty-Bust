@extends('layouts.app')


@section('content')
    
    <div class="container justify-content-center d-flex flex-column align-items-center w-50 min-vh-100 gap-3">
        <h2>Welcome Back Bounty Hunter!</h2>
        <form>
            @csrf
            <div class="form-group d-flex flex-column">
                <label for="exampleFormControlInput1">Username</label>
                <input type="text" name="username">
            </div>
            <div class="form-group d-flex flex-column">
                <label for="exampleFormControlInput1">Password</label>
                <input type="password" name="password">
            </div>
        </form>
         <button type="submit" class="btn btn-primary">Submit</button>
    </div>

@endsection