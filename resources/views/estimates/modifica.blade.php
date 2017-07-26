@extends('layouts.app')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<?php /*<script src="{{asset('public/scripts/signature.js')}}"></script>*/?>

<script src="{{asset('public/scripts/jquery.signature.js')}}"></script>
<script src="{{asset('public/scripts/excanvas.js')}}"></script>

<div class="modifica-blade-estimate">
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')

<div class="header-right">
	<div class="float-left">
        <h1> {{ trans('messages.keyword_modifyquote') }}  :<?php echo $preventivo->id . '/' . $preventivo->anno;?></h1>
        <hr>
    </div>    
    <div class="header-svg">
        <img src="{{url('images/HEADER2-RT_QUOTES.svg')}}" alt="header image">
    </div>
</div>

<script>$.datepicker.setDefaults(
    $.extend(
        {'dateFormat':'dd/mm/yy'},
         $.datepicker.regional['nl']
    )
);</script>


<div class="clearfix"></div>
<div class="height20"></div>

<div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12">
    <?php echo Form::open(array('url' => '/estimates/modify/quote' . '/' . $preventivo->id, 'files' => true, 'name' => 'edit_estimate', 'id' => 'edit_estimate')) ?>
    <?php $mediaCode = date('dmyhis');?>
{{ csrf_field() }}
<input type="hidden" name="idutente" value="{{$preventivo->idutente}}">
<input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />
<?php $selectedVal = '8'; ?>
@if($statoemotivoselezionato!=null)
	@foreach($statiemotivi as $statoemotivo)
		@if($statoemotivo->id == $statoemotivoselezionato->id_tipo) 
	        <?php $selectedVal = $statoemotivo->id; ?>        	 
       	@endif 
	@endforeach
@endif
<input type="hidden" id="hdstatoemotivo" name="statoemotivo" value="{{$selectedVal}}" />
<input type="hidden" id="hdPrezzo" name="prezzo" value="{{$preventivo->prezzo_confermato}}" />
<input type="hidden" name="signature" id="signatureJSON" value="<?php echo $preventivo->signature; ?>">

	<div class="row">
    	<div class="col-md-12 col-sm-12 col-xs-12">
        	<div class="form-group">
        <label for="id"> {{ trans('messages.keyword_noquote') }} 
			<input disabled value=":{{$preventivo->id}}/{{$preventivo->anno}}" type="text" id="id" name="id" placeholder="{{ trans('messages.keyword_budget_code') }} " class="form-control">
		</label>
		<div class="btn-group btn-group-top-space margin-right-left-space">
        	<a target="new" href="{{url('/estimates/pdf/quote/') . '/' . $preventivo->id}}" class="btn btn-default" title="{{trans('messages.keyword_see_budget')}} "><i class="fa fa-file-pdf-o"></i></a>
        </div>

        <div class="btn-group">
            <a target="new" href="{{ url('enti/modify/corporation').'/'.$preventivo->idente }}" class="btn btn-warning" title=" {{ trans('messages.keyword_gotoentity') }} "> {{ trans('messages.keyword_gotoentity') }}</a>
        </div>
			</div>
        </div>
    </div>    
        
        
	<div class="row">
    	<div class="col-md-12 col-sm-12 col-xs-12">
        	<div class="form-group">	
        <label for="oggetto"> {{ trans('messages.keyword_quotename') }}</label>
        <input value="{{$preventivo->oggetto}}" type="text" id="oggetto" name="oggetto" placeholder=" {{ trans('messages.keyword_subject_of_budget') }}" class="form-control required-input">
        	</div>
        </div>
    </div>    
        
        
        <div class="row">
    			<div class="col-md-4 col-sm-12 col-xs-12">
                	<div class="form-group">
    				<label for="dipartimento"> {{ trans('messages.keyword_from') }}</label>
                        <select name="dipartimento" class="js-example-basic-single_from form-control required-input">
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
                        <label for="dipartimento" generated="true" class="error"></label>
    			</div>
    			<div class="col-md-4 col-sm-12 col-xs-12">
                	<div class="form-group">
    				<label for="idente"> {{ trans('messages.keyword_to') }} </label>
                    <select name="idente" class="js-example-basic-single_to form-control required-input">
                        <option selected></option>
                        @foreach($enti as $ente)
                            @if($ente->id == $preventivo->idente)
                                <option selected value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomereferente}}</option>
                            @else
                                <option value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                            @endif
                        @endforeach
                    </select><script type="text/javascript">

    $(".js-example-basic-single_from").select2({ containerCssClass : "required-input" });
    $(".js-example-basic-single_to").select2({ containerCssClass : "required-input" });

</script>
    			</div>
                <label for="idente" generated="true" class="error"></label>
                	</div>
    			
    			<div class="col-md-4 col-sm-12 col-xs-12">
	                	<div class="form-group">
    				<label for="data"> {{ trans('messages.keyword_date') }}</label> 
                    <input value="{{$preventivo->data}}" type="text" id="data" name="data" placeholder=" {{ trans('messages.keyword_date_creation_quote') }}" class="form-control required-input">
                    	</div>
    			</div>
        </div>

		<div class="row">

    	<div class="col-md-12 col-sm-12 col-xs-12"><h4> {{ trans('messages.keyword_packages_and_optional') }} </h4><hr></div>
 
 @if(checkpermission('3', '16', 'scrittura','true'))
 <div class="col-md-12 set-mannualy-width-estimates-modifica col-sm-12 col-xs-12">
    <div class="btn-blk">    
    	<div class="space20"></div>   
        <?php /*<a target="new" href="{{url('/estimates/optional') . '/' . $preventivo->id}}" class="btn btn-info"><i class="fa fa-info"></i></a>*/?>
	    <a class="btn btn-warning"  id="add"><i class="fa fa-plus"></i></a>
	    <a class="btn btn-danger"  id="delete"><i class="fa fa-trash"></i></a>
    </div>
    
    <div class="select-box">
    	<div class="form-group">
            <label> {{ trans('messages.keyword_list_of_packages') }} </label>
        <select id="pacchetti" name="" class="js-example-basic-single form-control">
            <option></option>
            @foreach($pacchetti as $pacchetto)
                <option value="{{$pacchetto->id}}">{{$pacchetto->label}}</option>
            @endforeach
        </select>
        </div>
    </div>
    
    <div class="select-box">
    	<div class="form-group">
            <label> {{ trans('messages.keyword_optional_list') }} </label>
        <select id="optional" class="js-example-basic-single form-control">
            <option></option>
            @foreach($optional as $opt)
                <option value="{{$opt->id}}">{{$opt->code}}</option>
            @endforeach
        </select><script type="text/javascript">

    $(".js-example-basic-single").select2();

</script>
		</div>
    </div>
  </div>
  @endif  
    
    
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="height10"></div>
        <div class="set-height450">
        <table id="table" class="table table-bordered packages_and_optional">
            <thead>
                <th>#</th>            
                <th> {{ trans('messages.keyword_object') }}, {{ trans('messages.keyword_qty') }}, {{ trans('messages.keyword_unit_price') }} </th>
                <th> {{ trans('messages.keyword_description') }} </th>                
                <th> {{ trans('messages.keyword_subtotal') }}, {{ trans('messages.keyword_cyclicity') }}, {{ trans('messages.keyword_asterisca') }}</th>                
            </thead>
            <tbody id="tabella">
            @foreach($optional_preventivi as $keyopp => $valopp)
            <tr>
                <td><input class="selezione" id="checkNuL{{$valopp->id}}" type="checkbox"><label for="checkNuL{{$valopp->id}}"></label>
                    <input value="{{$valopp->id}}" name="codici[]" class="form-control" type="hidden"></td>
                <td><input name="oggetti[]" class="form-control" type="text" value="{{$valopp->oggetto}}">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12"><input name="qt[]" class="form-control qt" type="number" value="{{$valopp->qta}}"></div>
                        <div class="col-md-6 col-sm-12 col-xs-12"><input name="pru[]" class="form-control pr" type="number" value="{{$valopp->prezzounitario}}"></div>
                    </div>
                </td>
                <td><textarea name="desc[]" class="form-control">{{$valopp->descrizione}}</textarea></td>                
                <td><input name="tot[]" class="form-control tot" type="number" value="{{$valopp->totale}}">
                <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12"><select name="cicli[]" class="form-control">
                @foreach($frequency as $key => $frequencyval)
                <option value="{{$frequencyval->id}}" <?php if($valopp->Ciclicita==$frequencyval->id){ echo 'selected';}?>>{{ $frequencyval->rinnovo .' '. trans('messages.keyword_days') }} </option>
                @endforeach
                </select></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="switch"><input name="ast[{{$keyopp}}]" id="ast{{$valopp->id}}" type="checkbox" <?php if($valopp->asterisca=='1'){ echo 'checked';} ?>><label for="ast{{$valopp->id}}"></label></div>
                        </div>
                    </div>
                </td>                
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="height30"></div>
    <script>
        var pacchetti = <?php echo json_encode($pacchetti); ?>;
        var pacchettiLength = Object.keys(pacchetti).length;
        var optional = <?php echo json_encode($optional); ?>;
        var optionalLength = Object.keys(optional).length;
        var optionalPack = <?php echo json_encode($optional_pack); ?>;
        var optionalPackLength = Object.keys(optionalPack).length;
        count=0;
        $('#pacchetti').on("change", function() {
            
            var id = $('#pacchetti').val();
            var counttr = $('#tabella').children('tr').length;
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
                                    var checkboxLabel = document.createElement("label");                                        
                                    checkboxLabel.setAttribute('for', "checkNuL"+k+j);
                                    checkbox.type = "checkbox";
                                    checkbox.className = "selezione";
                                    checkbox.id = "checkNuL"+k+j;
                                    var td = document.createElement("td");
									 td.appendChild(checkbox);
                                    td.appendChild(checkboxLabel);
                                  
                                    
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
                                    
									var codiceInput = document.createElement("input");
                                    codiceInput.type = "hidden";
                                    codiceInput.value = count+1;
                                    codiceInput.name = "codici[]";
                                    codiceInput.className ="form-control";
                                    td.appendChild(codiceInput);
									
                                    // Oggetto
                                    var label = optional[k]['label'];
                                    var code = optional[k]['code'];
                                    var oggetto = document.createElement("td");
                                    var input = document.createElement("input");
                                    input.type = "text";
                                    input.value = code;
                                    input.name = "oggetti[]";
                                    input.className ="form-control";
                                    oggetto.appendChild(input);

                                    var oggettorow = document.createElement("div");
                                    oggettorow.className="row";
                                    var oggettodiv1 = document.createElement("div");
                                    oggettodiv1.className="col-md-6";
                                    var oggettodiv2 = document.createElement("div");
                                    oggettodiv2.className="col-md-6";

                                    oggettorow.appendChild(oggettodiv1);
                                    oggettorow.appendChild(oggettodiv2);
                                    
                                     // Q.tà
                                    var qt = document.createElement("input");
                                    qt.type = "number";
                                    var tdQt = document.createElement("td");
                                    qt.value = 1;
                                    qt.name = "qt[]";
                                    qt.className = "form-control qt";
                                    //tdQt.appendChild(qt);
                                    oggettodiv1.appendChild(qt);

                                    // Prezzo unitario
                                    var prez = optional[k]['price'];
                                    var prezzo = document.createElement("td");
                                    var inputPrezzo = document.createElement("input");
                                    inputPrezzo.type = "number";
                                    inputPrezzo.value = prez;
                                    inputPrezzo.name = "pru[]";
                                    inputPrezzo.className = "form-control pr";
                                    //prezzo.appendChild(inputPrezzo);
                                    oggettodiv2.appendChild(inputPrezzo);
                                    oggetto.appendChild(oggettorow);


                                    // Descrizione
                                    var desc = optional[k]['description'];
                                    var descrizione = document.createElement("td");
                                    var inputDesc = document.createElement("textarea");
                                    //inputDesc.type = "textarea";
                                    inputDesc.name = "desc[]";
                                    inputDesc.value = desc;
                                    inputDesc.className = "form-control";
                                    descrizione.appendChild(inputDesc);
                                    
                                    var totalerow = document.createElement("div");
                                    totalerow.className="row";
                                    var totalediv1 = document.createElement("div");
                                    totalediv1.className="col-md-6";
                                    var totalediv2 = document.createElement("div");
                                    totalediv2.className="col-md-6";

                                    totalerow.appendChild(totalediv1);
                                    totalerow.appendChild(totalediv2);

                                    // Totale
                                    var totale = document.createElement("input");
                                    totale.type = "number";
                                    var tdTot = document.createElement("td");
                                    totale.value = prez;
                                    totale.name = "tot[]";
                                    totale.className = "form-control tot";
                                    tdTot.appendChild(totale);

                                     var freqtd = document.createElement("td");
                                    var select = document.createElement("select");
                                    select.name = "cicli[]";
                                    select.className = "form-control";          
                                    var selectfrequency = optional[k]['frequenza'];                   
                                    var freq='';
                                    <?php 
                                        $freq = '';
                                        foreach($frequency as $key => $frequencyval){
                                            ?> 
                                            var frequencuid = '<?php echo $frequencyval->id;?>';
                                            var vselected = '';                        
                                            if(frequencuid == selectfrequency){
                                                vselected = 'selected';
                                            }

                                            freq +='<option value="<?php echo $frequencyval->id;?>" '+vselected+'><?php echo $frequencyval->rinnovo. ' '. trans('messages.keyword_days'); ?></option>';
                                            <?php 
                                        }
                                    ?>
                                    select.innerHTML = freq;
                                    totalediv1.appendChild(select);
                                    

                                   // var compl = document.createElement("td");
                                    var checkdiv = document.createElement("div");
                                    checkdiv.className = "switch";
                                    var check = document.createElement("input");
                                    check.type = "checkbox";
                                    check.name = "ast["+counttr+"]";
                                    check.id = "ast"+count;
                                                                      
                                    var checkLabel = document.createElement("label");
                                    checkLabel.for="ast"+counttr;
                                    checkLabel.setAttribute('for', "ast"+counttr);
                                    checkdiv.appendChild(check);
                                    checkdiv.appendChild(checkLabel);									
									totalediv2.appendChild(checkdiv);                                    
									
                                    tdTot.appendChild(totalerow);

									tr.appendChild(td);
									//tr.appendChild(qt1);
									//tr.appendChild(codice);
									tr.appendChild(oggetto);
									tr.appendChild(descrizione);
									//tr.appendChild(tdQt);
									//tr.appendChild(prezzo);
									tr.appendChild(tdTot);
                                    //tr.appendChild(freqtd);
									//tr.appendChild(compl);
									
                                    // Aggiungo la nuova riga
                                    tabella.appendChild(tr);
									count++;
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
            var counttr = $('#tabella').children('tr').length;            

            for(var k = 0; k < optionalLength; k++) {
                if(optional[k]['id'] == id) {
                    counttr = counttr + k;
                    // Aggiungo l'optional
                    var tr = document.createElement("tr");
                    // Checkbox
                    var checkbox = document.createElement("input");
                    var checkboxlabel = document.createElement("label");
                    checkboxlabel.setAttribute('for', "ast"+k);
                    checkbox.type = "checkbox";
                    checkbox.className = "selezione";
                    checkbox.id = "ast"+k;
                    var td = document.createElement("td");
                    td.appendChild(checkbox);
                    td.appendChild(checkboxlabel);                    
                    tr.appendChild(td);
					var ordine = document.createElement("input");
                    ordine.type = "number";
                    var qt1 = document.createElement("td");
                    ordine.value = 1;
                    ordine.name = "ordine[]";
                    ordine.className = "form-control";
                   // qt1.appendChild(ordine);
	               //tr.appendChild(qt1);

                var oggettorow = document.createElement("div");
                    oggettorow.className="row";
                    var oggettodiv1 = document.createElement("div");
                    oggettodiv1.className="col-md-6";
                    var oggettodiv2 = document.createElement("div");
                    oggettodiv2.className="col-md-6";

                    oggettorow.appendChild(oggettodiv1);
                    oggettorow.appendChild(oggettodiv2);

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
                    var code = optional[k]['code'];
                    var oggetto = document.createElement("td");
                    var input = document.createElement("input");
                    input.type = "text";
                    input.value = code;
                    input.name = "oggetti[]";
                    input.className ="form-control";
                    oggetto.appendChild(input);
                    oggetto.appendChild(oggettorow);
                    

                     // Q.tà
                    var qt = document.createElement("input");
                    qt.type = "number";
                    var tdQt = document.createElement("td");
                    qt.value = 1;
                    qt.name = "qt[]";
                    qt.className = "form-control qt";
                    oggettodiv1.appendChild(qt);
                    //tr.appendChild(tdQt);

                    // Prezzo unitario
                    var prez = optional[k]['price'];
                    var prezzo = document.createElement("td");
                    var inputPrezzo = document.createElement("input");
                    inputPrezzo.type = "number";
                    inputPrezzo.value = prez;
                    inputPrezzo.name = "pru[]";
                    inputPrezzo.className = "form-control pr";
                    //prezzo.appendChild(inputPrezzo);
                    oggettodiv2.appendChild(inputPrezzo);
                    //tr.appendChild(prezzo);

                    tr.appendChild(oggetto);

                    // Descrizione
                    var desc = optional[k]['description'];
                    var descrizione = document.createElement("td");
                    var inputDesc = document.createElement("textarea");
                    //inputDesc.type = "text";
                    inputDesc.name = "desc[]";
                    inputDesc.value = desc;
                    inputDesc.className = "form-control";
                    descrizione.appendChild(inputDesc);
                    tr.appendChild(descrizione);
                   
                    var totalerow = document.createElement("div");
                        totalerow.className="row";
                        var totalediv1 = document.createElement("div");
                        totalediv1.className="col-md-6";
                        var totalediv2 = document.createElement("div");
                        totalediv2.className="col-md-6";

                        totalerow.appendChild(totalediv1);
                        totalerow.appendChild(totalediv2);
                    
                    // Totale
                    var totale = document.createElement("input");
                    totale.type = "number";
                    var tdTot = document.createElement("td");
                    totale.value = prez;
                    totale.name = "tot[]";
                    totale.className = "form-control tot";                    
                    tdTot.appendChild(totale);
                    tr.appendChild(tdTot);					

					var freqtd = document.createElement("td");
                    var select = document.createElement("select");
                    select.name = "cicli[]";
                    select.className = "form-control";          
                    var selectfrequency = optional[k]['frequenza'];
                   
                    var freq='';
                    <?php 
                        $freq = '';
                        foreach($frequency as $key => $frequencyval){
                            ?> 
                            var frequencuid = '<?php echo $frequencyval->id;?>';
                            var vselected = '';                        
                            if(frequencuid == selectfrequency){
                                vselected = 'selected';
                            }

                            freq +='<option value="<?php echo $frequencyval->id;?>" '+vselected+'><?php echo $frequencyval->rinnovo. ' '. trans('messages.keyword_days'); ?></option>';
                            <?php 
                        }
                    ?>
                    //select.innerHTML = '<?php //echo $freq; ?>';
                    select.innerHTML = freq;                    
                    totalediv1.appendChild(select);
                   // tr.appendChild(freqtd);
					
                    // Asterisca
                    var checkdiv = document.createElement("div");
                    checkdiv.className = "switch";
                    var check = document.createElement("input");
                    check.type = "checkbox";
                    check.name = "ast["+counttr+"]";
                    check.id = "ast"+counttr;
                    var checkLabel = document.createElement("label");
                    checkLabel.for="ast"+counttr;
                    checkLabel.setAttribute('for', "ast"+counttr);
                    checkdiv.appendChild(check);
                    checkdiv.appendChild(checkLabel);

                    totalediv2.appendChild(checkdiv);                    
                    tdTot.appendChild(totalerow);
                    tabella.appendChild(tr);   
					count++;          
                }
            }
        });
        
        
        $('#add').on("click", function() {
            // Aggiungo una riga vuota
            var tr = document.createElement("tr");
            var counttr = $('#tabella').children('tr').length;
            // Checkbox                        
            var checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.className = "selezione";
            checkbox.id = "checkNu"+counttr;
            var checkboxlabel = document.createElement("label");
            checkboxlabel.for = "checkNu"+counttr;
            checkboxlabel.setAttribute('for', "checkNu"+counttr);

            var td = document.createElement("td");
            td.appendChild(checkbox);
            td.appendChild(checkboxlabel);
            tr.appendChild(td);
            // Codice
            var codice = document.createElement("td");
            var codiceInput = document.createElement("input");
            codiceInput.type = "text";
          //  codiceInput.value = Math.random().toString(36).substring(7);
            codiceInput.name = "codici[]";
            codiceInput.className ="form-control";
            codice.appendChild(codiceInput);
            //tr.appendChild(codice);

			var ordine = document.createElement("input");
            ordine.type = "number";
            var qt1 = document.createElement("td");
            ordine.value = 1;
            ordine.name = "ordine[]";
            ordine.className = "form-control";
           // qt1.appendChild(ordine);
			//tr.appendChild(qt1);

            var oggettorow = document.createElement("div");
                oggettorow.className="row";
                var oggettodiv1 = document.createElement("div");
                oggettodiv1.className="col-md-6";
                var oggettodiv2 = document.createElement("div");
                oggettodiv2.className="col-md-6";

                oggettorow.appendChild(oggettodiv1);
                oggettorow.appendChild(oggettodiv2);

            var codiceInput = document.createElement("input");
            codiceInput.type = "hidden";
            codiceInput.value = count+1;
            codiceInput.name = "codici[]";
            codiceInput.className ="form-control";
            td.appendChild(codiceInput);


            // Oggetto
            var oggetto = document.createElement("td");
            var input = document.createElement("input");
            input.type = "text";
            input.name = "oggetti[]";
            input.className ="form-control";
            oggetto.appendChild(input);            
            oggetto.appendChild(oggettorow);
            tr.appendChild(oggetto);

            // Descrizione
            var descrizione = document.createElement("td");
            var inputDesc = document.createElement("textarea");
            //inputDesc.type = "text";
            inputDesc.name = "desc[]";
            inputDesc.className = "form-control";
            descrizione.appendChild(inputDesc);
            tr.appendChild(descrizione);
            // Q.tà
            var qt = document.createElement("input");
            qt.type = "number";
            var tdQt = document.createElement("td");
            qt.name = "qt[]";
            qt.className = "form-control qt";
            oggettodiv1.appendChild(qt);
            //tr.appendChild(tdQt);
            // Prezzo unitario
            var prezzo = document.createElement("td");
            var inputPrezzo = document.createElement("input");
            inputPrezzo.type = "number";
            inputPrezzo.name = "pru[]";
            inputPrezzo.className = "form-control pr";
            //prezzo.appendChild(inputPrezzo);
            //tr.appendChild(prezzo);
            oggettodiv2.appendChild(inputPrezzo);

            // Totale
            var totale = document.createElement("input");
            totale.type = "number";
            var tdTot = document.createElement("td");
            totale.name = "tot[]";
            totale.className = "form-control tot";
            tdTot.appendChild(totale);
            tr.appendChild(tdTot);

            var totalerow = document.createElement("div");
            totalerow.className="row";
            var totalediv1 = document.createElement("div");
            totalediv1.className="col-md-6";
            var totalediv2 = document.createElement("div");
            totalediv2.className="col-md-6";

            totalerow.appendChild(totalediv1);
            totalerow.appendChild(totalediv2);        
			
			var freqtd = document.createElement("td");            
            var select = document.createElement("select");            
            select.name = "cicli[]";
            select.className = "form-control";          
            <?php 
                $freq = '';
                foreach($frequency as $key => $frequencyval){
                     $freq .='<option value="'.$frequencyval->id.'">'.$frequencyval->rinnovo. ' '. trans('messages.keyword_days') .'</option>';
                }
            ?>
            select.innerHTML = '<?php echo $freq; ?>';            
            totalediv1.appendChild(select);
            //tr.appendChild(freqtd);
			
            // Asterisca
            var checkdiv = document.createElement("div");
            checkdiv.className = "switch";
            var check = document.createElement("input");
            check.type = "checkbox";
            check.name = "ast["+counttr+"]";
            check.id = "ast"+counttr;
            var checkLabel = document.createElement("label");
            checkLabel.for="ast"+counttr;
            checkLabel.setAttribute('for', "ast"+counttr);
            checkdiv.appendChild(check);
            checkdiv.appendChild(checkLabel);
            
            //var tdAst = document.createElement("td");            
            //tdAst.appendChild(checkdiv);
            totalediv2.appendChild(checkdiv);
            tdTot.appendChild(totalerow);
            
            //tr.appendChild(tdAst);
            // Aggiungo la nuova riga
            tabella.appendChild(tr);  
			count++;
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
        	return confirm("{{ trans('messages.keyword_sure') }}: " + n + " pacchetti/optional?");
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
        
        
        
		<div class="row">
            
            <div class="col-lg-12 col-md-12">
            	<div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
	            	<div class="form-group">
				<label for="considerazioni"> {{ trans('messages.keyword_considerations') }}</label>
			    <textarea id="considerazioni" name="considerazioni" placeholder=" {{ trans('messages.keyword_budget_considerations') }} " class="form-control required-input considerazioni">{{$preventivo->considerazioni}}</textarea>
    				</div>
                    <div class="form-group">
				<label for="valenza"> {{ trans('messages.keyword_valenza') }}</label>
			    <input value="{{$preventivo->valenza}}" type="text" id="valenza" name="valenza" placeholder=" {{ trans('messages.valency_budget') }} " class="form-control required-input">
    				</div>
				
                
               
                 
    
    
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
    /*Append the payment method to original forms */
    $('#edit_estimate').submit(function(){ //listen for submit event
        //var queryString = $('#frmpayments').serialize();
        /*var paymentMethodhtml = $("#paymethod").html();
        $('#edit_estimate').append(queryString);*/
        var x = $("#frmpayments").serializeArray();        
        if($('#edit_estimate').valid() && x != "") {                
            $.each(x, function(i, field){         
                var ht="<input type='text' name='"+field.name+"' value='"+field.value+"' style='display:none;'>";
                $("#edit_estimate").append(ht);
            });         
        }       
        return true;
    }); 
    
	</script>
                
    <script>
        function calcola() {
          var totale = $('#subtotale').val() || 0;
          var scontoagente = $('#scontoagente').val() || 0;
          var scontobonus = $('#scontobonus').val() || 0;
          var totalescontato = $('#totale').val() || 0;
          var dapagare = $('#totaledapagare').val() || 0;
                        
          var totale = eval(prompt("{{trans('messages.keyword_enter_the_total')}}:", totale));
          var scontoagente = eval(prompt("{{trans('messages.keyword_enter_the_agent_discount')}}:", scontoagente));
          var scontobonus = eval(prompt("{{trans('messages.keyword_enter_the_bonus_discount')}}:", scontobonus));
          var scontato =  totale - (totale / 100 * scontoagente);
          var totalescontato = eval(prompt("{{trans('messages.keyword_enter_the_total_discount')}}:", (scontato - (scontato / 100 * scontobonus))));
          var dapagare = eval(prompt("{{trans('messages.keyword_enter_the_total_payable')}}:", totalescontato));

          $('#subtotale').val(totale);
          $('#scontoagente').val(scontoagente);
          $('#scontobonus').val(scontobonus);
          $('#totale').val(totalescontato);
          $('#totaledapagare').val(dapagare);
        }
      </script>            
                
                
          
                
			</div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                    <label for="noteimportanti"> {{ trans('messages.keyword_important_notes') }} </label>
                    <textarea id="noteimportanti" name="noteimportanti" placeholder=" {{ trans('messages.keyword_important_notes') }} " class="form-control noteimportanti">{{$preventivo->noteimportanti}}</textarea>
                    </div>
                   
                   <div class="form-group"> 
                    <label for="finelavori"> {{ trans('messages.keyword_end_date_works') }} </label>
                    <input value="{{$preventivo->finelavori}}" type="text" id="finelavori" name="finelavori" placeholder=" {{ trans('messages.keyword_date_expected_end_of_work') }} " class="form-control required-input">
                    </div>
                </div>
                
                
                
            
            	
            
            
            	 <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                <label for="scontoagente"> {{ trans('messages.keyword_agent_discount') }}  <span class="required">(%)</span></label>
			    <input value="{{$preventivo->scontoagente}}" type="number" step=any id="scontoagente" name="scontoagente" placeholder=" {{ trans('messages.keyword_agent_discount_-_calculated_on_the_total') }} " class="form-control" title="% {{ trans('messages.keyword_of_maximum_discount_attributable_user') }} ">
    			</div>
				</div>
            
            	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
               <div class="form-group">  
                <label for="scontobonus"> {{ trans('messages.keyword_agent_discount_discount') }}  <span class="required">(%)</span></label>
    <input value="{{$preventivo->scontobonus}}" type="number" step=any id="scontobonus" name="scontobonus" placeholder=" {{ trans('messages.keyword_calculated_on_the_total_already_discounted') }} " class="form-control" title="% {{ trans('messages.keyword_discounted_by_the_retailer') }} ">
    			</div>
    		</div>
            
                	
                    
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                	<div class="form-group">
                    <label for="subtotale"> {{ trans('messages.keyword_total') }}  <span class="required">(€)</span><a onclick="calcola()" class="" title="Compilazione assistita">  {{ trans('messages.keyword_click') }}  <i class="fa fa-info"></i> {{ trans('messages.keyword_for_compilation') }} </a></label>
    <input value="{{$preventivo->subtotale}}" step=any type="number" id="subtotale" name="subtotale" placeholder="{{ trans('messages.keyword_initial_price') }} " class="form-control" title=" {{ trans('messages.keyword_initial_value_calculated_individual_packages') }} "> 
    				</div> </div>
                
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
                 <label for="totale"> {{ trans('messages.keyword_discounted_total') }}  <span class="required">(€)</span></label>
    <input value="{{$preventivo->totale}}" type="number" step=any id="totale" name="totale" placeholder=" {{ trans('messages.keyword_total_price') }} " class="form-control" title="{{ trans('messages.keyword_discounted_value_or_overwritten_value') }} ">
    			</div>
            </div>
            
            
            
            
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
    			<div class="form-group"> 
       <label for="totaledapagare"> {{ trans('messages.keyword_topay') }}  <span class="required">(€)</span></label>
    <input value="{{$preventivo->totaledapagare}}" type="number" step=any id="totaledapagare" name="totaledapagare" placeholder=" {{ trans('messages.keyword_total_price_to_be_paid') }} " class="form-control" title=" {{ trans('messages.keyword_value_to_be_entered_for_any_rounding') }} ">
    			</div>
    
            </div>
            <div id="extrafields"></div>
             
            </div>
            </div>
		</div>
        </form>
        
        
        @if(checkpermission('3', '16', 'scrittura','true'))
       <div class="row">
           <div class="col-md-12 col-sm-12 col-xs-12 mb16 show-desktop"> 
            <button onclick="mostra2()" type="submit" class="btn btn-warning">{{ trans('messages.keyword_save') }}</button>
           </div>
       </div>
       @endif
        
	</div>
    
	<div class="col-md-4 col-sm-12 col-xs-12">	
        <div class="form-group bg-white signature-wrap"> 
            <div class="height">                
                <label for="signature1">{{trans('messages.keyword_customer_signature')}}</label>
                @if(isset($statoemotivoselezionato->id_tipo) && $statoemotivoselezionato->id_tipo != '6' && (checkpermission('3', '16', 'scrittura','true')))
                <div class="text-right"><a class="btn btn-warning" id="confirmsignature">{{trans('messages.keyword_confirm')}}</a>
                <a class="btn btn-danger" id="clearsignature">{{trans('messages.keyword_clear_label')}}</a></div>
                @endif
            </div>
            <div class="set-height image_upload_div">                
                <div id="signature1"> </div>                
            </div>
        </div> 
         
		<div class="form-group">
			<label for="statoemotivo"> {{ trans('messages.keyword_emotional_state') }} </label>
            <select name="statoemotivo" class="form-control" id="statoemotivo">
                <!-- statoemotivoselezionato -->
                @if($statoemotivoselezionato!=null)
                    @foreach($statiemotivi as $statoemotivo)
                    <?php $label = (!empty($statoemotivo->language_key)) ?  ucwords(strtolower(trans('messages.'.$statoemotivo->language_key))) : (($statoemotivo->name)); ?>
                        <option @if($statoemotivo->id == $statoemotivoselezionato->id_tipo) selected @endif style="background-color:{{$statoemotivo->color}};color:#ffffff" value="{{$statoemotivo->id}}">{{wordformate($label)}}</option>
                    @endforeach
                @else
                    @foreach($statiemotivi as $statoemotivo)
                    <?php $label = (!empty($statoemotivo->language_key)) ?  ucwords(strtolower(trans('messages.'.$statoemotivo->language_key))) : (($statoemotivo->name)); ?>
                        <option  value="{{$statoemotivo->id}}">{{wordformate($label)}}</option>
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
			$("#hdstatoemotivo").val($(this).val());
		});		
		</script>
     <div class="row">   <div class="col-md-12 col-sm-12 col-xs-12" id="prezzo">
			<div class="form-group">
                <label for="prezzo"> {{ trans('messages.keyword_confirmpriceto') }} :</label>
                <input type="textarea" id="prezzo_confermato" name="prezzo" class="form-control" value="{{$preventivo->prezzo_confermato}}">
            </div>
            
            
            
            
            <div class="estimate-add-tbl">
				<label for="metodo"> {{ trans('messages.keyword_payment_method') }} </label>
                @if(checkpermission('3', '16', 'scrittura','true'))
                    <a class="btn btn-warning" id="addpay"><i class="fa fa-plus"></i></a>
	               <a class="btn btn-danger" id="deletepay"><i class="fa fa-trash"></i></a>
                @endif

    <div id="paymethod">
    <form id="frmpayments">
    	<div class="set-height-paymethod">
    		<table class="table table-striped table-bordered">	               
	                <tbody id="filespay">
                    @if(count($quote_paymento) > 0)
                    @foreach($quote_paymento as $quote_paymento)
                    <tr>
                    <?php  ?>
                    	<td><input class="selezione" id="payment_{{ $quote_paymento->qp_id}}" type="checkbox"><label for="payment_{{ $quote_paymento->qp_id}}"></label></td>
                        <td><input class="form-control datapicker" name="datapay[]" value="{{ date('d/m/Y',strtotime($quote_paymento->qp_data)) }}" id="datapay{{ $quote_paymento->qp_id }}" placeholder="Data" type="text"></td>
                        <td><input class="form-control" name="amountper[]" placeholder="%" value="{{ $quote_paymento->qp_percenti}}" type="text"></td>
                        <td><input class="form-control" name="importo[]" placeholder="importo" value="{{ $quote_paymento->qp_amnt}}" type="text"></td>
                    </tr>
                    @endforeach
                    @else
                     @for($i=0;$i< 3;$i++)
                    <tr><td><input class="selezione" id="payment_{{$i}}" type="checkbox"><label for="payment_{{$i}}"></label></td>
                        <td><input class="form-control datapicker" name="datapay[]" value="" id="datapay{{$i}}" placeholder="Data" type="text"></td>
                        <td><input class="form-control" name="amountper[]" placeholder="%" value="" type="text"></td>
                        <td><input class="form-control" name="importo[]" placeholder="importo" value="" type="text"></td>
                    </tr>
                    @endfor
                    @endif
	                </tbody>
	                <script>

	                var $j = jQuery.noConflict();
	                    var selezioneFile3 = [];
	                    var nFile3 = 0;
	                    var kFile3 = 3;
	                    $j('#addpay').on("click", function() {
	                        var tab = document.getElementById("filespay");
	                        var tr = document.createElement("tr");
	                        var check = document.createElement("td");
	                        var checkbox = document.createElement("input");
                            var checkboxLabelpay = document.createElement("label");
                            checkboxLabelpay.setAttribute('for', "payment"+kFile3);
	                        checkbox.type = "checkbox";
	                        checkbox.className = "selezione";
                            checkbox.id = "payment"+kFile3;
	                        check.appendChild(checkbox);
                            check.appendChild(checkboxLabelpay);
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
				                selezioneFile3[nFile3] = $(this).parent().parent();
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

                    var j = jQuery.noConflict();

                    var selezione = [];
                    var n = 0;
                    
                    j('table').on('click','tr input.selezione',function(e) {
                        if (e.target.checked) {
                            j(this).closest("tr").addClass("selected");
                            selezione[n++] = j(this).closest('tr');
                        } else {
                            selezione[n--] = undefined;
                            j(this).closest("tr").removeClass("selected");
                        }
                    });
                    
                    function check() {                         
                        return confirm("{{ trans('messages.keyword_sure') }}: " + n + " {{ trans('messages.keyword_quotes') }}?");
                    }
                    
                    j('#deletepay').on("click", function() {
                        // Elimino le righe selezionate
                        if(check() && n != 0) {
                            for(var i = 0; i < n; i++) {
                                selezione[i].remove();
                            }
                            n = 0;
                        }
                        
                    });                      
 var $ = jQuery.noConflict();
	                </script>
	            </table></div></form></div>
  
			</div>
            
            
            
            
            
            
            
            

        </div></div><script>
		$('#prezzo_confermato').on("change", function() {
			$("#hdPrezzo").val($(this).val());
		});	
        </script>

		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            	<div class="bg-white modifica-blade-estimate-upload">
                	
                    <div class="form-group">
	        <label for="scansione"> 
            {{ trans('messages.keyword_attach_administrative_file') }} </label>
	      			</div>
                    
            <div class="row">
	        <div class="col-md-12 col-sm-12 col-xs-12">
            	@if(checkpermission('3', '16', 'scrittura','true'))
                <div class="image_upload_div">
                <?php echo Form::open(array('url' => '/estimates/modify/quote/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
                        {{ csrf_field() }}
                        <input type="hidden" name="idpreventivo" name="idpreventivo" value="{{ $preventivo->id }}">
    			</form>				
				</div>
                @endif
                <script>
				var urlgetfile = '<?php echo url('/estimates/modify/quote/getfiles/'.$mediaCode); ?>';

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
					var urlD = '<?php echo url('/estimates/modify/quote/deletefiles/'); ?>/'+id;
						$.ajax({url: urlD, success: function(result){
							$(".quoteFile_"+id).remove();
					    }});
				}
				
				 function sociallinks(id){   
                    $("#social_id").val(id); 
					$.ajax({
						url:"{{url('social/image')}}",
						type:'post',
						data: { "_token": "{{ csrf_token() }}","idval": id },
                        success:function(data){
							 $("#socialmedia").modal();
							 $('#newsocial').html(data);
                        } 
					});        
                   
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
                    var urlD = '<?php echo url('/estimates/modify/quote/updatefiletype/'); ?>/'+typeid+'/'+fileid;
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
                        $downloadlink = url('/storage/app/images/quote/'.$prev->name);
                        $filename = $prev->name;            
                        $arrcurrentextension = explode(".", $filename);
                        $extention = end($arrcurrentextension);
                                    
                        $arrextension['docx'] = 'docx-file.jpg';
                        $arrextension['pdf'] = 'pdf-file.jpg';
                        $arrextension['xlsx'] = 'excel.jpg';
                        if(isset($arrextension[$extention])){
                            $imagPath = url('/storage/app/images/default/'.$arrextension[$extention]);          
                        }
                        $titleDescriptions = (!empty($prev->title)) ? '<hr><strong>'.$prev->title.'</strong><p>'.$prev->description.'</p>' : "";
        				if(checkpermission('3', '16', 'scrittura','true')){
                        $html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a href="'.$downloadlink.'" class="btn btn-info pull-right"  download><i class="fa fa-download"></i></a><a class="btn btn-success pull-right"  onclick="sociallinks('.$prev->id.')"><i class="fa fa-share-alt"></i></a><a class="btn btn-danger pull-right"  onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-trash"></i></a>'.$titleDescriptions.'</td></tr>';
                        }
                        else {
                         $html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a href="'.$downloadlink.'" class="btn btn-info pull-right"  download><i class="fa fa-download"></i></a><a class="btn btn-success pull-right"  onclick="sociallinks('.$prev->id.')"><i class="fa fa-share-alt"></i></a>'.$titleDescriptions.'</td></tr>';   
                        }
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
                            if(checkpermission('3', '16', 'scrittura','true')){    
                            $html .=' <div class="cust-checkbox"><input type="checkbox" name="rdUtente_'.$prev->id.'"  '.$check.' id="'.$rolname.'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.',this.id);"  value="'.$val->ruolo_id.'" /><label for="'.$rolname.'_'.$prev->id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';
                            }
                            else {
                                $html .=' <div class="cust-checkbox"><input type="checkbox" name="rdUtente_'.$prev->id.'"  '.$check.' id="'.$rolname.'_'.$prev->id.'" disabled readyonly value="'.$val->ruolo_id.'" /><label for="'.$rolname.'_'.$prev->id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';
                            }
        				}
        				echo $html .='</td></tr>';
			         }
					}
                    ?></tbody>
                    <tbody id="files">
	                </tbody>
                    
	                <script>
	                var $ = jQuery.noConflict();
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
				                selezione[nFile] = $(this).parent().parent();
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
	            </table></div><hr>
	            </div>
                
                </div>

            </div>
            
            </div>
            </div>
            
	</div>
    
    @if(checkpermission('3', '16', 'scrittura','true'))
    <div class="col-md-12 col-sm-12 col-xs-12 mb16 show-mobile"> <button onclick="mostra2()" type="submit" class="btn btn-warning">{{ trans('messages.keyword_save') }} </button></div>
    @endif
    
</div>

</div>

<div class="footer-svg">
  <img src="{{url('images/FOOTER3-ORIZZONTAL_QUOTES.svg')}}" alt="avvisi">
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
                <form action="{{ url('/estimates/mediacomment/').'/'.$mediaCode }}" name="commnetform" method="post" id="commnetform">
                    {{ csrf_field() }}
                    @include('common.errors')                       
                    <div class="row">
                        <div class="col-md-12">                               
                            <div class="form-group">
                                <label for="title" class="control-label"> {{ ucfirst(trans('messages.keyword_title')) }}</label>
                                <input value="{{ old('title') }}" type="text" name="title" id="title" class="form-control required-input" placeholder="{{ ucfirst(trans('messages.keyword_title')) }} ">
                            </div>
                            <div class="form-group">
                                <label for="descriptions" class="control-label"> {{ ucfirst(trans('messages.keyword_description')) }}</label>
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

<div class="modal fade newsocial-popu" id="socialmedia" role="dialog" aria-labelledby="modalTitle">
    <div class="modal-dialog modal-l">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="modalTitle">{{trans('messages.keyword_social_media')}}</h3>
                </div>
				 <div class="modal-body">
                <input type="hidden" id="social_id" name="social_id" value="">
				<div class="row" id="newsocial">
            <?php 

                if(isset($socials)){
                    foreach ($socials as $social) { ?>
                    <div class="col-md-3 col-sm-4 col-xs-4">
                    <a href="" class="img-responsive">
                        <img src="{{ url('storage/app/images/social/'.$social->image)}}" alt="{{$social->title}}">
                    </a>
                    </div>    
                <?php   
                    }
                }
            ?>
            </div>
                  
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
      $("#edit_estimate").validate({            
      rules: {
         dipartimento: {
             required: true
         },
         idente: {
             required: true                    
         },
         considerazioni: {
             required: true                    
         },
         valenza: {
             required: true                    
         },
         finelavori: {
             required: true                    
         },
         data: {
             required: true                    
         },
         oggetto: {
             required: true                    
         },
         amountper: {
             digits: true                    
         }
      },
      messages: {
         dipartimento: {
            required: "{{stringformate(trans('messages.keyword_please_select_from'))}}"
         },
         idente: {
            required: "{{stringformate(trans('messages.keyword_please_select_to'))}}"
         },
         considerazioni: {
            required: "{{stringformate(trans('messages.keyword_please_enter_considerations'))}}"
         },
         valenza: {
            required: "{{stringformate(trans('messages.keyword_please_select_valency'))}}"
         },
         finelavori: {
            required:"{{stringformate(trans('messages.keyword_please_select_end_date'))}}"
         },
         data: {
             required:"{{stringformate(trans('messages.keyword_please_select_date'))}}"
         },
         oggetto: {
             required:"{{stringformate(trans('messages.keyword_please_enter_a_quotenm'))}}"
         },
         amountper: {
             required:"{{stringformate(trans('messages.keyword_only_digits_allowed'))}}"
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
                url:'{{ url('/estimates/mediacomment/').'/'.$mediaCode }}',
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
</script>

<script>

    
$('#data').datepicker();
$('#valenza').datepicker();
$('#finelavori').datepicker();
$('.datapicker').datepicker();
</script> 

<script type="text/javascript">
    //var $js = jQuery.noConflict();
    //$(function() {
        //$.extend($.kbw.signature.options, {color: '#0000ff'});
        $('#signature1').signature({ 
            change: function(event, ui) {                 
            }/*,
            syncField: '#signatureJSON'*/
        });          
            var $js = jQuery.noConflict();
            $js('#clearsignature').click(function() { 
                $js('#signature1').signature('clear'); 
            }); 
            $js('#confirmsignature').click(function() {
                //if($js('#signature1').signature('isEmpty')){
                    if(confirm("{{trans('messages.keyword_are_you_sure?')}}")){                       
                        $js("#signatureJSON").val("");
                        var signature = $js('#signature1').signature('toJSON')
                        $js("#signatureJSON").val(signature);                    
                        confirmQuotes(signature);
                    }
                /*}
                else {
                    alert("Please signature to confirm quote");
                }*/                
            });             
            /*
            $('#svg').click(function() {
                alert($('#sig').signature('toSVG'));
            });*/
    //});
     var currentsignature = '<?php echo $preventivo->signature; ?>';
     var currentEmotionst = '<?php echo $statoemotivoselezionato->id_tipo;?>';
     var issuperadmin = '<?php echo Auth::user()->id;?>';
     var issuperadmintype = '<?php echo Auth::user()->dipartimento;?>'; 
     if(currentEmotionst == '6' && issuperadmin != '0' && issuperadmintype != '0'){        
        $js("#statoemotivo").prop("disabled", true);
        $js('#signature1').signature('disable');
     }
     if(currentsignature != "") {                        
        $js('#signature1').signature('disable');
        $js('#signature1').signature('draw', currentsignature);
     }
     

    
    function confirmQuotes(signature){
        var quoteId = '<?php echo $preventivo->id;?>';    
        var urlD = '<?php echo url('/estimates/quoteconfirm/'); ?>';
        $.ajax({
            url: urlD,
            type: 'post',
            data: { "_token": "{{ csrf_token() }}",signature: signature,id:quoteId },
            success:function(data){
                window.location.reload(true);
            }
        });
    }

</script>

@endsection