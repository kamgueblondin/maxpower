<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{$boutique->nom}} {{$boutique->localisation}} | Inventaires.</title>
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
    @include('users.partials.header', ['title' => __('Faire des Inventaires')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary table-responsive shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Gestion des Inventaires') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('stocks.shops',$boutique->id) }}" class="btn btn-sm btn-primary">{{ __('Retours au stocks') }}</a>
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
							<form method="post" id="form" action="{{ route('shops.inventaire') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                                <div class="form-group">
                                    <input type="hidden" name="boutique_id" value="{{ $boutique->id }}" required >
                                    <table class="table table-striped table-bordered bootstrap-datatable datatable bg-white" id="datatable-basics">
                                    <thead>
                                    <tr>
                                        <th>Choisir</th>
                                        <th>Produit ref</th>
                                        <th>Produit nom</th>
                                        <th>Catégorie</th>
                                        <th>Stock Supposé être</th>
                                        <th>P.U</th>
                                        <th>Stock réel</th>
                                        <th>Sous total <span class="text-danger"> (FCFA)</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($boutique->stocks as $key => $stock)
                                    <tr>
                                    <td>
                                        <input type="checkbox" name="stocks[]" value="{{$stock->id}}" onclick="if(document.getElementById(this.value).disabled==false){document.getElementById(this.value).disabled=true;document.getElementById(this.value).value='';document.getElementById('to'+this.value).value='';document.getElementById('t'+this.value).innerHTML='';totalActuel();}else{document.getElementById(this.value).disabled=false;document.getElementById(this.value).value='';document.getElementById('to'+this.value).value='';document.getElementById('t'+this.value).innerHTML='';totalActuel();}">
                                    </td>
                                    <td>
                                        <label>{{ $stock->produit->reference }}</label>
                                    </td>
                                    <td>
                                        <label>{{ $stock->produit->nom }}</label>
                                    </td>
                                    <td>
                                        <label>{{ $stock->produit->categorie->nom }}</label>
                                    </td>
                                    <td>
                                        <label>{{ $stock->valeur }}</label>
                                    </td>
                                    <td>
                                        <label>{{ $stock->produit->prix }} FCFA</label>
                                        <input type="hidden" value="{{ $stock->produit->prix }}" id="p{{$stock->id}}">
                                    </td>
                                    <td>
                                       <input type="number"  name="quantites[]" min="0" disabled required class="span12 typeahead" id="{{$stock->id}}" onkeyup="document.getElementById('t'+this.id).innerHTML=(document.getElementById('p'+this.id).value*this.value);document.getElementById('t'+this.id).value=(document.getElementById('p'+this.id).value*this.value);document.getElementById('to'+this.id).value=(document.getElementById('p'+this.id).value*this.value); totalActuel();" onchange="document.getElementById('t'+this.id).innerHTML=(document.getElementById('p'+this.id).value*this.value);document.getElementById('t'+this.id).value=(document.getElementById('p'+this.id).value*this.value);document.getElementById('to'+this.id).value=(document.getElementById('p'+this.id).value*this.value); totalActuel();">
                                    </td>
                                    <td>
                                        <label  id="t{{$stock->id}}"></label>
                                        <input type="hidden" class="totall" id="to{{$stock->id}}">
                                    </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                   </table>
                                   <div class="control-group" style="display: none;">
                                        <label class="control-label" for="quantite">Montants net des Sorties<span class="text-danger"> (FCFA)</span> </label>
                                        <div class="controls">
                                            <input type="text" readonly class="span10" id="n">
                                        </div>
                                    </div>
    						
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
<script type="text/javascript">
    $(document).ready(function (){
       var table = $('#datatable-basics').DataTable({
                @if(app()->getLocale() == 'fr')
                    @else
                "language": {
                    "sProcessing":     "Traitement en cours...",
                    "sSearch":         "Rechercher&nbsp;:",
                    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    "sInfoPostFix":    "",
                    "sLoadingRecords": "Chargement en cours...",
                    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                    "oPaginate": {
                        "sFirst":      "Premier",
                        "sPrevious":   "Pr&eacute;c&eacute;dent",
                        "sNext":       "Suivant",
                        "sLast":       "Dernier"
                    },
                    "oAria": {
                        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                    },
                    "select": {
                        "rows": {
                            _: "%d lignes séléctionnées",
                            0: "Aucune ligne séléctionnée",
                            1: "1 ligne séléctionnée"
                        }
                    }
                }
                @endif
            });
       
       // Handle form submission event 
       $('#form').on('submit', function(e){
          var form = this;
          var vide=0;
          // Encode a set of form elements from all pages as an array of names and values
          var params = table.$('input').serializeArray();

          //vérification des champs
          $.each(params, function(){     
             // If element doesn't exist in DOM
             if(!$.contains(document, form[this.name])){
                // Create a hidden element 
                if(this.value==""){
                  e.preventDefault();
                  vide=1;
                }
             } 
          });    
          // Iterate over all form elements
          if (vide==0) {
            $.each(params, function(){     
               // If element doesn't exist in DOM
               if(!$.contains(document, form[this.name])){
                  // Create a hidden element 
                  $(form).append(
                     $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', this.name)
                        .val(this.value)
                  );
               } 
            });      

            // FOR DEMONSTRATION ONLY
            // The code below is not needed in production
            
            // Output form data to a console     
            //$('#example-console-form').text($(form).serialize());
             
            // Remove added elements
            $('input[type!="hidden"]', form).remove();

            // Prevent actual form submission
            //e.preventDefault();
          }else{
            alert("désoler des champs ne sont pas remplis veillez vérifier puis recommencer!!");
          }
       });      
    });
</script>
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