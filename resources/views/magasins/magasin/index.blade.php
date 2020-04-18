<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $magasin->nom }} {{ $magasin->localisation }} Journées.</title>
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
	                <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
	                <li class="breadcrumb-item"><a href="{{route('users.magasins',$magasin->id)}}">{{$magasin->nom}}</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Accueil</li>
	            </ol>
	        </nav>
	        @can('magasin-historiques-list')
	        <a href="{{ route('historiques.magasins',$magasin->id) }}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Historiques</a>
	        @endcan
	    </div>
	        <div class="col-lg-6 col-5 text-right">
	        	@can('magasin-entree-list')
	            <a href="{{ route('entrees.magasins',$magasin->id) }}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Entrées</a>
	            @endcan
	            @can('magasin-boutique-sortie-list')
	            <a href="{{ route('sortie-boutique.magasins',$magasin->id) }}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Sorties vers Boutiques</a>
	            @endcan
	            @can('magasin-magasin-sortie-list')
	            <a href="{{route('sortie-magasin.magasins',$magasin->id)}}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Sorties vers Magasins</a>
	            @endcan
	            @can('magasin-stocks-list')
	            <a href="{{route('stocks.magasins',$magasin->id,csrf_token())}}" class="btn btn-sm btn-neutral mt-1 d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">Stocks</a>
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
						  	@can('magasin-jour-create')
                                <a href="{{ route('days.ceated',$magasin->id) }}" class="btn btn-sm btn-neutral">{{ __('Ajouter une Journée') }}</a>
                            @endcan
					      </li>
						  <li class="list-group-item">
						  	@can('magasin-historiques-list')
					        <a href="{{ route('historiques.magasins',$magasin->id) }}" class="btn btn-sm btn-neutral">Historiques</a>
					        @endcan
					      </li>
						  <li class="list-group-item">
						  	@can('magasin-entree-list')
				            <a href="{{ route('entrees.magasins',$magasin->id) }}" class="btn btn-sm btn-neutral mt-1">Entrées</a>
				            @endcan
						  </li>
						  <li class="list-group-item">
						  	@can('magasin-boutique-sortie-list')
				            <a href="{{ route('sortie-boutique.magasins',$magasin->id) }}" class="btn btn-sm btn-neutral mt-1">Sorties vers Boutiques</a>
				            @endcan
						  </li>
						  <li class="list-group-item">
						  	 @can('magasin-magasin-sortie-list')
					            <a href="{{route('sortie-magasin.magasins',$magasin->id)}}" class="btn btn-sm btn-neutral">Sorties vers Magasins</a>
					          @endcan
						  </li>
						  <li class="list-group-item">
						  	@can('magasin-stocks-list')
				            <a href="{{route('stocks.magasins',$magasin->id,csrf_token())}}" class="btn btn-sm btn-neutral">Stocks</a>
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
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Journées') }}</h3>
                            </div>
                            @can('magasin-jour-create')
                            <div class="col-4 text-right">
                                <a href="{{ route('days.ceated',$magasin->id) }}" class="btn btn-sm btn-primary d-none d-sm-none d-md-none d-lg-none d-xl-inline-flex">{{ __('Ajouter une Journée') }}</a>
                                <a href="" class="btn btn-sm btn-primary d-xl-none" class="btn btn-primary" data-toggle="modal" data-target="#menu">{{ __('plus') }}</a>
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
                    <div class="col-12">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
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

					<div class="table-responsive">
					<table class="table table-bordered bootstrap-datatable datatable bg-white" id="datatable-buttons" style="width:100%;">
					 <thead class="thead-light">
					  <tr>
						 <th>Numéro</th>
						 <th>Date du jour</th>
						 <th>Description</th>
						 <th>Déçision</th>
						 <th width="280px">Action</th>
					  </tr>
					  </thead>
		                <tbody>
					    @php $i=0; @endphp
						@foreach ($magasin->jours as $key => $jour)
						<tr>
							<td>{{ ++$i }}</td>
							<td>{{ $jour->created_at->format('d/m/Y H:i') }}</td>
							<td>{{ $jour->description }}</td>
							<td>@if($jour->actif==true) En cours d'exercice @else cloturé @endif</td>
							<td>
								<div class="dropdown">
									<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										
										@can('magasin-jour-list')
										<a class="dropdown-item" href="{{ route('days.show',$jour) }}">{{ __('Lister') }}</a>@endcan
										@if($jour->actif==true)
										@can('magasin-jour-edit')
										<a class="dropdown-item" href="{{ route('days.edit',$jour->id) }}">{{ __('Editer') }}</a>
										@endcan
										@can('magasin-jour-delete')
										<form action="{{ route('days.destroy', $jour->id) }}" method="post">
											@csrf
											@method('delete')
											<button type="button" class="dropdown-item" onclick="confirm('{{ __("ête vous sûr de vouloir supprimer cette journée?") }}') ? this.parentElement.submit() : ''">
												{{ __('Supprimer') }}
											</button>
										</form> 
										@endcan
										@endif
									</div>
								</div>
							</td>
						</tr>
						@endforeach
						</tbody>
					</table>
                   </div>
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