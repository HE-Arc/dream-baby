@extends('layouts.app')

@section('content')

<div class="container">
    <div class="status">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    You are logged in as seeker!
    </div>
    <p>This is your home as a seeker
</div>

@endsection