@extends('master')
@section('title', 'Dodavanje igraca')

@section('content')
<h1>Dodavanje igraca</h1>
<div class="row ml-3">
	<form class="col-4" action='/igrac/dodaj' method="POST">
		@csrf
		<input type="hidden" value="@if(isset($player)){{ $player->id }}@endif" name='id'>
        <div class="form-group">
			<label class="label-form">Ime</label>
		<input type="text" class="form-control" name='name' value="@if(isset($player)){{ $player->name }} @endif" required>
        </div>
        <div class="form-group">
			<label class="label-form">Prezime</label>
			<input type="text" class="form-control" name='surname' value="@if(isset($player)){{ $player->surname }}@endif" required>
        </div>
		<div class="form-group">
			<label for="gender" class="label-form">Pol</label>
			<select type="text" class="form-control" name="gender" required>
				<option value="Musko">Musko</option>
				<option value="Zensko">Zensko</option>
			</select>
        </div>
		<div class="form-group">
			<label class="label-form">Datum rodjenja</label>
			<input type="date" class="form-control" name='birth_date' value="@if(isset($player)){{ $player->birth_date }}@endif" required>
        </div>
        <div class="form-group">
			<label class="label-form">Email</label>
			<input type="email" class="form-control" name='email' value="@if(isset($player)){{ $player->email }}@endif" required>
        </div>
		<div class="form-group">
			<label class="label-form">Rejting</label>
			<input type="text" class="form-control" name='rating' value="@if(isset($player)){{ $player->rating }}@endif" required>
        </div>
        <div class="form-group">
			<label class="label-form">Lozinka</label>
			<input type="password" class="form-control" name='password' value="@if(isset($player)){{ $player->password }}@endif" required>
        </div>

        <div class="form-group">
		<input type="submit" class="btn btn-primary" value="@if(!isset($player)) {{'Dodaj'}} @else {{'Izmeni'}} @endif">
		</div>
    </form>
@endsection