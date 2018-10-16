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
            <li><a href="#">Questions</a></li>
            <li><a href="#">Private messages</a></li>
            <li><a href="#">Edit profil</a></li>
        </ul>
    </div>
</div>
@endsection