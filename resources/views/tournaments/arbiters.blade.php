@extends('master')

@section('title', 'Sudije - '.$tournament->name)

@section('content')

<h1>Sudije - {{ $tournament->name }}</h1>
	
<div class="row">

	@if(sizeof($arbiters) > 0)
	<form class="col-12 form-inline mb-2" method="POST" action="/turnir/{{$tournament->id}}/dodajSudiju">
		@csrf
		<select class="form-control mr-2" name="arbiter_id">
			@foreach($arbiters as $arbiter)
				<option value="{{$arbiter->id}}">{{$arbiter->name}} {{$arbiter->surname}}</option>
			@endforeach
		</select>

		<input type="submit" value="Dodaj" class="btn btn-primary">

	</form>
	@endif

	<table class="table table-hover text-center col-12">
		<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Sudija</th>
				<th scope="col">Rang</th>
				<th scope="col">Ukloni sudiju</th>
			</tr>
		</thead>

		<tbody>
			@foreach($tournament->arbiters as $arbiter)
			<tr>
				<th scope="row">{{$loop->index + 1}}</th>
				<td>{{ $arbiter->name }} {{$arbiter->surname }}</td>
				<td>{{ $arbiter->getArbiterRank() }}</td>
				<td>
					<form class="form-inline d-flex justify-content-center" method="POST" action="/turnir/{{$tournament->id}}/ukloniSudiju">
						@csrf
						<input type="hidden" name="arbiter_id" value="{{$arbiter->id}}">
						<input type="submit" class="btn btn-danger" value="-">
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</div>
@endsection