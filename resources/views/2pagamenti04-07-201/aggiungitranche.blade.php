@extends('layouts.app')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<!-- <style type="text/css">
.table.table-bordered tr td input[type="checkbox"] { display: block;}
</style> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>

@include('common.errors')
<form action="{{url('/pagamenti/tranche/store')}}" method="post" name="add_fattura" id="add_fattura">
	{{ csrf_field() }}
	<?php $mediaCode = date('dmyhis');?>
    <input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />
    
    <div class="invoice-aggiungitranche">
    
    <div class="header-lst-img">
        <div class="header-svg text-left float-left">
            <img src="http://betaeasy.langa.tv/dev/images/HEADER1_LT_ACCOUNTING.svg" alt="header image">
        </div>
        <div class="float-right text-right">
            <h1> {{ trans('messages.keyword_add_invoice') }} </h1><hr>
        </div>
	</div>
    
    
    	<div class="clearfix"></div>
		<div class="height20"></div>

    
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
    	
	
	<div class="row">
	
    
    <div class="col-md-4">
		 	<label for="id"> {{ trans('messages.keyword_invoicenumber') }} </label>
	        <input value="{{old('idfattura')}}" type="text" id="idfattura" name="idfattura" placeholder=" {{ trans('messages.keyword_invoicenumber') }} " class="form-control">
        </div>

        <div class="col-md-8">
			
		    <label for="legameprogetto"> {{ trans('messages.keyword_linktoproject') }} <span class="required">(*)</span> </label>
		    <select name="legameprogetto" id="legameprogetto" class="js-example-basic-single form-control">
		       <option></option>
            @foreach($progetti as $progetto)
            	<option value="{{$progetto->id}}">::{{$progetto->id}}<?php echo '/' . substr($progetto->datainizio, -2);?> | {{ ucwords(strtolower($progetto->nomeprogetto)) }}</option>
            @endforeach
		        
		    </select>
<br><br>
		</div>
    
    
	<div class="col-md-4">
		<h4> {{ trans('messages.keyword_invoice_header') }} </h4>
	    <label for="sedelegaleente"> {{ trans('messages.keyword_registered_office_from') }}  <span class="required">(*)</span> </label>
	    <select name="DA" id="sedelegaleente" class="js-example-basic-single form-control">
	        <option></option>
	        @foreach($enti as $ente)
	        <option value="{{$ente->id}}">{{$ente->id}} | {{ ucwords(strtolower($ente->nomeazienda)) }}</option>
	        @endforeach
	    </select><br>
	    <br>
	    <label for="note"> {{ trans('messages.keyword_note') }}  </label>
		<input value="" type="text" class="form-control" id="note" name="note" placeholder="{{ trans('messages.keyword_note') }} ">

	    <br><label for="modalita"> {{ trans('messages.keyword_payment_methods') }} </label>
		<input value="{{old('modalita')}}" type="text" class="form-control" id="modalita" name="modalita" placeholder=" {{ trans('messages.keyword_payment_methods') }} "><br>
	</div>
	<div class="col-md-4">
	<input type="hidden" name="id_disposizione" value="{{$idfattura}}"> 
		<br><br>
	   <label for="sedelegaleentea"> {{ trans('messages.keyword_registered_office_to') }} <span class="required">(*)</span> </label>
	    <select id="sedelegaleentea" name="A" class="js-example-basic-single form-control">
	        <option></option>
	        @foreach($enti as $ente)
	        <option value="{{$ente->id}}">{{$ente->id}} | {{ ucwords(strtolower($ente->nomeazienda)) }}</option>
	        @endforeach
	    </select><br><br>

	 	<label for="emissione"> {{ trans('messages.keyword_issue_of_the') }} <span class="required">(*)</span> </label>
	    <input value="{{old('emissione')}}" type="text" name="emissione" id="emissione" class="form-control"><br>

		<label for="iban"> {{ trans('messages.keyword_company_iban') }} </label>
	     <select name="iban" id="iban" class="js-example-basic-single form-control">
	        <option></option>
	        @foreach($enti as $ente)
	        <option value="{{$ente->iban}}">{{$ente->id}} | {{ ucwords(strtolower($ente->nomeazienda)) }}</option>
	        @endforeach
	    </select><script type="text/javascript">

    $(".js-example-basic-single").select2();

</script><br>
		
	</div>
	<div class="col-md-4">
	<br><br>
	<label for="Tipo"> {{ trans('messages.keyword_type_of_invoice') }} </label>
        <select id="Tipo" name="tipofattura" class="form-control">
        	<option value="0" selected> {{ trans('messages.keyword_sales_invoice') }} 
        	</option>
            <option value="1"> {{ trans('messages.keyword_credit_note') }} </option>
        </select><br>
        
	    
	    <label for="base"> {{ trans('messages.keyword_on_the_base') }} <span class="required">(*)</span></label>
	    <input value="{{old('base')}}" class="form-control" type="text" name="base" id="base" placeholder="{{ trans('messages.keyword_on_the_base') }} ">
	    <br>

        <label for="indirizzospedizione"> {{ trans('messages.keyword_shipping_address') }} </label>
        <select name="indirizzospedizione" name="indirizzospedizione" id="indirizzospedizione" class="js-example-basic-single form-control">
	        <option></option>
	        @foreach($enti as $ente)
	        <option value="{{$ente->indirizzospedizione}}">{{$ente->id}} | {{ ucwords(strtolower($ente->nomeazienda)) }}</option>
	        @endforeach
	    </select>

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
    		var vecchiaData = dd + "/" + mm + "/" + yyyy + " " + new Date().toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
    		var dataInserimento = vecchiaData.toString();
    		var impedisciModifica = function(e) {
    			this.blur();
    			this.value = dataInserimento;
		    }
	</script>
		
	</div>
	</div>
			<h4> {{ trans('messages.keyword_invoice_body') }} </h4>
               <div class="row">
                <div class="col-md-12">
                        <a class="btn btn-warning"  id="aggiungiCorpo"><span class="fa fa-plus"></span></a>
                        <a class="btn btn-danger"  id="eliminaCorpo"><span class="fa fa-trash"></span></a>
                </div>
               </div> 
               
               <div class="height10"></div>
               
	        <div class="set-height">
	    	<table class="table table-bordered">
	    		<thead>
	    			<th>#</th>
	    			<th> {{ trans('messages.keyword_references') }} </th>
	    			<th> {{ trans('messages.keyword_description') }} </th>
	    			<th> {{ trans('messages.keyword_qty') }} </th>
	    			<th> {{ trans('messages.keyword_unitary') }} </th>
	    			<th> {{ trans('messages.keyword_subtotal') }} </th>

	    		</thead>
	    		<tbody id="corpofattura">
                <script>
				
	                   
	                    var kCorpo = 0;
				 var selezioneCorpo = [];
	                    var nCorpo = 0;
				</script>
                <?php $totale = 0; ?>
                	@if($corpofattura != null)
                	@foreach($corpofattura as $ele)
                    	<tr>
                        	<td><input type="checkbox" class="selezione"></td>
                            <td><input class="form-control" type="text" name="ordine[]" value="<?php echo ':' . $ordine . '/' . $anno; ?>"></td>
                            <td><input class="form-control" type="text" name="desc[]" value="<?php echo $ele->descrizione; ?>"></td>
                            <td><input class="form-control" type="text" name="qt[]" value="<?php echo $ele->qta; ?>"></td>
                            <td><input class="form-control" type="text" name="subtotale[]" value="<?php echo $ele->prezzounitario; ?>"></td>
                            <td><input class="form-control" type="text" name="scontoagente[]" value="<?php echo $sconto; ?>"></td>
                            <td><input class="form-control" type="text" name="scontobonus[]" value="<?php echo $scontobonus; ?>"></td>
                            <td><input class="form-control" type="text" name="prezzonetto[]" value="<?php echo $ele->totale; ?>"></td>
                            <td><input class="form-control" type="text" name="iva[]" value=""></td>
                            <?php $totale += $ele->totale; ?>
                            <script>
								$j('.selezione').on("click", function() {
									selezioneCorpo[nCorpo] = $j(this).parent().parent();
									nCorpo++;
		                		});
							</script>
                        </tr>
                    @endforeach
                    @endif
	    		</tbody>
			 <script>
			 var count = 0;
            $j('#aggiungiCorpo').on("click", function() {

                var tab = document.getElementById("corpofattura");

                var tr = document.createElement("tr");
                var check = document.createElement("td");

                var checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.className = "selezione";
                checkbox.id = "checkopt";
                check.appendChild(checkbox);

                var checkboxLabel = document.createElement("label");
            	checkboxLabel.setAttribute('for', "checkopt"+count);
	            var td = document.createElement("td");
	            check.appendChild(checkboxLabel);


                var ord = document.createElement("td");
                var ordine = document.createElement("input");
                ordine.type = "text";
                ordine.placeholder = ":{{ trans('messages.keyword_quote') }}";
                ordine.className = "form-control";
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
	//                   tr.appendChild(perc);
					// tr.appendChild(per);
	//                   tr.appendChild(netto);
	//                   tr.appendChild(perciva);
	                kCorpo++;
	                count++;

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
	    	</div>
			<h4> {{ trans('messages.keyword_base_invoice') }} </h4><a onclick="calcola()" class="" title="{{ trans('messages.keyword_assembled_compilation') }}"> {{ trans('messages.keyword_click') }}  <span class="fa fa-info"></span> {{ trans('messages.keyword_for_compilation') }} </span></a>
			<div class="table-responsive">
	   	<br><table class="table table-bordered">
	   		<thead>
	   			
	   			<th> {{ trans('messages.keyword_network') }} </th>
	   			<th> {{ trans('messages.keyword_additional_discount') }}</th>
	   			<th> {{ trans('messages.keyword_total_net') }} </th>
	   			<th> {{ trans('messages.keyword_taxable_invoice') }} </th>
	   			<th> {{ trans('messages.keyword_vat_price') }}  </th>
	   			<th>% {{ trans('messages.keyword_vat') }} IVA</th>
	   			<th><b> {{ trans('messages.keyword_amount_due') }} </b></th>
	   		</thead>
	   		<tbody>
	   			
	   			<td><input id="netto" class="form-control" type="text" name="netto" value="{{old('netto')}}"></td>
	   			<td><input id="sconto" class="form-control" type="text" name="scontoaggiuntivo" value="{{old('scontoaggiuntivo')}}"></td>
	   			<td><input id="nettototale" class="form-control" type="text" name="nettototale" value="{{old('nettototale')}}"></td>
	   			<td><input id="imponibile" class="form-control" type="text" name="imponibile" value="{{old('imponibile')}}"></td>
	   			<td><input id="prezzoiva" class="form-control" type="text" name="prezzoiva" value="{{old('prezzoiva')}}"></td>
	   			<td><input id="percentualeiva" class="form-control" type="text" name="percentualeiva" value="{{old('percentualeiva')}}"></td>
	   			<td><input id="dapagare" class="form-control" type="text" name="dapagare" value="{{old('dapagare')}}"></td>
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
						
						var importototale = eval(prompt("{{trans('messages.keyword_enter_the_amount_equivalent_to')}} 100%", <?php echo $totale; ?> || netto));
						sconto = eval(prompt("{{trans('messages.keyword_enter_the_additional_discount')}} (€)", sconto));
						percentuale = eval(prompt("{{trans('messages.keyword_enter_the_percentage')}} (%)", percentuale));
						netto = eval(prompt("{{trans('messages.keyword_enter_the_net_price')}} (€)", (importototale - sconto) * percentuale / 100));
						imponibile = eval(prompt("{{trans('messages.keyword_enter_the_taxable_amount')}} (€)", netto));
						percentualeiva = eval(prompt("{{trans('messages.keyword_enter_the_vat')}} (%)", 22));
						prezzoiva = eval(prompt("{{trans('messages.keyword_enter_the_price_with_vat')}} (€)", imponibile * percentualeiva / 100));
						dapagare = eval(prompt("{{trans('messages.keyword_enter_the_total_payable')}} (€)", imponibile + prezzoiva));
						
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
	   	</div>

	<div class="row"><div class="col-md-2" >
		<input onclick="mostra2()" type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_save') }}">
	</div></div>

	</div>
	<div class="col-md-4">
		<label for="statoemotivo"> {{ trans('messages.keyword_emotional_state') }} </label>
		<!-- statiemotivi -->
		<select name="statoemotivo" class="form-control" id="statoemotivo">
			@for($i = 0; $i < count($statiemotivi); $i++)
            	@if($i == 0)
					<option selected style="background-color:{{$statiemotivi[$i]->color}};color:#ffffff">{{ ucwords(strtolower($statiemotivi[$i]->name)) }}</option>
                @else
                	<option style="background-color:{{$statiemotivi[$i]->color}};color:#ffffff">{{ ucwords(strtolower($statiemotivi[$i]->name)) }}</option>
                @endif
			@endfor
		</select>
		<script>
		var yourSelect = document.getElementById( "statoemotivo" );
			document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		$j('#statoemotivo').on("change", function() {
			var yourSelect = document.getElementById( "statoemotivo" );
			document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		});
		</script>
		<br>
		  <label for="privato"> {{ trans('messages.keyword_hide_stats') }} </label> 
		  <span class="fa fa-eye-slash" title="{{ trans('messages.keyword_ifso') }} "></span>
            <select class="form-control" name="privato">
            	<option value="0" selected>{{ trans('messages.keyword_no') }} </option>
                <option value="1"> {{ trans('messages.keyword_yes') }} </option>
            </select>
		
			
			<br><label for="tipo"> {{ trans('messages.keyword_type') }}  </label>
		    <select name="tipo" id="tipo" class="form-control">
    		    <option value="0"> {{ trans('messages.keyword_payment') }} </option>
    		    <option value="1"> {{ trans('messages.keyword_renewal') }} </option>
		    </select>
			<div id="frequenza">
		    <br><label for="frequ"> {{ trans('messages.keyword_frequency_in_days') }}<span class="required">(*)</span> </label>
		    <input id="frequ" name="frequenza" class="form-control" placeholder="{{ trans('messages.keyword_frequency_in_days') }}" value="{{old('frequenza')}}">
		</div>
        
			<br><label for="percentuale">% {{ trans('messages.keyword_total_amount') }}  <span class="required">(*)</span></label>
			<input id="percentuale" name="percentuale" class="form-control" value="{{old('percentuale')}}" placeholder="% {{ trans('messages.keyword_description') }}">
            <div id="percentualediv">
		    <br><label for="frequ"> {{ trans('messages.keyword_amount') }} </label>
		    <input id="frequ" name="importo_nopercentuale" class="form-control" placeholder=" {{ trans('messages.keyword_amount') }} " value="{{old('importo_nopercentuale')}}">
		</div>
            <script>
			$j('#percentuale').on("change", function() {
				if($j('#percentuale').val() == 0) {
					// Nascondo l'importo
					$j('#percentualediv').show();
					
				} else {
					// Mostro l'importo
					$j('#percentualediv').hide();
				}
			});
			</script>
			<br><label for="datascadenza"> {{ trans('messages.keyword_expiry_date_invoice') }} <span class="required">(*)</span></label><br>
		    <input value="{{old('datascadenza')}}" class="form-control" name="datascadenza" id="datascadenza"></input><br>
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

		<div class="row">
          	<div class="col-md-12">
            <div class="bg-white modifica-blade-estimate-upload">
            
	        <label for="scansione"> 
	        {{ trans('messages.keyword_attach_administrative_file') }} 
	        </label><br>
	        <div class="row">
	        <div class="col-md-12">
            	<div class="image_upload_div">
                <?php echo Form::open(array('url' => '/add/fatture/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>					
					{{ csrf_field() }}					
    			</form>				
				</div>
				<script>
				var $ = jQuery.noConflict();
				var urlgetfile = '<?php echo url('/add/fatture/getfiles/'.$mediaCode); ?>';
				Dropzone.autoDiscover = false;
				$(".dropzone").each(function() {
				  $(this).dropzone({
					complete: function(file) {
					  if (file.status == "success") {
					  	 $.ajax({url: urlgetfile, success: function(result){
        					$("#files").html(result);
							$(".dz-preview").remove();
							$(".dz-message").show();
					    }});
					  }
					  if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                           $( "#addMediacommnetmodal" ).modal();
                           $('#addMediacommnetmodal').on('shown.bs.modal', function(){});
                      }
					}
				  });
				});
				function deleteQuoteFile(id){
					var urlD = '<?php echo url('/add/fatture/deletefiles/'); ?>/'+id;
						$.ajax({url: urlD, success: function(result){
							$(".quoteFile_"+id).remove();
					    }});
				}				
				function updateType(typeid,fileid,checkboxid1){           
                    var ischeck = 0;            
                    if($('#'+checkboxid1+':checkbox:checked').length > 0){                
                        var ischeck = 1;
                    }
                    var checkValues = $j('input[name=rdUtente_'+fileid+']:checked').map(function(){
                        return $(this).val();
                    }).get();
                    var urlD = '<?php echo url('/add/fatture/updatefiletype/'); ?>/'+typeid+'/'+fileid;
                    $.ajax({
                        url: urlD,
                        type: 'post',
                        data: { "_token": "{{ csrf_token() }}",ids: checkValues },
                        success:function(data){
                        }
                    });
                    //$.ajax({url: urlD, success: function(result){ }});
                }				
			
                </script>
	           <div class="set-height">
                <table class="table table-striped table-bordered">	                
	                <tbody><?php
					if(isset($preventivo->id) && isset($quotefiles)){
					foreach($quotefiles as $prev) {
						$imagPath = url('/storage/app/images/quote/'.$prev->name);
						$titleDescriptions = (!empty($prev->title)) ? '<hr><strong>'.$prev->title.'</strong><p>'.$prev->description.'</p>' : "";
	        			$html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a class="btn btn-danger pull-right"  onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-trash"></i></a>'.$titleDescriptions.'</td></tr>';						
						
						$html .='<tr class="quoteFile_'.$prev->id.'"><td>';
						$utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', '=', 0)->get();							
						foreach($utente_file as $key => $val){
							$check = '';
							$array = explode(',', $prev->type);
                            if(in_array($val->ruolo_id,$array)){                    
                                $check = 'checked';
                            }
                            $specailcharcters = array("'", "`");
                            $rolname = str_replace($specailcharcters, "", $val->nome_ruolo);
                            $html .=' <div class="cust-checkbox"><input type="checkbox" name="rdUtente_'.$prev->id.'"  '.$check.' id="'.$rolname.'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.',this.id);"  value="'.$val->ruolo_id.'" /><label for="'.$rolname.'_'.$prev->id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';
						}
						echo $html .='</td></tr>';
						}
					}
                    ?></tbody>
                    <tbody id="files">
	                </tbody>
                    
	                <script>
	                
	                    var selezione = [];
	                    var nFile = 0;
	                    var kFile = 0;
	                    $('#aggiungiFile').on("click", function() {
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
	                        $('.selezione').on("click", function() {
				                selezione[nFile] = $j(this).parent().parent();
				                nFile++;
		                	});
	                    });
	                    $('#eliminaFile').on("click", function() {
	                       for(var i = 0; i < nFile; i++) {
	                           selezione[i].remove();
	                       }
	                       nFile = 0;
	                    });
	                </script>
	            </table><hr></div>
	            </div></div>
            </div>	
            </div>
            </div>
            
            	
	</div>
</div>


<div class="modal fade" id="addMediacommnetmodal" role="dialog" aria-labelledby="modalTitle">
    <div class="modal-dialog modal-l">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="modalTitle">{{trans('messages.keyword_add_title_and_description')}}</h3>
            </div>
            <div class="modal-body">
                <!-- Start form to add a new event -->
                <form action="{{ url('/fatture/mediacomment/').'/'.$mediaCode }}" name="commnetform" method="post" id="commnetform">
                    {{ csrf_field() }}
                    @include('common.errors')                       
                    <div class="row">
                        <div class="col-md-12">                               
                            <div class="form-group">
                                <label for="title" class="control-label"> {{ ucfirst(trans('messages.keyword_title')) }} <span class="required">(*)</span> </label>
                                <input value="{{ old('title') }}" type="text" name="title" id="title" class="form-control" placeholder="{{ ucfirst(trans('messages.keyword_title')) }} ">
                            </div>
                            <div class="form-group">
                                <label for="descriptions" class="control-label"> {{ ucfirst(trans('messages.keyword_description')) }} <span class="required">(*)</span></label>
                                <textarea rows="5" name="descriptions" id="descriptions" class="form-control" placeholder="{{ ucfirst(trans('messages.keyword_description')) }}">{{ old('descriptions') }}</textarea>
                            </div>
                        </div>
                     </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_submit') }} ">
                    </div>
                </form>
                <!-- End form to add a new event -->
            </div>
        </div>
    </div>
</div>


</div>



<div class="footer-svg">
  <img src="http://betaeasy.langa.tv/dev/images/FOOTER2_RB_ACCOUNTING.svg" alt="footer enti image">
</div>




<script type="text/javascript">
$(document).ready(function() {
      $("#commnetform").validate({            
            rules: {
                title: {
                    required: true
                },
                descriptions: {
                    required: true                    
                }
            },
            messages: {
                title: {
                    required: "{{trans('messages.keyword_please_enter_a_title')}}"
                },
                descriptions: {
                    required: "{{trans('messages.keyword_please_enter_a_description')}}"
                }
            }
        });

      $(function(){
        $('#commnetform').on('submit',function(e){
            $.ajaxSetup({
                header:$('meta[name="_token"]').attr('content')
            })
            e.preventDefault(e);
                $.ajax({
                type:"POST",
                url:'{{ url('/fatture/mediacomment/').'/'.$mediaCode }}',
                data:$(this).serialize(),
                //dataType: 'json',
                success: function(data) {                    
                    if(data == 'success'){
                         $.ajax({url: urlgetfile, success: function(result){                
                            $("#files").html(result);
                            $(".dz-preview").remove();
                            $(".dz-message").show();
                        }});
                      $('#addMediacommnetmodal').modal('hide');
                    }
                },
                error: function(data){                   
                  if(data == 'success'){
                        $.ajax({url: urlgetfile, success: function(result){                
                            $("#files").html(result);
                            $(".dz-preview").remove();
                            $(".dz-message").show();
                        }});
                      $('#addMediacommnetmodal').modal('hide');
                    }
                }
            })
            });
        });
    });

$(document).ready(function() {
      
	// validate add invoice form on keyup and submit
    $("#add_fattura").validate({
        
        rules: {   
        	idfattura: {
        		digits:true
        	},
        	legameprogetto: {
        		required: true
        	},        
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
        	legameprogetto: {
                required: "{{ trans('messages.keyword_please_select_projectlink') }}"
            },
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