
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
    <div class="row">
        <div class="col">
            <h1>{{$user->name}}</h1>
            <div class="text-center">
                <img class="m-3 rounded img-fluid" src="{{ route('donor.image', ['filename' => $donor->photo_uri]) }}" alt="{{$user->name}} - Profile Picture"/>
            </div>
        </div>
        <div class="jumbotron text-center">
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-transgender"></i>
                <p class="col-md-8 " id="sex">{{$donor->sex == 0 ? 'Male' : 'Female'}}</p>
            </div>
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-birthday-cake"></i>
                <p class="col-md-8 " id="birthdate">{{date("d F Y" ,strtotime($donor->birth_date))}}</p>
            </div>
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-eye"></i>
                <p class="col-md-8 " id="eyecolor">{{$eyecolor}}</p>
            </div>
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-scissors"></i>
                <p class="col-md-8 " id="haircolor">{{$haircolor}}</p>
            </div>
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-id-card-o"></i>
                <p class="col-md-8 " id="ethnicity">{{$ethnicity}}</p>
            </div>
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-group"></i>
                <p class="col-md-8 " id="family_antecedents">{{$donor->family_antecedents}}</p>
            </div>
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-medkit"></i>
                <p class="col-md-8 " id="medical_antecedents">{{$donor->medical_antecedents}}</p>
            </div>
            
            <div class="row">
                <h3 class="col text-center"><a class="btn-link" href="{{route('questions.donor', $donor->user_id)}}">Questions</a><h3>
            </div>
        </div>
    </div>
</div>
@endsection
