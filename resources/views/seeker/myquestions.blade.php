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


    <form method="DELETE" action="#"  enctype="multipart/form-data">
        @csrf
            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <p>radio button to select</p>
                    <p>Questions</p>
                    <p>Answers</p>
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
</div>
@endsection