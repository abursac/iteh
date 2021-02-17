@extends('master')
@section('title','Igraci')
@section('content')

@auth('admin')
<h1>Unapredjivanje igraca u sudiju</h1>
<table class="table table-hover col-xl-8">
    <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Ime</th>
          <th scope="col">Prezime</th>
          <th scope="col">Rejting</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td> - </td>           
            <td>{{ $player->name }}</td>
            <td>{{ $player->surname }}</td>
            <td>{{ $player->rating }}</td>
        <td><form class="col-xl-8" action='/igrac/sudija/{{$player->id}}' method="POST">

                @csrf
                <div class="form-group">
                    <label class="label-form">Rang sudije:</label>
                    <select class="form-control" name="rang">
                        @foreach($arbiterRanks as $arbiterRank)
                        <option value="{{$arbiterRank->id}}">{{$arbiterRank->name}}</option>
                        @endforeach
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
@endauth

@endsection