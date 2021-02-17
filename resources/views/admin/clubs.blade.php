@extends('master')

@section('title', 'Dodavanje takmicenja')

@section('content')

@auth('admin')
<h1>Razmatranje zahteva za registraciju klubova</h1>
<div class="row">
    <table class="table table-hover col-xl-8 mt-5">
        <thead class="thead-dark">
        <tbody>
            @foreach($clubs as $club)
            @if($club->confirmed == 0)
            <tr>
                <td>{{ $club->name }}</td>
                <td>{{ $club->address }}</td>
                <td><a class="btn-btn primary" href="/klubovi/{{$club->id}}" role="button">Razmotri zahtev</a></td>  
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endauth

@endsection