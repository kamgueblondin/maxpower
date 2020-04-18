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
		<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
			<div class="container-fluid">
				<div class="header-body">
					<!-- Card stats -->
					<div class="row">
						@can('voir-administration')
							<div class="col-xl-3 col-lg-6 pt-3">
								<div class="card card-stats mb-4 mb-xl-0">
									<a href="{{route('dashboard')}}">
									<div class="card-body">
										<div class="row">
											<div class="col">
												<h5 class="card-title text-uppercase text-muted mb-0">Tableau de bord</h5>
												<span class="h2 font-weight-bold mb-0">Aller</span>
											</div>
											<div class="col-auto">
												<div class="icon icon-shape bg-danger text-white rounded-circle shadow">
													<i class="fas fa-home"></i>
												</div>
											</div>
										</div>
										<p class="mt-3 mb-0 text-muted text-sm">
											<span class="text-success mr-2"><i class="fa fa-arrow-up"></i> Accès: </span>
											<span class="text-nowrap"> Conditionné </span>
										</p>
									</div>
									</a>
								</div>
							</div>
							@endcan
							<div class="col-xl-3 col-lg-6 pt-3">
								<div class="card card-stats mb-4 mb-xl-0">
									<a href="{{route('message.index')}}">
									<div class="card-body">
										<div class="row">
											<div class="col">
												<h5 class="card-title text-uppercase text-muted mb-0">Méssagerie</h5>
												<span class="h2 font-weight-bold mb-0">{{Auth::user()->messages->where('vu','=',0)->count()}} méssage(s)</span>
											</div>
											<div class="col-auto">
												<div class="icon icon-shape bg-green text-white rounded-circle shadow">
													<i class="fas fa-envelope"></i>
												</div>
											</div>
										</div>
										<p class="mt-3 mb-0 text-muted text-sm">
											<span class="text-success mr-2"><i class="fa fa-arrow-up"></i> Accès: </span>
											<span class="text-nowrap"> libre </span>
										</p>
									</div>
									</a>
								</div>
							</div>
						@foreach(auth()->user()->magasins as $m)
						<div class="col-xl-3 col-lg-6 pt-3">
							<div class="card card-stats mb-4 mb-xl-0">
								<a href="{{route('users.magasins',$m->id,csrf_token())}}">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<h5 class="card-title text-uppercase text-muted mb-0">{{$m->nom}}</h5>
											<span class="h3 font-weight-bold mb-0">{{$m->localisation}}</span>
										</div>
										<div class="col-auto">
											<div class="icon icon-shape bg-warning text-white rounded-circle shadow">
												<i class="fas fa-chart-pie"></i>
											</div>
										</div>
									</div>
									<p class="mt-3 mb-0 text-muted text-sm">
										<span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> Type:</span>
										<span class="text-nowrap"> Magasin</span>
									</p>
								</div>
								</a>
							</div>
						</div>
						@endforeach
						@foreach(auth()->user()->boutiques as $b)
						<div class="col-xl-3 col-lg-6 pt-3">
							<div class="card card-stats mb-4 mb-xl-0">
								<a href="{{route('users.shops',$b->id,csrf_token())}}">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<h5 class="card-title text-uppercase text-muted mb-0">{{$b->nom}}</h5>
											<span class="h3 font-weight-bold mb-0">{{$b->localisation}}</span>
										</div>
										<div class="col-auto">
											<div class="icon icon-shape bg-info text-white rounded-circle shadow">
												<i class="fas fa-lock"></i>
											</div>
										</div>
									</div>
									<p class="mt-3 mb-0 text-muted text-sm">
										<span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> Type: </span>
										<span class="text-nowrap">Boutique</span>
									</p>
								</div>
								</a>
							</div>
						</div>
						@endforeach
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

		<div class="container mt--10 pb-5" style="border-color: none;border-image: none;></div>
	</div>

            @include('layouts.footers.guest')

        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')
        
        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
    </body>
</html>
