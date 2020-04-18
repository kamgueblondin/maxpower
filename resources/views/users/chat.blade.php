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
        <div class="container-fluid header bg-primary bg-gradient-primary pb-6 pt-3 pt-md-8">
            <br><br>
                    @if(auth()->check())
                        <div class="card">
                            <div id="app" class="card-body">
                             <div  class="chat-app"style="font-weight: bold;">
                             <div  class="conversation">
                                 <h1 class="text-light">
                                 @if(isset($recepteurM))
                                    @foreach($contacts as $contact)
                                    @if($contact->id==$recepteurM)
                                    <span style="color:blue;">{{$contact->name}} </span>
                                    @endif
                                    @endforeach
                                 @else
                                 <span style="color:blue;">{{'Sélectionner un Contact'}}</span>
                                 @endif
                                 <span class="mif-mobile place-right" style="color:blue;"></span></h1>
                                 <div class="feed" id="conntennn">
                                        <ul>
                                            @if(isset($recepteurM))
                                            @foreach($messages as $message)
                                            @if(auth()->user()->id==$message->recepteur)
                                                <li  class="message sent" style="list-style-type: none;">
                                                    <div class="text">
                                                        {!!$message->contenu!!}
                                                    </div>
                                                </li>
                                            @else
                                                <li class="message received" style="list-style-type: none;">
                                                    <div  class="text">
                                                        {!!$message->contenu!!}
                                                    </div>
                                                </li>
                                            @endif
                                            @endforeach
                                            @endif
                                        </ul>
                                 </div>
                                 <div class="composer">
                                 <form id="formChat" method="POST" onsubmit="return false">
                                     <div class="input-control text full-size">
                                        <input type="text" name="contenu"  id="contenu" required placeholder="Entrer le contenu..." class="form-control input-lg">
                                            <div class="input-group-append">
                                                    <button  class="button helper-button clear" id="envoie" type="button">
                                                            Envoyer
                                                        </button>
                                                    </div>
                                    </div>
                                    @if(isset($recepteurM))
                                    <input type="hidden" id="recepteur" name="recepteur" value="{{$recepteurM}}">
                                    <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                                    @endif
                                </form>
                                </div>
                            </div>
                             <div  class="contacts-list">
                             <ul>
                                <table id="dataTables" style="color:white;">
                                    <thead>
                                    <tr><td>
                                    </td>
                                    </tr>
                                    </thead>
                                    <tbody id="contacts-list" style="color:white;">
                                @foreach($contacts as $contact)
                                <tr><td>
                                <a style="color: black;" href="/messages/{{$contact->id}}">
                                    <li class="">
                                    <div class="avatar"><span class="mif-user icon"></span></div>
                                    <div class="contact">
                                    <p class="name">{{$contact->name}} {{$contact->email}}
                                    @if($contact->vu!=0)
                                    <span class="badge bg-magenta text-geen fg-grayLighter">
                                        <span style="font-size:14px;">{{$contact->vu}}</span>
                                    </span>
                                    </p>
                                    @endif
                                    </div> <!---->
                                    </li>
                                </a>
                                </td></tr>
                                @endforeach
                                </tbody>
                                </table>
                            </ul>
                            </div>
                        </div>
                      </div>
                    </div>
                    @else
                        <h4 class="text-center">@lang('Connectez vous pour pouvoir profiter  du chat !')</h4>
                    @endif
                </div>
         <div class="container mt--10 pb-5"></div>
                </div>
            </div>
        </div>

        @include('layouts.footers.guest')
        
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
        

        <script>
    		jQuery(document).ready(function() {
    			 $('#conntennn').scrollTop(150000000000);
    					@if(isset($recepteurM))
    			var auto_refresh=setInterval(function(){
    					$('#conntennn').load("{{ url('refresh_message/'.$recepteurM)}}");
    					$('#conntennn').scrollTop(1500000000);
    				},1000);
    					@endif
    					@if(isset($recepteurM))
    			var auto_refresh=setInterval(function(){
    					$('#contacts-list').load("{{ url('refresh_contact/'.$recepteurM)}}");
    				},3000);
    			@endif
    			@if(isset($recepteurM))
    			$("#envoie").click(function(e){
    				e.preventDefault();

    				$.post(
    					'/messages',
    					{
    						contenu : $("#contenu").val(),

    						recepteur : $("#recepteur").val(),

    						_token : $("#token").val()
    					},

    					function(data){

    						if(data){


    							//alert("<p>Méssage envoyer avec succès !</p>");
    							document.getElementById('contenu').value="";
    						}
    						else{

    							//alert("<p>Une erreur s'est produite lors de l'envoi...</p>");
    						}

    					},
    					'text'
    				);
    			});

    			@endif
    			@if(isset($recepteurM))
    			$("#formChat").keydown(function (e) {
    				if (e.keyCode == 13) {
    					e.preventDefault();
    					$.post(
    						'/messages',
    						{
    							contenu : $("#contenu").val(),

    							recepteur : $("#recepteur").val(),

    							_token : $("#token").val()
    						},

    						function(data){

    							if(data){


    								//alert("<p>Méssage envoyer avec succès !</p>");
    								document.getElementById('contenu').value="";
    							}
    							else{

    								//alert("<p>Une erreur s'est produite lors de l'envoi...</p>");
    							}

    						},
    						'text'
    					);
    				}
    			});
    			@endif
    		});
        if ( $.fn.dataTable.isDataTable( '#dataTables' ) ) {
            table = $('#dataTables').DataTable();
        }
        else {
            table = $('#dataTables').DataTable( {
                paging: false,
                "bInfo" : false
            } );
        }
    	</script>
        <!-- Argon JS && @include('layouts.footers.auth')-->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
    </body>
</html>