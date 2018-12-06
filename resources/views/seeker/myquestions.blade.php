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
    <form method="DELETE" action="#"  enctype="multipart/form-data">
    @csrf
        @foreach ($questions as $question)
        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="text-md-left">
                    <input type="radio" id="{{$question->seeker_id}}" name="seeker_id" value="{{$question->seeker_id}}" required>
                    <p>
                        {{ $question->anonymous==0 ? $user->name : 'Anonymous'}}: {{$question->message}}
                    </p>
                </div>
                <div class="text-md-left">
                    <p>
                        {{$donors_users[$question->donor_id]->name}} : {{$answers[$question->id]->reply}}
                    </p>
                </div>
            </div>
        </div>
        @endforeach

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