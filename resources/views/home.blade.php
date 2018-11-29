@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 class="display-4">Dream Baby</h1>
        <p class="lead">Tinder for assisted reproduction !</p>
        <hr class="my-4">
        <p>Become a egg or sperm seeker and find the perfect donnor for your dream baby.
            Like tinder, swipe right to select and left to decline. It's never been easier !</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="/login" role="button">login</a>
            <a class="btn btn-primary btn-lg" href="/register" role="button">register</a>
        </p>
    </div>
</div>
@endsection
