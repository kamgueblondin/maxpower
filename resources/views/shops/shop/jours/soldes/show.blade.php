<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Max power') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
		</head>
		<body class="bg-default">
			@auth()
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
				
			@endauth
			
			<div class="main-content">
				@include('layouts.navbars.mynavbar')
    @include('users.partials.header', ['title' => __('Soldes')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Affichage de la vente en solde') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('jours.boutiques.soldes',$sortie->boutique_jour_id) }}" class="btn btn-sm btn-primary">{{ __('Retours à la liste') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">


				<div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Facture :</strong>
                            {{ $sortie->facture->nom }}
                        </div>
                    </div>

					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Auteur de la sortie:</strong>
							{{ $sortie->user->name }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Produit concerné:</strong>
							{{ $sortie->stock->produit->nom }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Référence du produit:</strong>
							{{ $sortie->stock->produit->reference }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Catégorie du produit:</strong>
							{{ $sortie->stock->produit->categorie->nom }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Quantité vendue:</strong>
							{{ $sortie->quantite }}
						</div>
					</div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Prix de vente de l'entreprise:</strong>
                            {{ $sortie->stock->produit->prix }} fcfa
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Prix de vente au client:</strong>
                            {{ $sortie->prix }} fcfa
                        </div>
                    </div>

					<div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Sous total:</strong>
                            {{ $sortie->prix * $sortie->quantite }} fcfa
                        </div>
                    </div>

					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Date des sorties:</strong>
							{{ $sortie->created_at->format('d/m/Y H:i') }}
						</div>
					</div>
				</div>
	
                   </div>
            <div class="container mt--10 pb-5"></div>
	    </div>
    </div>
</div>

        @guest()
            @include('layouts.footers.guest')
        @endguest
        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')
        
        <!-- Argon JS && @include('layouts.footers.auth')-->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
    </body>
</html>