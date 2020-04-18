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
        @include('users.partials.header', [
            'title' => __('Salut') . ' '. auth()->user()->name,
            'description' => __('Ceci est votre page de profil. Vous pouvez voir les progrès que vous avez accomplis dans votre travail et gérer vos projets ou tâches assignées'),
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
                                        <img src="{{ asset('argon') }}/img/theme/User_Avatar.png" class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                            <div class="d-flex justify-content-between">
                                <a href="{{route('home')}}" class="btn btn-sm btn-info mr-4">{{ __('Accueil') }}</a>
                                <a href="{{url('messages')}}" class="btn btn-sm btn-default float-right">{{ __('Message') }}</a>
                            </div>
                        </div>
                        <div class="card-body pt-0 pt-md-4">
                            <div class="text-center">
                                <h3>
                                    {{ auth()->user()->name }}<span class="font-weight-light">, 27</span>
                                </h3>
                                <div class="h5 font-weight-300">
                                    <i class="ni location_pin mr-2"></i>{{ __('Ville: Bafoussam, Pays: Cameroun') }}
                                </div>
                                <div class="h5 mt-4">
                                    <i class="ni business_briefcase-24 mr-2"></i>{{ __('Une solution digitale de gestion automatisée - Max power') }}
                                </div>
                                <div>
                                    <i class="ni education_hat mr-2"></i>{{ auth()->user()->name }} {{ auth()->user()->email }}
                                </div>
                                <hr class="my-4" />
                                <p>{{ __('Mini description de mon profile.') }}</p>
                                <a href="#">{{ __('Voir plus') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <h3 class="col-12 mb-0">{{ __('Editer mon Profile') }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('profile.update') }}" autocomplete="off">
                                @csrf
                                @method('put')

                                <h6 class="heading-small text-muted mb-4">{{ __('Mès informations') }}</h6>
                                
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Nom') }}</label>
                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nom') }}" value="{{ old('name', auth()->user()->name) }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                        <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Envoyer') }}</button>
                                    </div>
                                </div>
                            </form>
                            <hr class="my-4" />
                            <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                                @csrf
                                @method('put')

                                <h6 class="heading-small text-muted mb-4">{{ __('Mot de passe') }}</h6>

                                @if (session('password_status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('password_status') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-current-password">{{ __('Mot de passe actuel') }}</label>
                                        <input type="password" name="old_password" id="input-current-password" class="form-control form-control-alternative{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Mot de passe actuel ici...') }}" value="" required>
                                        
                                        @if ($errors->has('old_password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('old_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-password">{{ __('Nouveau mot de passe') }}</label>
                                        <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Entrer le ici...') }}" value="" required>
                                        
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-password-confirmation">{{ __('Confirmer le nouveau mot de passe') }}</label>
                                        <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirmer le nouveau mot de passe ici...') }}" value="" required>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Changer mon mot de passe') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                            <div class="container mt--10 pb-5"></div>
                </div>
            </div>
        </div>

            @include('layouts.footers.guest')
        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')
        
        <!-- Argon JS && @include('layouts.footers.auth')-->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
    </body>
</html>