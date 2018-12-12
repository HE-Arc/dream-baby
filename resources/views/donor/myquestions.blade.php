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
    <!-- Questions -->
    @foreach ($questions as $question)
    <div class="container">
        <div class="row swipe-info">
            <p class="col-md text-left">
                {{ $question->message }}
            </p>
            <p class="col-md text-right">
                @if($question->anonymous == false)
                {{ $seekers_users[$question->seeker_id]->name}}
                @else
                Anonymous
                @endif
            </p>
        </div>
        <div class="row">
            @if(isset($answers[$question->id]))
            <div class="col input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">{{$answers[$question->id]->reply}}</span>
                </div>
            </div>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button">
                    <a href="{{route('questions.delete', $question->id)}}" class="btn-link">{{ __('Delete') }}</a>
                </button>
            </div>
            @else
            <form class="replyQuestion" method="POST" action="{{route('questions.reply', $question->id)}}" enctype="multipart/form-data">
            @csrf
                <div class="col input-group">
                    <input type="text" name="reply" id="reply" class="form-control" placeholder="Reply..." aria-label="Reply..." aria-describedby="basic-addon2" required>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-secondary">
                            {{ __('Reply') }}
                        </button>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
    @endforeach
    <div class="row">
        <div class="mx-auto">
            <a href="{{route('questions.delete.all')}}" class="btn btn-danger btn-block mt-3" role="button">
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
