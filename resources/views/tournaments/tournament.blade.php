@extends('master')

@section('title', $tournament->name)

@section('content')

<h1> {{ $tournament->name }}</h1>

@if(Auth::guard('player')->check() && $tournament->type == 'player')
	
	<form action="/turnir/{{$tournament->id}}/prijavaIgraca/{{Auth::guard('player')->user()->id}}" method="POST">
		@csrf
		@if(!$tournament->isPlayerParticipating(Auth::guard('player')->user()->id))
		<input type="submit" value="Prijava na turnir" class="btn btn-primary"/>
		@else
		<input type="submit" value="Odjava sa turnira" class="btn btn-danger"/>
		@endif
	</form>
@elseif(Auth::guard('club')->check() && $tournament->type == 'club')

	<form action="/turnir/{{$tournament->id}}/prijavaKluba/{{Auth::guard('club')->user()->id}}" method="POST">
		@csrf
		@if(!$tournament->isClubParticipating(Auth::guard('club')->user()->id))
		<input type="submit" value="Prijava na turnir" class="btn btn-primary"/>
		@else
		<input type="submit" value="Odjava sa turnira" class="btn btn-danger"/>
		@endif
	</form>
@endif

	<ul class="nav nav-tabs nav-fill mt-3" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="tabela-tab" data-toggle="tab" href="#tabela" role="tab"
				aria-controls="tabela" aria-selected="true">Tabela</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="rezultati-id" data-toggle="tab" href="#rezultati" role="tab"
				aria-controls="rezultati" aria-selected="false">Rezultati</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="spisak-tab" data-toggle="tab" href="#spisak" role="tab" aria-controls="spisak"
				aria-selected="false">Informacije</a>
		</li>
	</ul>
	
	<div class="tab-content" id="myTabContent">

		<!-- Tabela TAB -->
		<div class="tab-pane fade show active p-5" id="tabela" role="tabpanel" aria-labelledby="tabela-tab">
			<h1 class="h1">Tabela</h1>
			<table class="table table-hover text-center">
				<thead class="thead-dark">
					<tr>
						<th scope="col">#</th>
						<th scope="col">Ime i prezime</th>
						<th scope="col">Poeni</th>
					</tr>
				</thead>

				<tbody>
					@foreach($table as $participant)
					<tr>
						<th scope="row">{{$loop->index + 1}}</th>
						<td>{{ $participant->player->name }} @if($tournament->type='player') {{$participant->player->surname }} @endif</td>
						<td>{{ $participant->points }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			
		</div>

		<!-- Rezultati tab -->
		<div class="tab-pane fade p-5" id="rezultati" role="tabpanel" aria-labelledby="rezultati-tab">
			<h1 class="h1">Rezultati</h1>

			@auth('player')
			@if(Auth::guard('player')->user()->isArbiter() && $tournament->arbiters->contains('id', Auth::user()->id))
			<a href="/turnir/{{$tournament->id}}/unosRezultata" class="btn btn-primary mb-1">Unos rezultata</a>
			@endif
			@endauth

			@for($i = 1; $i <= $rounds; $i++)
			<h3 class="h3">{{$i}}. Kolo</h3>
			<table class="table table-hover text-center">
				<thead class="thead-dark">
					<tr>
						<th scope="col" style="width:10%">#</th>
						<th class="w-30" scope="col" style="width:40%">Beli</th>
						<th scope="col" style="width:10%">Rezultat</th>
						<th class="w-30" scope="col" style="width:40%">Crni</th>
					</tr>
				</thead>

				<tbody>
					@php
					$results = $type::where('tournament_id', $tournament->id)->where('round', $i)->orderBy('table')->get();
					@endphp
					
					@foreach($results as $result)
					<tr>
						<th scope="row">{{$result->table}}.</th>
						<td class="w-30">{{$result->white->name}} @if($tournament->type == 'player') {{$result->white->surname}} @endif</td>
						<td>{{$result->white_result}} : {{$result->black_result}}</td>
						<td class="w-30">{{$result->black->name}} @if($tournament->type == 'player') {{$result->black->surname}} @endif</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endfor
			
			
		</div>

		<!-- Informacije tab-->
		<div class="tab-pane fade p-5" id="spisak" role="tabpanel" aria-labelledby="spisak-tab">			
			<h1 class="h1">Informacije</h1>
			
			<p class="p">Datum pocetka: {{date('d.m.Y.', strtotime($tournament->start_date))}}</p>
			<p class="p">Datum kraja: {{date('d.m.Y.', strtotime($tournament->end_date))}}</p>
			<p class="p">Email: {{$tournament->email}}</p>
			<p class="p">Telefon: {{$tournament->phone}}</p>
			<p class="p">Adresa: {{$tournament->place}}</p>

			@auth('player')
				@if(Auth::guard('player')->user()->email == $tournament->email)
					<a href="/turnir/{{$tournament->id}}/sudije" class="btn btn-primary">Dodavanje sudija</a>
				@endif
			@endauth

			@auth('admin')
				@if(Auth::guard('admin')->user()->email == $tournament->email)
					<a href="/turnir/{{$tournament->id}}/sudije" class="btn btn-primary">Dodavanje sudija</a>
				@endif
			@endauth

			@auth('club')
				@if(Auth::guard('club')->user()->email == $tournament->email)
					<a href="/turnir/{{$tournament->id}}/sudije" class="btn btn-primary">Dodavanje sudija</a>
				@endif
			@endauth

			<table class="table table-hover text-center col-12">
				<thead class="thead-dark">
					<tr>
						<th scope="col">#</th>
						<th scope="col">Sudija</th>
						<th scope="col">Rang</th>
						
						@auth('player')
							@if(Auth::guard('player')->user()->email == $tournament->email)
								<th scope="col">Ukloni sudiju</th>
							@endif
						@endauth

						@auth('admin')
							@if(Auth::guard('admin')->user()->email == $tournament->email)
								<th scope="col">Ukloni sudiju</th>
							@endif
						@endauth

						@auth('club')
							@if(Auth::guard('club')->user()->email == $tournament->email)
								<th scope="col">Ukloni sudiju</th>
							@endif
						@endauth

					</tr>
				</thead>

				<tbody>
					@foreach($tournament->arbiters as $arbiter)
					<tr>
						<th scope="row">{{$loop->index + 1}}</th>
						<td>{{ $arbiter->name }} {{$arbiter->surname }}</td>
						<td>{{ $arbiter->getArbiterRank() }}</td>

						@auth('player')
							@if(Auth::guard('player')->user()->email == $tournament->email)
								<td>
									<form class="form-inline d-flex justify-content-center" method="POST" action="/turnir/{{$tournament->id}}/ukloniSudiju">
										@csrf
										<input type="hidden" name="arbiter_id" value="{{$arbiter->id}}">
										<input type="submit" class="btn btn-danger" value="-">
									</form>
								</td>
							@endif
						@endauth

						@auth('club')
							@if(Auth::guard('club')->user()->email == $tournament->email)
								<td>
									<form class="form-inline d-flex justify-content-center" method="POST" action="/turnir/{{$tournament->id}}/ukloniSudiju">
										@csrf
										<input type="hidden" name="arbiter_id" value="{{$arbiter->id}}">
										<input type="submit" class="btn btn-danger" value="-">
									</form>
								</td>
							@endif
						@endauth

						@auth('admin')
							@if(Auth::guard('admin')->user()->email == $tournament->email)
								<td>
									<form class="form-inline d-flex justify-content-center" method="POST" action="/turnir/{{$tournament->id}}/ukloniSudiju">
										@csrf
										<input type="hidden" name="arbiter_id" value="{{$arbiter->id}}">
										<input type="submit" class="btn btn-danger" value="-">
									</form>
								</td>
							@endif
						@endauth
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection