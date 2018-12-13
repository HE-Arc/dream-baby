@extends('layouts.app')

@section('content')

<div class="container">
    <div class="jumbotron">
        <h1 class="display-4">Hello {{$user->name}} !</h1>
        <p class="lead h4">Ready to find your dream donor ?</p>
        <hr class="my-4">
        <p class="h5">This is your home as a seeker.
            <a class="btn-link" href="{{ route('profil.myprofil') }}">
                Edit your criteria
            </a>
            and 
            <a class="btn-link" href="{{ route('search') }}">
                find your dream genitor !
            </a>
        </p>
    </div>
</div>

@endsection