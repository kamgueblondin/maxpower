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
    @include('users.partials.header', ['title' => __('Charges')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Modification de la charge') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('jours.boutiques.charges',$charge->boutique_jour_id) }}" class="btn btn-sm btn-primary">{{ __('Retours à l\'accueil') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                     <form method="post" action="{{ route('boutique-charges.update', $charge->id) }}" autocomplete="off">
                            @csrf
                            @method('PATCH')
                            <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-description">{{ __('description') }}</label>
                                    <input type="text" name="description" value="{{ $charge->description }}" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer la description') }}" value="{{ old('description') }}" required autofocus>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('montant') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-montant">{{ __('montant') }}</label>
                                    <input type="number" min="0" value="{{ $charge->montant }}" name="montant" id="input-montant" class="form-control form-control-alternative{{ $errors->has('montant') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le montant') }}" value="{{ old('montant') }}" required autofocus>

                                    @if ($errors->has('montant'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('montant') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Envoyer') }}</button>
                                </div>
                            </div>
                        </form>
                   
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