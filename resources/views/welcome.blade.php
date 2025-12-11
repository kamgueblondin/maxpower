<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Max power') }}</title>
        <meta name="description" content="Plateforme de gestion Max Power: inventaires, stocks, ventes, historiques pour boutiques et magasins.">
        <meta name="keywords" content="Max Power, inventaire, stocks, ventes, magasins, boutiques, gestion commerciale">
        <meta name="author" content="{{ config('app.name', 'Max power') }}">
        <meta name="robots" content="index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1">
        <meta name="referrer" content="strict-origin-when-cross-origin">
        <link rel="canonical" href="{{ url('/') }}">

        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ config('app.name', 'Max power') }}">
        <meta property="og:description" content="Plateforme de gestion Max Power: inventaires, stocks, ventes, historiques pour boutiques et magasins.">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:site_name" content="{{ config('app.name', 'Max power') }}">
        <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">
        <meta property="og:image" content="{{ asset('argon/img/brand/favicon.png') }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ config('app.name', 'Max power') }}">
        <meta name="twitter:description" content="Plateforme de gestion Max Power: inventaires, stocks, ventes, historiques pour boutiques et magasins.">
        <meta name="twitter:image" content="{{ asset('argon/img/brand/favicon.png') }}">
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">

        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "name": "{{ config('app.name', 'Max power') }}",
          "url": "{{ url('/') }}",
          "logo": "{{ asset('argon/img/brand/favicon.png') }}"
        }
        </script>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "WebSite",
          "name": "{{ config('app.name', 'Max power') }}",
          "url": "{{ url('/') }}"
        }
        </script>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Store",
          "name": "{{ config('app.name', 'Max power') }}",
          "url": "{{ url('/') }}",
          "description": "Plateforme de gestion commerciale pour boutiques et magasins (inventaires, stocks, ventes, historiques).",
          "logo": "{{ asset('argon/img/brand/favicon.png') }}",
          "brand": {
            "@type": "Brand",
            "name": "Max Power"
          }
        }
        </script>
		</head>
		<body class="bg-default">
			@auth()
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
				
			@endauth
			
			<div class="main-content">
				@include('layouts.navbars.navbare')
		<div class="header bg-gradient-primary py-7 py-lg-8">
			<div class="container">
				<div class="header-body text-center mt-7 mb-7">
					<div class="row justify-content-center">
						<div class="col-lg-5 col-md-6">
							<h1 class="text-white">{{ __('Bienvenue chez Max Power:') }} <br/>{{ __('La marque qui rassure.') }}</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="separator separator-bottom separator-skew zindex-100">
				<svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
					<polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
				</svg>
			</div>
		</div>

		<div class="container mt--5 pb--1" style="border-color: none;border-image: none;"></div>
	</div>

 
            @include('layouts.footers.guest')

        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')
        
        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
    </body>
</html>
