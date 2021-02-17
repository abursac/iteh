@extends('master')
@section('title','Informacije o igracu')
@section('content')


<div class="container-fluid mt-1 ml-5">
    <div id="igrac-profil">
        <div class="row">
            <div class="col-sm-3 mt-4">
                <div class="text-center">
                    @if($player->image == null)
                    <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" style="width: 500px"
                        class="avatar img-circle img-thumbnail" alt="avatar">
                    @else
                        @php
                            $image = base64_encode( $player->image);
                        @endphp
                        <img src="data:image/jpeg;base64,{{$image}}" style="width: 500px "class="avatar img-circle img-thumbnail"alt="avatar"/>
                    @endif
                    <div class="col-sm-12">
                        <h1>{{$player->name}} {{$player->surname}}</h1>
                    </div>
                </div>
                @auth('player')
                @if(Auth::guard('player')->user()->id == $player->id)
                <form action="/igrac/slika" method="POST" enctype="multipart/form-data">   
                @csrf               
                    <div class="input-group mb-3">
                        <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" accept=".jpg,.png,.jpeg" name="image" required>
                        <label class="custom-file-label" for="inputGroupFile01">Izaberite fajl</label>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{Auth::user()->id}}">
                    <input type="submit" class="btn btn-primary" value="Promeni sliku">
                </form>

                @endif
                @endauth
                <hr>
                <a href="/igrac" class="badge badge-primary"> < Nazad</a>
            </div>
            <div class="col-sm-4 mt-4">
            <form action="/igrac/dodaj" method="POST">
            @csrf
                <div class="tab-content">
                    @auth('player')
                    @if(Auth::guard('player')->user()->id == $player->id)
                        <input type="hidden" name="id" value="{{Auth::user()->id}}">
                    @endif
                    @endauth
                    <div class="tab-pane active" id="home">

                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="first_name">
                                        <h4>Ime</h4>
                                    </label>
                                    <div class="alert alert-info" for="first_name">
                                        @auth('player')
                                        @if(Auth::user()->id == $player->id)
                                            <input type="text" class="form-control" value="{{$player->name}}" name="name" required>
                                        @else
                                            <h5>{{$player->name}}</h5>
                                        @endif
                                        @endauth

                                        @guest('player')
                                            <h5>{{$player->name}}</h5>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="last_name">
                                        <h4>Prezime</h4>
                                    </label>
                                    <div class="alert alert-info" for="last_name">
                                        @auth('player')
                                        @if(Auth::user()->id == $player->id)
                                            <input type="text" class="form-control" value="{{$player->surname}}" name="surname" required>
                                        @else
                                            <h5>{{$player->surname}}</h5>
                                        @endif
                                        @endauth

                                        @guest('player') 
                                            <h5>{{$player->surname}}</h5>
                                        @endguest
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="email">
                                        <h4>E-mail</h4>
                                    </label>
                                    <div class="alert alert-info" for="last_name">
                                        @auth('player')
                                        @if(Auth::user()->id == $player->id)
                                            <input type="text" class="form-control" value="{{$player->email}}" name="email" required>
                                        @else
                                            <h5>{{$player->email}}</h5>
                                        @endif
                                        @endauth

                                        @guest('player')
                                            <h5>{{$player->email}}</h5>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 ml-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="home">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <p>
                                    <h4>Pol</h4>
                                </p>

                                <div class="alert alert-info" for="last_name">
                                    @auth('player')
                                    @if(Auth::user()->id == $player->id)
                                        <select class="form-control" name="gender" required>
                                            <option value="{{$player->gender}}" selected>{{$player->gender}}</option>
                                            <option value="Musko">Musko</option>
                                            <option value="Zensko">Zensko</option>
                                        </select>
                                    @else
                                        <h5>{{$player->gender}}</h5>
                                    @endif
                                    @endauth

                                    @guest('player')
                                        <h5>{{$player->gender}}</h5>
                                    @endguest

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="datum_rodjenja">
                                    <h4>Datum rodjenja</h4>
                                </label>
                                <br>
                                <div class="alert alert-info" for="last_name">
                                    @auth('player')
                                    @if(Auth::user()->id == $player->id)
                                        <input type="date" class="form-control" value="{{$player->birth_date}}" name="birth_date" required>
                                    @else
                                        <h5>{{$player->birth_date}}</h5>
                                    @endif
                                    @endauth

                                    @guest('player')
                                        <h5>{{$player->birth_date}}</h5>
                                    @endguest
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="datum_rodjenja">
                                    <h4>Klubovi</h4>
                                </label>
                                <div class="alert alert-info"> 
                                    @php
                                    $ime_kluba = "";
                                    $veze = DB::table('club_player')->where('player_id','=',$player->id)->get();
                                    if(count($veze) == 0)
                                    {
                                        echo "<p>Igrac nije uclanjen ni u jedan klub.</p>";
                                    } 
                                    else 
                                    {
                                        foreach($veze as $veza)
                                        {
                                            $klub = DB::table('clubs')->where('id','=',$veza->club_id)->first();
                                            if($klub == null)
                                            {
                                                echo "<p>Greska</p>";
                                            }
                                            else 
                                            {
                                                echo "<p>".$klub->name." : </p>";
                                                if($veza->left != null)
                                                    echo "<p>".$veza->joined." <-> ".$veza->left."</p>";
                                                else
                                                    echo "<p>".$veza->joined." <-> danas</p>";
                                            }
                                        }
                                    }

                                    @endphp
                                </div>
                            </div>
                        </div>
                        
                        @auth('player')
                        @if(Auth::user()->id == $player->id)
                        <div class="form-group">
                            <div class="col-xs-6">
                                <input type="submit" class="btn btn-primary" value="Azuriraj podatke">
                            </div>
                        </div>
                        @endif
                        @endauth
                </form>
                        @auth('club')
                        <div class="form-group">
                            <div class="col-xs-6">
                                @php
                                    $in_club = false;
                                    $igrac = null;
                                    $veze =  DB::table('club_player')->where('club_id','=',Auth::guard('club')->user()->id)->get();
                                    foreach($veze as $veza)
                                    {
                                        if($veza->left == null)
                                            $in_club = true;
                                    }
                                    if($in_club == true) 
                                        $igrac = DB::table('players')->where('id','=',$veza->player_id)->first();
                                @endphp

                                @if($igrac != null && $player->id == $igrac->id)
                                    <form action="/klub/dajOtkazIgracu" method="POST">
                                        @csrf
                                        <input type="hidden" name="club_id" value="{{Auth::guard('club')->user()->id}}">
                                        <input type="hidden" name="player_id" value="{{$player->id}}" >
                                        <input type="submit" class="btn btn-primary text-white" value="Otpusti igraca">
                                    </form>
                                @else
                                    <form action="/klub/posaljiZahtevIgracu" method="POST">
                                        @csrf
                                        <input type="hidden" name="club_id" value="{{Auth::guard('club')->user()->id}}">
                                        <input type="hidden" name="player_id" value="{{$player->id}}" >
                                        <input type="submit" class="btn btn-primary text-white" value="Posalji zahtev za uclanjenje">
                                    </form>
                                @endif
                            </div>
                        </div>
                        @endauth
                        
                        @auth('admin')
                        <div class="form-group">
                            <div class="col-xs-6">
                                <a href="/igrac/sudija/{{$player->id}}" class="btn btn-success text-white">Unapredi u sudiju</a>
                            </div>
                        </div>
                        @endauth
                    </div>

                </div>
            </div>
    
        </div>
    </div>

    @auth('player')
    @if(Auth::user()->id == $player->id)
    <h2 class="mt-5" align="center">Promena lozinke</h2>
    <div class="container w-75 text-center">
        <form action="/igrac/promena_lozinke" method="POST">
            @csrf
            <input type="hidden" name="player_id" value="{{$player->id}}"> 
            <!-- Stara lozinka -->
            <input type="password" class="form-control mt-2" name="old_pass" placeholder="Stara lozinka" required>
            
            <!-- Nova lozinka -->
            <input type="password" class="form-control mt-2" name="new_pass"  placeholder="Nova lozinka" required>
                  
            <!-- Nova lozinka portvrda-->
            <input type="password" class="form-control mt-2" name="new_pass_2" placeholder="Potvrda lozinke" required>
            
            <input type="submit" class="btn btn-primary mt-2" value="Promeni lozinku">
        </form>
    </div>
    @endif
    @endauth
     
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

<script>
  $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });
</script>

@endsection