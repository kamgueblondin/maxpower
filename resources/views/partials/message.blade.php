<ul>
	@if(isset($recepteurM))
	@foreach($messages as $message)
	@if(auth()->user()->id==$message->recepteur)
		<li  class="message sent" style="list-style-type: none;">
			<div  class="text">
				{{$message->contenu}}
			</div>
		</li>
	@else
		<li class="message received" style="list-style-type: none;">
			<div  class="text">
				{{$message->contenu}}
			</div>
		</li>
	@endif
	@endforeach
	@endif
</ul>
							 