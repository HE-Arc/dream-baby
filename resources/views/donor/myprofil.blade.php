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
    <form method="POST" action="{{route('donor.myprofil.update', $user->id)}}"  enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        @if (session('success'))
        <div class = "alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (count($errors) > 0)
        <div class = "alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

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
            <label class="col-md-4 col-form-label text-md-right">Birth Date:</label>
            <div class="col-md-6">
                <input class="form-control" type="date" id="birth_date" name="birth_date" value="{{$donor->birth_date}}" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Eye color:</label>
            <div class="col-md-6">
                <select class="form-control" id="eye_color" name="eye_color" required>
                    @foreach ($eye_colors as $item)
                        <option value="{{$item->id}}" {{($donor->eye_color == $item->id ? "selected":"") }}>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Skin color:</label>
            <div class="col-md-6">
            <select class="form-control" id="ethnicity" name="ethnicity" required>
                @foreach ($ethnicities as $item)
                    <option value="{{$item->id}}" {{($donor->ethnicity == $item->id ? "selected":"") }}>{{$item->name}}</option>
                @endforeach
            </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Hair color:</label>
            <div class="col-md-6">
                <select class="form-control" id="hair_color" name="hair_color" required>
                    @foreach ($hair_colors as $item)
                        <option value="{{$item->id}}" {{($donor->hair_color == $item->id ? "selected":"") }}>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Medical antecedents:</label>
            <div class="col-md-6">
                <textarea class="form-control" id="medical_antecedents" name="medical_antecedents" required>{{$donor->medical_antecedents}}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Familial antecedents:</label>
            <div class="col-md-6">
                <textarea class="form-control" id="family_antecedents" name="family_antecedents" required>{{$donor->family_antecedents}}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Upload Profile Image:</label>
            <div class="custom-file col-md-6">
                <input type="file" class="custom-file-input" id="profil_picture" name="image">
                <label class="custom-file-label" for="profil_picture">( jpg|png|gif , < 2 Mo )</label>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Validate') }}
                </button>
            </div>
        </div>
    </form>

    <!--<h3><a href="/donor/questions">View, edit and answer to my public questions</a></h3> Really needed ? cause we have the link in the nav bar-->
    <h3>Swipe history</h3>
    <div class="row">
        <div class="col-md-6 offset-md-4">
            <div class="jumbotron">
            @if (count($positiveSwipesArray) > 0)
                @foreach ($positiveSwipesArray as $id => $name)
                    <a class="btn btn-link" href="/profil/{{$id}}">{{$name}}</a><br/>
                @endforeach
            @else
            <p>Still no seeker intrested in your profil but it will not be longer</p>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection
