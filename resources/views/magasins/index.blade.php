@extends('layouts.app', ['title' => __('Gestion des Magasins')])

@section('content')
	<div class="header bg-primary bg-gradient-primary pb-6 pt-3 pt-md-8">
	    <div class="container-fluid">
	        <div class="header-body">
	           <div class="row align-items-center py-4">
	    <div class="col-lg-6 col-7">
	        <h6 class="h2 text-white d-inline-block mb-0">Administration</h6>
	        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
	            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
	                <li class="breadcrumb-item"><a href=""><i class="fas fa-home"></i></a></li>
	                <li class="breadcrumb-item"><a href="{{route('magasins.index')}}">Magasins</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Liste</li>
	            </ol>
	        </nav>
	    </div>
	            <div class="col-lg-6 col-5 text-right">
	            <a href="{{ route('magasins.create') }}" class="btn btn-sm btn-neutral">Nouveau</a>
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
                                <h3 class="mb-0">{{ __('Magasins') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('magasins.create') }}" class="btn btn-sm btn-primary">{{ __('Ajouter un Magasin') }}</a>
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


					<table class="table table-bordered bootstrap-datatable datatable bg-white" style="width:100%;" id="datatable-buttons">
                                    <thead>
					  <tr>
						 <th>Numéro</th>
						 <th>Nom</th>
						 <th width="280px">Action</th>
					  </tr>
					  </thead>
                        <tbody>
					    @php $i=0; @endphp
						@foreach ($magasins as $key => $magasin)
						<tr>
							<td>{{ ++$i }}</td>
							<td>{{ $magasin->nom }}</td>
							<td>
								<div class="dropdown">
									<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a class="dropdown-item" href="{{ route('magasins.show',$magasin) }}">{{ __('Lister') }}</a>
										@can('magasin-edit')
										<a class="dropdown-item" href="{{ route('magasins.edit',$magasin->id) }}">{{ __('Editer') }}</a>
										@endcan
										@can('magasin-delete')
										<form action="{{ route('magasins.destroy', $magasin->id) }}" method="post">
											@csrf
											@method('delete')
											<button type="button" class="dropdown-item" onclick="confirm('{{ __("ête vous sûr de vouloir supprimer le magasin?") }}') ? this.parentElement.submit() : ''">
												{{ __('Supprimer') }}
											</button>
										</form> 
										@endcan
									</div>
								</div>
							</td>
						</tr>
						@endforeach
						</tbody>
					</table>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection
@push('js')
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
@endpush