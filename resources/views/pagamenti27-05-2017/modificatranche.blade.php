@extends('layouts.app')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<style>tr:hover td {
    background: #f2ba81;
}</style>
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<h1> {{ trans('messages.keyword_editinvoice') }} <?php if(!$tranche->idfattura) echo "#0000/" . date('y'); else echo $tranche->idfattura; ?></h1><hr>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
 <link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>

@include('common.errors')
<form action="{{url('/pagamenti/tranche/update') . '/' . $tranche->id}}" method="post" name="edit_fattura" id="edit_fattura">
	{{ csrf_field() }}


	<?php $mediaCode = date('dmyhis');?>
    <input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />

	@if(isset($tranche->idfattura))
    	<input name="idfattura" value="{{ $tranche->idfattura }}" type="hidden">   
    @endif

<div class="row">
	<div class="col-md-8">
    	    <script>
			"use strict";
			$.datepicker.setDefaults(
                                        $.extend(
                                          {'dateFormat':'dd/mm/yy'},
                                          $.datepicker.regional['nl']
                                        )
                                      );
			var $j = jQuery.noConflict();
    	    	var clickEvent = new MouseEvent("click", {
					"view": window,
					"bubbles": true,
					"cancelable": false
				});
    	    				$j('#prev').on("change", function() {
    	    					var id = $j("#prev").val();
    	    					var link = document.createElement("a");
    	    					link.href = "{{ url('/progetti/add') }}" + '/' + id;
								link.dispatchEvent(clickEvent);
    	    				});
    	    			</script></label>
						<label for="preventivo"> {{ trans('messages.keyword_project') }}  <input type="text" disabled value=":cod/anno" class="form-control"></label>
                        <a href="{{ url('/pagamenti/tranche/pdf') . '/' . $tranche->id }}" style="text-decoration:none;background:#DDDDDD" target="new" class="btn" type="button"><i class="fa fa-file-pdf-o"></i></a>
			<h4> {{ trans('messages.keyword_invoice_header') }} </h4>
			<div class="col-md-12">
			<div class="col-md-3">
	<!-- colonna a sinistra -->
	    <label for="sedelegaleente"> {{ trans('messages.keyword_registered_office_from') }} </label>
	    <select name="DA" id="sedelegaleente" class="js-example-basic-single form-control">
	        <option></option>
	        @foreach($enti as $ente)
	        	@if($ente->id == $tranche->DA)
	        		<option selected value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                @else
                	<option value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                @endif
	        @endforeach
	    </select><br><br>

	    <label for="id"> {{ trans('messages.keyword_note') }}  </label>
        <input value="{{$tranche->idfattura}}" type="text" id="id" name="idfattura" placeholder="{{ trans('messages.keyword_paymentcode') }} " class="form-control">
	   
	    <br><label for="modalita"> {{ trans('messages.keyword_payment_methods') }} </label>
		<input value="{{$tranche->modalita}}" type="text" class="form-control" id="modalita" name="modalita" placeholder=" {{ trans('messages.keyword_payment_methods') }} "><br>
	</div>
	<div class="col-md-3">
		<label for="sedelegaleentea"> {{ trans('messages.keyword_registered_office_to') }} </label>
	    <select id="sedelegaleentea" name="A" class="js-example-basic-single form-control">
	        <option></option>
	        @foreach($enti as $ente)
            	@if($ente->id == $tranche->A)
	        		<option selected value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                @else
                	<option value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                @endif
	        @endforeach
	    </select><br><br>
	   
          
	    <label for="emissione"> {{ trans('messages.keyword_issue_of_the') }} </label>
	    <input type="text" name="emissione" id="emissione" class="form-control" value="{{$tranche->emissione}}">

	    <br><label for="iban"> {{ trans('messages.keyword_company_iban') }} </label>
	     <select name="iban" id="iban" class="js-example-basic-single form-control">
	        <option></option>
	        @foreach($enti as $ente)
            	@if($ente->iban == $tranche->iban)
	       			<option selected value="{{$ente->iban}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                @else
                	<option value="{{$ente->iban}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                @endif
	        @endforeach
	    </select><script type="text/javascript">

    $(".js-example-basic-single").select2();

</script><br>
		
	</div>
	<div class="col-md-3">
	 <label for="id"> {{ trans('messages.keyword_invoicenumber') }} </label>
        <input value="{{$tranche->idfattura}}" type="text" id="idfattura" name="idfattura" placeholder=" {{ trans('messages.keyword_paymentcode') }} " class="form-control"><br>
    </div>
	<div class="col-md-3">
	<label for="Tipo"> {{ trans('messages.keyword_type_of_invoice') }} </label>
        <select id="Tipo" name="tipofattura" class="form-control">
        	@if($tranche->tipofattura == "NOTA DI CREDITO")
                <option value="0"> {{ trans('messages.keyword_sales_invoice') }} </option>
                <option value="1" selected> {{ trans('messages.keyword_credit_note') }} </option>
            @else
            	<option value="0" selected> {{ trans('keyword_sales_invoice.keyword') }} </option>
                <option value="1"> {{ trans('messages.keyword_credit_note') }} </option>
            @endif
        </select><br>
     
	    <label for="base"> {{ trans('messages.keyword_on_the_base') }} </label>
	    <input class="form-control" type="text" name="base" id="base" placeholder="{{ trans('messages.keyword_on_the_base') }}" value="{{$tranche->base}}">
	    <br>
	     <label for="indirizzospedizione"> {{ trans('messages.	keyword_shipping_address') }} </label>
        <select name="indirizzospedizione" id="indirizzospedizione" class="js-example-basic-single form-control">
	        <option></option>
	        @foreach($enti as $ente)
            	@if($ente->id == $tranche->indirizzospedizione)
	        		<option selected value="{{$ente->indirizzospedizione}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                @else
                	<option value="{{$ente->indirizzospedizione}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                @endif
	        @endforeach
	    </select><br>
	    <script>
	    
	        var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			var tbody = document.createElement("tbody");
			if(dd<10) {
				dd='0'+dd;
			} 
			if(mm<10) {
				mm='0'+mm;
			}
    		var vecchiaData = "<?php echo $tranche->datainserimento; ?>";
    		var dataInserimento = vecchiaData.toString();
    		var impedisciModifica = function(e) {
    			this.blur();
    			this.value = dataInserimento;
		    }
	</script>
		
	</div>
	</div>
			<h4> {{ trans('messages.keyword_invoice_body') }} </h4>
			
	        <div class="col-md-12">
            		<!-- <a target="new" href="{{url('/pagamenti/tranche/corpofattura') . '/' . $tranche->id}}" class="btn btn-info" style="color:#ffffff;text-decoration: none" title="Vedi Corpo fattura esistenti"><i class="fa fa-info"></i></a> -->
	                <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiCorpo"><i class="fa fa-plus"></i></a>
	                <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaCorpo"><i class="fa fa-eraser"></i></a>
	        </div><br>
	    	<table class="table table-striped">
	    		<thead>
	    			<th>#</th>
	    			<th> {{ trans('messages.keyword_references') }} </th>
	    			<th> {{ trans('messages.keyword_description') }} </th>
	    			<th> {{ trans('messages.keyword_qty') }} </th>
	    			<th> {{ trans('messages.keyword_subtotal') }} </th>
	    			<th> {{ trans('messages.keyword_total') }} </th>
	    		</thead>
	    		<tbody id="corpofattura">
	    		</tbody>
	    		 <script>
				 	var kCorpo = 0;
				 var selezioneCorpo = [];
	                    var nCorpo = 0;
	                    $j('#aggiungiCorpo').on("click", function() {
	                        var tab = document.getElementById("corpofattura");
	                        var tr = document.createElement("tr");
	                        var check = document.createElement("td");
	                        var checkbox = document.createElement("input");
	                        checkbox.type = "checkbox";
	                        checkbox.className = "selezione";
	                        check.appendChild(checkbox);
	                        var ord = document.createElement("td");
	                        var ordine = document.createElement("input");
	                        ordine.type = "text";
	                        ordine.className = "form-control";
	                        ordine.placeholder = ":{{ trans('messages.keyword_quote') }}";
	                        ordine.name = "ordine[]";
							// ordine.value = ":";
	                        ord.appendChild(ordine);

	                        var progetto = document.createElement("input");
	                        progetto.type = "text";
	                        progetto.placeholder = ":{{ trans('messages.keyword_project') }}";
	                        progetto.className = "form-control";
	                        progetto.name = "ordine[]";
							// progetto.value = ":";
	                        ord.appendChild(progetto);

	                        var td = document.createElement("td");
	                        var descrizione = document.createElement("textarea");
	                        descrizione.className = "form-control";
	                        descrizione.name = "desc[]";
	                        descrizione.rows = "3";
	                        descrizione.cols = "80";
	                        td.appendChild(descrizione);

	                        var qt = document.createElement("td");
	                        var quantita = document.createElement("input");
	                        quantita.type = "text";
	                        quantita.className = "form-control";
	                        quantita.name = "qt[]";
	                        qt.appendChild(quantita);

	                        var unitario = document.createElement("td");
	                        var unitary = document.createElement("input");
	                        unitary.type = "text";
	                        unitary.className = "form-control";
	                        unitary.name = "unitario";
							unitario.appendChild(unitary);


	                        var pr = document.createElement("td");
	                        var prezzo = document.createElement("input");
	                        prezzo.type = "text";
	                        prezzo.className = "form-control";
	                        prezzo.name = "subtotale[]";
	                        pr.appendChild(prezzo);
	                        var perc = document.createElement("td");
	                        var percentualesconto = document.createElement("input");
	                        percentualesconto.type = "text";
	                        percentualesconto.className = "form-control";
	                        percentualesconto.name = "scontoagente[]";
							perc.appendChild(percentualesconto);
							var per = document.createElement("td");
	                        var percentual = document.createElement("input");
	                        percentual.type = "text";
	                        percentual.className = "form-control";
	                        percentual.name = "scontobonus[]";
	                        per.appendChild(percentual);
	                        var netto = document.createElement("td");
	                        var prezzonetto = document.createElement("input");
	                        prezzonetto.type = "text";
	                        prezzonetto.className = "form-control";
	                        prezzonetto.name = "prezzonetto[]";
	                        netto.appendChild(prezzonetto);
	                        var perciva = document.createElement("td");
	                        var iva = document.createElement("input");
	                        iva.type = "text";
	                        iva.className = "form-control";
	                        iva.name = "iva[]";
	                        perciva.appendChild(iva);
	                        tr.appendChild(check);
	                        tr.appendChild(ord);
	                        tr.appendChild(td);
	                        tr.appendChild(qt);
	                        tr.appendChild(unitario);
	                        tr.appendChild(pr);
	      	//              tr.appendChild(perc);
			// 				tr.appendChild(per);
	      	//              tr.appendChild(netto);
	      	//              tr.appendChild(perciva);

	                        kCorpo++;

	                        tab.appendChild(tr);

	                        $j('.selezione').on("click", function() {
				                selezioneCorpo[nCorpo] = $j(this).parent().parent();
				                nCorpo++;
		                	});
	                    });

	                    $j('#eliminaCorpo').on("click", function() {
	                       for(var i = 0; i < nCorpo; i++) {
	                           selezioneCorpo[i].remove();
	                       }
	                       nCorpo = 0;
	                    });
	                </script>
	    	</table>
			<h4> {{ trans('messages.keyword_base_invoice') }} </h4><a onclick="calcola()" style="text-decoration:none" class="" title=" {{ trans('messages.keyword_assembled_compilation') }} "><br>{{ trans('messages.keyword_click') }}  <i class="fa fa-info"></i> {{ trans('messages.keyword_for_compilation') }} </i></a>
	   	<table class="table table-striped">
	   		<thead>
	   			
	   			<th> {{ trans('messages.keyword_network') }} </th>
	   			<th> {{ trans('messages.keyword_additional_discount') }} </th>
	   			<th> {{ trans('messages.keyword_total_net') }} </th>
	   			<th> {{ trans('messages.keyword_taxable_invoice') }} </th>
	   			<th> {{ trans('messages.keyword_vat_price') }} </th>
	   			<th>% {{ trans('messages.keyword_vat') }} </th>
	   			<th> {{ trans('messages.keyword_amount_due') }} </th>
	   		</thead>
	   		<tbody>
	   			<td><input id="lavorazioni" class="form-control" type="text" name="lavorazioni" value=""></td>
	   			<td><input id="netto" class="form-control" type="text" name="netto" value="{{$tranche->netto}}"></td>
	   			<td><input id="sconto" class="form-control" type="text" name="scontoaggiuntivo" value="{{$tranche->scontoaggiuntivo}}"></td>
	   			<td><input id="imponibile" class="form-control" type="text" name="imponibile" value="{{$tranche->imponibile}}"></td>
	   			<td><input id="prezzoiva" class="form-control" type="text" name="prezzoiva" value="{{$tranche->prezzoiva}}"></td>
	   			<td><input id="percentualeiva" class="form-control" type="text" name="percentualeiva" value="{{$tranche->percentualeiva}}"></td>
	   			<td><input id="dapagare" class="form-control" type="text" name="dapagare" value="{{$tranche->dapagare}}"></td>
                <script>
					function approssima(x) {
						
					}
					function calcola() {
						var percentuale = $j('#percentuale').val() || 0;
						var netto = $j('#netto').val() || 0;
						var sconto = $j('#sconto').val() || 0;
						var imponibile = $j('#imponibile').val() || 0;
						var prezzoiva = $j('#prezzoiva').val() || 0;
						var percentualeiva = $j('#percentualeiva').val() || 0;
						var dapagare = $j('#dapagare').val() || 0;
						
						var importototale = eval(prompt("Inserisci l'importo equivalente al 100%", netto));
						sconto = eval(prompt("Inserisci lo sconto aggiuntivo (€)", sconto));
						percentuale = eval(prompt("Inserisci la percentuale (%)", percentuale));
						netto = eval(prompt("Inserisci il prezzo netto (€)", (importototale - sconto) * percentuale / 100));
						imponibile = eval(prompt("Inserisci l'imponibile (€)", netto));
						percentualeiva = eval(prompt("Inserisci la l'iva (%)", 22));
						prezzoiva = eval(prompt("Inserisci il prezzo con iva (€)", imponibile * percentualeiva / 100));
						dapagare = eval(prompt("Inserisci il totale da pagare (€)", imponibile + prezzoiva));
						
						approssima(netto);
						approssima(imponibile);
						approssima(prezzoiva);
						approssima(dapagare);
						
						
						$j('#percentuale').val(percentuale);
						$j('#netto').val(importototale);
						$j('#sconto').val(sconto);
						$j('#imponibile').val(imponibile);
						$j('#prezzoiva').val(prezzoiva);
						$j('#percentualeiva').val(percentualeiva);
						$j('#dapagare').val(dapagare);
					}
					
				</script>
	   		</tbody>
	   	</table>
	   	<div class="col-md-2" style="padding-top:20px;padding-bottom:10px;">
		<input onclick="mostra2()" type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_save') }}">
	</div>
</form>
	</div>
	<div class="col-md-4">
		<label for="statoemotivo"> {{ trans('messages.keyword_emotional_state') }} </label>
		<select name="statoemotivo" class="form-control" id="statoemotivo" style="color:#ffffff">
			<!-- statoemotivoselezionato -->
			@if($statoemotivoselezionato!=null)
				@foreach($statiemotivi as $statoemotivo)
					<option @if($statoemotivo->id == $statoemotivoselezionato->id_tipo) selected @endif style="background-color:{{$statoemotivo->color}};color:#ffffff" value="{{$statoemotivo->name}}">{{$statoemotivo->name}}</option>
				@endforeach
			@else
				@foreach($statiemotivi as $statoemotivo)
					<option style="background-color:{{$statoemotivo->color}};color:#ffffff" value="{{$statoemotivo->name}}">{{$statoemotivo->name}}</option>
				@endforeach
			@endif
		</select>
		<script>
		var yourSelect = document.getElementById( "statoemotivo" );
			document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		$('#statoemotivo').on("change", function() {
			var yourSelect = document.getElementById( "statoemotivo" );
			document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		});
		</script>
		<br>
		 <label for="privato"> {{ trans('messages.keyword_hide_stats') }}  <i class="fa fa-eye-slash" title="{{ trans('messages.keyword_ifso') }} "></i>
            <select class="form-control" name="privato">
            	@if($tranche->privato == 0)
                    <option value="0" selected> {{ trans('messages.keyword_no') }} </option>
                    <option value="1"> {{ trans('messages.keyword_yes') }} </option>
                @else
                	<option value="0"> {{ trans('messages.keyword_no') }} </option>
                    <option value="1" selected> {{ trans('messages.keyword_yes') }} </option>
                @endif
            </select>

			<label for="tipo"> {{ trans('messages.keyword_type') }} </label>
		    <select name="tipo" id="tipo" class="form-control">
            	@if($tranche->tipo == 1)
                    <option value="0"> {{ trans('messages.keyword_payment') }} </option>
                    <option selected value="1"> {{ trans('messages.keyword_renewal') }} </option>
                @else
                	<option selected value="0"> {{ trans('messages.keyword_payment') }} </option>
                    <option value="1"> {{ trans('messages.keyword_renewal') }} </option>
                @endif
		    </select>
		<!-- 	<div id="frequenza">
		    <br><label for="frequ">Frequenza <p style="color:#f37f0d;display:inline">(In giorni)</p></label>
		    <input value="{{$tranche->frequenza}}" id="frequ" name="frequenza" class="form-control" placeholder="Frequenza">
		</div> -->
        
			<br><label for="percentuale">% {{ trans('messages.keyword_total_amount') }}  <p style="color:#f37f0d;display:inline">(*)</p></label>
			<input id="percentuale" name="percentuale" class="form-control" value="{{$tranche->percentuale}}" placeholder="{{ trans('messages.keyword_description') }} % ">
            <div id="percentualediv">
		    <br><label for="frequ"> {{ trans('messages.keyword_amount') }} </label>
		    <input name="importo_nopercentuale" class="form-control" placeholder="{{ trans('messages.keyword_amount') }} " value="<?php echo $tranche->testoimporto; ?>">
		</div>
            <script>
			if($j('#tipo').val() == 1) {
					// Mostro l'importo
					$j('#frequenza').show();
					
				} else {
					// Nascondo l'importo
					$j('#frequenza').hide();
				}
				
			function test() {
			if($j('#percentuale').val() == 0) {
					// Mostro l'importo
					$j('#percentualediv').show();
					
				} else {
					// Nascondo l'importo
					$j('#percentualediv').hide();
				}
			}
			test();
			
			$j('#percentuale').on("change", function() {
				test();
			});
			</script>
			<br><label for="datascadenza"> {{ trans('messages.keyword_expiry_date_invoice') }}  <p style="color:#f37f0d;display:inline">(*)</p></label><br>
		    <input value="{{$tranche->datascadenza}}" class="form-control" name="datascadenza" id="datascadenza"></input><br>
           
			  <script>
		    $j('#frequenza').hide();
			$j('#percentualediv').hide();
		    $j('#datainserimento').datepicker();
		    $j('#datascadenza').datepicker();
		    $j('#emissione').datepicker();
        $j('#tipo').on("change", function() {
			if($j('#tipo').val() == 0) {
			    // Nascondo la frequenza
			    $j('#frequenza').hide();
			} else {
			    // Mostro la frequenza
			    $j('#frequenza').show();
			}
		});
		</script>

</form>          	
          	<?php $mediaCode = date('dmyhis');?>

          	<div class="col-md-12">
	        <label for="scansione"> {{ trans('messages.keyword_attach_administrative_file') }} </label><br>
	        <br>
	        <div class="col-md-12">

            	<div class="image_upload_div">

                <?php echo Form::open(array('url' => '/add/fatture/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
						{{ csrf_field() }}
						<input type="hidden" name="idtranche" name="idtranche" value="{{ $tranche->id }}">
						
    			</form>				
				</div>

				<script>
				var url = '<?php echo url('/add/fatture/getfiles/'.$mediaCode); ?>';
				Dropzone.autoDiscover = false;
				$j(".dropzone").each(function() {
				  $j(this).dropzone({
					complete: function(file) {
					  if (file.status == "success") {
					  	 $j.ajax({url: url, success: function(result){
        					$j("#files").html(result);
							$j(".dz-preview").remove();
							$j(".dz-message").show();
					    }});
					  }
					}
				  });
				});

				function deleteQuoteFile(id){
					var urlD = '<?php echo url('/add/fatture/deletefiles/'); ?>/'+id;
						$j.ajax({url: urlD, success: function(result){
							$j(".quoteFile_"+id).remove();
					    }});
				}

				function updateType(typeid,fileid){

					var urlD = '<?php echo url('/add/fatture/updatefiletype/'); ?>/'+typeid+'/'+fileid;
						$j.ajax({url: urlD, success: function(result){
							//$j(".quoteFile_"+id).remove();
					    }});
				}				
			
                </script>

	            <table class="table table-striped table-bordered">	                
	                <tbody><?php
					if(isset($preventivo->id) && isset($quotefiles)){
					foreach($quotefiles as $prev) {
				$imagPath = url('/storage/app/images/quote/'.$prev->name);
				$html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-eraser"></i></a></td></tr>';
				$html .='<tr class="quoteFile_'.$prev->id.'"><td>';
				$utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', '=', 0)->get();							
				foreach($utente_file as $key => $val){
					$check = '';
					if($val->ruolo_id == $prev->type){
						$check = 'checked';
					}
					$html .=' <input type="radio" name="rdUtente_'.$prev->id.'"  '.$check.' id="rdUtente_'.$val->ruolo_id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.');"  value="'.$val->ruolo_id.'" /> '.$val->nome_ruolo;
				}
				echo $html .='</td></tr>';
			}
					}
                    ?></tbody>
                    <tbody id="files">
	                </tbody>
                    
	                <script>
	                var $j = jQuery.noConflict();
	                    var selezione = [];
	                    var nFile = 0;
	                    var kFile = 0;
	                    $j('#aggiungiFile').on("click", function() {
	                        var tab = document.getElementById("files");
	                        var tr = document.createElement("tr");
	                        var check = document.createElement("td");
	                        var checkbox = document.createElement("input");
	                        checkbox.type = "checkbox";
	                        checkbox.className = "selezione";
	                        check.appendChild(checkbox);
	                        kFile++;
	                        var td = document.createElement("td");
	                        var fileInput = document.createElement("input");
	                        fileInput.type = "file";
	                        fileInput.className = "form-control";
	                        fileInput.name = "filee[]";
	                        td.appendChild(fileInput);
	                        tr.appendChild(check);
	                        tr.appendChild(td);
	                        tab.appendChild(tr);
	                        $j('.selezione').on("click", function() {
				                selezione[nFile] = $j(this).parent().parent();
				                nFile++;
		                	});
	                    });
	                    $j('#eliminaFile').on("click", function() {
	                       for(var i = 0; i < nFile; i++) {
	                           selezione[i].remove();
	                       }
	                       nFile = 0;
	                    });
	                </script>
	            </table><hr>
	            </div>

            </div>
		
	</div>
</div>


<script type="text/javascript">
$(document).ready(function() {
      
	// validate add invoice form on keyup and submit
    $("#edit_fattura").validate({
        
        rules: {     
            DA: {
                required: true
            },
            A: {
                required: true
            },
            datascadenza: {
                required: true
            },
            percentuale: {
                required: true,
                digits:true
            },
            emissione: {
                required: true
            },
            tipofattura: 
            {
                required: true
            },
            base: {
                required: true
            }
        },
        messages: {
            DA: {
                required: "{{ trans('messages.keyword_please_select_from') }}"
            },
            A: {
                required: "{{ trans('messages.keyword_please_select_to') }}"
            },
            datascadenza: {
                required: "{{ trans('messages.keyword_please_select_expiry_date') }}"
            },
            percentuale: {
                required: "{{ trans('messages.keyword_please_enter_percentage') }}"
            },
            emissione: {
                required: "{{ trans('messages.keyword_please_select_emission') }}"
            },
            tipofattura: {
                required: "{{ trans('messages.keyword_please_select_type_invoice') }}"
            },
            base: {
                required: "{{ trans('messages.keyword_please_enter_base') }} "
            }
        }

    });

});

</script>

@endsection