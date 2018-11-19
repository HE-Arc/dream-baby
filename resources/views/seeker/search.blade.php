@extends('layouts.app')
  <!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/css/swiper.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<link rel="stylesheet" href="/css/swipe.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/js/swiper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


@section('content')

<div class="container">
    <div class="status">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    </div>
    @if(is_null($donor1))
    <h1>You have already swiped all the available donors on this website ! Congratulations !</h1>
    @else
    <h1><span id="username">{{$donor1['username']}}</span></h1>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide" id="swipe-div-no"></div>
            <div class="swiper-slide"><img id="photo" src="{{route('donor.image', ['filename' => $donor1['donor']->photo_uri])}}"/><br/></div>
            <div class="swiper-slide" id="swipe-div-yes"></div>
        </div>
    </div>
    <div id="center-wrapper">
        <div id="swipe-profil">
            <button id="swipe-no">No</button><button id="swipe-yes">Yes</button>
            <h2>Sex: <span id="sex">{{$donor1['donor']->sex == 0 ? 'Male' : 'Female'}}</span></h2>
            <h3>Eye color: <span id="eyecolor">{{$donor1['eyecolor']}}</span></h3>
            <h3>Hair color: <span id="haircolor">{{$donor1['haircolor']}}</span></h3>
            <h3>Ethnicity: <span id="ethnicity">{{$donor1['ethnicity']}}</span></h3>
            <h3>Family antecedents: <span id="family_antecedents">{{$donor1['donor']->family_antecedents}}</span></h3>
            <h3>Medical antecedents: <span id="medical_antecedents">{{$donor1['donor']->medical_antecedents}}</span></h3>
            <span style="display:none;" id="donor_id">{{$donor1['donor']->id}}</span>
        </div>
    </div>
    @if(is_null($donor2))
    @else
    <div id="hidden-profil">
        <span id="hidden-username">{{$donor2['username']}}</span>
        <span id="hidden-photo_uri">{{route('donor.image', ['filename' => $donor2['donor']->photo_uri])}}</span>
        <span id="hidden-sex">{{$donor2['donor']->sex == 0 ? 'Male' : 'Female'}}</span>
        <span id="hidden-eyecolor">{{$donor2['eyecolor']}}</span>
        <span id="hidden-haircolor">{{$donor2['haircolor']}}</span>
        <span id="hidden-ethnicity">{{$donor2['ethnicity']}}</span>
        <span id="hidden-family_antecedents">{{$donor2['donor']->family_antecedents}}</span>
        <span id="hidden-medical_antecedents">{{$donor2['donor']->medical_antecedents}}</span>
        <span id="hidden-donor_id">{{$donor1['donor']->id}}</span>
        
    </div>
    @endif
    @endif
</div>
<script src="/js/swipe.js"></script>
@endsection


    
    
   