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
    @if (count($questions) > 0)
    <form method="DELETE" action="#"  enctype="multipart/form-data">
    @csrf
        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                @foreach ($questions as $question)
                <div class="text-md-left"><input type="radio" id="{{$question->seeker_id}}" name="seeker_id" value="{{$question->seeker_id}}" required><strong>
                    @if ($question->anonymous==1)
                        Anonymous:
                    @else
                        {{$user->name}}:
                    @endif
                    </strong></strong><br/>{{$question->message}}
                    @if (key_exists($question->id, $answers))
                        <div class="text-md-right"><strong>$question->donor_id</strong></br>{{$answers[$question->id]->message}}</div>
                    @else
                    <div class="text-md-right"><strong>{{$question->donor_id}}</strong></br>still no response</div>
                    @endif
                @endforeach
            </div>
        </div>
            
        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Delete') }}
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
    <div class="col-md-6 offset-md-4">
        <div class="jumbotron">
            <p>You haven't asked any questions</p>
        </div>
    </div>
    @endif
</div>
@endsection