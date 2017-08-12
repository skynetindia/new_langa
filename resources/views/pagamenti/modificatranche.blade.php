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
<div class="header-lst-img">
	<div class="header-svg text-left float-left">
        <img src="{{url('images/HEADER1_LT_ACCOUNTING.svg')}}" alt="header image">
    </div>
    <div class="float-right text-right">
    	<h1> {{ trans('messages.keyword_editinvoice') }} <?php if(!$tranche->idfattura) echo "#0000/" . date('y'); else echo $tranche->idfattura; ?></h1><hr>
    </div>
</div>

<div class="clearfix"></div>
<div class="height20"></div>
@include('common.errors')
<form action="{{url('/pagamenti/tranche/update') . '/' . $tranche->id}}" method="post" name="edit_fattura" id="edit_fattura">
	{{ csrf_field() }}
	<?php $mediaCode = date('dmyhis');?>
    <input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />
	@if(isset($tranche->idfattura))
    	<input name="idfattura" value="{{ $tranche->idfattura }}" type="hidden">   
    @endif
<div class="row">
	<div class="col-md-8 col-sm-12 col-xs-12">
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
						
                        <div class="modificatranshe-blade-pagamenti-head"><?php 
                            $quotereference = isset($tranche->quoteId) ? ':' . $tranche->quoteId . '/' . $tranche->quoteyear : ''; 
                        ?><label for="preventivo"> {{ trans('messages.keyword_project') }}  <input type="text" disabled value="<?php echo $projecreference = isset($tranche->datainizio) ? ':' . $tranche->id_disposizione . '/' . substr($tranche->datainizio, -2) : ':cod/anno' ?>" placeholder=":cod/anno" class="form-control"></label>
                        <label for="preventivo"> {{ trans('messages.keyword_entity') }}  <input type="text" disabled value="<?php echo isset($tranche->nomeazienda) ? ':' . $tranche->DA . '/' . $tranche->nomeazienda : ':cod/entity' ?>" placeholder=":cod/anno" class="form-control"></label>
                        <a href="{{ url('/pagamenti/tranche/pdf') . '/' . $tranche->id }}"  target="new" class="btn" type="button"><i class="fa fa-file-pdf-o"></i></a>
                        </div>
                        
			<h4> {{ trans('messages.keyword_invoice_header') }} </h4>
			
            
            
            <div class="row">
          		 <div class="col-md-3 col-sm-12 col-xs-12">
            	<div class="form-group">
                <!-- colonna a sinistra -->
                    <label for="sedelegaleente"> {{ trans('messages.keyword_registered_office_from') }} </label>
                    <select name="DA" id="sedelegaleente" class="js-example-basic-single form-control required-input error">
                        <option></option>
                        @foreach($enti as $ente)
                            @if($ente->id == $tranche->DA)
                                <option selected value="{{$ente->id}}">{{$ente->id}} | {{ ucwords(strtolower($ente->nomeazienda)) }}</option>
                            @else
                                <option value="{{$ente->id}}">{{$ente->id}} | {{ ucwords(strtolower($ente->nomeazienda)) }}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="sedelegaleente" generated="true" class="error"></label>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">    
                        <div class="form-group">
                        <label for="sedelegaleentea"> {{ trans('messages.keyword_registered_office_to') }} </label>
                        <select id="sedelegaleentea" name="A" class="js-example-basic-single form-control required-input error">
                            <option></option>
                            @foreach($enti as $ente)
                                @if($ente->id == $tranche->A)
                                    <option selected value="{{$ente->id}}">{{$ente->id}} | {{ ucwords(strtolower($ente->nomeazienda)) }}</option>
                                @else
                                    <option value="{{$ente->id}}">{{$ente->id}} | {{ ucwords(strtolower($ente->nomeazienda)) }}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="sedelegaleentea" generated="true" class="error"></label>
                        </div>
                   </div>
                   <div class="col-md-3 col-sm-12 col-xs-12">     
                        <div class="form-group">
                     <label for="id"> {{ trans('messages.keyword_invoicenumber') }} </label>
                    <input value="{{$tranche->idfattura}}" type="text" id="idfattura" name="idfattura" placeholder=" {{ trans('messages.keyword_invoicenumber') }} " class="form-control">
                        </div>
                   </div>     
                   <div class="col-md-3 col-sm-12 col-xs-12">     
                        <div class="form-group">
                        <label for="Tipo"> {{ trans('messages.keyword_type_of_invoice') }} </label>
                            <select id="Tipo" name="tipofattura" class="form-control">
                                @if($tranche->tipofattura == "NOTA DI CREDITO")
                                    <option value="0"> {{ trans('messages.keyword_sales_invoice') }} </option>
                                    <option value="1" selected> {{ trans('messages.keyword_credit_note') }} </option>
                                @else
                                    <option value="0" selected> {{ trans('messages.keyword_sales_invoice') }} </option>
                                    <option value="1"> {{ trans('messages.keyword_credit_note') }} </option>
                                @endif
                            </select>
                            </div>
                   </div>     
                   
            </div>
            
            
            
            <div class="row">
            	 <div class="col-md-4 col-sm-12 col-xs-12">
                   		<div class="form-group">
                            <label for="id"> {{ trans('messages.keyword_note') }}  </label>
                            <input value="{{$tranche->idfattura}}" type="text" id="id" name="idfattura" placeholder="{{ trans('messages.keyword_note') }} " class="form-control">
                         </div>
                   </div>
                   <div class="col-md-4 col-sm-12 col-xs-12">
                   		<div class="form-group">
                            <label for="emissione"> {{ trans('messages.keyword_issue_of_the') }} </label>
                            <input type="text" name="emissione" id="emissione" class="form-control required-input error" placeholder="{{ trans('messages.keyword_issue_of_the') }}" value="<?php 
                            if($tranche->emissione != '0000-00-00'){
                                $dateemi = str_replace('/', '-', $tranche->emissione);
                                echo date('d/m/Y', strtotime($dateemi));
                            }
                            ?>">
                                </div>
                   </div>
                   
                   
                   <div class="col-md-4 col-sm-12 col-xs-12">
                   		<div class="form-group">
                            <label for="base"> {{ trans('messages.keyword_on_the_base') }} </label>
                            <input class="form-control required-input error" type="text" name="base" id="base" placeholder="{{ trans('messages.keyword_on_the_base') }}" value="{{$tranche->base}}">
                            </div>
                   </div>
            </div>
            
            <div class="row">
            	<div class="col-md-4 col-sm-12 col-xs-12">
                   		<div class="form-group">
                            <label for="modalita"> {{ trans('messages.keyword_payment_methods') }} </label>
                            <input value="{{$tranche->modalita}}" type="text" class="form-control" id="modalita" name="modalita" placeholder=" {{ trans('messages.keyword_payment_methods') }} ">
                        </div>
                   </div>
                   <div class="col-md-4 col-sm-12 col-xs-12">
                   		<div class="form-group">
                                <label for="iban"> {{ trans('messages.keyword_company_iban') }} </label>
                                 <select name="iban" id="iban" class="js-example-basic-single form-control">
                                    <option></option>
                                    @foreach($enti as $ente)
                                        @if($ente->iban == $tranche->iban)
                                            <option selected value="{{$ente->iban}}">{{$ente->id}} | {{ ucwords(strtolower($ente->nomeazienda)) }}</option>
                                        @else
                                            <option value="{{$ente->iban}}">{{$ente->id}} | {{ ucwords(strtolower($ente->nomeazienda)) }}</option>
                                        @endif
                                    @endforeach
                                </select><script type="text/javascript">
                        
                            $(".js-example-basic-single").select2();
                        
                       		 </script>
                       </div>
                   </div>
                   <div class="col-md-4 col-sm-12 col-xs-12">
                   		<div class="form-group">
                             <label for="indirizzospedizione"> {{ trans('messages.keyword_shipping_address') }} </label>
                            <select name="indirizzospedizione" id="indirizzospedizione" class="js-example-basic-single form-control">
                                <option></option>
                                @foreach($enti as $ente)
                                    @if($ente->id == $tranche->indirizzospedizione)
                                        <option selected value="{{$ente->indirizzospedizione}}">{{$ente->id}} | {{ ucwords(strtolower($ente->nomeazienda)) }}</option>
                                    @else
                                        <option value="{{$ente->indirizzospedizione}}">{{$ente->id}} | {{ ucwords(strtolower($ente->nomeazienda)) }}</option>
                                    @endif
                                @endforeach
                            </select>
                            </div>
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
            <div class="row">
	        <div class="col-md-12">
            		<!-- <a target="new" href="{{url('/pagamenti/tranche/corpofattura') . '/' . $tranche->id}}" class="btn btn-info" style="color:#ffffff;text-decoration: none" title="Vedi Corpo fattura esistenti"><i class="fa fa-info"></i></a> -->
                    @if(checkpermission('5', '20', 'scrittura','true'))
	                <a class="btn btn-warning" id="aggiungiCorpo"><i class="fa fa-plus"></i></a>
	                <a class="btn btn-danger" id="eliminaCorpo"><i class="fa fa-trash"></i></a>
                    @endif
	        </div>
            </div>
            <div class="height10"></div>
            <div class="set-height450">
	    	<table class="table table-bordered modificatranshe-blade-pagamenti-tbl">
	    		<thead>
	    			<th> #</th>
                    <th> {{ trans('messages.keyword_order') }} </th>
	    			<th> {{ trans('messages.keyword_references') }} </th>
	    			<th> {{ trans('messages.keyword_description') }}</th>
	    			<th> {{ trans('messages.keyword_qty') }}, {{ trans('messages.keyword_unitary') }} </th>
	    			<th> {{ trans('messages.keyword_subtotal') }} </th>
	    		</thead>

	    		<tbody id="corpofattura">
	    		<?php $pbody = 0;?>
	    		@foreach($invoicebody as $keybody => $keyval)
	    			<tr>
	    				<td><input class="selezione" id="checkinv{{$keybody}}" type="checkbox"><label for="checkinv{{$keybody}}"></label></td>
                        <td><input name="ordine_numerico[]" type="number" class="form-control priority" value="{{$keyval->ordine_numerico}}" placeholder="{{ trans('messages.keyword_order') }}"></td>                
	    				<td><input class="form-control" placeholder=":{{ trans('messages.keyword_quote') }}" name="ordine[]" type="text" value="{{$keyval->ordine}}">
	    				<input placeholder=":{{trans('messages.keyword_project')}}" class="form-control" name="project_refer_no[]" type="text" value="{{$keyval->project_refer_no}}"></td>
	    				<td><textarea class="form-control" name="desc[]" placeholder="{{ trans('messages.keyword_description') }}" rows="3" cols="80">{{$keyval->descrizione}}</textarea></td>
	    				<td><input class="form-control qt" placeholder=":Qty" name="qt[]" type="text" value="{{$keyval->qta}}">
	    				<input class="form-control pr" placeholder=":Unit Price" name="unitario[]" type="text" value="{{$keyval->netto}}"></td>
	    				<td><input class="form-control tot" name="subtotale[]" placeholder="{{ trans('messages.keyword_subtotal') }}" type="text" value="{{$keyval->subtotale}}">
	    				<div class="switch">
	    					<input value="1" class="astircflag" name="is_active[{{$keybody}}]" id="is_active_{{$keybody}}" <?php echo ($keyval->is_active == '1') ? 'checked' : ''?> type="checkbox">
	    					<label for="is_active_{{$keybody}}"></label>
	    				</div>
	    				</td></tr>
	    				<?php $pbody++;?>
	    		@endforeach
	    		</tbody>
	    		 <script>
			 		var kCorpo = '{{$pbody}}';
				 	var selezioneCorpo = [];
	                    var nCorpo = '{{$pbody}}';
	                    var count = '{{$pbody}}';
	                    $j('#aggiungiCorpo').on("click", function() {
	                        var tab = document.getElementById("corpofattura");
	                        var tr = document.createElement("tr");
	                        var check = document.createElement("td");
	                        var checkbox = document.createElement("input");
	                        checkbox.type = "checkbox";
	                        checkbox.className = "selezione";
	                        checkbox.id = "checkinv"+count;
	                        check.appendChild(checkbox);

	                        var checkboxLabel = document.createElement("label");                               
                            checkboxLabel.setAttribute('for', "checkinv"+count);
                            var td = document.createElement("td");
                            check.appendChild(checkboxLabel);

                            
                            var ordine_numericotd = document.createElement("td");
                            var ordine_numerico = document.createElement("input");
                            ordine_numerico.className = "form-control";
                            ordine_numerico.name = "ordine_numerico[]";   
                            ordine_numerico.value = count;                        
                            ordine_numerico.placeholder = "{{ trans('messages.keyword_order') }}";
                            ordine_numericotd.appendChild(ordine_numerico);

	                        var ord = document.createElement("td");
	                        var ordine = document.createElement("input");
	                        ordine.type = "text";
	                        ordine.className = "form-control";
	                        ordine.placeholder = ":{{ trans('messages.keyword_quote') }}";
	                        ordine.name = "ordine[]";
                            ordine.value="{{$quotereference}}";							
	                        ord.appendChild(ordine);

	                        var progetto = document.createElement("input");
	                        progetto.type = "text";
	                        progetto.placeholder = ":{{ trans('messages.keyword_project') }}";
	                        progetto.className = "form-control";
	                        progetto.name = "project_refer_no[]";
                            progetto.value="{{$projecreference}}";
							// progetto.value = ":";
	                        ord.appendChild(progetto);

	                        var td = document.createElement("td");
	                        var descrizione = document.createElement("textarea");
	                        descrizione.className = "form-control";
	                        descrizione.name = "desc[]";
	                        descrizione.rows = "3";
	                        descrizione.cols = "80";
                            descrizione.placeholder = "{{ trans('messages.keyword_description') }}";
	                        td.appendChild(descrizione);

	                        var qt = document.createElement("td");
	                        var quantita = document.createElement("input");
	                        quantita.type = "text";
	                        quantita.className = "form-control qt";
	                        quantita.placeholder = ":{{ trans('messages.keyword_qty') }}";
	                        quantita.name = "qt[]";
	                        qt.appendChild(quantita);

	                        var unitario = document.createElement("td");
	                        var unitary = document.createElement("input");
	                        unitary.type = "text";
	                        unitary.className = "form-control pr";
	                        unitary.placeholder = ":{{ trans('messages.keyword_unit_price') }}";
	                        unitary.name = "unitario[]";
							qt.appendChild(unitary);


	                        var pr = document.createElement("td");
	                        var prezzo = document.createElement("input");
	                        prezzo.type = "text";
	                        prezzo.className = "form-control tot";
	                        prezzo.name = "subtotale[]";
                            prezzo.placeholder ="{{ trans('messages.keyword_subtotal') }}";
	                        pr.appendChild(prezzo);

	                        var idNotificheDiv = document.createElement("div");
								idNotificheDiv.className='switch';
								
								var idNotificheLabel = document.createElement("label");
								idNotificheLabel.for = "is_active_"+count;
								idNotificheLabel.setAttribute('for', "is_active_"+count);
								var idNotifiche = document.createElement("input");
				                idNotifiche.type = "checkbox";	                        
				                idNotifiche.value = '1';
				                idNotifiche.name = "is_active["+count+"]";
								idNotifiche.id = "is_active_"+count;
                                idNotifiche.className = "astircflag";
								idNotificheDiv.appendChild(idNotifiche);
								idNotificheDiv.appendChild(idNotificheLabel);
								pr.appendChild(idNotificheDiv);


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
                            tr.appendChild(ordine_numericotd);                            
	                        tr.appendChild(ord);
	                        tr.appendChild(td);
	                        tr.appendChild(qt);
	                        tr.appendChild(pr);

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
			<h4> {{ trans('messages.keyword_base_invoice') }} </h4><a onclick="calcola()"  class="" title=" {{ trans('messages.keyword_assembled_compilation') }} "><br>{{ trans('messages.keyword_click') }}  <i class="fa fa-info"></i> {{ trans('messages.keyword_for_compilation') }} </i></a>
            <div class="table-responsive">
	   	<table class="table table-bordered">
	   		<thead>	   			 
                <th> {{ ucfirst(strtolower(trans('messages.keyword_weight'))) }} (kg) </th>
	   			<th> {{ trans('messages.keyword_network') }} </th>
	   			<th> {{ trans('messages.keyword_additional_discount') }} </th>
	   			<th> {{ trans('messages.keyword_total_net') }} </th>
	   			<th> {{ trans('messages.keyword_taxable_invoice') }} </th>
	   			<th> {{ trans('messages.keyword_vat_price') }} </th>
	   			<th>% {{ trans('messages.keyword_vat') }} </th>
	   			<th> {{ trans('messages.keyword_amount_due') }} </th>
	   		</thead>
	   		<tbody>
                <td><input id="peso" class="form-control" type="text" name="peso" placeholder="{{ucfirst(strtolower(trans('messages.keyword_weight')))}}" value="{{$tranche->peso}}"></td>
	   			<td><input id="netto" class="form-control" type="text" name="netto" placeholder="{{trans('messages.keyword_network')}}" value="{{$tranche->netto}}"></td>

	   			<td><input id="scontoaggiuntivo" class="form-control" type="text" placeholder="{{trans('messages.keyword_additional_discount')}}"  name="scontoaggiuntivo" value="{{$tranche->scontoaggiuntivo}}"></td>

	   			<td><input id="sconto" class="form-control" type="text" placeholder="{{trans('messages.keyword_total_net')}}"  name="scontoaggiuntivo" value="{{$tranche->scontoaggiuntivo}}"></td>

	   			<td><input id="imponibile" class="form-control" type="text" placeholder="{{trans('messages.keyword_taxable_invoice')}}"  name="imponibile" value="{{$tranche->imponibile}}"></td>

	   			<td><input id="prezzoiva" class="form-control" type="text" placeholder="{{trans('messages.keyword_vat_price')}}"  name="prezzoiva" value="{{$tranche->prezzoiva}}"></td>

	   			<td><input id="percentualeiva" class="form-control" type="text" placeholder="% {{ trans('messages.keyword_vat') }}"  name="percentualeiva" value="<?php 
                if(isset($tranche->percentualeiva) && $tranche->percentualeiva != null){
                    echo $tranche->percentualeiva;
                }
                elseif(isset($taxation->tassazione_percentuale)){
                    echo $taxation->tassazione_percentuale;   
                }
                ?>"></td>

	   			<td><input id="dapagare" class="form-control" placeholder="{{trans('messages.keyword_amount_due')}}"  type="text" name="dapagare" value="{{$tranche->dapagare}}"></td>

                <script>
                    $('table').on('change','tr input.qt', function() {
                         var prezzo = $(this).parent().closest('tr').find("input.pr").val();
                         var qta = $(this).val();
                         $(this).parent().closest('tr').find("input.tot").val(prezzo * qta);
                         calculateTotal();
                    });
                    
                    $('table').on('change','tr input.pr', function() {
                         var prezzo = $(this).val();
                         var qta = $(this).parent().closest('tr').find("input.qt").val();
                         $(this).parent().closest('tr').find("input.tot").val(prezzo * qta);
                         calculateTotal();
                    });
                    $('table').on('change','tr input.tot', function() {             
                         calculateTotal();
                    });
                    $('table').on('change','tr input.astircflag', function() {             
                         calculateTotal();
                    });
                    $('form').on('change','div input#percentuale', function() {                                     
                         calculateTotal();
                    });                   
                    $('form').on('change','div input#importo_nopercentuale', function() {                                     
                         calculateTotal();
                    });                   
                     $('table').on('change','tr input#scontoaggiuntivo', function() {                                     
                         finalamount();
                    });
                     $('table').on('change','tr input#percentualeiva', function() {                                     
                         finalamount();
                    });

                     
                     
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
                        var additionaldiscount =  $("scontoaggiuntivo").val() || 0;

						var importototale = eval(prompt("{{trans('messages.keyword_enter_the_amount_equivalent_to')}} 100%", netto));
						sconto = eval(prompt("{{trans('messages.keyword_enter_the_additional_discount')}} (€)", additionaldiscount));
						//percentuale = eval(prompt("{{trans('messages.keyword_enter_the_percentage_of_total_amount')}} (%)", percentuale));
                        
                        netto = netto - additionaldiscount
                        //var netprice = (netto - ((importototale - sconto) * percentuale / 100));
						netto = eval(prompt("{{trans('messages.keyword_enter_the_net_price')}} (€)", netto));
						imponibile = eval(prompt("{{trans('messages.keyword_enter_the_taxable_amount')}} (€)", netto));
						percentualeiva = eval(prompt("{{trans('messages.keyword_enter_the_vat')}} (%)", percentualeiva));
						prezzoiva = eval(prompt("{{trans('messages.keyword_enter_the_price_with_vat')}} (€)", imponibile * percentualeiva / 100));
						dapagare = eval(prompt("{{trans('messages.keyword_enter_the_total_payable')}} (€)", imponibile + prezzoiva));
						
						/*approssima(netto);
						approssima(imponibile);
						approssima(prezzoiva);
						approssima(dapagare);*/
                        
						$j('#percentuale').val(percentuale);
						$j('#netto').val(importototale);
						$j('#sconto').val(sconto);
                        $j('#scontoaggiuntivo').val(sconto);
                        
						$j('#imponibile').val(imponibile);
						$j('#prezzoiva').val(prezzoiva);
						$j('#percentualeiva').val(percentualeiva);
						$j('#dapagare').val(dapagare);
					}
                    function calculateTotal(){
                        var totalval = 0;   
                        var arrchekedp=[];
                        $(".astircflag").each(function(index) {
                            arrchekedp[index] = false;
                            if ($(this).is(':checked')) {
                                arrchekedp[index] = true;    
                            }
                        });
                        $(".tot").each(function(index) {
                             if(arrchekedp[index]==false && $(this).val() != "" && $(this).val() != 0) {
                                totalval = (parseFloat(totalval) + parseFloat($(this).val()));        
                            }
                        });                        
                        var percentuale = $("#percentuale").val();
                        var percentageAmount = $("#importo_nopercentuale").val();                        
                        if(parseInt(percentuale) > 0 ) {
                            var discountamount = ((totalval * percentuale) / 100);
                            totalval = (totalval - discountamount);
                        }
                        else if(parseInt(percentageAmount) > 0) {
                            totalval = (totalval - percentageAmount);                               
                        }
                        $("#netto").val(totalval);
                        finalamount();
                        /*var scontoagente = $("#scontoagente").val();
                        var scontobonus = $("#scontobonus").val();
                        var agentdiscount = ((totalval * scontoagente) / 100);
                        var topay = (totalval - agentdiscount);

                        var agentbonus = ((topay * scontobonus) / 100);
                        var TotalDiscount = (agentdiscount + agentbonus);    
                        topay = (topay - agentbonus);
                        $("#totale").val(TotalDiscount);
                        $("#totaledapagare").val(topay);*/
                        /*$("#agentdiscount").val(agentdiscount);
                        $("#agentbonus").val(agentbonus);*/
                    }
                    function finalamount() {
                        var NetWork = $("#netto").val();
                        var additionaldiscount =  $("#scontoaggiuntivo").val() || 0;
                        var vatpercentage = $j('#percentualeiva').val() || 0;
                        var totalNet = (NetWork - additionaldiscount);
                        $("#sconto").val(totalNet);
                        $("#imponibile").val(totalNet);
                        var getpercentageval = (totalNet * vatpercentage / 100);
                        vat = $("#prezzoiva").val(getpercentageval);
                        var amountdue = (totalNet + getpercentageval);                        
                        $("#dapagare").val(amountdue);                        
                    }					
				</script>
	   		</tbody>
	   	</table>
        </div>
    @if(checkpermission('5', '20', 'scrittura','true'))
	<div class="row">
    <div class="col-md-2 col-sm-12 col-xs-12 mb16 show-desktop">
		<input onclick="mostra2()" type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_save') }}">
	</div>
    </div>
    @endif
	</div>
	<div class="col-md-4 col-sm-12 col-xs-12">
    	<div class="clearfix"></div>
        <div class="height10"></div>
        
        <div class="form-group">
		<label for="statoemotivo"> {{ trans('messages.keyword_emotional_state') }} </label>
		<select name="statoemotivo" class="form-control" id="statoemotivo" >
			<!-- statoemotivoselezionato -->
			@if($statoemotivoselezionato!=null)
				@foreach($statiemotivi as $statoemotivo)
                <?php $label = (!empty($statoemotivo->language_key)) ?  ucwords(strtolower(trans('messages.'.$statoemotivo->language_key))) : (($statoemotivo->name)); ?>
					<option @if($statoemotivo->id == $statoemotivoselezionato->id_tipo) selected @endif style="background-color:{{$statoemotivo->color}};color:#ffffff" value="{{$statoemotivo->id}}">{{ ucwords(strtolower($label)) }}</option>
				@endforeach
			@else
				@foreach($statiemotivi as $statoemotivo)
                   <?php $label = (!empty($statoemotivo->language_key)) ?  ucwords(strtolower(trans('messages.'.$statoemotivo->language_key))) : (($statoemotivo->name)); ?>
					<option style="background-color:{{$statoemotivo->color}};color:#ffffff" value="{{$statoemotivo->id}}">{{ ucwords($label) }}</option>
				@endforeach
			@endif
		</select>
        </div>
		<script>
		var yourSelect = document.getElementById( "statoemotivo" );
			document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		$('#statoemotivo').on("change", function() {
			var yourSelect = document.getElementById( "statoemotivo" );
			document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		});
		</script>
		<div class="form-group">
		 <label for="privato"> {{ trans('messages.keyword_hide_stats') }} </label>
		  <i class="fa fa-eye-slash" title="{{ trans('messages.keyword_ifso') }} "></i>
            <select class="form-control" name="privato">
            	@if($tranche->privato == 0)
                    <option value="0" selected> {{ trans('messages.keyword_no') }} </option>
                    <option value="1"> {{ trans('messages.keyword_yes') }} </option>
                @else
                	<option value="0"> {{ trans('messages.keyword_no') }} </option>
                    <option value="1" selected> {{ trans('messages.keyword_yes') }} </option>
                @endif
            </select>
		</div>
        <div class="form-group">
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
        </div>    
            
		<!-- 	<div id="frequenza">
		    <br><label for="frequ">Frequenza <p style="color:#f37f0d;display:inline">(In giorni)</p></label>
		    <input value="{{$tranche->frequenza}}" id="frequ" name="frequenza" class="form-control" placeholder="Frequenza">
		</div> -->
        <div class="form-group">
			<label for="percentuale">% {{ trans('messages.keyword_total_amount') }} </label>
			<input id="percentuale" name="percentuale" class="form-control required-input error" value="{{$tranche->percentuale}}" placeholder="{{ trans('messages.keyword_total_amount') }} ">
        </div>   
        <div class="form-group"> 
            <div id="percentualediv">
		    <label for="frequ"> {{ trans('messages.keyword_amount') }} </label>
		    <input name="importo_nopercentuale" id="importo_nopercentuale" class="form-control" placeholder="{{ trans('messages.keyword_amount') }} " value="<?php echo $tranche->testoimporto; ?>">
		</div>
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
                var value = $j(this).val();
                if(value >= 100 ){
                    $j(this).val(99);
                }
				test();
			});
			</script>
			<div class="form-group">
            <label for="datascadenza"> {{ trans('messages.keyword_expiry_date_invoice') }}  </label>
		    <input value="<?php 
		    $datedatascadenza = str_replace('/', '-', $tranche->datascadenza);
			echo ($tranche->datascadenza != '0000-00-00') ? date('d/m/Y', strtotime($datedatascadenza)) : '';
		    ?>" class="form-control required-input error" name="datascadenza" placeholder="{{trans('messages.keyword_expiry_date_invoice')}}" id="datascadenza"></input>
            </div>
           
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
          	<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="bg-white image-upload-box">
	        <label for="scansione"> {{ trans('messages.keyword_attach_administrative_file') }} </label>            
            <div class="row">
	        <div class="col-md-12 col-sm-12 col-xs-12">
            	<div class="image_upload_div">
                <?php echo Form::open(array('url' => '/add/fatture/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
						{{ csrf_field() }}
						<input type="hidden" name="idtranche" name="idtranche" value="{{ $tranche->id }}">						
    			</form>				
				</div>
				<script>
				var urlgetfile = '<?php echo url('/add/fatture/getfiles/'.$mediaCode); ?>';
				Dropzone.autoDiscover = false;
				$j(".dropzone").each(function() {
				  $j(this).dropzone({
					complete: function(file) {
					  if (file.status == "success") {
					  	 $j.ajax({url: urlgetfile, success: function(result){
        					$j("#files").html(result);
							$j(".dz-preview").remove();
							$j(".dz-message").show();
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
						$j.ajax({url: urlD, success: function(result){
							$j(".quoteFile_"+id).remove();
					    }});
				}
 				function updateType(typeid,fileid,checkboxid1){           
                    var ischeck = 0;            
                    if($('#'+checkboxid1+':checkbox:checked').length > 0){                
                        var ischeck = 1;
                    }
                    var checkValues = $('input[name=rdUtente_'+fileid+']:checked').map(function()
                    {
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
                <div class="space30"></div>
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <input type="text" class="form-control" name="searchmediabox" id="searchmediabox" placeholder="{{trans('messages.keyword_search_media')}}">
                </div>
            </div>
            </div>
			<div class="set-height">
	            <table class="table table-striped table-bordered">	                
	                <tbody id="mainmedialist"><?php
					if(isset($tranche->id) && isset($quotefiles)){
						foreach($quotefiles as $prev) {
							$imagPath = url('/storage/app/images/quote/'.$prev->name);
							$downloadlink = url('/storage/app/images/quote/'.$prev->name);
							$filename = $prev->name;			
							$arrcurrentextension = explode(".", $filename);
							$extention = end($arrcurrentextension);
										
							$arrextension['docx'] = 'docx-file.jpg';
							$arrextension['pdf'] = 'pdf-file.jpg';
							$arrextension['xlsx'] = 'excel.jpg';
							if(isset($arrextension[$extention])){
								$imagPath = url('/storage/app/images/invoice/default/'.$arrextension[$extention]);			
							}

							
							$titleDescriptions = (!empty($prev->title)) ? '<hr><strong>'.$prev->title.'</strong><p>'.$prev->description.'</p>' : "";
	        				$html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a href="'.$downloadlink.'" class="btn btn-info pull-right"  download><i class="fa fa-download"></i></a><a class="btn btn-danger pull-right"  onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-trash"></i></a>'.$titleDescriptions.'</td></tr>';							

							$html .='<tr class="quoteFile_'.$prev->id.'"><td>';
							$utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', '=', 0)->where('nome_ruolo','!=','SupperAdmin')->get();							
							foreach($utente_file as $key => $val){
								$check = '';
								$array = explode(',', $prev->type);
	                            if(in_array($val->ruolo_id,$array)){                    
	                                $check = 'checked';
	                            }
	                            $specailcharcters = array("'", "`");
	                            $rolname = str_replace($specailcharcters, "", $val->nome_ruolo);
	                            $html .=' <div class="cust-checkbox"><input type="checkbox" name="rdUtente_'.$prev->id.'"  '.$check.' id="'.trim($rolname).'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.',this.id);"  value="'.$val->ruolo_id.'" /><label for="'.trim($rolname).'_'.$prev->id.'"> '.trim($val->nome_ruolo).'</label><div class="check"><div class="inside"></div></div></div>';
							}
							echo $html .='</td></tr>';
						}
					}
                    ?></tbody>
                    <tbody id="files"></tbody>
                    
	                <script>
                    $('#searchmediabox').keyup(function(e) {
                        var keyvalue = $(this).val();
                         var urlgetfile = '<?php echo url('/invoice/searchmedia/'.$tranche->id); ?>';   
                         if(keyvalue !=""){
                             var urlgetfile = '<?php echo url('/invoice/searchmedia/'.$tranche->id); ?>/'+keyvalue;   
                         }  
                         $.ajax({url: urlgetfile, success: function(result){
                            $("#mainmedialist").html(result);
                           // $(".dz-preview").remove();
                            //$(".dz-message").show();
                        }
                        });                   
                    });
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
	            </table>
                </div>
                <hr>
	            </div>
			</div>
            </div>
            </div>
            </div>
		
	</div>
    
   
    <div class="col-md-2 col-sm-12 col-xs-12 mb16 show-mobile">
		<input onclick="mostra2()" type="submit" class="btn btn-warning" value="{{ trans('messages.keyword_save') }}">
	</div>
  
    
</div>
<div class="footer-svg">
  <img src="{{url('images/FOOTER2_RB_ACCOUNTING.svg')}}" alt="footer enti image">
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
                                <label for="title" class="control-label"> {{ ucfirst(trans('messages.keyword_title')) }} </label>
                                <input value="{{ old('title') }}" type="text" name="title" id="title" class="form-control required-input" placeholder="{{ ucfirst(trans('messages.keyword_title')) }} ">
                            </div>
                            <div class="form-group">
                                <label for="descriptions" class="control-label"> {{ ucfirst(trans('messages.keyword_description')) }} </label>
                                <textarea rows="5" name="descriptions" id="descriptions" class="form-control required-input" placeholder="{{ ucfirst(trans('messages.keyword_description')) }}">{{ old('descriptions') }}</textarea>
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