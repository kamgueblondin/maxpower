<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dette : {{ $dette->partenaire }} du {{ $dette->created_at->format('d/m/Y H:i') }}</title>
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
        @include('users.partials.header', [
            'title' => __('Dette : ') . ' '. $dette->partenaire.' du '.$dette->created_at->format('d/m/Y H:i'),
            'description' => __('Ceci est la page de gestion des versements des dêttes. Vous pouvez voir les différents versements qui ont été faites par '.$dette->partenaire),
            'class' => 'col-lg-7'
        ])   

        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                    <div class="card card-profile shadow">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                            <div class="d-flex justify-content-between">
                                <a href="{{route('users.shops',$dette->boutique_id)}}" class="btn btn-sm btn-info mr-4">{{ __('Accueil') }}</a>
                                <a href="{{ route('jours.boutiques.dettes',$dette->boutique_jour_id) }}" class="btn btn-sm btn-default float-right">{{ __('Retours à la liste de la journée') }}</a>
                            </div>
                        </div>
                        <div class="card-body pt-0 mt-5 pt-md-4">
                            <div class="text-center">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Auteur de la dêtte:</strong>
                                            {{ $dette->user->name }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Nom du partenaire:</strong>
                                            {{ $dette->partenaire }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Description:</strong>
                                            {{ $dette->description }}
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Montant de la dêtte:</strong>
                                            {{ $dette->montant }} fcfa
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Date des dêttes:</strong>
                                            {{ $dette->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <h3 class="col-12 mb-0">{{ __('Gestion de la dette') }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
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
                            @php $tota=0;  @endphp
                            @foreach($dette->versements as $va)
                                @php $tota+=$va->montant;  @endphp
                            @endforeach
                            @if( $tota < $dette->montant )
                            <form method="post" action="{{ route('versement.dettes') }}" autocomplete="off">
                                @csrf
                                @method('post')

                                <h6 class="heading-small text-muted mb-4">{{ __('Ajouter un versement') }}</h6>

                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-description">{{ __('Description') }}</label>
                                        <input type="text" name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Description du versement') }}" value="{{ old('description') }}" required autofocus>
                                        <input type="hidden" name="dette_boutique_id" value="{{ $dette->id }}">
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('montant') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-montant">{{ __('Montant') }}</label>
                                        <input type="number" name="montant" id="input-montant" class="form-control form-control-alternative{{ $errors->has('montant') ? ' is-invalid' : '' }}" placeholder="{{ __('Montant') }}" value="{{ old('montant') }}" required>

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
                            <hr class="my-4" />
                            @endif
                            <table class="table table-striped table-bordered bootstrap-datatable datatable" id="datatable-buttons">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Information</th>
                                    <th>Valeur</th>
                                </tr>
                                </thead>
                                <caption>Listes des versements</caption>
                                <tbody>
                                @php $total=0;  @endphp
                                @foreach($dette->versements as $v)
                                @php $total+=$v->montant;  @endphp
                                <tr>
                                    <td><a href="{{route('versement.dettes.destroy',$v->id)}}" onclick="return confirm('Etes vous sure de vouloir supprimer ce versement ?')">Supprimer</a></td>
                                    <td>{{ $v->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $v->description }}</td>
                                    <td>{{ $v->montant }} FCFA</td>
                                </tr>
                                @endforeach
                                <tfoot>
                                <tr class="bg-blue text-white">
                                    <th colspan="3" >Total versements</th><th>{{$total}} FCFA</th>
                                </tr>
                                <tr  class="bg-success text-white">
                                    <th colspan="3">Somme Total de la dette</th><th>{{$dette->montant}} FCFA</th>
                                </tr>
                                <tr  class="bg-info text-white">
                                    <th colspan="3">Somme A Verser</th><th>{{$dette->montant-$total}} FCFA</th>
                                </tr>
                                </tfoot>
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
</html>