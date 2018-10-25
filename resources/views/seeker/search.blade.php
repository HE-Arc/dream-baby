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
            <li><a href="/seeker">home seeker</a></li>
            <li><a href="/seeker/search">Search a donor</a></li>
            <li><a href="/seeker/criteria">Criteria</a></li>
        </ul>
    </div>
    <p>Search for a donor ! Let's swipe and find your dream donor !
</div>

@endsection