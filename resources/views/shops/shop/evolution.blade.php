<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ $shop->nom }} {{ $shop->localisation }} Evolution Stock.</title>
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
	<div class="header bg-primary bg-gradient-primary pb-7 pt-5 pt-md-8">
		<div class="container-fluid">
			<div class="header-body">
				<div class="row align-items-center py-4">
					<div class="col-lg-6 col-7">
						<h6 class="h2 text-white d-inline-block mb-0">Gestion</h6>
						<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
							<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
								<li class="breadcrumb-item"><a href=""><i class="fas fa-home"></i></a></li>
								<li class="breadcrumb-item"><a href="{{route('users.shops',$shop->id,csrf_token())}}">{{$shop->nom}}</a></li>
								<li class="breadcrumb-item">Evolution</li>
								<li class="breadcrumb-item  active" aria-current="page"><a href="{{route('stocks.shops',$shop->id,csrf_token())}}">{{$produit->reference}}</a></li>
							</ol>
						</nav>
					</div>
					<div class="col-lg-6 col-5 text-right">
						@can('shop-comptabilite')
							<a href="" class="btn btn-sm btn-neutral mt-1 d-xl-none" class="btn btn-primary" data-toggle="modal" data-target="#menu">plus</a>
							<div class="modal" id="menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">{{ $shop->nom }} {{ $shop->localisation }} Evolution</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
									</div>
								</div>
							</div>
						@endcan
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid mt--7">
		<div class="row">
			<div class="col">
				<div class="table-responsive card shadow">
					<div class="card-header border-0">
						<div class="row align-items-center">
							<div class="col-8">
								<h3 class="mb-0">{{ __("Definissez la periode d'exercice") }}</h3>
								<form action="" method="GET" class="form-inline row d-flex align-content-center justify-content-center">
									{{ csrf_field() }}
									<label for="debut" class="mx-3"> Date de debut
										<input type="hidden" name="produit" value="{{ $produit->id }}">
										<input type="hidden" name="shop" value="{{ $shop->id }}">
									<input type="date" class="form-control" value="{{ $start }}" id="debut" name="debut" placeholder="Date de debut">
									<label for="fin"  class="mx-3"> Date de fin </label>
									<input type="date" class="form-control" id="fin" value="{{ $stop }}" name="fin" placeholder="Date de fin">
									&nbsp &nbsp
									<button class="btn btn-primary" type="submit">Filtré</button>
								</form>
							</div>
							<div class="col-4 text-right">
								<a href="{{route('users.shops',$shop->id,csrf_token())}}" class="btn btn-sm btn-primary">{{ __('Retourner à l\'accueil') }}</a>
							</div>
						</div>
					</div>

					<div class="col-12">
						@if (session('status'))
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								{{ session('status') }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						@endif
					</div>


					@if ($message = Session::get('success'))
						<div class="alert alert-success">
							<p>{{ $message }}</p>
						</div>
					@endif

					<h1 align="center">Entrées</h1>
					<table class="table table-bordered bootstrap-datatable datatable bg-white" style="width:100%;"  id="datatable-buttons">
						<thead class="thead-light">
						<tr>
							<th>Numéro</th>
							<th>Nom </th>
							<th>Quantité</th>
							<td>Date</td>
						</tr>
						</thead>
						<tbody>
						@php $i=0; @endphp
						@foreach ($entrees as  $entree)
								<tr>
									<td>{{ ++$i }}</td>
									<td>{{ $entree->stock->produit->nom }}</td>
									<td>{{ $entree->quantite }}</td>
									<td>{{ $entree->created_at }}</td>
								</tr>
						@endforeach
						</tbody>
						<tfoot><tr><th colspan="2">total  :</th><td colspan="2"><b>{{ $entrees->sum('quantite') }}</b></td></tr></tfoot>
					</table>

					<h1 align="center">Sortie Vers Boutique</h1>
					<table class="table table-bordered bootstrap-datatable datatable bg-white" style="width:100%;"  id="datatable-buttons">
						<thead class="thead-light">
						<tr>
							<th>Numéro</th>
							<th>Nom </th>
							<th>Destination</th>
							<th>Quantité</th>
							<td>Date</td>
						</tr>
						</thead>
						<tbody>
						@php $i=0; @endphp
						@foreach ($sortieBoutiques as  $sortie)
								<tr>
									<td>{{ ++$i }}</td>
									<td>{{ $sortie->stock->produit->nom }}</td>
									<td>{{ $sortie->autherBoutique->nom }}</td>
									<td>{{ $sortie->quantite }}</td>
									<td>{{ $sortie->created_at }}</td>
								</tr>
						@endforeach
						</tbody>
						<tfoot><tr><th colspan="3">total  :</th><td colspan="2"><b>{{ $sortieBoutiques->sum('quantite') }}</b></td></tr></tfoot>
					</table>

					<h1 align="center">Sortie vers shop</h1>
					<table class="table table-bordered bootstrap-datatable datatable bg-white" style="width:100%;"  id="datatable-buttons">
						<thead class="thead-light">
						<tr>
							<th>Numéro</th>
							<th>Nom</th>
							<th>Destination</th>
							<th>Quantité</th>
							<td>Date</td>
						</tr>
						</thead>
						<tbody>
						@php $i=0; @endphp
						@foreach ($sortieshops as  $sortie)
								<tr>
									<td>{{ ++$i }}</td>
									<td>{{ $sortie->stock->produit->nom }}</td>
									<td>{{ $sortie->shop->nom }}</td>
									<td>{{ $sortie->quantite }}</td>
									<td>{{ $sortie->created_at }}</td>
								</tr>
						@endforeach
						</tbody>
						<tfoot><tr><th colspan="3">total  :</th><td colspan="2"><b>{{ $sortieshops->sum('quantite') }}</b></td></tr></tfoot>
					</table>

				</div>
				<div class="container mt--10 pb-5"></div>
			</div>
		</div>
	</div>

	@guest()
		@include('layouts.footers.guest')
	@endguest
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('js/js.cookie.js') }}"></script>
	<script src="{{ asset('js/jquery.scrollbar.min.js') }}"></script>
	<script src="{{ asset('js/jquery-scrollLock.min.js') }}"></script>
	<!-- Optional JS -->
	<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('js/buttons.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('js/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('js/buttons.flash.min.js') }}"></script>
	<script src="{{ asset('js/buttons.print.min.js') }}"></script>
	<script src="{{ asset('js/dataTables.select.min.js') }}"></script>
	<!-- Argon JS -->
	<script src="{{ asset('js/argon.min.js?v=1.1.0') }}"></script>
</body>
</html>