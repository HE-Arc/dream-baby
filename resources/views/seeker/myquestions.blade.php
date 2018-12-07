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
    <h2>Questions</h2>
    @if (count($questions) > 0)
    <form method="POST" action="questions.delete"  enctype="multipart/form-data">
    @csrf
        @foreach ($questions as $question)
        <div class="container">
            <div class="row swipe-info">
                <p class="col-md text-left">
                    You've asked to
                </p>
                <p>
                    <a href="{{route('profil.profil', $donors_users[$question->donor_id]->id)}}" class="col-md text-right">
                        {{$donors_users[$question->donor_id]->name}}
                    </a>
                </p>
            </div>
            <div class="row">
                <div class="col input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">{{$question->message}}</span>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button">
                            <a href="{{route('questions.delete', $question->id)}}" >{{ __('Delete') }}</a>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row text-md-right">
                <!-- TO IMPROVE -->
                @if(isset($answers[$question->id]))
                <p>{{$answers[$question->id]->reply}}</p>
                @else
                <p class="font-italic">still no reponses...</p>
                @endif
            </div>
        </div>
        @endforeach
    </form>

    <div class="form-group row">
        <div class="col-md-6 offset-md-4">
            <a href="{{route('questions.delete.all')}}" class="btn btn-danger btn-block" role="button">
                {{ __('Delete all questions') }}
            </a>
        </div>
    </div>
    @else
    <div class="col-md-6 offset-md-4">
        <div class="jumbotron">
            <p>You haven't asked any questions</p>
        </div>
    </div>
    @endif
</div>
@endsection