@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
 <link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>

<style>
tr:hover td {
    background: #f2ba81;
}
.selected {
    background: #f37f0d;
}
</style>
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<h1> {{trans('messages.keyword_modifyquote')}}  :<?php echo $preventivo->id . '/' . $preventivo->anno;?></h1>



<hr>

<!--
'preventivi'
'utenti'
'enti'
'dipartimenti'
-->
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

@include('common.errors')

<script>$.datepicker.setDefaults(
    $.extend(
        {'dateFormat':'dd/mm/yy'},
         $.datepicker.regional['nl']
    )
);</script>
<div class="col-md-12">
    <div class="col-md-8">
    <?php echo Form::open(array('url' => '/preventivi/modify/quote' . '/' . $preventivo->id, 'files' => true)) ?>
    <?php $mediaCode = date('dmyhis');?>
{{ csrf_field() }}
<input type="hidden" name="idutente" value="{{$preventivo->idutente}}">
<input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />

        <label for="id"> {{trans('messages.keyword_no_estimate')}} 
			<input disabled value=":{{$preventivo->id}}/{{$preventivo->anno}}" type="text" id="id" name="id" placeholder=" {{trans('messages.keyword_codebudget')}}  " class="form-control">
		</label>
		<div class="btn-group">
        	<a target="new" href="{{url('/preventivi/pdf/quote/') . '/' . $preventivo->id}}" class="btn" title="Vedi preventivo" style="display:inline;background-color:#DDD"><i class="fa fa-file-pdf-o"></i></a>
        </div>
        <br>
		<label for="oggetto">{{trans('messages.keyword_name_quotation')}} </label>
        <input value="{{$preventivo->oggetto}}" type="text" id="oggetto" name="oggetto" placeholder="{{trans('messages.keyword_name_quotation')}}" class="form-control"><br>
        <div class="row">
    			<div class="col-md-4">
    				<label for="dipartimento">{{trans('messages.keyword_from')}}</label>
                        <select name="dipartimento" class="js-example-basic-single form-control">
                            <option selected></option>
                            @foreach($dipartimenti as $dipartimento)   
                                @if($dipartimento->id == $preventivo->dipartimento)
                                    <option selected value="{{$dipartimento->id}}">{{$dipartimento->nomedipartimento}}</option>
                                @else
                                    <option value="{{$dipartimento->id}}">{{$dipartimento->nomedipartimento}}</option>
                                @endif
                            @endforeach
                        </select>
    			</div>
    			<div class="col-md-4">
    				<label for="idente">{{trans('messages.keyword_to')}}</label>
                    <select name="idente" class="js-example-basic-single form-control">
                        <option selected></option>
                        @foreach($enti as $ente)
                            @if($ente->id == $preventivo->idente)
                                <option selected value="{{$ente->id}}">{{$ente->nomeazienda}} | {{$ente->nomereferente}}</option>
                            @else
                                <option value="{{$ente->id}}">{{$ente->nomeazienda}}</option>
                            @endif
                        @endforeach
                    </select><script type="text/javascript">

    $(".js-example-basic-single").select2();

</script>
    			</div>
    			
    			<div class="col-md-4">
    				<label for="data">{{trans('messages.keyword_date')}}</label>
                    <input value="{{$preventivo->data}}"type="text" id="data" name="data" placeholder="{{trans('messages.keyword_date_creation_preventive')}}" class="form-control"><br>
    			</div>
        </div>


		<div class="col-md-12">

    <h4>{{trans('messages.keyword_packages_and_optional')}}</h4><hr>
    <div class="col-md-4">        
         <a target="new" href="{{url('/preventivi/optional') . '/' . $preventivo->id}}" class="btn btn-info" style="color:#ffffff;text-decoration: none" title="Vedi Optional già inseriti"><i class="fa fa-info"></i></a>
	    <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="add"><i class="fa fa-plus"></i></a>
	    <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="delete"><i class="fa fa-eraser"></i></a>
    </div>
    <div class="col-md-4">
            <label>{{trans('messages.keyword_list_of_packages')}}</label>
        <select style="display:inline" id="pacchetti" class="js-example-basic-single form-control">
            <option></option>
            @foreach($pacchetti as $pacchetto)
                <option value="{{$pacchetto->id}}">{{$pacchetto->label}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
            <label>{{trans('messages.keyword_optional_list')}}/label>
        <select style="display:inline" id="optional" class="js-example-basic-single form-control">
            <option></option>
            @foreach($optional as $opt)
                <option value="{{$opt->id}}">{{$opt->label}}</option>
            @endforeach
        </select><script type="text/javascript">

    $(".js-example-basic-single").select2();

</script>
    </div>
    
    <div class="col-md-12">
        <br>
        <table id="table" class="table table-bordered">
            <thead>
                <th>#</th>
              <!--  <th>Ordine</th>
                <th>Codice</th>-->
                <th>{{trans('messages.keyword_object')}}</th>
                <th>{{trans('messages.keyword_description')}}</th>
                <th>{{trans('messages.keyword_qty')}}</th>
                <th>{{trans('messages.keyword_unit_price')}}</th>
                <th>{{trans('messages.keyword_subtotal')}}</th>
                <th>{{trans('messages.keyword_cyclicality')}}</th>
                <th>{{trans('messages.keyword_asterisca')}}</th>
            </thead>
            <tbody id="tabella">
            </tbody>
        </table>
    </div>
    <script>
        var pacchetti = <?php echo json_encode($pacchetti); ?>;
        var pacchettiLength = Object.keys(pacchetti).length;
        var optional = <?php echo json_encode($optional); ?>;
        var optionalLength = Object.keys(optional).length;
        var optionalPack = <?php echo json_encode($optional_pack); ?>;
        var optionalPackLength = Object.keys(optionalPack).length;
        
        $('#pacchetti').on("change", function() {
            var id = $('#pacchetti').val();
            for(var i = 0; i < pacchettiLength; i++) {
                if(pacchetti[i]['id'] == id) {
                    // Per ogni optional confronto il suo id con quello negli optional_pack
                    for(var k = 0; k < optionalLength; k++) {
                        for(var j = 0; j < optionalPackLength; j++) {
                            if(optionalPack[j]['pack_id'] == id) {
                                if(optional[k]['id'] == optionalPack[j]['optional_id']) {
                                    // Per ogni optional del pacchetto
                                    var tr = document.createElement("tr");
                                    // Checkbox
                                    var checkbox = document.createElement("input");
                                    checkbox.type = "checkbox";
                                    checkbox.className = "selezione";
                                    var td = document.createElement("td");
                                    td.appendChild(checkbox);
                                    
									/*var ordine = document.createElement("input");
                                    ordine.type = "number";
                                    var qt1 = document.createElement("td");
                                    ordine.value = 1;
                                    ordine.name = "ordine[]";
                                    ordine.className = "form-control";
                                    qt1.appendChild(ordine);
									
                                    // Codice
                                    var idogg = optional[k]['id'];
                                    var codice = document.createElement("td");
                                    var codiceInput = document.createElement("input");
                                    codiceInput.type = "number";
                                    codiceInput.value = idogg;
                                    codiceInput.name = "codici[]";
                                    codiceInput.className ="form-control";
                                    codice.appendChild(codiceInput);*/
                                    
                                    // Oggetto
                                    var label = optional[k]['label'];
                                    var oggetto = document.createElement("td");
                                    var input = document.createElement("input");
                                    input.type = "text";
                                    input.value = label;
                                    input.name = "oggetti[]";
                                    input.className ="form-control";
                                    oggetto.appendChild(input);
                                    
                                    // Descrizione
                                    var desc = optional[k]['description'];
                                    var descrizione = document.createElement("td");
                                    var inputDesc = document.createElement("input");
                                    inputDesc.type = "text";
                                    inputDesc.name = "desc[]";
                                    inputDesc.value = desc;
                                    inputDesc.className = "form-control";
                                    descrizione.appendChild(inputDesc);
                                    
                                    // Q.tà
                                    var qt = document.createElement("input");
                                    qt.type = "number";
                                    var tdQt = document.createElement("td");
                                    qt.value = 1;
                                    qt.name = "qt[]";
                                    qt.className = "form-control qt";
                                    tdQt.appendChild(qt);
                                    
                                    // Prezzo unitario
                                    var prez = optional[k]['price'];
                                    var prezzo = document.createElement("td");
                                    var inputPrezzo = document.createElement("input");
                                    inputPrezzo.type = "number";
                                    inputPrezzo.value = prez;
                                    inputPrezzo.name = "pru[]";
                                    inputPrezzo.className = "form-control pr";
                                    prezzo.appendChild(inputPrezzo);
                                    
                                    // Totale
                                    var totale = document.createElement("input");
                                    totale.type = "number";
                                    var tdTot = document.createElement("td");
                                    totale.value = prez;
                                    totale.name = "tot[]";
                                    totale.className = "form-control tot";
                                    tdTot.appendChild(totale);
                                    
                                    // Asterisca
									/*var select1 = document.createElement("select");
									var compl = document.createElement("td");
									select1.name = "ast[]";
									select1.className = "form-control";
									var array = ["No", "Si"];
									compl.appendChild(select1);
									
									for(var i = 0; i < array.length; i++) {
										var option = document.createElement("option");
										option.value = i;
										option.text = array[i];
										select1.appendChild(option);
									}
									*/
									    // Asterisca
									var check = document.createElement("input");
									check.type = "checkbox";
									var compl = document.createElement("td");
									check.name = "ast[]";
									compl.appendChild(check);
									//tr.appendChild(tdAst);
									
									
									
									tr.appendChild(td);
									//tr.appendChild(qt1);
									//tr.appendChild(codice);
									tr.appendChild(oggetto);
									tr.appendChild(descrizione);
									tr.appendChild(tdQt);
									tr.appendChild(prezzo);
									tr.appendChild(tdTot);
									tr.appendChild(compl);
                                    // Aggiungo la nuova riga
                                    tabella.appendChild(tr);
                                }
                            }
                        }
                    }
                    break;
                }
            }
        });
        
        
        $('#optional').on("change", function() {
            var id = $('#optional').val();
            for(var k = 0; k < optionalLength; k++) {
                if(optional[k]['id'] == id) {
                    // Aggiungo l'optional
                    var tr = document.createElement("tr");
                    // Checkbox

                    var checkbox = document.createElement("input");
                    checkbox.type = "checkbox";
                    checkbox.className = "selezione";
                    var td = document.createElement("td");
                    td.appendChild(checkbox);
                    tr.appendChild(td);
					var ordine = document.createElement("input");
                                    ordine.type = "number";
                                    var qt1 = document.createElement("td");
                                    ordine.value = 1;
                                    ordine.name = "ordine[]";
                                    ordine.className = "form-control";
                                   // qt1.appendChild(ordine);
					//tr.appendChild(qt1);
                    // Codice
                    var idogg = optional[k]['id'];
                    var codice = document.createElement("td");
                    var codiceInput = document.createElement("input");
                    codiceInput.type = "number";
                    codiceInput.value = idogg;
                    codiceInput.name = "codici[]";
                    codiceInput.className ="form-control";
                   // codice.appendChild(codiceInput);
                    //tr.appendChild(codice);
                    // Oggetto
                    var label = optional[k]['label'];
                    var oggetto = document.createElement("td");
                    var input = document.createElement("input");
                    input.type = "text";
                    input.value = label;
                    input.name = "oggetti[]";
                    input.className ="form-control";
                    oggetto.appendChild(input);
                    tr.appendChild(oggetto);
                    // Descrizione
                    var desc = optional[k]['description'];
                    var descrizione = document.createElement("td");
                    var inputDesc = document.createElement("input");
                    inputDesc.type = "text";
                    inputDesc.name = "desc[]";
                    inputDesc.value = desc;
                    inputDesc.className = "form-control";
                    descrizione.appendChild(inputDesc);
                    tr.appendChild(descrizione);
                    // Q.tà
                    var qt = document.createElement("input");
                    qt.type = "number";
                    var tdQt = document.createElement("td");
                    qt.value = 1;
                    qt.name = "qt[]";
                    qt.className = "form-control qt";
                    tdQt.appendChild(qt);
                    tr.appendChild(tdQt);
                    // Prezzo unitario
                    var prez = optional[k]['price'];
                    var prezzo = document.createElement("td");
                    var inputPrezzo = document.createElement("input");
                    inputPrezzo.type = "number";
                    inputPrezzo.value = prez;
                    inputPrezzo.name = "pru[]";
                    inputPrezzo.className = "form-control pr";
                    prezzo.appendChild(inputPrezzo);
                    tr.appendChild(prezzo);
                    // Totale
                    var totale = document.createElement("input");
                    totale.type = "number";
                    var tdTot = document.createElement("td");
                    totale.value = prez;
                    totale.name = "tot[]";
                    totale.className = "form-control tot";
                    tdTot.appendChild(totale);
                    tr.appendChild(tdTot);
                    // Asterisca
                    var check = document.createElement("input");
                    check.type = "checkbox";
                    var tdAst = document.createElement("td");
                    check.name = "ast[]";
                    tdAst.appendChild(check);
                    tr.appendChild(tdAst);
                    // Aggiungo la nuova riga
                    tabella.appendChild(tr);             
                }
            }
        });
        
        
        $('#add').on("click", function() {
            // Aggiungo una riga vuota
            var tr = document.createElement("tr");
            // Checkbox
            var checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.className = "selezione";
            var td = document.createElement("td");
            td.appendChild(checkbox);
            tr.appendChild(td);
            // Codice
            var codice = document.createElement("td");
            var codiceInput = document.createElement("input");
            codiceInput.type = "text";
          //  codiceInput.value = Math.random().toString(36).substring(7);
            codiceInput.name = "codici[]";
            codiceInput.className ="form-control";
            codice.appendChild(codiceInput);
            tr.appendChild(codice);
			var ordine = document.createElement("input");
                                    ordine.type = "number";
                                    var qt1 = document.createElement("td");
                                    ordine.value = 1;
                                    ordine.name = "ordine[]";
                                    ordine.className = "form-control";
                                   // qt1.appendChild(ordine);
			//tr.appendChild(qt1);
            // Oggetto
            var oggetto = document.createElement("td");
            var input = document.createElement("input");
            input.type = "text";
            input.name = "oggetti[]";
            input.className ="form-control";
            oggetto.appendChild(input);
            tr.appendChild(oggetto);
            // Descrizione
            var descrizione = document.createElement("td");
            var inputDesc = document.createElement("input");
            inputDesc.type = "text";
            inputDesc.name = "desc[]";
            inputDesc.className = "form-control";
            descrizione.appendChild(inputDesc);
            //tr.appendChild(descrizione);
            // Q.tà
            var qt = document.createElement("input");
            qt.type = "number";
            var tdQt = document.createElement("td");
            qt.name = "qt[]";
            qt.className = "form-control qt";
            tdQt.appendChild(qt);
            tr.appendChild(tdQt);
            // Prezzo unitario
            var prezzo = document.createElement("td");
            var inputPrezzo = document.createElement("input");
            inputPrezzo.type = "number";
            inputPrezzo.name = "pru[]";
            inputPrezzo.className = "form-control pr";
            prezzo.appendChild(inputPrezzo);
            tr.appendChild(prezzo);
            // Totale
            var totale = document.createElement("input");
            totale.type = "number";
            var tdTot = document.createElement("td");
            totale.name = "tot[]";
            totale.className = "form-control tot";
            tdTot.appendChild(totale);
            tr.appendChild(tdTot);
            // Asterisca
            var check = document.createElement("input");
            check.type = "checkbox";
            var tdAst = document.createElement("td");
            check.name = "ast[]";
            tdAst.appendChild(check);
            tr.appendChild(tdAst);
            // Aggiungo la nuova riga
            tabella.appendChild(tr);  
        });
        
        
        var selezione = [];
        var n = 0;
        
        $('table').on('click','tr input.selezione',function(e) {
            if (e.target.checked) {
	            $(this).closest("tr").addClass("selected");
	            selezione[n++] = $(this).closest('tr');
            } else {
	            selezione[n--] = undefined;
	            $(this).closest("tr").removeClass("selected");
            }
        });
        
        
        function check() {
        	return confirm("Sei sicuro di voler eliminare: " + n + " pacchetti/optional?");
        }
        
        $('#delete').on("click", function() {
            // Elimino le righe selezionate
            if(check() && n != 0) {
                for(var i = 0; i < n; i++) {
                    selezione[i].remove();
                }
                n = 0;
            }
            
        });
        
        $('table').on('change','tr input.qt', function() {
             var prezzo = $(this).parent().closest('tr').find("input.pr").val();
             var qta = $(this).val();
	         $(this).parent().closest('tr').find("input.tot").val(prezzo * qta);
        });
        
        $('table').on('change','tr input.pr', function() {
             var prezzo = $(this).val();
             var qta = $(this).parent().closest('tr').find("input.qt").val();
	         $(this).parent().closest('tr').find("input.tot").val(prezzo * qta);
        });
        
        var tabella = document.getElementById("tabella");
    </script>

		</div>
		<div class="col-md-12">
			<div class="col-md-4">
			<label for="considerazioni">{{trans('messages.keyword_considerations')}}</label>
    <textarea id="considerazioni" name="considerazioni" placeholder="{{trans('messages.keyword_budget_considerations')}}" class="form-control">{{$preventivo->considerazioni}}</textarea><br>
				<label for="valenza">{{trans('messages.keyword_valenza')}}</label>
    <input value="{{$preventivo->valenza}}" type="text" id="valenza" name="valenza" placeholder="{{trans('messages.keyword_valency_of_the_budget')}}" class="form-control"><br>
				<label for="scontoagente">{{trans('messages.keyword_agent_discount')}} <p style="color:#f37f0d;display:inline">(%)</p></label>
    <input value="{{$preventivo->scontoagente}}" type="number" step=any id="scontoagente" name="scontoagente" placeholder="{{trans('messages.keyword_agent_discount_-_calculated_on_the_total')}}" class="form-control" title="% di sconto massimo attribuibile in base al proprio tipo di utenza"><br>
				
			</div>
			<div class="col-md-4">
				<label for="noteimportanti">{{trans('messages.keyword_important_notes')}}</label>
    <textarea id="noteimportanti" name="noteimportanti" placeholder="{{trans('messages.keyword_important_notes')}}" class="form-control">{{$preventivo->noteimportanti}}</textarea><br>
				<label for="finelavori">{{trans('messages.keyword_end_date_works')}}</label>
    <input value="{{$preventivo->finelavori}}" type="text" id="finelavori" name="finelavori" placeholder="{{trans('messages.keyword_date_expected_end_of_work')}}" class="form-control"><br>
				<label for="scontobonus">{{trans('messages.keyword_agent_discount_discount')}} <p style="color:#f37f0d;display:inline">(%)</p></label>
    <input value="{{$preventivo->scontobonus}}" type="number" step=any id="scontobonus" name="scontobonus" placeholder="{{trans('messages.keyword_calculated_on_the_total_already_discounted')}}" class="form-control" title="% {{trans('messages.keyword_discounted_by_the_retailer')}}"><br>
			</div>
			<div class="col-md-4">
				<label for="metodo">{{trans('messages.keyword_payment_method')}}</label>
                 <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="addpay"><i class="fa fa-plus"></i></a>
	    <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="deletepay"><i class="fa fa-eraser"></i></a>
    <div id="paymethod"><table class="table table-striped table-bordered">
	               
	                <tbody id="filespay">
	                </tbody>
	                <script>
	                var $j = jQuery.noConflict();
	                    var selezioneFile3 = [];
	                    var nFile3 = 0;
	                    var kFile3 = 0;
	                    $j('#addpay').on("click", function() {
	                        var tab = document.getElementById("filespay");
	                        var tr = document.createElement("tr");
	                        var check = document.createElement("td");
	                        var checkbox = document.createElement("input");
	                        checkbox.type = "checkbox";
	                        checkbox.className = "selezione";
	                        check.appendChild(checkbox);
	                        kFile3++;
							var td = document.createElement("td");
	                        var dataInput = document.createElement("input");
	                        dataInput.type = "text";
	                        dataInput.className = "form-control datapicker";
	                        dataInput.name = "datapay[]";
							 dataInput.id = "datapay"+kFile3;
							dataInput.placeholder  = "Data";
	                        td.appendChild(dataInput);
							
	                        var perinupt = document.createElement("td");
	                        var perInput = document.createElement("input");
	                        perInput.type = "text";
	                        perInput.className = "form-control";
	                        perInput.name = "amountper[]";
							perInput.placeholder  = "%";
	                        perinupt.appendChild(perInput);
							
							var importtd = document.createElement("td");
	                        var importinput = document.createElement("input");
	                        importinput.type = "text";
	                        importinput.className = "form-control";
	                        importinput.name = "importo[]";
							importinput.placeholder  = "importo";
	                        importtd.appendChild(importinput);
							
	                        tr.appendChild(check);
	                        tr.appendChild(td);
							tr.appendChild(perinupt);
							tr.appendChild(importtd);
	                        tab.appendChild(tr);
	                        $j('.selezione').on("click", function() {
				                selezioneFile3[nFile3] = $j(this).parent().parent();
				                nFile3++;
		                	});
							  $j('.datapicker').datepicker();
	                    });
	                    $j('#eliminaFile2').on("click", function() {
	                       for(var i = 0; i < nFile3; i++) {
	                           selezioneFile3[i].remove();
	                       }
	                       nFile3 = 0;
						
	                    });
	                </script>
	            </table></div>
  
				<label for="subtotale">{{trans('messages.keyword_total')}} <p style="color:#f37f0d;display:inline">(€)</p><a onclick="calcola()" style="text-decoration:none" class="" title="{{trans('messages.keyword_assembled_compilation')}}">{{trans('messages.keyword_click')}} <i class="fa fa-info"></i>{{trans('messages.keyword_for_compilation')}} </a></label>
    <input value="{{$preventivo->subtotale}}" step=any type="number" id="subtotale" name="subtotale" placeholder="{{trans('messages.keyword_initial_price')}}" class="form-control" title="{{trans('messages.keyword_initial_value_calculated_individual_packages')}}"><br>
    <label for="totale">{{trans('messages.keyword_discounted_total')}} <p style="color:#f37f0d;display:inline">(€)</p></label>
    <input value="{{$preventivo->totale}}" type="number" step=any id="totale" name="totale" placeholder="{{trans('messages.keyword_discounted_total')}} " class="form-control" title="{{trans('messages.keyword_discounted_value_or_overwritten_value')}}"><br>
			</div>
		</div>
		<div class="col-md-12">
			<div class="col-md-4">
				
				<label for="totaledapagare">{{trans('messages.keyword_to_pay')}} <p style="color:#f37f0d;display:inline">(€)</p></label>
    <input value="{{$preventivo->totaledapagare}}" type="number" step=any id="totaledapagare" name="totaledapagare" placeholder="{{trans('messages.keyword_total_price_to_be_paid')}}" class="form-control" title="{{trans('messages.keyword_value_to_be_entered_for_any_rounding')}}"><br>
            </div>
			<div class="col-md-4">
				<label for="lineebianche">{{trans('messages.keyword_number_of_lines')}}</label>
				<input value="{{$preventivo->lineebianche}}" type="number" id="lineebianche" name="lineebianche" placeholder="{{trans('messages.keyword_number_of_lines')}}" class="form-control" title="{{trans('messages.keyword_enter_how_many_lines_page_of_the_quote')}}">
    <script>
	var testo = "<?php echo $preventivo->noteintestazione; ?>";
	function mostra() {
		if($('#noteenti').val()) {
			testo = $('#noteenti').val();
			$('#noteenti').val("");
		} else {
			$('#noteenti').val(testo);
			testo = "";
		}
	}
	function mostra2() {
		if(!$('#noteenti').val()) {
			$('#noteenti').val(testo);
			$('#notefiscali').val(testoFiscale);
			$('#notetecniche').val(testoTecnico);
		}
	}
	</script>
			</div>
            <!--<div class="col-md-4">
				<label for="noteintestazione">Note private relative al preventivo</label><a onclick="mostra()" id="mostra"> <i class="fa fa-eye"></i></a>   
    <textarea style="background-color:#f39538;color:#ffffff" rows="2" title="Note nascoste, clicca l'occhio per mostrare" class="form-control nascondi" name="noteintestazione" id="noteenti" placeholder="Inserisci note commerciali del preventivo"></textarea><br>
			</div>-->
            <script>
        function calcola() {
          var totale = $('#subtotale').val() || 0;
          var scontoagente = $('#scontoagente').val() || 0;
          var scontobonus = $('#scontobonus').val() || 0;
          var totalescontato = $('#totale').val() || 0;
          var dapagare = $('#totaledapagare').val() || 0;
                        
          var totale = eval(prompt("Inserisci il totale:", totale));
          var scontoagente = eval(prompt("Inserisci lo sconto agente:", scontoagente));
          var scontobonus = eval(prompt("Inserisci lo sconto bonus:", scontobonus));
          var scontato =  totale - (totale / 100 * scontoagente);
          var totalescontato = eval(prompt("Inserisci il totale scontato:", (scontato - (scontato / 100 * scontobonus))));
          var dapagare = eval(prompt("Inserisci il totale da pagare:", totalescontato));

          $j('#subtotale').val(totale);
          $j('#scontoagente').val(scontoagente);
          $j('#scontobonus').val(scontobonus);
          $j('#totale').val(totalescontato);
          $j('#totaledapagare').val(dapagare);
        }
      </script>
		</div>
        <div class="col-md-6">
    <button onclick="mostra2()" type="submit" class="btn btn-warning">{{trans('messages.keyword_save')}}</button>
</div>
        </form>
	</div>
	<div class="col-md-4">
	

		<label for="statoemotivo">{{trans('messages.keyword_emo')}}</label>
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
		<br>
		<script>
		var yourSelect = document.getElementById( "statoemotivo" );
		document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		$j('#statoemotivo').on("change", function() {
			var yourSelect = document.getElementById( "statoemotivo" );
			document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		});
		</script>
        <div class="col-md-12" id="prezzo" <?php if((Auth::user()->dipartimento == 2 ) || (Auth::user()->id == 0 )){ ?> style="display: block" <?php } else{?> style="display:block;"<?php }?>>

            <label for="prezzo">{{trans('messages.keyword_confirmpriceto')}}</label>
            <br>
            <input type="textarea" name="prezzo" class="form-control" value="">
            <br>

        </div>

            <div class="col-md-12">
	        <label for="scansione">{{trans('messages.keyword_attachment')}}</label><br>
	        <br>
	        <div class="col-md-12">
            	<div class="image_upload_div">
                <?php echo Form::open(array('url' => '/preventivi/modify/quote/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
{{ csrf_field() }}
    			</form>				
				</div><script>
				var url = '<?php echo url('/preventivi/modify/quote/getfiles/'.$mediaCode); ?>';
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
					var urlD = '<?php echo url('/preventivi/modify/quote/deletefiles/'); ?>/'+id;
						$j.ajax({url: urlD, success: function(result){
							$j(".quoteFile_"+id).remove();
					    }});
				}
				function updateType(typeid,fileid){
					var urlD = '<?php echo url('/preventivi/modify/quote/updatefiletype/'); ?>/'+typeid+'/'+fileid;
						$j.ajax({url: urlD, success: function(result){
							//$j(".quoteFile_"+id).remove();
					    }});
				}				
				<?php /* if(isset($preventivo->id)){?>
				var url1 = '<?php echo url('/preventivi/modify/quote/getdefaultfiles/'.$preventivo->id); ?>';
				$j.ajax({url: url1, success: function(result){
        					$j("#files").html(result);
							$j(".dz-preview").remove();
							$j(".dz-message").show();
					    }});
						<?php } */?>
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
            <!-- fase 3 -->
<?php /*?>            <div class="col-md-12"><label for="notecontrattuali">Note private per il tecnico</label><a onclick="mostraTecnico()" id="mostra"> <i class="fa fa-eye"></i></a>  
                <textarea style="background-color:#f39538;color:#ffffff" rows="2" name="notetecniche" id="notetecniche" placeholder="Inserisci note tecniche accordate verbalmente/scritte a mano sul preventivo" title="Note nascoste, clicca l'occhio per mostrare" class="form-control">{{$preventivo->notetecniche}}</textarea><br>
                <script>
					var testoTecnico = "<?php echo $preventivo->notetecniche; ?>";
					function mostraTecnico() {
						if($j('#notetecniche').val()) {
							testoTecnico = $j('#notetecniche').val();
							$j('#notetecniche').val("");
						} else {
							$j('#notetecniche').val(testoTecnico);
							testoTecnico = "";
						}
					}
					mostraTecnico();
				</script>
            </div>
            <div class="col-md-12">
	        <label for="scansione">Allega file tecnico </label><br>
	        <div class="col-md-12">
	                <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiFile2"><i class="fa fa-plus"></i></a>
	                <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaFile2"><i class="fa fa-eraser"></i></a>
                    <a target="new" href="{{url('/preventivi/files') . '/' . $preventivo->id}}" class="btn btn-info" style="color:#ffffff;text-decoration: none" title="Vedi files"><i class="fa fa-info"></i></a>
	        </div><br>
	        <div class="col-md-12">
	            <table class="table table-striped table-bordered">
	                <thead>
	                    <th>#</th>
	                    <th>Sfoglia</th>
	                </thead>
	                <tbody id="files2">
	                </tbody>
	                <script>
	                var $j = jQuery.noConflict();
	                    var selezioneFile2 = [];
	                    var nFile2 = 0;
	                    var kFile2 = 0;
	                    $j('#aggiungiFile2').on("click", function() {
	                        var tab = document.getElementById("files2");
	                        var tr = document.createElement("tr");
	                        var check = document.createElement("td");
	                        var checkbox = document.createElement("input");
	                        checkbox.type = "checkbox";
	                        checkbox.className = "selezione";
	                        check.appendChild(checkbox);
	                        kFile2++;
	                        var td = document.createElement("td");
	                        var fileInput = document.createElement("input");
	                        fileInput.type = "file";
	                        fileInput.className = "form-control";
	                        fileInput.name = "filetecnico[]";
	                        td.appendChild(fileInput);
	                        tr.appendChild(check);
	                        tr.appendChild(td);
	                        tab.appendChild(tr);
	                        $j('.selezione').on("click", function() {
				                selezioneFile2[nFile2] = $j(this).parent().parent();
				                nFile2++;
		                	});
	                    });
	                    $j('#eliminaFile2').on("click", function() {
	                       for(var i = 0; i < nFile2; i++) {
	                           selezioneFile2[i].remove();
	                       }
	                       nFile2 = 0;
	                    });
	                </script>
	            </table>
	    </div>
            </div>
            <div class="col-md-12"> 
             <strong><h3><p style="color:#f37f0d">Inserisci in statistiche?</p></h3></strong>
        </div>
        <div class="col-md-4">
            <select name="legameprogetto" class="form-control">
            	@if($preventivo->legameprogetto == 1)
                    <option selected value="1">Si</option>
                    <option  value="0">No</option>
                @else
                	<option value="1">Si</option>
                    <option selected value="0">No</option>
                @endif
            </select>
        </div><?php */?>
		
	</div>
</div>
<script>

    
$j('#data').datepicker();
$j('#valenza').datepicker();
$j('#finelavori').datepicker();
   $j('.datapicker').datepicker();

</script> 

@endsection