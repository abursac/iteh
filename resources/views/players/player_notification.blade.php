@extends('master')
@section('title','Obavestenja')
@section('content')


<h1> Vasa Obavestenja</h1>
<br><br>
@foreach($obavestenja as $obavestenje)

@php
    $klub = DB::table('clubs')->where('id','=',$obavestenje->club_id)->first();
@endphp    

@if($obavestenje->status == 'declined')
<div class="alert alert-warning" role="alert">
    <div class = "row">
        <div class = "col-sm-8">
            Klub "{{$klub->name}}" je odbio Vas zahtev da se uclanite. &nbsp;
        </div>
        <div class = "col-sm-1">
            <form action="/igrac/ukloniZahtev" method="POST" class="form-inline">
                @csrf
                <input type="hidden" name="player_id" value="{{$obavestenje->player_id}}"> 
                <input type="hidden" name="club_id" value="{{$obavestenje->club_id}}"> 
                <input type="submit" class="btn btn-primary" value="X">
            </form>
        </div>
        <div class = "col-sm-1">
            <a href="/klub/{{$klub->id}}" class="btn btn-info">Info</a>
        </div>
    </div>
</div>
@elseif($obavestenje->status == 'accepted')
<div class="alert alert-success" role="alert">
    <div class = "row">
        <div class = "col-sm-8">
            Klub "{{$klub->name}}" je prihvatio vas zahtev! &nbsp;
        </div>
        <div class = "col-sm-1">
            <form action="/igrac/ukloniZahtev" method="POST" class="form-inline">
                @csrf
                <input type="hidden" name="player_id" value="{{$obavestenje->player_id}}"> 
                <input type="hidden" name="club_id" value="{{$obavestenje->club_id}}"> 
                <input type="submit" class="btn btn-primary" value="X">
            </form>
        </div>
        <div class = "col-sm-1">
            <a href="/klub/{{$klub->id}}" class="btn btn-info">Info</a>
        </div>
    </div>
</div>
@elseif($obavestenje->expiry_date >= date('Y-m-d'))
<div class="alert alert-info" role="alert">
    <div class = "row">
        <div class = "col-sm-8">
            Klub "{{$klub->name}}" Vas je pozvao da se uclanite u klub!
        </div>
        <div class = "col-sm-1">
            <form action="/igrac/prihvatiZahtev" method="POST" class="form-inline">
                @csrf
                <input type="hidden" name="player_id" value="{{$obavestenje->player_id}}"> 
                <input type="hidden" name="club_id" value="{{$obavestenje->club_id}}"> 
                <input type="submit" class="btn btn-success" value="Prihvati">
            </form>
        </div>
        <div class = "col-sm-1">
            <form action="/igrac/odbijZahtev" method="POST" class="form-inline">
                @csrf
                <input type="hidden" name="player_id" value="{{$obavestenje->player_id}}"> 
                <input type="hidden" name="club_id" value="{{$obavestenje->club_id}}"> 
                <input type="submit" class="btn btn-danger" value="Odbij">
            </form>
        </div>
        <div class = "col-sm-1">
            <a href="/klub/{{$klub->id}}" class="btn btn-info">Info</a>
        </div>
    </div>
</div>
@else 
<div class="alert alert-info" role="alert">
    <div class = "row">
        <div class = "col-sm-8">
            Klub "{{$klub->name}}" Vas je pozvao da se uclanite, medjutim poziv je istekao datuma {{$obavestenje->expiry_date}}. &nbsp;
        </div>
        <div class = "col-sm-2">
            <form action="/igrac/ukloniZahtev" method="POST" class="form-inline">
                @csrf
                <input type="hidden" name="player_id" value="{{$obavestenje->player_id}}"> 
                <input type="hidden" name="club_id" value="{{$obavestenje->club_id}}"> 
                <input type="submit" class="btn btn-primary" value="X">
            </form>
        </div>
    </div>
</div>
@endif

@endforeach


@endsection