@extends('layouts.app')

@section('content')

<div class="container">
    <div class="status">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    You are logged in as donor!
    </div>
    <div class="links">
        <ul>
            <li><a href="/">home donor</a></li>
            <li><a href="/donor/questions">Questions</a></li>
            <li><a href="/donor/profil">Edit profil</a></li>
        </ul>
    </div>
    <p>This is your home as a donor
</div>
@endsection