@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <!-- Card stats -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Utilisateurs</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$utilisateurs->count()}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> Gestion: </span>
                                    <span class="text-nowrap"><a href="{{route('user.index')}}">Aller à la gestion</a></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Boutiques</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$boutiques->count()}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> Gestion: </span>
                                    <span class="text-nowrap"><a href="{{route('shops.index')}}">Aller à la gestion</a></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Magasins</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$magasins->count()}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                            <i class="fas fa-chart-pie"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> Gestion: </span>
                                    <span class="text-nowrap"><a href="{{route('magasins.index')}}">Aller à la gestion</a></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">MESSAGES</h5>
                                        <span class="h2 font-weight-bold mb-0">{{Auth::user()->messages->where('vu','=',0)->count()}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> Gestion: </span>
                                    <span class="text-nowrap"><a href="{{url('messages')}}"> méssagerie</a></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid mt--7">
        <div class="row mt-5">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="table-responsive card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Boutiques</h3>
                            </div>
                            <div class="col text-right">
                                <a href="#!" class="btn btn-sm btn-primary">Imprimer</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Boutiques</th>
                                    <th scope="col">Journées</th>
                                    <th scope="col">Ventes</th>
                                    <th scope="col">Sorties</th>
                                    <th scope="col">Utilisateurs</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($boutiques as $boutique)
                                <tr>
                                    <th scope="row">
                                      @if(isset($boutiques))  {{ $boutique->nom }} {{ $boutique->localisation }} @endif
                                    </th>
                                    <td>
                                       @if(isset($boutique->jours)) {{ $boutique->jours->count() }} @endif
                                    </td>
                                    <td>
                                        @if(isset($boutique->ventes))
                                        {{ $boutique->ventes->count() }} @endif
                                    </td>
                                    <td>
                                        @if(isset($boutique->sortieMagasins))
                                        {{ $boutique->sortieMagasins->count() }} @endif
                                    </td>
                                    <td>
                                        @if(isset($boutique->users))
                                        {{ $boutique->users->count() }} @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="table-responsive card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Magasins</h3>
                            </div>
                            <div class="col text-right">
                                <a href="#!" class="btn btn-sm btn-primary">Imprimer</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Magasins</th>
                                    <th scope="col">Journées</th>
                                    <th scope="col">Entrées</th>
                                    <th scope="col">Sorties</th>
                                    <th scope="col">Utilisateurs</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach($magasins as $magasin)
                                <tr>
                                    <th scope="row">
                                      @if(isset($magasins))  {{ $magasin->nom }} {{ $magasin->localisation }} @endif
                                    </th>
                                    <td>
                                       @if(isset($magasin->jours)) {{ $magasin->jours->count() }} @endif
                                    </td>
                                    <td>
                                        @if(isset($magasin->ventes))
                                        {{ $magasin->ventes->count() }} @endif
                                    </td>
                                    <td>
                                        @if(isset($magasin->sortieMagasins))
                                        {{ $magasin->sortieMagasins->count()+$magasin->sortieBoutiques->count() }} @endif
                                    </td>
                                    <td>
                                        @if(isset($magasin->users))
                                        {{ $magasin->users->count() }} @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush