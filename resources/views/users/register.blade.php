@extends('master')
@section('title', 'Registracija')

@section('content')


	<ul class="nav nav-tabs nav-fill mt-3" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#igrac" role="tab"
				aria-controls="igrac" aria-selected="true">Igrac</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#klub" role="tab"
				aria-controls="igrac" aria-selected="false">Klub</a>
		</li>
	</ul>
	<div class="tab-content" id="myTabContent">

		<!-- Igrac TAB -->
		<div class="tab-pane fade show active p-5" id="igrac" role="tabpanel" aria-labelledby="igrac-tab">
			<div class="container-fluid mt-1 ml-5">
				<h1 class="h1">Registracija igraca</h1>
				<div class="row">
					<form class="col-8" action="/korisnici/registracija" method="POST">
						@csrf	
						<div class="form-group">
							<label for="name" class="label-form">Ime</label>
							<input type="text" class="form-control" name="name" required/>
							@error('name')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group">
							<label for="name" class="label-form">Prezime</label>
							<input type="text" class="form-control" name="surname" required/>
							@error('surname')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group">
							<label for="gender" class="label-form">Pol</label>
							<select type="text" class="form-control" name="gender" required>
								<option value="Muski">Muski</option>
								<option value="Zenski">Zenski</option>
							</select>
							@error('gender')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group">
							<label for="birth_date" class="label-form">Datum rodjenja</label>
							<input type="date" class="form-control" name="birth_date" required/>
							@error('birth_date')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group">
							<label for="email" class="label-form">Email</label>
							<input type="email" class="form-control" name="email" required/>
							@error('email')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="password" class="label-form">Lozinka</label>
							<input type="password" class="form-control" name="password" required/>
							@error('password')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group">
							<label for="confirmPassword" class="label-form">Potvrda lozinke</label>
							<input type="password" class="form-control" name="confirmPassword" required/>
							@error('confirmPassword')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group">
							<input type="submit" value="Registracija" class="btn btn-primary"/>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Klub tab -->
		<div class="tab-pane fade p-5" id="klub" role="tabpanel" aria-labelledby="klub-tab">
			<div class="container-fluid mt-1 ml-5">
				<h1 class="h1">Registracija kluba</h1>
				<div class="row">
					<form class="col-xl-8" action='/klub/dodaj' method="POST">
						
						@csrf
						<div class="form-group">
							<label class="label-form">Naziv</label>
							<input type="text" class="form-control" name='name'>
							@error('name')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group">
							<label class="label-form">Email</label>
							<input type="email" class="form-control" name='email'>
							@error('email')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>						

						<div class="form-group">
							<label class="label-form">Datum osnivanja</label>
							<input type="date" class="form-control" name='founded'>
							@error('date')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group">
							<label class="label-form">Adresa</label>
							<input type="text" class="form-control" name='address'>
							@error('address')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group">
							<label class="label-form">Telefon</label>
							<input type="phone" class="form-control" name='phone'>
							@error('phone')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="password" class="label-form">Lozinka</label>
							<input type="password" class="form-control" name="password" required/>
							@error('password')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group">
							<label for="confirmPassword" class="label-form">Potvrda lozinke</label>
							<input type="password" class="form-control" name="confirmPassword" required/>
							@error('confirmPassword')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Potvrdi">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


@endsection