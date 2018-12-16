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

        @foreach ($questions as $question)
        <div class="container">
            <div class="row swipe-info">
                <p class="col-md text-left">
                    You've asked to
                </p>
                <p>
                    <a href="{{route('profil.profil', $donors_users[$question->donor_id]->id)}}" class="col-md text-right btn-link">
                        {{$donors_users[$question->donor_id]->name}}
                    </a>
                </p>
            </div>
            <div class="row">
                <div class="col input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text repliedQuestionText" id="">{{$question->message}}</span>
                    </div>
                    <div class="input-group-append">
                        <form action="{{route('questions.delete', $question->id)}}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary" type="button">{{ __('Delete') }}</button>
                        </form>

                    </div>
                </div>
            </div>
            <div class="row text-md-right">
                <!-- TO IMPROVE -->
                @if(isset($answers[$question->id]))
                <p class="repliedQuestionText">{{$answers[$question->id]->reply}}</p>
                @else
                <p class="font-italic">still no reponses...</p>
                @endif
            </div>
        </div>
        @endforeach


    <div class="form-group row">
        <div class="col-md-6 offset-md-4">
            <form action="{{route('questions.delete.all')}}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit"  class="btn btn-danger btn-block" type="button"> {{ __('Delete all questions') }}</button>
            </form>
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