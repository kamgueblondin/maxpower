@extends('layouts.app', ['title' => __('Boutique')])

@section('content')
    @include('users.partials.header', ['title' => __('boutique')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Modification de la boutique') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('shops.index') }}" class="btn btn-sm btn-primary">{{ __('Retours à la liste') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    <form method="post" action="{{ route('shop.update.logo', $shop->id) }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                    <div class="form-group{{ $errors->has('logo') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-logo">{{ __('logo') }}</label>
                        <input type="file" name="logo" value="{{ $shop->logo }}" id="input-logo" class="form-control form-control-alternative{{ $errors->has('logo') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le logo') }}" value="{{ old('logo') }}" required="true" autofocus>

                        @if ($errors->has('logo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('logo') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="text-center">
                            <button type="submit" class="btn btn-success mt-4">{{ __('Envoyer') }}</button>
                        </div>
                    </div>
                    </form>
                    <hr>
					<form method="post" action="{{ route('shops.update', $shop->id) }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
							<div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('nom') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-nom">{{ __('Nom') }}</label>
                                    <input type="text" name="nom" id="input-nom" class="form-control form-control-alternative{{ $errors->has('nom') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le nom') }}" value="{{ $shop->nom }}" value="{{ old('nom') }}" required autofocus>

                                    @if ($errors->has('nom'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nom') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('localisation') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-localisation">{{ __('localisation') }}</label>
                                    <input type="text" name="localisation" id="input-localisation" class="form-control form-control-alternative{{ $errors->has('localisation') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer la localisation') }}" value="{{ $shop->localisation }}" value="{{ old('localisation') }}" required autofocus>

                                    @if ($errors->has('localisation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('localisation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                 <div class="form-group{{ $errors->has('slogan') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-slogan">{{ __('slogan') }}</label>
                                    <input type="text" name="slogan" value="{{ $shop->slogan }}" id="input-slogan" class="form-control form-control-alternative{{ $errors->has('slogan') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le slogan') }}" value="{{ old('slogan') }}"  autofocus>

                                    @if ($errors->has('slogan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('slogan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('adresse') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-adresse">{{ __('adrèsse') }}</label>
                                    <input type="text" name="adresse" id="input-adresse" class="form-control form-control-alternative{{ $errors->has('adresse') ? ' is-invalid' : '' }}" value="{{ $shop->adresse }}" placeholder="{{ __('Entrer l\'adresse') }}" value="{{ old('adresse') }}"  autofocus>

                                    @if ($errors->has('adresse'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('adresse') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('telephone_1') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-telephone_1">{{ __('téléphone 1') }}</label>
                                    <input type="text" name="telephone_1" value="{{ $shop->telephone_1 }}" id="input-telephone_1" class="form-control form-control-alternative{{ $errors->has('telephone_1') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le numero de telephone 1') }}" value="{{ old('telephone_1') }}" autofocus>

                                    @if ($errors->has('telephone_1'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('telephone_1') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('telephone_2') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-telephone_2">{{ __('téléphone 2') }}</label>
                                    <input type="text" name="telephone_2" value="{{ $shop->telephone_2 }}" id="input-telephone_2" class="form-control form-control-alternative{{ $errors->has('telephone_2') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le numero de telephone 2') }}" value="{{ old('telephone_2') }}" autofocus>

                                    @if ($errors->has('telephone_2'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('telephone_2') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('email') }}</label>
                                    <input type="text" name="email" value="{{ $shop->email }}" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer l\'email') }}" value="{{ old('email') }}"  autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('numero_rc') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-numero_rc">{{ __('numero registre de commerce') }}</label>
                                    <input type="text" value="{{ $shop->numero_rc }}" name="numero_rc" id="input-numero_rc" class="form-control form-control-alternative{{ $errors->has('numero_rc') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le numero du registre de commerce') }}" value="{{ old('numero_rc') }}" autofocus>

                                    @if ($errors->has('numero_rc'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('numero_rc') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Utilisateurs:</strong>
                                        <br/><br/>
                                        @foreach($users as $value)
                                        <div class="custom-control custom-checkbox mb-3">
                                          <input class="custom-control-input" @foreach($shop->users as $v) @if($v->id==$value->id) checked @endif @endforeach name="utilisateurs[]" value="{{$value->id}}" id="customCheck1{{$value->id}}" type="checkbox">
                                          <label class="custom-control-label" for="customCheck1{{$value->id}}">{{ $value->name }}</label>
                                        </div>
                                        <br/>
                                        @endforeach
                                    </div>
                                </div>
                        
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Envoyer') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
 @include('layouts.footers.auth')
    </div>
@endsection