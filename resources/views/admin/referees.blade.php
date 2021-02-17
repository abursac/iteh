@extends('master')

@section('title', 'Dodavanje takmicenja')

@section('content')

<h1>Prikaz sudija</h1>

<div class="row">
    <table class="table table-hover col-xl-8 mt-5">
        <thead class="thead-dark">
        <tbody>
            @foreach($players as $player)
            <tr>
                @if($player->isArbiter())
                <td>{{ $player->surname }}</td>
                <td>{{ $player->name }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection