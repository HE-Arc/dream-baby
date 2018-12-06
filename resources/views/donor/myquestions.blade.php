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
        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="text-md-left">
                    <input type="radio" id="{{$question->seeker_id}}" name="seeker_id" value="{{$question->seeker_id}}" required>
                    <p>
                        {{ $question->anonymous==0 ? $seekers_users[$question->seeker_id]->name : 'Anonymous'}}: {{$question->message}}
                    </p>
                </div>
                <div class="text-md-left">
                    <p>
                        {{$user->name}} : {{$answers[$question->id]->reply}}
                    </p>
                </div>
                <br/><a href="#"><span class="text-danger">delete</a>
            </div>
        </div>
        @endforeach

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <h3>Reply to question</h3>
                <textarea class="form-control" id="message" name="message" required></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Validate') }}
                </button>
            </div>
        </div>
    </form>  
    
    <div class="form-group row">
        <div class="col-md-6 offset-md-4">
            <a href="#" class="btn btn-danger btn-block">
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
