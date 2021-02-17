@extends('master')
@section('title','Igraci kluba')
@section('content')

@if ($players->count() == 0)
    <h4 class="mt-5" align="center">Trenutno nemate registrovanih igraca.</h4>
@else 
    <table class="table col-sm-9">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Ime</th>
            <th scope="col">Prezime</th>
            <th scope="col">Rejting</th>
            <th scope="col">Vise</th>
        </tr>
        </thead>
        <tbody id = "igraci_tabla">
            @foreach ($players as $player)
            <tr>
                    <td class = "col-xl-1">{{$loop->index + 1}}</td> 
                    <td class = "col-xl-3">{{$player->name}}</td>  
                    <td class = "col-xl-3">{{$player->surname}}</td>  
                    <td class = "col-xl-2">{{$player->rating}}</td>  
                    <td class = "col-xl-1"><a class="btn btn-primary" href="/igrac/{{ $player->id }}">+</a></td> 
                </tr>
            @endforeach
            
            <tr>
                <td colspan="5">
                <ul class="pagination justify-content-center">
                @for($i = 1; $i< $broj_stranica + 1;$i++)
                    <li class="page-item"><button class="page-link"  onclick="prikazi_igrace({{$i}})">{{$i}}</button></li>
                @endfor
                </ul>
                </td>
            </tr>
        </tbody>
    </table>
@endif

@endsection