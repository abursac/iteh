@extends('master')
@section('title','Portal sahovskog saveza')
@section('content-no-container')

<script>
    //Igraci
    function prikazi_igrace(page_ = 1) {
      let name = document.getElementById("ime_filter").value;
      let gender = document.getElementById("pol_filter").value;
      let min_rating = document.getElementById("min_rejting_filter").value;
      let max_rating = document.getElementById("max_rejting_filter").value;
      let page = page_;

      $.ajax({
        type: "POST",
        url: "/igrac",
        data: {_token:'<?php echo csrf_token();?>',name:name,gender:gender,min_rating:min_rating,max_rating:max_rating,page:page},
        success: function (data) {
          document.getElementById("igraci_tabla").innerHTML = data;
          return;
        },
        error: function (data) {
          return;
        },
      });
    }
    window.onload = function(){prikazi_igrace();}
    $(document).on('keyup','#ime_filter',function(){prikazi_igrace();});
    $(document).on('keyup','#min_rejting_filter',function(){prikazi_igrace();});
    $(document).on('keyup','#max_rejting_filter',function(){prikazi_igrace();});
    $(document).on('change','#pol_filter',function(){prikazi_igrace();});

    //Klubovi
    function prikazi_klubove(strana_ = 1)
    {
      let naziv_filter = document.getElementById("naziv_filter").value;
      let opstina_filter = document.getElementById("opstina_filter").value;
      let min_datum_filter = document.getElementById("min_datum_filter").value;
      let max_datum_filter = document.getElementById("max_datum_filter").value;
      let strana = strana_;

      $.ajax({
        type: "POST",
        url: "/klub",
        data: {_token:'<?php echo csrf_token();?>',naziv_filter:naziv_filter,opstina_filter:opstina_filter,min_datum_filter:min_datum_filter,max_datum_filter:max_datum_filter,strana:strana},
        success: function (data) {
          document.getElementById("klubovi_tabela").innerHTML = data;
          return;
        },
        error: function (data) {
          return;
        },
      });
    }
    $(document).on('click', '#klubovi-tab', function() { prikazi_klubove(); });
    $(document).on('keyup','#naziv_filter',function() { prikazi_klubove(); });
    $(document).on('change','#opstina_filter',function() { prikazi_klubove(); });
    $(document).on('keyup','#min_datum_filter',function() { prikazi_klubove(); });
    $(document).on('keyup','#max_datum_filter',function() { prikazi_klubove(); });
    

    //Turniri
    function prikazi_turnire(page_ = 1) {
     let naziv = document.getElementById("turnir_filter_naizv").value;
     let mesto_odrzavanja = document.getElementById("turnir_filter_mesto").value;
     let broj_kola = document.getElementById("turnir_filter_br_kola").value;
     let datum_od = document.getElementById("turnir_filter_vreme_od").value;
     let datum_do = document.getElementById("turnir_filter_vreme_do").value;
     let strana = page_;
      $.ajax({
        type: "POST",
        url: "/turnir",
        data: {_token:'<?php echo csrf_token();?>',page:strana,name:naziv,place:mesto_odrzavanja,rounds:broj_kola,start_date:datum_od,end_date:datum_do},
        success: function (data) {
          document.getElementById("turniri_tabla").innerHTML = data;
          return;
        },
        error: function (data) {
          return;
        },
      });
    }
    $(document).on('click', '#takmicenja-tab', function() { prikazi_turnire(); });
    $(document).on('keyup','#turnir_filter_naizv',function() { prikazi_turnire(); });
    $(document).on('keyup','#turnir_filter_mesto',function() { prikazi_turnire(); });
    $(document).on('change','#turnir_filter_br_kola',function() { prikazi_turnire(); });
    $(document).on('keyup','#turnir_filter_br_kola',function() { prikazi_turnire(); });
    $(document).on('change','#turnir_filter_vreme_od',function() { prikazi_turnire(); });
    $(document).on('change','#turnir_filter_vreme_do',function() { prikazi_turnire(); });

</script>

<ul class="nav nav-tabs nav-fill mt-3" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="igraci-tab" data-toggle="tab" href="#igraci" role="tab" aria-controls="igraci" aria-selected="true">Igraci</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="klubovi-tab" data-toggle="tab" href="#klubovi" role="tab" aria-controls="klubovi" aria-selected="false">Klubovi</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="takmicenja-tab" data-toggle="tab" href="#takmicenja" role="tab" aria-controls="takmicenja"
        aria-selected="false">Turniri</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">

    <!-- IGRACI TAB -->
    <div class="tab-pane fade show active p-5" id="igraci" role="tabpanel" aria-labelledby="igraci-tab">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 mb-2">

            <!-- FILTERI  IGRACI -->
            <div class="card">
              <article class="card-group-item">
                <header class="card-header">
                  <h6 class="title">Ime </h6>
                </header>
                <div class="filter-content">
                  <div class="card-body">
                    <input type="text" class="form-control" id="ime_filter">

                  </div> <!-- card-body.// -->
                </div>
              </article> <!-- card-group-item.// -->

              <article class="card-group-item">
                <header class="card-header">
                  <h6 class="title">Pol </h6>
                </header>
                <div class="filter-content">
                  <div class="card-body">
                      <select class="form-control" id = "pol_filter">
                        <option value="Svi" selected>Svi</option>
                        <option value="Muski">Muski</option>
                        <option value="Zenski">Zenski</option>
                      </select>
                  </div> <!-- card-body.// -->
                </div>
              </article> <!-- card-group-item.// -->

              <article class="card-group-item">
                <header class="card-header">
                  <h6 class="title">Rejting</h6>
                </header>
                <div class="filter-content">
                  <div class="card-body">
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label>Min</label>
                        <input type="number" class="form-control" placeholder="0" id="min_rejting_filter">
                      </div>
                      <div class="form-group col-md-6 text-right">
                        <label>Max</label>
                        <input type="number" class="form-control" placeholder="3000" id="max_rejting_filter">
                      </div>
                    </div>
                  </div> <!-- card-body.// -->
                </div>
              </article> <!-- card-group-item.// -->
            </div>
          </div>
          <!-- /FILTERI IGRACI -->

          <!-- TABELA IGRACI -->
          <table class="table table-hover table-responsive-md col-xl-8">
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
                
            </tbody>
          </table>
         <!-- /TABELA IGRACI -->

        </div>
      </div>
    </div>
    <!-- KLUBOVI TAB -->
    <div class="tab-pane fade p-5" id="klubovi" role="tabpanel" aria-labelledby="klubovi-tab">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 mb-2">
            
            <!-- FILTERI  KLUB -->
            <div class="card">
              <article class="card-group-item">
                <header class="card-header">
                  <h6 class="title"> Naziv </h6>
                </header>
                <div class="filter-content">
                  <div class="card-body">
                    <input type="text" class="form-control" id = "naziv_filter">
                  </div> <!-- card-body.// -->
                </div>
              </article> <!-- card-group-item.// -->

              <article class="card-group-item">
                <header class="card-header">
                  <h6 class="title"> Opstina </h6>
                </header>
                <div class="filter-content">
                  <div class="card-body">
                    <input type="text" class="form-control" id = "opstina_filter">
                  </div> <!-- card-body.// -->
                </div>
              </article> <!-- card-group-item.// -->

              <article class="card-group-item">
                <header class="card-header">
                  <h6 class="title">Datum osnivanja</h6>
                </header>
                <div class="filter-content">
                  <div class="card-body">
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label> Od </label>
                        <input type="date" class="form-control" id = "min_datum_filter">
                      </div>
                      <div class="form-group col-md-6 text-right">
                        <label> Do </label>
                        <input type="date" class="form-control" id = "max_datum_filter">
                      </div>
                    </div>
                  </div> <!-- card-body.// -->
                </div>
              </article> <!-- card-group-item.// -->
            </div>
          </div>
            <!-- /FILTERI  KLUB -->
        
          <!-- TABELA  KLUB -->
          <table class="table table-hover table-responsive-md col-xl-8">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Naziv</th>
                <th scope="col">Broj clanova</th>
                <th scope="col">Adresa</th>
                <th scope="col">Vise</th>
              </tr>
            </thead>
            <tbody id = 'klubovi_tabela'>
            </tbody>
            <!-- /TABELA  KLUB -->
          
          </table>
        </div>
      </div> 
    </div>

    <!-- TURNIRI TAB -->
    <div class="tab-pane fade p-5" id="takmicenja" role="tabpanel" aria-labelledby="takmicenja-tab">
      <div class="container">
        <a href="/turnir/dodaj" class="btn btn-primary mb-2">Novi turnir</a>
        <div class="row">
          <div class="col-xl-4 mb-2">
            <!-- FILTERI TURNIRI -->        
            <div class="card">
              <article class="card-group-item">
                <header class="card-header">
                  <h6 class="title">Naziv </h6>
                </header>
                <div class="filter-content">
                  <div class="card-body">
                    <input type="text" class="form-control" id="turnir_filter_naizv">

                  </div> <!-- card-body.// -->
                </div>
              </article> <!-- card-group-item.// -->

              <article class="card-group-item">
                <header class="card-header">
                  <h6 class="title">Mesto odrzavanja </h6>
                </header>
                <div class="filter-content">
                  <div class="card-body">
                    <input type="text" class="form-control" id="turnir_filter_mesto">

                  </div> <!-- card-body.// -->
                </div>
              </article> <!-- card-group-item.// -->

              <article class="card-group-item">
                <header class="card-header">
                  <h6 class="title">Broj kola</h6>
                </header>
                <div class="filter-content">
                  <div class="card-body">
                    <input type="number" class="form-control" id="turnir_filter_br_kola">

                  </div> <!-- card-body.// -->
                </div>
              </article> <!-- card-group-item.// -->

              <article class="card-group-item">
                <header class="card-header">
                  <h6 class="title">Vreme odrzavanja</h6>
                </header>
                <div class="filter-content">
                  <div class="card-body">
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label>Od</label>
                        <input type="date" class="form-control" id="turnir_filter_vreme_od">
                      </div>
                      <div class="form-group col-md-6 text-right">
                        <label>Do</label>
                        <input type="date" class="form-control" id="turnir_filter_vreme_do">
                      </div>
                    </div>
                  </div> <!-- card-body.// -->
                </div>
              </article> <!-- card-group-item.// -->
          
            </div>
            <br>
            <a href="/turnir/dodaj" class="btn btn-primary btn-block mb-2">Novi turnir</a>
          </div>
          
        <!-- /FILTERI TURNIRI -->

        <!-- TABELA TURNIRI -->
          <table class="table table-hover table-responsive-md col-xl-8">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Naziv</th>
                <th scope="col">Mesto</th>
                <th scope="col">Broj kola</th>
                <th scope="col">Datum pocetka</th>
                <th scope="col">Datum kraja</th>
                <th scope="col" class="igrac">Vise</th>                
              </tr>
            </thead>
            <tbody id="turniri_tabla">

            </tbody>
            <!-- /TABELA TURNIRI -->
          </table>
        </div>
      </div>
    </div>
  </div>


@endsection
