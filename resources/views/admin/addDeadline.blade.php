@extends('master')

@section('title', 'Dodavanje takmicenja')

@section('content')

@auth('admin')
<h1>Dodavanje prelaznog roka</h1>
<div class="row">
    <form class="col-xl-8" action='/dodajRok' method="POST">

        @csrf
        <div class="form-group">
            <label class="label-form">Datum pocetka</label>
            <input type="date" class="form-control" name='start'>
        </div>

        <div class="form-group">
            <label class="label-form">Datum zavrsetka</label>
            <input type="date" class="form-control" name='end'>
        </div>

        <div>
            <label class="label-form">Tip roka:</label>
			<select class="form-control" name="tip">
                @foreach($deadlineTypes as $dT)
                    <option value="{{ $dT->id }}">{{ $dT->tip }}</option>
                @endforeach
		    </select>
        </div>

        <div class="form-group">
			<input type="submit" class="btn btn-primary" value="Potvrdi">
		</div>
    </form>
</div>
@endauth

@endsection