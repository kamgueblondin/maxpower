@extends('layouts.app', ['title' => __('Magasins')])

@section('content')
    @include('users.partials.header', ['title' => __('Magasin')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Modification du magasin') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('magasins.index') }}" class="btn btn-sm btn-primary">{{ __('Retours à la liste') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
					 <form method="post" action="{{ route('magasins.update', $magasin->id) }}" autocomplete="off">
                            @csrf
                            @method('PATCH')
							<div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('nom') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-nom">{{ __('Nom') }}</label>
                                    <input type="text" name="nom" id="input-nom" class="form-control form-control-alternative{{ $errors->has('nom') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le nom') }}" value="{{ $magasin->nom }}" value="{{ old('nom') }}" required autofocus>

                                    @if ($errors->has('nom'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nom') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('localisation') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-localisation">{{ __('localisation') }}</label>
                                    <input type="text" name="localisation" id="input-localisation" class="form-control form-control-alternative{{ $errors->has('localisation') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer la localisation') }}" value="{{ $magasin->localisation }}" value="{{ old('localisation') }}" required autofocus>

                                    @if ($errors->has('localisation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('localisation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                 <div class="form-group{{ $errors->has('slogan') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-slogan">{{ __('slogan') }}</label>
                                    <input type="text" name="slogan"  value="{{ $magasin->slogan }}" id="input-slogan" class="form-control form-control-alternative{{ $errors->has('slogan') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le slogan') }}" value="{{ old('slogan') }}" autofocus>

                                    @if ($errors->has('slogan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('slogan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('adresse') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-adresse">{{ __('adrèsse') }}</label>
                                    <input type="text" name="adresse" id="input-adresse" class="form-control form-control-alternative{{ $errors->has('adresse') ? ' is-invalid' : '' }}" value="{{ $magasin->adresse }}" placeholder="{{ __('Entrer l\'adresse') }}" value="{{ old('adresse') }}"  autofocus>

                                    @if ($errors->has('adresse'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('adresse') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Utilisateurs:</strong>
                                        <br/><br/>
                                        @foreach($users as $value)
                                        <div class="custom-control custom-checkbox mb-3">
                                          <input class="custom-control-input" @foreach($magasin->users as $v) @if($v->id==$value->id) checked @endif @endforeach name="utilisateurs[]" value="{{$value->id}}" id="customCheck1{{$value->id}}" type="checkbox">
                                          <label class="custom-control-label" for="customCheck1{{$value->id}}">{{ $value->name }}</label>
                                        </div>
                                        <br/>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Magasins:</strong>
                                        <br/><br/>
                                        @foreach($magasins as $v)
                                        @if ($v->id!=$magasin->id)
                                        <div class="custom-control custom-checkbox mb-3">
                                          <input class="custom-control-input"  @foreach($magasin->magasins as $val) @if($v->id==$val->id) checked @endif @endforeach name="magasins[]" value="{{$v->id}}" id="customCheck2{{$v->id}}" type="checkbox">
                                          <label class="custom-control-label" for="customCheck2{{$v->id}}">{{ $v->nom }} {{ $v->localisation }}</label>
                                        </div>
                                        <br/>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Boutiques:</strong>
                                        <br/><br/>
                                        @foreach($shops as $v)
                                        <div class="custom-control custom-checkbox mb-3">
                                          <input class="custom-control-input"  @foreach($magasin->boutiques as $val) @if($v->id==$val->id) checked @endif @endforeach name="boutiques[]" value="{{$v->id}}" id="customCheck3{{$v->id}}" type="checkbox">
                                          <label class="custom-control-label" for="customCheck3{{$v->id}}">{{ $v->nom }} {{ $v->localisation }}</label>
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
        </div>
        
 @include('layouts.footers.auth')
    </div>
@endsection