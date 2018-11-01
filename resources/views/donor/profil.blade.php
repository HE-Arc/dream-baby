
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
    <h1>{{$user->name}}</h1>
    <img src="{{$donor->photo_uri == null ? 'https://pbs.twimg.com/profile_images/3141672525/42d0f32a6b76790e8d6f1ad6fcd30dbe_400x400.png' : $donor->photo_uri}}"/><br/>
    <h2>Sex: {{$donor->sex == 0 ? 'Male' : 'Female'}}</h2>
    <h3>Eye color: {{$eyecolor}}</h3>
    <h3>Hair color: {{$haircolor}}</h3>
    <h3>Ethnicity: {{$ethnicity}}</h3>
    <h3>Family antecedents: {{$donor->family_antecedents}}</h3>
    <h3>Medical antecedents: {{$donor->medical_antecedents}}</h3>
  {{$donor}}<br/>
  {{$user}}
</div>
@endsection
