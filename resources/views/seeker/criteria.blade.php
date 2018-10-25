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
    <p>This is your actual criteria. Let's configure what your dream donor will look like !
</div>

@endsection