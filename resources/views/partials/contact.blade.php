@foreach($contacts as $contact)
<tr><td>
<a style="color: black;" href="/messages/{{$contact->id}}">
	<li class="">
	<div class="avatar"><div class="avatar"><span class="mif-user icon"></span></div></div>
	<div class="contact">
	<p class="name">{{$contact->name}} {{$contact->email}}
	@if($contact->vu!=0)
	<span class="badge bg-magenta text-green fg-grayLighter">
		<span style="font-size:14px;">{{$contact->vu}}</span>
	</span>
	</p>
	@endif
	</div> <!---->
	</li>
</a>
</td></tr>
@endforeach