@extends('layouts.app')

@section('content')

<style>
div.img {
    border: 1px solid #ccc;
}

div.img:hover {
    border: 1px solid #f37f0d;
}

div.img img {
    width: 300px;
    height: 200px;
}


div.desc {
    padding: 10px;
    text-align: center;
}

* {
    box-sizing: border-box;
}

.clearfix:after {
    content: "";
    display: table;
    clear: both;
}
</style>

@if(!empty(Session::get('nuovaregistrazione')))

    <h1 style="text-align:center;color:#ffffff">Tutto sotto controllo, manca soltanto la conferma dell'admin
    <img class="img-responsive" src="http://easy.langa.tv/storage/app/images/ok.jpg"></img>
    {{Session::forget('nuovaregistrazione')}}               
    
@elseif(!empty(Session::get('confermaregistrazione')))
    
    <h1 style="text-align:center;color:#ffffff">Account attivato con successo, una email è già stata inviata al nuovo utente
    <img class="img-responsive" src="http://easy.langa.tv/storage/app/images/ok.jpg"></img>
    {{Session::forget('confermaregistrazione')}}
    
@elseif (Auth::guest())  

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Benvenuto nel Sistema Easy
                </div>

                <div class="panel-body">
				    <div class="col-md-4">
                        <br>
                        <div style="text-align: center">
                            <a href="{{url('/')}}">
                                <img style="width:200px;height:200px" src="{{url('images/logo.png')}}" ></img>
                            </a>
                        </div>
					</div>
                    <br><br>
					<div class="col-md-8">
                        <br><h4>Benvenuto su Easy <strong>LANGA</strong>!</h4>
                        Un semplice, veloce e sicuro metodo per organizzare la tua azienda. Accedendo potrai gestire
					    i tuoi eventi, visualizzare gli enti già contattati da altri utenti, gestire i progetti, 
                        eseguire i preventivi per i clienti, gestire i pagamenti e le relative fatture.<br></br>
                        <small>*ruoli e capacità della vostra utenza sono decisi a monte dalla divisione informatica LANGA WEB<br><br>
                        Maggiori informazioni su <a href="http://www.langa.tv" target="_blank">www.langa.tv</a></small>
					</div>                     
                </div><br>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: right">
                    <a class="btn btn-warning" href="{{ url('/login') }}">Accedi al Mondo Easy</a>
                    <a class="btn btn-warning" href="{{ url('/register') }}">Registrati QUI</a>
                </div>
            </div>
        </div>
    </div>
@else

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Link rapidi
                </div>
                <div class="panel-body">
                    <?php
                    // Seleziono i Link Rapidi dell'utente
                    $link = DB::table('link_profilo')
                        ->where('id_user', Auth::user()->id)
                        ->get();
                        
                    $counter = 1;
                    ?>
                    <div class="row">
                    @foreach($link as $l)
                        <div class="col-md-4">
                              <div class="col-md-12">
                                <div class="thumbnail">
                                  <a href="{{$l->url}}"><img src="http://easy.langa.tv/storage/app/images/<?php echo $l->image; ?>" alt="Link Rapido"></a>
                                </div>
                              </div>
                            <div class="caption" style="padding:15px">
                               <h4>{{$l->name}}</h4>
                            </div>
                        </div>
                        <?php
                            if($counter % 3 == 0) {
                                echo "</div><div class='row'>";
                            }
                        ?>
                        <?php $counter++; ?>
                    @endforeach
                </div>
        </div>
    </div>
</div></div>
@endif

@endsection
