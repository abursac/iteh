@extends('master')

@section('title', 'Dodavanje takmicenja')

@section('content')

<h1>Prelazni rokovi</h1>

<div class="row">
<table class="table table-hover col-xl-8 mt-5">
    <thead class="thead-dark">
    <tbody>        
        @foreach($deadlines as $deadline)
        <tr>
            <td>{{ $deadline->start }}</td>
            <td>{{ $deadline->end }}</td>
            <td>{{ $deadline->deadlineTypes()->first()->tip }}
        </tr>
        @endforeach
    </tbody>
</table>
</div>

@endsection
    