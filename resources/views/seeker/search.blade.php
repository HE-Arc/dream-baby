@extends('layouts.app')
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/css/swiper.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<link rel="stylesheet" href="/css/swipe.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/js/swiper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

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
    <h1>You have already swiped all the available donors based on your criterions on this website ! Congratulations !</h1>
    @else
    <h1><span id="username">{{$donorsArray[0]['username']}}</span></h1>

    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide" id="swipe-div-no"></div>
            <div class="swiper-slide"><img id="photo" class="img-fluid" src="{{route('donor.image', ['filename' => $donorsArray[0]['donor']->photo_uri])}}"/><br/></div>
            <div class="swiper-slide" id="swipe-div-yes"></div>
        </div>
    </div>

    <div id="center-wrapper" class="row">
        <div id="swipe-profil">
            <button id="swipe-no">No</button><button id="swipe-yes">Yes</button>
            <h2><strong>Sex: </strong><span id="sex">{{$donorsArray[0]['donor']->sex == 0 ? 'Male' : 'Female'}}</span></h2>
            <h2><strong>Birth Date: </strong><span id="birthdate">{{date("d F Y" ,strtotime($donorsArray[0]['donor']->birth_date))}}</span></h2>
            <h2><strong>Age: </strong><span id="age">{{ floor((time() - strtotime($donorsArray[0]['donor']->birth_date)) / 31556926) }}</span></h2>
            <h3><strong>Eye color: </strong><span id="eyecolor">{{$donorsArray[0]['eyecolor']}}</span></h3>
            <h3><strong>Hair color: </strong><span id="haircolor">{{$donorsArray[0]['haircolor']}}</span></h3>
            <h3><strong>Ethnicity: </strong><span id="ethnicity">{{$donorsArray[0]['ethnicity']}}</span></h3>
            <h3><strong>Family antecedents: </strong><span id="family_antecedents">{{$donorsArray[0]['donor']->family_antecedents}}</span></h3>
            <h3><strong>Medical antecedents: </strong><span id="medical_antecedents">{{$donorsArray[0]['donor']->medical_antecedents}}</span></h3>
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
            <span class="hidden-age">{{ floor((time() - strtotime($donorsArray[0]['donor']->birth_date)) / 31556926) }}</span>
            <span class="hidden-birthdate">{{date("d F Y" ,strtotime($donorsArray[0]['donor']->birth_date))}}</span>
        </div>
        @endfor
    </div>
    @endif
</div>
<script src="/js/swipe.js"></script>
@endsection
