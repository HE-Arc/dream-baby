@extends('layouts.app')

@section('content')

<div class="container">
    <div class="status">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <h1><a class="btn btn-link" href="{{route('profil.profil', $user_donor->id)}}">{{$user_donor->name}}</a></h1>
    <img class="w-25 m-3 img-fluid" src="{{ route('donor.image', ['filename' => $donor->photo_uri]) }}" alt="{{$user->name}} - Profile Picture"/><br/>
    
    <h2>Ask a public question</h2>
    <form method="POST" action="{{route('questions.ask', $donor->id)}}"  enctype="multipart/form-data">
    @csrf
        <div class="form-group row">
            <div class="col-md-6">
                <textarea class="form-control" id="message" name="message" required></textarea>
                <input type="checkbox" id="anonymous" class="form-check-input" name="anonymous" value="1"><label for="anonymous">Anonymous question </label> 
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
    
    <h2>Public questions</h2>
    @if (count($questions) > 0)
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
        <div class="text-md-right">
            <!-- TO IMPROVE -->
            @if(isset($answers[$question->id]))
            <p>{{$answers[$question->id]->reply}}</p>
            @else
            <p class="font-italic">still no reponses...</p>
            @endif
        </div>
    </div>
    @endforeach
    @endif

</div>
@endsection
