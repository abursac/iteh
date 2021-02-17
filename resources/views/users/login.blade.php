@extends('master')

@section('title', 'Prijava')

@section('content')

<div class="container">
	<h1>Prijava</h1>
<div class="row">
	<form class="col-6" action="/korisnici/login" method="POST">
		@csrf

		@error('login')
		<span class="text-danger">{{ $message }}</span>
		@enderror

		<div class="form-group">
			<label for="email" class="label-form">Email</label>
			<input type="email" class="form-control" id="email" name="email"/>
		</div>

		<div class="form-group">
			<label for="password" class="label-form">Lozinka</label>
			<input type="password" class="form-control" id="password" name="password"/>
		</div>

		<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Prijavite se">
		</div>
	</form>
</div>
</div>

@endsection