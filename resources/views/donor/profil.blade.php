
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
    <img class="w-25 m-3 img-fluid" src="{{ route('donor.image', ['filename' => $donor->photo_uri]) }}" alt="{{$user->name}} - Profile Picture"/><br/>
    <h2>Sex: {{$donor->sex == 0 ? 'Male' : 'Female'}}</h2>
    <h3>Birth Date: {{date("d F Y" ,strtotime($donor->birth_date))}}</h3>
    <h3>Age: {{ floor((time() - strtotime($donor->birth_date)) / 31556926) }}</h3>
    <h3>Eye color: {{$eyecolor}}</h3>
    <h3>Hair color: {{$haircolor}}</h3>
    <h3>Ethnicity: {{$ethnicity}}</h3>
    <h3>Family antecedents: {{$donor->family_antecedents}}</h3>
    <h3>Medical antecedents: {{$donor->medical_antecedents}}</h3>
</div>
@endsection
