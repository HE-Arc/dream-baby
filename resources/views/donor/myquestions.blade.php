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
    <div class="row">
        <h1 class="col">Questions</h3>
    </div>
    @if (count($questions) > 0)
    <!-- Questions form -->
    <div class="row">
        <p class="col">Select a question you want to answer to</p>
    </div>
    <form method="POST" action="#"  enctype="multipart/form-data">
    @csrf
    @foreach ($questions as $question)
    <div class="container">
        <div class="row swipe-info">
            <p class="col-md text-left">
                {{ $question->message }}
            </p>
            <p class="col-md text-right">
                {{ $question->anonymous==0 ? $seekers_users[$question->seeker_id]->name : 'Anonymous'}}
            </p>
        </div>
        <div class="row">
            <div class="col input-group mb-3">
                @if(isset($answers[$question->id]))
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">{{$answers[$question->id]->reply}}</span>
                </div>
                @else
                <input type="text" class="form-control" placeholder="Reply..." aria-label="Reply..." aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">
                        <a href="{{route('questions.reply', $question->id)}}" >{{ __('Create') }}</a>
                    </button>
                </div>
                @endif
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">
                        <a href="{{route('questions.delete', $question->id)}}" >{{ __('Delete') }}</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
    <div class="form-group row">
        <div class="col mx-auto">
            <a href="{{route('questions.deleteAll')}}" class="btn btn-danger btn-block">
                {{ __('Delete all questions') }}
            </a>
        </div>
    </div>
    @else
    <!-- No questions have been asked -->
    <div class="col-md-6 offset-md-4">
        <div class="jumbotron">
            <p>Still no seeker has asked you a question but it will not be longer</p>
        </div>
    </div>
    @endif
</div>
@endsection
