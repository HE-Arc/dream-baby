@extends('layouts.app')

@section('content')

<div class="container">
    <div class="jumbotron">
        <h1 class="display-4">Hello {{$user->name}} !</h1>
        <p class="lead h4">Ready to spread your genetics all around ?</p>
        <hr class="my-4">
        <p class="h5">This is your home as a donor.
            <a class="btn-link" href="{{ route('profil.myprofil') }}">
                Describe yourself
            </a>
            and 
            <a class="btn-link" href="{{ route('search') }}">
                answer to the questions that you've been asked !
            </a>
        </p>
    </div>
</div>
@endsection