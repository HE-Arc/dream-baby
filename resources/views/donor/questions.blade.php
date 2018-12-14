@extends('layouts.app')

@section('content')

<div class="container">
    <div class="status">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col">
            <h1 class="col">
                <a class="btn-link" href="{{route('profil.profil', $user_donor->id)}}">{{$user_donor->name}}</a>
            </h1>
            <img class="col rounded img-fluid" src="{{ route('donor.image', ['filename' => $donor->photo_uri]) }}" alt="{{$user->name}} - Profile Picture"/><br/>
        </div>
        <div class="col">
            <h2>Ask a public question</h2>
            <form method="POST" action="{{route('questions.ask', $donor->user_id)}}" enctype="multipart/form-data">
            @csrf
                <div class="form-group">
                    <div class="">
                        <textarea class="form-control" id="message" name="message" required></textarea>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="anonymous" class="custom-control-input" name="anonymous" value="1">
                            <label class="custom-control-label" for="anonymous"> ask as Anonymous</label> 
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Validate') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr class="my-4">
    <h2 class="row">Questions</h2>
    @if (count($questions) > 0)
    @foreach ($questions as $question)
    <div class="container public-question">
        <div class="row swipe-info">
            <p class="col-md text-left question repliedQuestionText">
                {{ $question->message }}
            </p>
            <p class="col-md text-right">
                asked by {{ $question->anonymous==0 ? $seekers_users[$question->seeker_id]->name : 'Anonymous'}}
            </p>
        </div>
        <div class="row text-md-left">
            <!-- TO IMPROVE -->
            @if(isset($answers[$question->id]))
                <p class="col question-reply">{{$answers[$question->id]->reply}}</p>
            @else
                <p class="col font-italic">still no reponses...</p>
            @endif
        </div>
    </div>
    @endforeach
    @else
    <div class="container public-question question">
        <p class="text-md-center">Be the first to ask !</p>
    </div>
    @endif

</div>
@endsection
