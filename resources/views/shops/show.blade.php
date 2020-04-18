@extends('layouts.app', ['title' => __('Boutiques')])

@section('content')
    @include('users.partials.header', ['title' => __('Boutique')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Affichage de la boutique') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('shops.index') }}" class="btn btn-sm btn-primary">{{ __('Retours à la liste') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">


				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>logo:</strong>
							<img width="150" height="150" src="{{asset('images/logos/')}}/{{ $shop->logo }}" alt="logo">
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Nom:</strong>
							{{ $shop->nom }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Localisation:</strong>
							{{ $shop->localisation }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Téléphone 1:</strong>
							{{ $shop->telephone_1 }}
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Utilisateurs:</strong>
							@if(!empty($shop->users))
								@foreach($shop->users as $v)
									<label class="label label-success">{{ $v->name }},</label>
								@endforeach
							@endif
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<strong>Magasins:</strong>
							@if(!empty($shop->magasins))
								@foreach($shop->magasins as $v)
									<label class="label label-success">{{ $v->nom }} {{ $v->localisation }},</label>
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