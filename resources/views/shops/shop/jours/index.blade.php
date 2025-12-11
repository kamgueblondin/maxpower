<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $boutique->nom }} {{ $boutique->localisation }} {{ $jour->description }} Liste des tâches de la journée {{ $jour->description }}</title>
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
	                <li class="breadcrumb-item"><a href="{{route('users.shops',$boutique->id,csrf_token())}}">{{$boutique->nom}}</a></li>
	                <li class="breadcrumb-item"><a href="">{{$jour->description}}</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Accueil</li>
	            </ol>
	        </nav>
	    </div>
	        <div class="col-lg-6 col-5 text-right">
	        	@can('vente-boutique-list')
	            <a href="{{ route('jours.boutiques.ventes',$jour->id) }}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Ventes</a>
	            @endcan
	            @can('solde-boutique-list')
	            <a href="{{ route('jours.boutiques.soldes',$jour->id) }}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Soldes</a>
	            @endcan
			    @can('boutique-magasin-sortie-list')
	            <a href="{{route('jours.boutiques.magasins.sorties',$jour->id)}}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Sorties vers magasins</a>
	            @endcan
			    @can('charge-boutique-list')
	            <a href="{{ route('jours.boutiques.charges',$jour->id) }}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Charges</a>
	            @endcan
			    @can('tontine-boutique-list')
	            <a href="{{ route('jours.boutiques.tontines',$jour->id) }}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Tontines</a>
	           	@endcan
			    @can('versement-boutique-list')
	            <a href="{{ route('jours.boutiques.versements',$jour->id) }}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Versements</a>
	            @endcan
			    @can('dette-boutique-list')
	            <a href="{{ route('jours.boutiques.dettes',$jour->id) }}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Dêttes</a>
	            @endcan
	            <a href="" class="btn btn-sm btn-neutral mt-1 d-xl-none" class="btn btn-primary" data-toggle="modal" data-target="#menu">plus</a>
	            <div class="modal" id="menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Ménu</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body text-center">
				        <ul class="list-group text-center">
				         <li class="list-group-item">
						  	@can('vente-boutique-list')
				            <a href="{{ route('jours.boutiques.ventes',$jour->id) }}" class="btn btn-sm btn-neutral mt-1">Ventes</a>
				            @endcan
				         </li>
				         <li class="list-group-item">
						  	@can('solde-boutique-list')
				            <a href="{{ route('jours.boutiques.soldes',$jour->id) }}" class="btn btn-sm btn-neutral mt-1">Soldes</a>
				            @endcan
				         </li>
				         <li class="list-group-item">
						    @can('boutique-magasin-sortie-list')
				            <a href="{{route('jours.boutiques.magasins.sorties',$jour->id)}}" class="btn btn-sm btn-neutral mt-1">Sorties vers magasins</a>
				            @endcan
				         </li>
				         <li class="list-group-item">
						    @can('charge-boutique-list')
				            <a href="{{ route('jours.boutiques.charges',$jour->id) }}" class="btn btn-sm btn-neutral mt-1">Charges</a>
				            @endcan
				         </li>
				         <li class="list-group-item">
						    @can('tontine-boutique-list')
				            <a href="{{ route('jours.boutiques.tontines',$jour->id) }}" class="btn btn-sm btn-neutral mt-1">Tontines</a>
				           	@endcan
				         </li>
				         <li class="list-group-item">
						    @can('versement-boutique-list')
				            <a href="{{ route('jours.boutiques.versements',$jour->id) }}" class="btn btn-sm btn-neutral mt-1">Versements</a>
				            @endcan
				         </li>
				         <li class="list-group-item">
						    @can('dette-boutique-list')
				            <a href="{{ route('jours.boutiques.dettes',$jour->id) }}" class="btn btn-sm btn-neutral mt-1">Dêttes</a>
				            @endcan
				         </li>
						</ul>
				      </div>
				    </div>
				  </div>
				</div>
	        </div>
	    </div> 
	    </div>
	    </div>
	</div>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
               <div class="card table-responsive shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
	                            <div class="col-6">
	                                <h3 class="mb-0">{{ __('Historique du jours') }}</h3>
	                            </div>
	                            @can('boutique-jour-create')
								<div class="col-6 text-right">
	                            @if($jour->actif==true)
	                            @can('boutique-jour-close')
	                                <a href="{{ route('jours.actionc',$jour->id) }}" class="btn btn-sm btn-primary mt-1" onclick="return confirm('Etes vous sure de vouloir Boucler la journée ?')">{{ __('Boucler la journée') }}</a>
	                            @endcan
	                            @else
	                            	@can('boutique-comptabilite')
	                                <a href="{{ route('journal.shops.print',$jour->id) }}" class="btn btn-sm btn-primary mt-1">{{ __('Imprimer le journal') }}</a>
	                                @endcan
	                            @can('boutique-jour-open')
	                                <a href="{{ route('jours.actiono',$jour->id) }}" class="btn btn-sm btn-primary mt-1" onclick="return confirm('Etes vous sure de vouloir Déblocker la journée ?')">{{ __('Déblocker la journée') }}</a>
	                            @endcan
	                            @endif
									<a href="{{route('users.shops',$boutique->id,csrf_token())}}" class="btn btn-sm btn-primary mt-1">Retours aux journées</a>
								</div>
	                            @endcan
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


					<table class="table table-bordered bootstrap-datatable datatable bg-white" id="datatable-buttons" style="width:100%;">
						<thead class="thead-light">
					  <tr>
						 <th>Numéro</th>
						 <th>Action</th>
						 <th>Auteur</th>
						 <th>Description</th>
						 <th>Date</th>
					  </tr>
					  </thead>
		                <tbody>
					    @php $i=0; @endphp
						@foreach ($jour->historiques as $key => $jour)
						<tr>
							<td>{{ ++$i }}</td>
							<td>{{ $jour->entite }}</td>
							<td>{{ $jour->user->name }}</td>
							<td>{{ $jour->description }}</td>
							<td>{{ $jour->created_at->format('d/m/Y H:i') }}</td>
						</tr>
						@endforeach
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