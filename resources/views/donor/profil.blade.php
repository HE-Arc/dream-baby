
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
    <div class="mx-auto">
        <h1 class="text-center">{{$user->name}}</h1>
    </div>

    <div class="text-center">
        <img class="w-25 m-3 img-fluid" src="{{ route('donor.image', ['filename' => $donor->photo_uri]) }}" alt="{{$user->name}} - Profile Picture"/>
    </div>
    <div class="jumbotron text-center">
        <div class="row swipe-info">
            <i class="col-md-2 fa fa-transgender"></i>
            <p class="col-md-8 text-justify" id="sex">{{$donor->sex == 0 ? 'Male' : 'Female'}}</p>
        </div>
        <div class="row swipe-info">
            <i class="col-md-2 fa fa-birthday-cake"></i>
            <p class="col-md-8 text-justify" id="birthdate">{{date("d F Y" ,strtotime($donor->birth_date))}}</p>
        </div>
        <div class="row swipe-info">
            <i class="col-md-2 fa fa-eye"></i>
            <p class="col-md-8 text-justify" id="eyecolor">{{$eyecolor}}</p>
        </div>
        <div class="row swipe-info">
            <i class="col-md-2 fa fa-scissors"></i>
            <p class="col-md-8 text-justify" id="haircolor">{{$haircolor}}</p>
        </div>
        <div class="row swipe-info">
            <i class="col-md-2 fa fa-id-card-o"></i>
            <p class="col-md-8 text-justify" id="ethnicity">{{$ethnicity}}</p>
        </div>
        <div class="row swipe-info">
            <i class="col-md-2 fa fa-group"></i>
            <p class="col-md-8 text-justify" id="family_antecedents">{{$donor->family_antecedents}}</p>
        </div>
        <div class="row swipe-info">
            <i class="col-md-2 fa fa-medkit"></i>
            <p class="col-md-8 text-justify" id="medical_antecedents">{{$donor->medical_antecedents}}</p>
        </div>
        
        <div class="row">
            <p class="col text-center"><a class="btn btn-link" href="/donor/{{$user->id}}/questions">Questions</a><p>
        </div>
    </div>
</div>
@endsection
