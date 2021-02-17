<!DOCTYPE html>
<html lang="sr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, inital-scale=1.0" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <title>@yield('title')</title>

        <script src="https://kit.fontawesome.com/021abf950c.js" crossorigin="anonymous"></script>
    </head>
    
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/"><img src="/images/logo.png" width="50" height="50" class="d-inline-block align-top" alt=""></a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                       <a class="nav-link text-dark" href="/"> Pocetna</a>
                    </li>
                     <li class="nav-item">
                       <a class="nav-link text-dark" href="/turnir"> Turniri</a>
                    </li>
                </ul>
            </div>

            <div class="collapse navbar-collapse justify-content-end " id="navbarSupportedContent">
    
                @auth('player')
                    <h4>{{ Auth::guard('player')->user()->name. " ". Auth::guard('player')->user()->surname }}</h4>

                    <a class="ml-1" href="/igrac/moj_klub/{{Auth::guard('player')->user()->id}}"><i class="fas fa-chess-pawn fa-3x"></i></a>
                    <a class="ml-1" href="/igrac/obavestenja/{{Auth::guard('player')->user()->id}}"><i class="fas fa-envelope fa-3x"></i></a>
                    <a class="ml-1" href="/igrac/{{Auth::guard('player')->user()->id}}"><i class="fas fa-user-cog fa-3x"></i></a>

                    <form action="/korisnici/logout" method="GET">
                        <input type="submit" class="btn btn-danger ml-2" value="Odjava"/>
                    </form>
                @endauth

                @auth('admin')
                    <h4>Admin</h4>

                    <a class="ml-1" href="/adminProfil"><i class="fas fa-cog fa-3x"></i></a>
                    <a class="ml-1" href="/dodajRok"><i class="fas fa-clock fa-3x"></i></a>
                    <a class="ml-1" href="/korisnici"><i class="fas fa-user fa-3x"></i></a>
                    <a class="ml-1" href="/klubovi"><i class="fas fa-chess-king fa-3x"></i></a>

                    <form action="/korisnici/logout" method="GET">
                        <input type="submit" class="btn btn-danger ml-2" value="Odjava"/>
                    </form>
                @endauth

                @auth('club')
                <h4>{{ Auth::guard('club')->user()->name }}</h4>

                    <a class="ml-1" href="/klub/igraci/{{Auth::guard('club')->user()->id}}"><i class="fas fa-chess-king fa-3x"></i></i></a>
                    <a class="ml-1" href="/klub/obavestenja/{{Auth::guard('club')->user()->id}}"><i class="fas fa-envelope fa-3x"></i></a>
                    <a class="ml-1" href="/klub/{{Auth::guard('club')->user()->id}}"><i class="fas fa-users-cog fa-3x"></i></a>

                    <form action="/korisnici/logout" method="GET">
                        <input type="submit" class="btn btn-danger ml-2" value="Odjava"/>
                    </form>
                @endauth


                @guest('admin') @guest('player') @guest('club')

                <form class="form-inline my-2 my-lg-0" action="/korisnici/login" method="POST">
                    @csrf
                    <input class="form-control mr-sm-2" type="email" name="email" placeholder="Email" aria-label="Email">
                    <input class="form-control mr-sm-2" type="password" placeholder="Lozinka" aria-label="Lozinka" name="password">
                    <input type="submit" class="btn btn-success my-2 my-sm-0 mr-2" value="Prijavite se"/>
                </form>
                
                <a href="/korisnici/registracija"><button class="btn btn-primary my-2 my-sm-0">Registrujte se</button></a>
                @endguest @endguest @endguest
            </div>
        </nav>

        <div class="container">
        @yield('content')
        </div>
        @yield('content-no-container')
    </body>
</html>
