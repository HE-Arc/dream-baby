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
    <h1>Edit my profil</h1>
    <h3>User settings</h3>
    <form method="POST" action="{{route('seeker.myprofil.update', $user->id)}}">
        @csrf
        @method('PATCH')

        <div class="form-group row">
            <label for="name" class="col-md-4 text-md-right">{{ __('Name') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$user->name}}" required autofocus>

                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-4 text-md-right">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email}}" required>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
                <h5 class="col-md-4 text-md-right">Biography</h5>

            <div class="col-md-6">
                <textarea class="form-control" id="bio" name="bio" required>{{$seeker->bio}}</textarea>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Validate') }}
                </button>
            </div>
        </div>
    </form>
    <h3>Search criteria</h3>
    <form method="POST" action="#">
        @csrf

        <!-- sperm or egg -->
        <div class="form-group row">
            <h5 class="col-md-4 text-md-right">Sex</h5>
            <div class="col-md-6">
                <div class="form-check-inline">
                    <input class="form-check-input" type="radio" id="femaleSex" value="1" name="sex" required
                    {{ $seekerCriteria['main']->sex == 1 ? 'checked' : '' }} />
                    <label for="femaleSex" class="form-check-label">Female </label>
                </div>
                <div class="form-check-inline">
                    <input class="form-check-input" type="radio" id="maleSex" value="2" name="sex" required
                    {{ $seekerCriteria['main']->sex == 0 ? 'checked' : '' }} />
                    <label for="maleSex" class="form-check-label">Male </label>
                </div>
            </div>
        </div>

        <!-- donor age -->
        
        <!-- eye color -->
        <div class="form-group row">
                <h5 class="col-md-4 text-md-right">Eyes colors</h5>
            <div class="col-md-6">
                <p> {{ count($seekerCriteria['eye']) }}
                @foreach ($seekerCriteria['eye'] as $item)
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input type="checkbox"  class="form-check-input" value="{{$item->id}}">
                        {{ $item->name }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <!-- hair color -->
        <div class="form-group row">
            <h5 class="col-md-4 text-md-right">Hair colors</h5>
            <div class="col-md-6">
                @foreach ($seekerCriteria['hair'] as $item)
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input type="checkbox"  class="form-check-input" value="{{$item->id}}" {{$item->searched ? 'checked' : ''}}>
                        {{ $item->name }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <!-- ethnicity -->
        <div class="form-group row">
            <h5 class="col-md-4 text-md-right">Ethnicities</h5>
            <div class="col-md-6">
                @foreach ($seekerCriteria['ethnicity'] as $item)
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input type="checkbox"  class="form-check-input" value="{{$item->id}}">
                        {{ $item->name }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Validate') }}
                </button>
            </div>
        </div>
    </form>
    <h3>Swipe history</h3>
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <a href="#" class="btn btn-primary btn-block">
                {{ __('Delete history') }}
            </a>
        </div>
    </div>
</div>
@endsection
