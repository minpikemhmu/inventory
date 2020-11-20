<table>
	<thead>
		<th valign="center">Date</th>
		@foreach($ways as $way)
		<th valign="center" style="width: 30px;height: 30px;">{{$way->user->name}}</th>
		@endforeach
	</thead>
	<tbody>
		<tr></tr>
		@foreach($dates as $date)
		<tr>
			<td valign="center" style="width: 20px;height: 30px;">{{$date}}</td>
			@foreach($ways as $man)
			@php $count=0; @endphp
			@foreach($man->pickups as $pickup) 
				@if($pickup->created_at->format('d-m-y')==$date)
					@php $count++; @endphp
				@endif
			@endforeach

			@foreach($man->ways as $way) 
				@if($way->created_at->format('d-m-y')==$date)
					@php $count++; @endphp
				@endif
			@endforeach
			<td valign="center" style="width:20px;height: 30px;">{{$count}}</td>
			
			@endforeach


		</tr>
		@endforeach
		
	</tbody>
</table>