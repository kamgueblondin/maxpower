@extends('layouts.app', ['title' => __('Gestion des utilisateurs')])

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
                    <li class="breadcrumb-item"><a href="{{route('user.index')}}">Utilisateurs</a></li>
                <li class="breadcrumb-item active" aria-current="page">Liste</li>
                </ol>
            </nav>
        </div>
                <div class="col-lg-6 col-5 text-right">
                <a href="{{ route('user.create') }}" class="btn btn-sm btn-neutral">Nouveau</a>
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
                                <h3 class="mb-0">{{ __('Utilisateurs') }}</h3>
                            </div>
							@can('user-edit')
                            <div class="col-4 text-right">
                                <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">{{ __('Ajouter un utilisateur') }}</a>
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

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush"  id="datatable-buttons">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Nom') }}</th>
                                    <th scope="col">{{ __('Téléphone') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
									<th scope="col">{{ __('Roles') }}</th>
                                    <th scope="col">{{ __('Date de Création') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                        </td>
										<td>
										  @if(!empty($user->getRoleNames()))
											@foreach($user->getRoleNames() as $v)
											   <label class="badge badge-success">{{ $v }}</label>
											@endforeach
										  @endif
										</td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
												@can('user-list')
													<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
															<form action="{{ route('user.destroy', $user) }}" method="post">
																@csrf
																@method('delete')
																<a class="dropdown-item" href="{{ route('user.show',$user->id) }}">{{ __('Consulter') }}</a>
																@can('user-edit')
																<a class="dropdown-item" href="{{ route('user.edit', $user) }}">{{ __('Editer') }}</a>
																@endcan
																@can('user-delete')
																<button type="button" class="dropdown-item" onclick="confirm('{{ __("ête vous sûr de vouloir supprimer l\'utilisateur?") }}') ? this.parentElement.submit() : ''">
																	{{ __('Supprimer') }}
																</button>
																@endcan
															</form>  
													</div>
												@endcan
                                            </div>
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