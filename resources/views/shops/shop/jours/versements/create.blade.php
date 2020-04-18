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
    @include('users.partials.header', ['title' => __('Ajouter un versement')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary table-responsive shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Gestion des versements') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('jours.boutiques.versements',$jour->id) }}" class="btn btn-sm btn-primary">{{ __('Retours à l\'accueil') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
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
							<form method="post" action="{{ route('boutique-versements.store') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                                <div class="form-group{{ $errors->has('destination') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-destination">{{ __('nom de la destination du versement') }}</label>
                                    <input type="text" name="destination" id="input-destination" class="form-control form-control-alternative{{ $errors->has('destination') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le nom de la destination du versement') }}" value="{{ old('destination') }}" required autofocus>

                                    @if ($errors->has('destination'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('destination') }}</strong>
                                        </span>
                                    @endif
                                </div>
                               <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-description">{{ __('description') }}</label>
                                    <input type="text" name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer la description') }}" value="{{ old('description') }}" required autofocus>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('montant') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-montant">{{ __('montant') }}</label>
                                    <input type="number" min="0" name="montant" id="input-montant" class="form-control form-control-alternative{{ $errors->has('montant') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le montant') }}" value="{{ old('montant') }}" required autofocus>

                                    @if ($errors->has('montant'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('montant') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="boutique_id" value="{{ $boutique->id }}" required >
                                     <input type="hidden" name="boutique_jour_id" value="{{ $jour->id }}" required >
    						
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
<script laguage="javascript">
function totalActuel(){
    document.getElementById('n').value="";
    var checkedValue = 0; 
    var total=0;
    var inputElements = document.getElementsByClassName('totall');
    for(var i=0; inputElements.length; ++i){
       checkedValue = parseFloat(inputElements[i].value);
       if(checkedValue){
           total+=parseFloat(checkedValue);
           document.getElementById('n').value=total; 
       }
    }
}
</script>