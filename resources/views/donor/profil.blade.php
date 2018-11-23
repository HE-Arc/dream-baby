
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
    <h2><strong>Sex: </strong>{{$donor->sex == 0 ? 'Male' : 'Female'}}</h2>
    <h3><strong>Birth Date: </strong>{{date("d F Y" ,strtotime($donor->birth_date))}}</h3>
    <h3><strong>Age: </strong>{{ floor((time() - strtotime($donor->birth_date)) / 31556926) }}</h3>
    <h3><strong>Eye color: </strong>{{$eyecolor}}</h3>
    <h3><strong>Hair color: </strong>{{$haircolor}}</h3>
    <h3><strong>Ethnicity: </strong>{{$ethnicity}}</h3>
    <h3><strong>Family antecedents: </strong>{{$donor->family_antecedents}}</h3>
    <h3><strong>Medical antecedents: </strong>{{$donor->medical_antecedents}}</h3>
    <h2><strong><a href="/donor/{{$donor->id}}/questions">Public questions</a></strong></h2>
</div>
@endsection
