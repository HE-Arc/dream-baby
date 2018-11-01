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
    <div class="links">
        <ul>
            <li><a href="/donor">home donor</a></li>
            <li><a href="/donor/questions">Questions</a></li>
            <li><a href="/donor/profil">Edit profil</a></li>
        </ul>
    </div>
    <p>Here you can edit your profil ! Be the dream donor ;)</p>
    <h1>Edit my profil</h1>
    <form method="POST" action="">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

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
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

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
            <label class="col-md-4 col-form-label text-md-right">Eye color:</label>
        
            <div class="col-md-6">
                <select id="eye_color" name="eye_color" required>
                    <option value="1">Blue</option>
                    <option value="2">Green</option>
                    <option value="3">Brown</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Skin color:</label>
        
            <div class="col-md-6">
            <select id="skin_color" name="skin_color" required>
                <option value="1">White</option>
                <option value="2">Black</option>
                <option value="3">Asian</option>
            </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Hair color:</label>
        
            <div class="col-md-6">
                <select id="hair_color" name="hair_color" required>
                <option value="0">Blue</option>
                <option value="1">Green</option>
                <option value="2">Brown</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Medical antecedents:</label>
        
            <div class="col-md-6">
                <textarea id="medical_antecedents" name="medical_antecedents" required></textarea>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Familial antecedents:</label>
        
            <div class="col-md-6">
        <textarea id="family_antecedents" name="family_antecedents" required></textarea>
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
</div>
@endsection
