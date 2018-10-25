@extends('layouts.app')

@section('content')

<div class="container">
    <div class="status">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    </div>
    <div class="links">
        <ul>
            <li><a href="/donor">home donor</a></li>
            <li><a href="/donor/questions">Questions</a></li>
            <li><a href="/donor/profil">Edit profil</a></li>
        </ul>
    </div>
    <p>Here you can edit your profil ! Be the dream donor ;)
</div>
@endsection
