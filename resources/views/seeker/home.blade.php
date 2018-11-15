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
    <div class="links">
        <ul>
            <li><a href="/">home seeker</a></li>
            <li><a href="/seeker/search">Search a donor</a></li>
            <li><a href="/seeker/criteria">Criteria</a></li>
            <li><a href="/seeker/profil">Edit my profil</a></li>
        </ul>
    </div>
    <p>This is your home as a seeker
</div>

@endsection