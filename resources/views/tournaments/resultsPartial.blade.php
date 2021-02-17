@foreach($results as $result)
<tr>
	<td><input type="number" value="{{$result->table}}" name="table[]" min="1" max="{{$maxTables}}"></td>
	<td>
		<select onchange="playerSelected(this)" name="white[]" class="white">
			<option value="0">Izaberite igraca</option>
			<option value="{{$result->white->id}}" selected>{{$result->white->name}} {{$result->white->surname}}</option>
		</select>
	</td>
	<td>
		@if($tournament->type == 'player')
		<select name="result[]">
			<option value="2" {{ $result->white_result == 1 ? "selected" : ""}}>1:0</option>
			<option value="1" {{ $result->white_result == $result->black_result ? "selected" : ""}}>0.5:0.5</option>
			<option value="0" {{ $result->white_result == 0 ? "selected" : ""}}>0:1</option>
		</select>
		@else
		<select name="result[]">
			@for($i = 0; $i <= $tournament->playersPerClub; $i += 0.5)
			<option value="{{$i}}" {{$result->white_result == $i ? "selected" : ""}}>{{$i}}:{{$tournament->playersPerClub - $i}}</option>
			@endfor
		</select>
		@endif
	</td>
	<td>
		<select onchange="playerSelected(this)" name="black[]" class="black">
			<option value="0">Izaberite igraca</option>
			<option value="{{$result->black->id}}" selected>{{$result->black->name}} {{$result->black->surname}}</option>
		</select>
	</td>
</tr>
@endforeach

@if(sizeof($results) == 0)
<tr>
	<td><input type="number" value="1" name="table[]" min="1" max="{{$maxTables}}"></td>
	<td>
		<select onchange="playerSelected(this)" name="white[]" class="white">
			<option value="0">Izaberite igraca</option>
		</select>
	</td>
	<td>
		@if($tournament->type == "player")
		<select name="result[]">
			<option value="2">1:0</option>
			<option value="1">0.5:0.5</option>
			<option value="0">0:1</option>
		</select>
		@else
		<select name="result[]">
			@for($i = 0; $i <= $tournament->playersPerClub; $i += 0.5)
			<option value="{{$i}}">{{$i}}:{{$tournament->playersPerClub - $i}}</option>
			@endfor
		</select>
		@endif
	</td>
	<td>
		<select onchange="playerSelected(this)" name="black[]" class="black">
			<option value="0">Izaberite igraca</option>
		</select>
	</td>
</tr>
@endif