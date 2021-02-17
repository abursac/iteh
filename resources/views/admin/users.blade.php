@extends('master')

@section('title', 'Dodavanje takmicenja')

@section('content')

@auth('admin')
<h1>Razmatranje zahteva za registraciju igraca</h1>
<div class="row">
    <table class="table table-hover col-xl-8 mt-5">
        <thead class="thead-dark">
        <tbody>
            @foreach($users as $user)
            @if($user->confirmed == 0)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->surname }}</td>
                <td><a class="btn-btn primary" href="/korisnici/{{$user->id}}" role="button">Razmotri zahtev</a></td>  
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endauth

@endsection