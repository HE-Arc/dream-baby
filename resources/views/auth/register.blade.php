@extends('layouts.app')
@section('content')
<script src="js/register.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

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
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('I am...') }}</label>

                            <div class="col-md-6">
                                <div class="form-check-inline">
                                    <input class="form-check-input" onclick="showDonorForm();" id="user_type_donor" type="radio" name="user_type" value="donor" required>
                                    <label for="user_type_donor" class="form-check-label" required>... a donor</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input" onclick="hideDonorForm();"  id="user_type_seeker" type="radio" name="user_type" value="seeker" required>
                                    <label for="user_type_seeker" class="form-check-label" required>... a seeker</label>
                                </div>
                            </div>
                        </div>
                        <div id="donorInfo" style="display:none;">
                          <div class="form-group row">
                              <label class="col-md-4 col-form-label text-md-right">Sex:</label>

                              <div class="col-md-6">
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" id="femaleSex" value="0" name="sex">
                                        <label for="femaleSex"class="form-check-label">Female </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" id="maleSex" value="1" name="sex">
                                        <label for="maleSex" class="form-check-label">Male </label>
                                    </div>
                                </div>
                          </div>

                        <div class="form-group row">
                              <label class="col-md-4 col-form-label text-md-right">Birth Date:</label>

                              <div class="col-md-6">
                                  <input class="form-control" type="date" id="birth_date" name="birth_date" required>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-4 col-form-label text-md-right">Eye color:</label>

                              <div class="col-md-6">
                                  <select class="form-control" id="eye_color" name="eye_color" required>
                                    @foreach ($eye_colors as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                  </select>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-4 col-form-label text-md-right">Ethnicity:</label>

                              <div class="col-md-6">
                                <select class="form-control" id="ethnicity" name="ethnicity" required>
                                  @foreach ($ethnicities as $item)
                                      <option value="{{$item->id}}">{{$item->name}}</option>
                                  @endforeach
                                </select>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-4 col-form-label text-md-right">Hair color:</label>

                              <div class="col-md-6">
                                <select class="form-control" id="hair_color" name="hair_color" required>
                                  @foreach ($hair_colors as $item)
                                      <option value="{{$item->id}}">{{$item->name}}</option>
                                  @endforeach
                                </select>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-4 col-form-label text-md-right">Medical antecedents:</label>

                              <div class="col-md-6">
                                <textarea class="form-control" id="medical_antecedents" name="medical_antecedents" required></textarea>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-4 col-form-label text-md-right">Familial antecedents:</label>

                              <div class="col-md-6">
                                <textarea class="form-control" id="family_antecedents" name="family_antecedents" required></textarea>
                              </div>
                          </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
