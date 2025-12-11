@extends('layouts.app', ['title' => __('Produits Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Modifier le produit')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Gestion des produits') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('produits.index') }}" class="btn btn-sm btn-primary">{{ __('Retours à la liste') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="post" action="{{ route('produits.update', $produit->id) }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('reference') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-reference">{{ __('reference') }}</label>
                                    <input type="text" name="reference" value="{{$produit->reference}}" id="input-reference" class="form-control form-control-alternative{{ $errors->has('reference') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer la reference') }}" value="{{ old('reference') }}" required autofocus>

                                    @if ($errors->has('reference'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('reference') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('nom') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-nom">{{ __('Nom') }}</label>
                                    <input type="text" name="nom" value="{{$produit->nom}}" id="input-nom" class="form-control form-control-alternative{{ $errors->has('nom') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le nom') }}" value="{{ old('nom') }}" required autofocus>

                                    @if ($errors->has('nom'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nom') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-description">{{ __('description') }}</label>
                                    <input type="text" name="description" value="{{$produit->description}}" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer la description') }}" value="{{ old('description') }}" required autofocus>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('prix_achat') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-prix_achat">{{ __('prix d\'achat') }}</label>
                                    <input type="number" min="0" value="{{$produit->prix_achat}}" name="prix_achat" id="input-prix_achat" class="form-control form-control-alternative{{ $errors->has('prix_achat') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le prix d\'achat') }}" value="{{ old('prix_achat') }}" required autofocus>

                                    @if ($errors->has('prix_achat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('prix_achat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('prix') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-prix">{{ __('prix de vente') }}</label>
                                    <input type="number" min="0" value="{{$produit->prix}}" name="prix" id="input-prix" class="form-control form-control-alternative{{ $errors->has('prix') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le prix de vente') }}" value="{{ old('prix') }}" required autofocus>

                                    @if ($errors->has('prix'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('prix') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('categorie_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-categorie">{{ __('Catégorie') }}</label>
                                    <select name="categorie_id" id="input-categorie" class="form-control form-control-alternative{{ $errors->has('categorie_id') ? ' is-invalid' : '' }}" value="{{ old('categorie_id') }}" required autofocus>
                                        <option value="{{$produit->categorie->id}}" selected="true">{{$produit->categorie->nom}}</option>
                                        @foreach($categories as $categorie)
                                            <option value="{{$categorie->id}}">{{$categorie->nom}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('categorie'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('categorie_id') }}</strong>
                                        </span>
                                    @endif
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