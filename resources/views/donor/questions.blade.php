@extends('layouts.app')

@section('content')

<div class="container">
    <div class="status">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <h1><a class="btn btn-link" href="/profil/{{$user->id}}">{{$user->name}}</a></h1>
    <img class="w-25 m-3 img-fluid" src="{{ route('donor.image', ['filename' => $donor->photo_uri]) }}" alt="{{$user->name}} - Profile Picture"/><br/>
    <h2>Public questions</h2>
    <div class="row">
        <div class="col-md-6 offset-md-4">
            @foreach ($questions as $question)
            @if ($question->question==1)
                <div class="text-md-left"><strong>
                @if ($question->anonymous==1)
                Anonymous:
                @else
                {{$question->name}}:
                @endif
                </strong><br/>{{$question->message}}</div></br>
            @else
                <div class="text-md-right"><strong>{{$user->name}}</strong></br>{{$question->message}}</div>
            @endif
            @endforeach
        </div>
    </div>

    @if(Auth::user()->user_type_id==2 and isset($swiped))
    <h3>Ask a public question</h3>
    <form method="POST" action="/donor/ask/{{$donor->id}}"  enctype="multipart/form-data">
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
    @endif


</div>
@endsection
