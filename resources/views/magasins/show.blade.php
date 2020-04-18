@extends('layouts.app', ['title' => __('Magasins')])

@section('content')
    @include('users.partials.header', ['title' => __('Magasin')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Affichage du magasin') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('magasins.index') }}" class="btn btn-sm btn-primary">{{ __('Retours à la liste') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">


				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Nom:</strong>
							{{ $magasin->nom }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Localisation:</strong>
							{{ $magasin->localisation }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Adrèsse:</strong>
							{{ $magasin->adresse }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Utilisateurs:</strong>
							@if(!empty($magasin->users))
								@foreach($magasin->users as $v)
									<label class="label label-success">{{ $v->name }},</label>
								@endforeach
							@endif
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Magasins:</strong>
							@if(!empty($magasin->magasins))
								@foreach($magasin->magasins as $b)
									<label class="label label-success">{{ $b->nom }} {{ $b->localisation }},</label>
								@endforeach
							@endif
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Boutiques:</strong>
							@if(!empty($magasin->users))
								@foreach($magasin->boutiques as $b)
									<label class="label label-success">{{ $b->nom }} {{ $b->localisation }},</label>
								@endforeach
							@endif
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
 @include('layouts.footers.auth')
    </div>
@endsection