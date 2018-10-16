@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    <div class="card-body-links">
                        <ul>
                            <li><a href="/login">login</a></li>
                            <li><a href="/donor">sing in as a donor</a></li>
                            <li><a href="/seeker">sing in as a seeker</a></li>
                        </ul>
                    </div>
                    <div class="card-body-content">
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
