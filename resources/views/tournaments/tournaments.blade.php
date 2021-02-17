@extends('master')
@section('title','Turniri')
@section('content')
	<h1> Turniri </h1>
	<a href="/turnir/dodaj" class="btn btn-primary mb-2">Novi turnir</a>

	<div class="row">
		<div class="col-xl-4">
			<div class="card">
				<article class="card-group-item">
					<header class="card-header">
						<h6 class="title">Naziv </h6>
					</header>
					<div class="filter-content">
						<div class="card-body">
						<input type="text" class="form-control">

						</div>
					</div>
				</article>

				<article class="card-group-item">
					<header class="card-header">
						<h6 class="title">Mesto odrzavanja </h6>
					</header>
					<div class="filter-content">
						<div class="card-body">
						<input type="text" class="form-control">

						</div>
					</div>
				</article>

				<article class="card-group-item">
					<header class="card-header">
						<h6 class="title">Broj kola</h6>
					</header>
					<div class="filter-content">
						<div class="card-body">
						<input type="number" class="form-control">

						</div> 
				</article>

				<article class="card-group-item">
				<header class="card-header">
					<h6 class="title">Vreme odrzavanja</h6>
				</header>
				<div class="filter-content">
					<div class="card-body">
					<div class="form-row">
						<div class="form-group col-md-6">
						<label>Od</label>
						<input type="date" class="form-control">
						</div>
						<div class="form-group col-md-6 text-right">
						<label>Do</label>
						<input type="date" class="form-control">
						</div>
					</div>
					</div>
				</div>
				</article>
			</div>
		</div>


		<table class="table table-hover col-xl-8">
			<thead class="thead-dark">
				<tr>
				<th scope="col">#</th>
				<th scope="col">Naziv</th>
				<th scope="col">Datum pocetka</th>
				<th scope="col" class="igrac">Vise</th>

				@auth('player') 
					<th scope="col" class="igrac">Prijava</th>
				@endauth 

				@auth('club')
					<th scope="col" class="igrac">Prijava</th>
				@endauth
				
				</tr>
			</thead>
			<tbody>
				@foreach($tournaments as $tournament)
				<tr>
					<th scope="row">{{ $loop->index + 1 }}</th>
					<td>{{ $tournament->name }}</td>

					@php
					$date = strtotime($tournament->start_date); 
					$new_date = date('d.m.Y.', $date);
					@endphp
					<td>{{ $new_date }}</td>

					<td class="igrac"><a class="btn btn-primary" href="/turnir/{{ $tournament->id }}">+</a></td>

					@if(Auth::guard('player')->check() && $tournament->type == 'player' && 
						!$tournament->isPlayerParticipating(Auth::guard('player')->user()->id))
					<td>
						<form action="/turnir/{{$tournament->id}}/prijavaIgraca/{{Auth::guard('player')->user()->id}}" method="POST">
							@csrf
							<input type="submit" value="+" class="btn btn-primary"/>
						</form>
					</td>
					@elseif(Auth::guard('club')->check() && $tournament->type == 'club' &&
							!$tournament->isClubParticipating(Auth::guard('club')->user()->id))
					<td>
						<form action="/turnir/{{$tournament->id}}/prijavaKluba/{{Auth::guard('club')->user()->id}}" method="POST">
							@csrf
							<input type="submit" value="+" class="btn btn-primary"/>
						</form>
					</td>
					@elseif(Auth::guard('club')->check() && $tournament->type == 'player' ||
							Auth::guard('player')->check() && $tournament->type == 'club')
					<td>
						<button class="btn btn-primary disabled">+</button>
					</td>
					@elseif(Auth::guard('club')->check() && $tournament->type == 'club' &&
							$tournament->isClubParticipating(Auth::guard('club')->user()->id))
					<td>
						<form action="/turnir/{{$tournament->id}}/prijavaIgraca/{{Auth::guard('club')->user()->id}}" method="POST">
							@csrf
							<input type="submit" value="-" class="btn btn-danger"/>
						</form>
					</td>
					@elseif(Auth::guard('player')->check() && $tournament->type == 'player' &&
							$tournament->isPlayerParticipating(Auth::guard('player')->user()->id))
					<td>
						<form action="/turnir/{{$tournament->id}}/prijavaIgraca/{{Auth::guard('player')->user()->id}}" method="POST">
							@csrf
							<input type="submit" value="-" class="btn btn-danger"/>
						</form>
					</td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection