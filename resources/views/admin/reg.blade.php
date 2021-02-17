@extends('master')

@section('title', 'Dodavanje takmicenja')

@section('content')

@auth('admin')
<h1>Zahtev za registraciju igraca</h1>
<div class="row">
    <table class="table table-hover col-xl-8 mt-5">
        <thead class="thead-dark">
        <tbody>
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->surname }}</td>
                <td>
                    <form class="col-xl-8" action='/korisnici/{{$user->id}}' method="POST">

                        @csrf
                        <div class="form-group">
                            <label class="label-form">Rejting:</label>
                            <input type="text" class="form-control" name='rating' value="0">
                        </div>

                        <div class="form-group">
                            <label class="label-form">Zeljena akcija:</label>
                            <select class="form-control" name="confirm">
                                <option value="0">-</option>
                                <option value="2">Odbij</option>
                                <option value="1">Prihvati</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Potvrdi">
                        </div>
                    </form>
                </td> 
            </tr>
        </tbody>
    </table>
</div>
@endauth

@endsection