@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div class="card-body-status">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in as donor!
                    </div>
                    <div class="card-body-links">
                        <ul>
                            <li><a href="#">Questions</a></li>
                            <li><a href="#">Private messages</a></li>
                            <li><a href="#">Edit profil</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection