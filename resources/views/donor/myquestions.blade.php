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
    <p>In this page, you can read and response the questions that have been asked to you !
    <h3>Public questions (select a question you want to answer)</h3>
    <form method="POST" action="/donor/reply"  enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6 offset-md-4">
            @foreach ($questions as $question)
            @if ($question->question==1)
                <div class="text-md-left"><input type="radio" id="{{$question->seeker_id}}" name="seeker_id" value="{{$question->seeker_id}}" required><strong>
                @if ($question->anonymous==1)
                    Anonymous:
                @else
                    {{$question->name}}:
                @endif
                </strong></strong><br/>{{$question->message}}
            @else
                <div class="text-md-right"><strong>{{$user->name}}</strong></br>{{$question->message}}
            @endif
            <br/><a href="/donor/deletequestion/{{$question->id}}"><span class="text-danger">delete</a></div>
            @endforeach
        </div>
    </div>
    <h3>Reply to question</h3>
   
    @csrf
    <div class="form-group row">
        <div class="col-md-6">
            <textarea class="form-control" id="message" name="message" required></textarea>
        </div>
    </div>
    <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Validate') }}
                </button>
            </div>
        </div>
    </form>
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <a href="/donor/deleteallquestions" class="btn btn-danger btn-block">
                {{ __('Delete all questions') }}
            </a>
        </div>
    </div>

</div>
@endsection
