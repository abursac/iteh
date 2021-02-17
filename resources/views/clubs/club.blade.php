@extends('master')
@section('title','Informacije o klubu')
@section('content')


<div class="container-fluid mt-1 ml-5">
    <div id="klub-profil">
        <div class="row">
            <div class="col-sm-3">

                <div class="text-center">
                    @if($club->image == null)
                    <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" style="width: 500px"
                        class="avatar img-circle img-thumbnail" alt="avatar">
                    @else
                        @php
                            $image = base64_encode( $club->image);
                        @endphp
                        <img src="data:image/jpeg;base64,{{$image}}" style="width: 500px "class="avatar img-circle img-thumbnail"alt="avatar"/>
                    @endif
                    <div class="col-sm-12">
                        <h1>{{$club->name}}</h1>
                    </div>
                </div>
                @auth('club')
                @if(Auth::guard('club')->user()->id == $club->id)
                <form action="/klub/slika" method="POST" enctype="multipart/form-data">   
                @csrf               
                    <div class="input-group mb-3">
                        <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" accept=".jpg,.png,.jpeg" name="image" required>
                        <label class="custom-file-label" for="inputGroupFile01">Izaberite fajl</label>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{$club->id}}">
                    <input type="submit" class="btn btn-primary" value="Promeni sliku">
                </form>

                @endif
                @endauth

                <hr>
                <a href="/klub" class="badge badge-primary"> < Nazad</a>
            </div>
            <div class="col-sm-4">
            <form action="/klub/dodaj" method="POST">
            @csrf
                <div class="tab-content">
                    @auth('club')
                    @if(Auth::guard('club')->user()->id == $club->id)
                    <input type="hidden" name="id" value="{{Auth::guard('club')->user()->id}}">
                    @endif
                @endauth
                    <div class="tab-pane active" id="home">
                    
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="name">
                                        <h4>Naziv</h4>
                                    </label>
                                    <div class="alert alert-info" for="name">
                                        @auth('club')
                                        @if(Auth::guard('club')->user()->id == $club->id)
                                            <input type="text" class="form-control" value="{{$club->name}}" name="name" required>
                                        @else
                                            <h5>{{$club->name}}</h5>
                                        @endif
                                        @endauth

                                        @guest('club')
                                            <h5>{{$club->name}}</h5>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="email">
                                        <h4>E-mail</h4>
                                    </label>
                                    <div class="alert alert-info" for="email">
                                        @auth('club')
                                        @if(Auth::guard('club')->user()->id == $club->id)
                                            <input type="text" class="form-control" value="{{$club->email}}" name="email" required>
                                        @else
                                            <h5>{{$club->email}}</h5>
                                        @endif
                                        @endauth

                                        @guest('club')
                                            <h5>{{$club->email}}</h5>
                                        @endguest
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="address">
                                        <h4>Adresa</h4>
                                    </label>
                                    <div class="alert alert-info" for="address">
                                        @auth('club')
                                        @if(Auth::guard('club')->user()->id == $club->id)
                                            <input type="text" class="form-control" value="{{$club->address}}" name="address" required>
                                        @else
                                            <h5>{{$club->address}}</h5>
                                        @endif
                                        @endauth

                                        @guest('club')
                                            <h5>{{$club->address}}</h5>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="phone">
                                        <h4>Telefon</h4>
                                    </label>
                                    <div class="alert alert-info" for="phone">
                                        @auth('club')
                                        @if(Auth::guard('club')->user()->id == $club->id)
                                            <input type="text" class="form-control" value="{{$club->phone}}" name="phone" required>
                                        @else
                                            <h5>{{$club->phone}}</h5>
                                        @endif
                                        @endauth

                                        @guest('club')
                                            <h5>{{$club->phone}}</h5>
                                        @endguest
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="founded">
                                        <h4>Datum osnivanja </h4>
                                    </label>
                                    <br>
                                    <div class="alert alert-info" for="founded"><label id="founded" name="founded">
                                        @auth('club')
                                            @if(Auth::guard('club')->user()->id == $club->id)
                                                <input type="date" class="form-control" value="{{$club->founded}}" name="founded" required>
                                            @else
                                                <h5>{{$club->founded}}</h5>
                                            @endif
                                            @endauth

                                            @guest('club')
                                                <h5>{{$club->founded}}</h5>
                                            @endguest
                                    </label></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="founded">
                                        <h4> Opstina </h4>
                                    </label>
                                    <br>
                                    <div class="alert alert-info" for="municipality"><label id="municipality" name="municipality">
                                        @auth('club')
                                            @if(Auth::guard('club')->user()->id == $club->id)
                                                <input type="text" class="form-control" value="{{$club->municipality}}" name="municipality" required>
                                            @else
                                                <h5>{{$club->municipality}}</h5>
                                            @endif
                                            @endauth

                                            @guest('club')
                                                <h5>{{$club->municipality}}</h5>
                                            @endguest
                                    </label></div>
                                </div>
                            </div>

                            @auth('club')
                            @if(Auth::guard('club')->user()->id == $club->id)
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <input type="submit" class="btn btn-primary" value="Azuriraj podatke">
                                </div>
                            </div>
                            @endif
                            @endauth

                        </form>
                        
                            @auth('player')
                            <div class="form-group">
                                <div class="col-xs-6">
                                    @php
                                        $in_club = false;
                                        $klub = null;
                                        $veze =  DB::table('club_player')->where('player_id','=',Auth::user()->id)->get();
                                        foreach($veze as $veza)
                                        {
                                            if($veza->left == null)
                                                $in_club = true;
                                        }
                                        if($in_club == true) 
                                            $klub = DB::table('clubs')->where('id','=',$veza->club_id)->first();
                                    @endphp

                                    @if($klub != null && $club->id == $klub->id)
                                        <form action="/igrac/napusti_klub" method="POST">
                                            @csrf
                                            <input type="hidden" name="club_id" value="{{$club->id}}">
                                            <input type="hidden" name="player_id" value="{{Auth::user()->id}}" >
                                            <input type="submit" class="btn btn-primary text-white" value="Napusti klub">
                                        </form>
                                    @else
                                    <form action="/igrac/zahtev_za_klub" method="POST">
                                        @csrf
                                        <input type="hidden" name="club_id" value="{{$club->id}}">
                                        <input type="hidden" name="player_id" value="{{Auth::user()->id}}" >
                                        <input type="submit" class="btn btn-primary text-white" value="Posalji zahtev za uclanjenje">
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endauth
                </div>
            </div>
        </div>

        @error('error')
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{$message}}
            </div>
        @enderror
        @error('success')
            <div class="alert alert-success alert-dismissible fade show">
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