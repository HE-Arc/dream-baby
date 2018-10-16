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
            <li><a href="#">Search a donor</a></li>
            <li><a href="#">Criteria</a></li>
        </ul>
    </div>
</div>

@endsection