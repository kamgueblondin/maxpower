<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $magasin->nom }} {{ $magasin->localisation }} Stocks.</title>
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
	                <li class="breadcrumb-item"><a href="{{route('users.magasins',$magasin->id,csrf_token())}}">{{$magasin->nom}}</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Stocks</li>
	            </ol>
	        </nav>
	    </div>
	    <div class="col-lg-6 col-5 text-right">
	    	@can('magasin-comptabilite')
	            <a href="{{ route('stocks.magasins.print',$magasin->id) }}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Imprimer</a>
	            <a href="{{ route('inventaire.magasins',$magasin->id) }}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Inventaire</a>
	            <a href="" class="btn btn-sm btn-neutral mt-1 d-xl-none" class="btn btn-primary" data-toggle="modal" data-target="#menu">plus</a>
	            <div class="modal" id="menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">{{ $magasin->nom }} {{ $magasin->localisation }} Stocks</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body text-center">
				        <ul class="list-group text-center">
				        <li class="list-group-item">
				        <a href="{{ route('stocks.magasins.print',$magasin->id) }}" class="btn btn-sm btn-neutral mt-1">Imprimer</a>
				        </li>
				        <li class="list-group-item">
				        <a href="{{ route('inventaire.magasins',$magasin->id) }}" class="btn btn-sm btn-neutral mt-1">Inventaire</a>
				        </li>
						</ul>
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
                                <h3 class="mb-0">{{ __('Stocks') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route('users.magasins',$magasin->id,csrf_token())}}" class="btn btn-sm btn-primary">{{ __('Retourner à l\'accueil') }}</a>
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


					<table class="table table-bordered bootstrap-datatable datatable bg-white" style="width:100%;"  id="datatable-buttons">
						<thead class="thead-light">
						  <tr>
							 <th>Numéro</th>
							 <th>Référence</th>
							 <th>Nom</th>
							 <th>Catégorie</th>
							 <th>Stocks initial</th>
							 <th>Stocks réel</th>
							 @can('magasin-comptabilite')<th>Prix d'achat</th>
							 <th>Prix de vente</th>
							 <th>Vendus</th>
							 <th>Bénéfice</th>
						 	 <th>S.I * P.A</th>
						 	 <th>S.R * P.A</th>
						  	 <th>S.I * P.V</th>
						 	 <th>S.R * P.V</th>@endcan
						  </tr>
						  </thead>
		                <tbody>
					    @php $i=0; $spvI=0;$spvR=0;$spaI=0;$spaR=0;$tb=0;$sV=0;$tpv=0;$tpc=0;$ti=0;$tr=0; 
					    @endphp
						@foreach ($magasin->stocks as $key => $stock)
						@php $spvI+=$stock->valeur*$stock->produit->prix;
						$spvR+=$stock->initial*$stock->produit->prix;
						$spaI+=$stock->valeur*$stock->produit->prix_achat;
						$spaR+=$stock->initial*$stock->produit->prix_achat;
						$tb+=($stock->initial-$stock->valeur) * ($stock->produit->prix-$stock->produit->prix_achat);
						$sV+=$stock->initial-$stock->valeur;
						$tpv+=$stock->produit->prix;
						$tpc+=$stock->produit->prix_achat;
						$ti+=$stock->valeur;
						$tr+=$stock->initial;
						@endphp
						@if( $stock->valeur>(20*$stock->initial)/100 )
						<tr>
							<td>{{ ++$i }}</td>
							<td>{{ $stock->produit->reference }}</td>
							<td>{{ $stock->produit->nom }}</td>
							<td>{{ $stock->produit->categorie->nom }}</td>
							<td>{{ $stock->initial }}</td>
							<td>{{ $stock->valeur }}</td>
							@can('boutique-comptabilite')<td>{{ $stock->produit->prix_achat }} FCFA</td>
							<td>{{ $stock->produit->prix }} FCFA</td>
							<td>{{ $stock->initial-$stock->valeur }}</td>
							<td>{{ ($stock->initial-$stock->valeur) * ($stock->produit->prix-$stock->produit->prix_achat)}}</td>
							<td>{{ $stock->initial*$stock->produit->prix_achat }}</td>
							<td>{{ $stock->valeur*$stock->produit->prix_achat }}</td>
							<td>{{ $stock->initial*$stock->produit->prix }}</td>
							<td>{{ $stock->valeur*$stock->produit->prix }}</td>@endcan
						</tr>
						@else
						<tr class="text-red">
							<td>{{ ++$i }}</td>
							<td>{{ $stock->produit->reference }}</td>
							<td>{{ $stock->produit->nom }}</td>
							<td>{{ $stock->produit->categorie->nom }}</td>
							<td>{{ $stock->initial }}</td>
							<td>{{ $stock->valeur }}</td>
							@can('boutique-comptabilite')<td>{{ $stock->produit->prix_achat }} FCFA</td>
							<td>{{ $stock->produit->prix }} FCFA</td>
						 	<td>{{ $stock->initial-$stock->valeur }}</td>
						 	<td>{{ ($stock->initial-$stock->valeur) * ($stock->produit->prix-$stock->produit->prix_achat)}}</td>
						 	<td>{{ $stock->initial*$stock->produit->prix_achat }}</td>
							<td>{{ $stock->valeur*$stock->produit->prix_achat }}</td>
							<td>{{ $stock->initial*$stock->produit->prix }}</td>
							<td>{{ $stock->valeur*$stock->produit->prix }}</td>@endcan
						</tr>
						@endif
						@endforeach
						<tr>
							<td>{{ ++$i }}</td>
							<td></td>
							<td></td>
							<td>Total</td>
							<td>{{ $tr }}</td>
							<td>{{ $ti }}</td>
							@can('boutique-comptabilite')<td>{{ $tpc }} FCFA</td>
							<td>{{ $tpv }} FCFA</td>
						 	<td>{{ $sV }}</td>
						 	<td>{{ ($tb)}}</td>
						 	<td>{{ $spaR }}</td>
							<td>{{ $spaI }}</td>
							<td>{{ $spvR }}</td>
							<td>{{ $spvI }}</td>@endcan
						</tr>
					</tbody>
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