@extends('layouts.app')
@section('content')

<h1>Segnalazioni</h1><hr>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

@include('common.errors')

<div class="row">
	<div class="col-md-12">
    <div class="col-md-6">
    <?php echo Form::open(array('url' => '/valutaci/store/', 'files' => true)) ?>
    {{ csrf_field() }}
    	<div class="col-md-12">
    		<h6 style="text-align:left"><span class="fa fa-frown-o"></span> Ci dispiace che qualcosa non abbia funzionato come avrebbe dovuto. Per aiutare
            	lo sviluppo di Easy <strong>LANGA</strong> compila questi pochi campi per permettere agli sviluppatori di correggere il problema il prima possibile.<h6 style="color:#f37f0d"><strong>Ricordati che più informazioni dai sull'errore, più semplice sarà individuarlo, riprodurlo e risolverlo</strong></h6>
            </h6>
            <h5 style="color:#f37f0d">In che pagina eri quando si è verificato il problema?</h5><input type="text" id="url" placeholder="http://easy.langa.tv/enti/modify/corporation/0" name="posizione" class="form-control">
            <h5 style="color:#f37f0d">Descrivi l'errore che hai trovato</h5><textarea rows="10" id="errore" placeholder="Oddio! ho perso tutti i miei enti!" name="errore" class="form-control"></textarea>
            <h5 style="color:#f37f0d">Allega un'immagine</h5><input type="file" name="screen" class="form-control">
            <br><input type="submit" class="btn btn-warning" value="Invia" onclick="return controlla();">
        </div>
        <script>
		function controlla() {
			var url = document.getElementById("url").value;
			var errore = document.getElementById("errore").value;
			if(url == "" || errore == "") {
				alert("Attento, compila tutti i campi per segnalare l'errore, così sara possibile risolverlo :)");
				return false;
			} else
				return true;
		}
		</script>
    </form>
    </div>
    <div class="col-md-6">
	<form action="{{url('/valutaci/store')}}" method="post">
    {{ csrf_field() }}
    	<div class="col-md-12">
    		<h6 style="text-align:left"><span class="fa fa-smile-o"></span> Siamo contenti che tutto funzioni perfettamente. Per aiutare
            	lo sviluppo di Easy <strong>LANGA</strong> compila questi pochi campi per sostenere il lavoro degli sviluppatori.
            </h6>
            <h5 style="color:#f37f0d">Dicci cosa ne pensi di Easy</h5><textarea rows="15" id="love" placeholder="Non potrei vivere senza Easy!" name="love" class="form-control"></textarea>
            <h5 style="color:#f37f0d">Allega un'immagine</h5><input type="file" name="screen" class="form-control">
            <br><input type="submit" class="btn btn-warning" value="Invia" onclick="return controlla2();">
        </div>
        <script>
		function controlla2() {
			var msg = document.getElementById("love").value;
			if(msg == "") {
				alert("Attento, compila tutti i campi per segnalare la valutazione, grazie");
				return false;
			} else
				return true;
		}
		</script>
    </form>
    </div>
    </div>
</div>

@endsection