@extends('master')

@section('title', 'Adminov profil')

@section('content')

@auth('admin')
<form action="/promenaEmaila" method="POST">
    @csrf
    <div class="form-group">
    <div class="col-xs-6">
        <label>
            <h4>E-mail</h4>
        </label>
        <div class="alert alert-info">
            <input type="hidden" name="a_id" value="{{$admin->id}}">
            <input type="text" class="form-control" value="{{$admin->email}}" name="email" required>
            <input type="submit" class="btn btn-primary mt-2" value="Promeni email">
        </div>
    </div>
    </div>
</form>
<h2 class="mt-5" align="center">Promena lozinke</h2>
<div class="container w-75 text-center">
    <form action="/promenaLozinke" method="POST">
        @csrf
        <input type="hidden" name="admin_id" value="{{$admin->id}}"> 
        <!-- Stara lozinka -->
        <input type="password" class="form-control mt-2" name="old_pass" placeholder="Stara lozinka" required>
        
        <!-- Nova lozinka -->
        <input type="password" class="form-control mt-2" name="new_pass"  placeholder="Nova lozinka" required>
              
        <!-- Nova lozinka portvrda-->
        <input type="password" class="form-control mt-2" name="new_pass_2" placeholder="Potvrda lozinke" required>
        
        <input type="submit" class="btn btn-primary mt-2" value="Promeni lozinku">
    </form>
</div>

@error('error')
    <div class="alert alert-danger alert-dismissible fade show mt-3">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{$message}}
    </div>
@enderror

@error('success')
<div class="alert alert-success alert-dismissible fade show mt-3">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{$message}}
</div>
@enderror
@endauth

@endsection