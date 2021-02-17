@extends('master')

@section('title', 'Dodavanje takmicenja')

@section('content')

<script>

function typeSelected(value)
{
	if(value == "club")
	{
		document.getElementById("playersPerClub").style.display = "block";
	}
	else
	{
		document.getElementById("playersPerClub").style.display = "none";
	}
}
</script>

<h1>Dodavanje takmicenja</h1>
<div class="row">
	<form class="col-xl-8" action='/turnir/dodaj' method="POST">
		
		@csrf
		<div class="form-group">
			<label class="label-form">Naziv</label>
			<input type="text" class="form-control" name='name'>
			@error('name')
			<span class="text-danger">{{$message}}</span>
			@enderror
		</div>

		<div class="form-group">
			<label class="label-form">Tip turnira:</label>
			<select class="form-control" name="type" onchange="typeSelected(this.value)">
				<option value="club">Ekipno</option>
				<option value="player">Pojedinacno</option>
			</select>
		</div>

		<div class="form-group" id="playersPerClub">
			<label class="label-form">Broj igraca po klubu:</label>
			<input type="number" class="form-control" name="playersPerClub">
		</div>

		<div class="form-group">
			<label class="label-form">Broj kola</label>
			<input type="number" class="form-control" name='rounds'>
		</div>

		<div class="form-group">
			<label class="label-form">Mesto</label>
			<input type="text" class="form-control" name='place'>
		</div>

		<div class="form-group">
			<label class="label-form">Datum pocetka</label>
			<input type="date" class="form-control" name='start_date'>
			@error('start_date')
			<span class="text-danger">{{$message}}</span>
			@enderror
		</div>

		<div class="form-group">
			<label class="label-form">Datum kraja</label>
			<input type="date" class="form-control" name='end_date'>
		</div>

		<div class="form-group">
			<label class="label-form">Vreme</label>
			<input type="time" class="form-control" name='time'>
		</div>

		<div class="form-group">
			<label class="label-form">Telefon</label>
			<input type="phone" class="form-control" name='phone'>
		</div>

		<div class="form-group">
			<label class="label-form">E-mail</label>
			<input type="email" class="form-control" name='email'>
		</div>

		<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Potvrdi">
		</div>
	</form>
</div>

@endsection