@extends('layouts.app')
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/css/swiper.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> 
<link rel="stylesheet" href="/css/swipe.css">


@section('content')

<div class="container">
    <div class="status">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
    </div>

    @if(is_null($donorsArray))
    <div class="jumbotron">
        <h1 class="display-4 text-left">Congratulations !</h1>
        <p class="lead">You already have swiped all the available donors...</p>
        <hr class="my-4">
        <p>But <a href="/profil">change your criteria</a> or wait a little bit to find new ones !</p>
    </div>
    @else
    <h1><span id="username">{{$donorsArray[0]['username']}}</span></h1>

    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide" id="swipe-div-no"></div>
            <div class="swiper-slide"><img id="photo" class="img-fluid" src="{{route('donor.image', ['filename' => $donorsArray[0]['donor']->photo_uri])}}"/><br/></div>
            <div class="swiper-slide" id="swipe-div-yes"></div>
        </div>
    </div>

    <div id="center-wrapper" class="jumbotron">
        <div id="swipe-profil">
            <div class="btn-group row">
                <div class="text-center">
                    <button id="swipe-no" class="btn btn-primary col-md-2 swipe-no">No</button>
                    <button id="swipe-yes"class="btn btn-primary col-md-2 swipe-yes">Yes</button>
                <div>
            </div>
            <hr class="my-4 row">
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-transgender"></i>
                <p class="col-md-8 text-justify" id="sex">{{$donorsArray[0]['donor']->sex == 0 ? 'Male' : 'Female'}}</p>
            </div>
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-birthday-cake"></i>
                <p class="col-md-8 text-justify" id="age">{{date("d F Y", strtotime($donorsArray[0]['donor']->birth_date))}} ({{ floor((time() - strtotime($donorsArray[0]['donor']->birth_date)) / 31556926)}} years old)</p>
            </div>
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-eye"></i>
                <p class="col-md-8 text-justify" id="eyecolor">{{$donorsArray[0]['eyecolor']}}</p>
            </div>
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-scissors"></i>
                <p class="col-md-8 text-justify" id="haircolor">{{$donorsArray[0]['haircolor']}}</p>
            </div>
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-id-card-o"></i>
                <p class="col-md-8 text-justify" id="ethnicity">{{$donorsArray[0]['ethnicity']}}</p>
            </div>
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-group"></i>
                <p class="col-md-8 text-justify" id="family_antecedents">{{$donorsArray[0]['donor']->family_antecedents}}</p>
            </div>
            <div class="row swipe-info">
                <i class="col-md-2 fa fa-medkit"></i>
                <p class="col-md-8 text-justify" id="medical_antecedents">{{$donorsArray[0]['donor']->medical_antecedents}}</p>
            </div>
            <span style="display:none;" id="donor_id">{{$donorsArray[0]['donor']->id}}</span>
        </div>
    </div>
    
    <div id="hidden-profils">
        @for ($i = 1; $i < count($donorsArray); $i++)
        <div id="hidden-profil{{$i}}">
            <span class="hidden-username">{{$donorsArray[$i]['username']}}</span>
            <span class="hidden-photo"><img class="img-fluid" class="photo" src="{{route('donor.image', ['filename' => $donorsArray[$i]['donor']->photo_uri])}}"/></span>
            <span class="hidden-sex">{{$donorsArray[$i]['donor']->sex}}</span>
            <span class="hidden-eyecolor">{{$donorsArray[$i]['eyecolor']}}</span>
            <span class="hidden-haircolor">{{$donorsArray[$i]['haircolor']}}</span>
            <span class="hidden-ethnicity">{{$donorsArray[$i]['ethnicity']}}</span>
            <span class="hidden-family_antecedents">{{$donorsArray[$i]['donor']->family_antecedents}}</span>
            <span class="hidden-medical_antecedents">{{$donorsArray[$i]['donor']->medical_antecedents}}</span>
            <span class="hidden-donor_id">{{$donorsArray[$i]['donor']->id}}</span>
            <span class="hidden-age">{{date("d F Y", strtotime($donorsArray[$i]['donor']->birth_date))}} ({{ floor((time() - strtotime($donorsArray[$i]['donor']->birth_date)) / 31556926)}} years old)</span>
        </div>
        @endfor
    </div>
    @endif
</div>
<script src="/js/swipe.js"></script>
@endsection
