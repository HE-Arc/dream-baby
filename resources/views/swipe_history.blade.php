
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
    <h3>Positive swipe history</h3>
    <div class="row">
        <div class="col-md-6 offset-md-4">
            <div class="jumbotron">
            @if(Auth::user()->user_type_id == 2) <!-- Seeker -->
            <div class="progress">
                <div data-toggle="tooltip" data-html="true" data-placement="top" title="{{$swipeCounter['positiveCount']}} positive swipes" class="progress-bar bg-success" role="progressbar" style="width: {{$swipeCounter['positiveCount']/$swipeCounter['total']*100}}%" aria-valuenow="{{$swipeCounter['positiveCount']}}" aria-valuemin="0" aria-valuemax="{{$swipeCounter['total']}}"></div>
                <div data-toggle="tooltip" data-html="true" data-placement="top" title="{{$swipeCounter['negativeCount']}} negatives swipes" class="progress-bar bg-danger" role="progressbar" style="width: {{$swipeCounter['negativeCount']/$swipeCounter['total']*100}}%" aria-valuenow="{{$swipeCounter['negativeCount']}}" aria-valuemin="0" aria-valuemax="{{$swipeCounter['total']}}"></div>
                <div  data-toggle="tooltip" data-html="true" data-placement="top" title="{{$swipeCounter['remainingCount']}} potential swipes remaining" class="progress-bar bg-secondary" role="progressbar" style="width: {{($swipeCounter['total']-$swipeCounter['positiveCount']-$swipeCounter['negativeCount'])/$swipeCounter['total']*100}}%" aria-valuenow="{{$swipeCounter['total']-$swipeCounter['positiveCount']-$swipeCounter['negativeCount']}}" aria-valuemin="0" aria-valuemax="{{$swipeCounter['total']}}"></div>
            </div>
            @endif
                @if (count($positiveSwipesArray) > 0)
                    <br/>
                    @foreach ($positiveSwipesArray as $item)
                        <a class="btn btn-link" href="/profil/{{$item['id']}}">{{$item['name']}}</a><br/>
                    @endforeach
                @else
                    @if(Auth::user()->user_type_id == 1)    <!-- Donor -->
                        <p>Still no seeker interested in your profil but it will not be longer</p>    
                    @elseif(Auth::user()->user_type_id == 2) <!-- Seeker -->
                        <p>Oh ! You haven't found any donors... You will find some soon!</p>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <br/>
    @if(Auth::user()->user_type_id == 2) <!-- Seeker -->
    <form method="POST" action="{{route('swipe.deletehistory')}}">
        @csrf
        @method('DELETE')
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-danger btn-block">
                    {{ __('Delete history') }}
                </button>
            </div>
        </div>
    </form>
    @endif
</div>
@endsection
