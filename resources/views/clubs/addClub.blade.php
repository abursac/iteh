@extends('master')
@section('title', 'Dodavanje kluba')
@section('content')

<h1>Dodavanje kluba</h1>
<div class="row">
	<form class="col-xl-8" action='/klub/dodaj' method="POST">
		
		@csrf
		<input type="hidden" value="@if(isset($club)){{ $club->id }}@endif" name='id'>
		<div class="form-group">
			<label class="label-form">Naziv</label>
			<input type="text" class="form-control" name='name' value="@if(isset($club)){{ $club->name }} @endif" required>
		</div>

		<div class="form-group">
			<label class="label-form">Email</label>
            <input type="text" class="form-control" name='email' value="@if(isset($club)){{ $club->email }} @endif" required>
		</div>

		<div class="form-group">
			<label class="label-form">Lozinka</label>
			<input type="password" class="form-control" name='password' value="@if(isset($club)){{ $club->password }} @endif" required>
		</div>

		<div class="form-group">
			<label class="label-form">Founded</label>
			<input type="date" class="form-control" name='founded' value="@if(isset($club)){{ $club->founded }} @endif" required>
		</div>

		<div class="form-group">
			<label class="label-form">Adresa</label>
			<input type="text" class="form-control" name='address' value="@if(isset($club)){{ $club->address }} @endif" required>
		</div>

		<div class="form-group">
			<label class="label-form">Telefon</label>
			<input type="phone" class="form-control" name='phone' value="@if(isset($club)){{ $club->phone }} @endif" required>
		</div>

		<div class="form-group">
			<input type="submit" class="btn btn-primary" value="@if(!isset($club)) {{'Dodaj'}} @else {{'Izmeni'}} @endif">
		</div>
	</form>
</div>
@endsection