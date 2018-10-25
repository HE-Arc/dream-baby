@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="links">
                        <ul>
                            <li><a href="/login">login</a></li>
                            <li><a href="/register">register</a></li>
                        </ul>
                    </div>
                    <div class="description">
                        <p>Tinder for assisted reproduction !</p>
                        <p>
                            Become a egg or sperm seeker and find the perfect donnor for your dream baby.
                            Like tinder, swipe right to select and left to decline. It's never been easier !
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
