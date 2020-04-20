@extends('layouts.app', ['title' => __('Produits')])

@section('content')
    @include('users.partials.header', ['title' => __('Produit')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Affichage du produit') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('produits.index') }}" class="btn btn-sm btn-primary">{{ __('Retours à la liste') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">


				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Référence:</strong>
							{{ $produit->reference }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Nom:</strong>
							{{ $produit->nom }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Description:</strong>
							{{ $produit->description }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Prix d'achat':</strong>
							{{ $produit->prix_achat }} FCFA
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Prix de vente:</strong>
							{{ $produit->prix }} FCFA
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Bénéfice pour le produit:</strong>
							{{ $produit->prix-$produit->prix_achat }} FCFA
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Catégorie:</strong>
							{{ $produit->categorie->nom }}
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
 @include('layouts.footers.auth')
    </div>
@endsection