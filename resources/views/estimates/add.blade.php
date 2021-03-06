@extends('layouts.app')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<div class="add-blade-estimate">
<div class="header-right">
	<div class="float-left">
    	<h1>{{trans('messages.keyword_add_quote')}}</h1><hr>
    </div>
    <div class="header-svg">
         <img src="{{url('images/HEADER2-RT_QUOTES.svg')}}" alt="header image">
    </div>
</div>

<div class="clearfix"></div>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<div class="row">
  <div class="col-md-8 col-sm-12 col-xs-12">
  <?php echo Form::open(array('url' => '/estimates/store', 'files' => true, 'id' => 'add_preventivo', 'name' => 'add_preventivo')) ?>
   <?php $mediaCode = date('dmyhis');?>
{{ csrf_field() }}

<script>$.datepicker.setDefaults(
    $.extend(
        {'dateFormat':'dd/mm/yy'},
		//{ changeYear: true },
         $.datepicker.regional['nl']
    )
);</script>
<input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />
<input type="hidden" id="hdstatoemotivo" name="statoemotivo" value="8" />

		<div class="row">
        	<div class="col-md-12 col-sm-12 col-xs-12">
            	<div class="form-group">
        <label for="id">{{trans('messages.keyword_no_estimate')}}
            <input disabled value=":cod/anno" type="text" id="id" name="id" placeholder="{{trans('messages.keyword_budget_code')}}" class="form-control">
        </label> 
        		</div>
        	</div>      
        </div>
        
        <div class="row">
        	<div class="col-md-12 col-sm-12 col-xs-12">
            	<div class="form-group">
        <label for="name_preventivo">{{trans('messages.keyword_name_quotation')}}</label>
        <input value="{{ old('oggetto') }}" type="text" id="name_preventivo" name="oggetto" placeholder="{{trans('messages.keyword_name_quotation')}}" class="form-control required-input">
        		</div>
        	</div>
        </div>
        
        <div class="row">
                <div class="col-md-4 col-sm-12 col-xs-12">
                		<div class="form-group">
                    <label for="dipartimento">{{trans('messages.keyword_from')}}</label>
                        <select name="dipartimento" class="js-example-basic-single form-control required-input">
                            <option selected></option>
                            @foreach($dipartimenti as $dipartimento)
                                    <option value="{{$dipartimento->id}}"  <?php if( old('dipartimento') == $dipartimento->id){ echo 'selected'; }?>>{{$dipartimento->nomedipartimento}}</option>                              
                            @endforeach
                        </select>
                        	</div>
                    <label for="dipartimento" generated="true" class="error"></label>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                		<div class="form-group">
                    <label for="idente">{{trans('messages.keyword_to')}}</label>
                    <select name="idente" class="js-example-basic-single form-control required-input">
                        <option selected></option>
                        @foreach($enti as $ente)                           
                                <option value="{{$ente->id}}" <?php if( old('idente') == $ente->id){ echo 'selected'; }?>>{{$ente->id.' | '.$ente->nomeazienda}}</option>
                        @endforeach
                    </select><script type="text/javascript">
    $(".js-example-basic-single").select2();
</script>
						</div>
                        <label for="idente" generated="true" class="error"></label>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                		<div class="form-group">
                    <label for="data">{{trans('messages.keyword_date')}}</label>
                    <input value="{{old('data')}}" type="text" id="data" name="data" placeholder="{{trans('messages.keyword_date_creation_preventive')}}" class="form-control required-input">
                    	</div>
                </div>
        </div>

        <div class="row">
	 <div class="col-md-12 col-sm-12 col-xs-12"><h4>{{trans('messages.keyword_packages_and_optional')}}</h4><hr></div>
    <div class="col-md-12 set-mannualy-width-estimates-modifica col-sm-12 col-xs-12">
        <div class="btn-blk">    
            <div class="space20"></div> 
            <a class="btn btn-warning"  id="add"><i class="fa fa-plus"></i></a>
            <a class="btn btn-danger"  id="delete"><i class="fa fa-trash"></i></a>
        </div>
        <div class="select-box">
            <div class="form-group">
                <label>{{trans('messages.keyword_list_of_packages')}}</label>
                <select id="pacchetti" class="js-example-basic-single form-control">
                    <option></option>
                    @foreach($pacchetti as $pacchetto)
                        <option value="{{$pacchetto->id}}">{{$pacchetto->label}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="select-box">
            <div class="form-group">
                <label>{{trans('messages.keyword_optional_list')}}</label>
                <select id="optional" class="js-example-basic-single form-control">
                    <option></option>
                    @foreach($optional as $opt)
                        <option value="{{$opt->id}}">{{$opt->code}}</option>
                    @endforeach
                </select>
                <script type="text/javascript">
                    $(".js-example-basic-single").select2();
                </script>
            </div>
        </div>  
    </div>  
    <div class="col-md-12 col-sm-12 col-xs-12">
     <div class="height10"></div>
        <div class="set-height450">
        <table id="table" class="table table-bordered packages_and_optional">
            <thead>
                <th>#</th>
                <th> {{ trans('messages.keyword_order') }} </th>                
                <th> {{ trans('messages.keyword_object') }}, {{ trans('messages.keyword_qty') }}, {{ trans('messages.keyword_unit_price') }} </th>
                <th> {{ trans('messages.keyword_description') }} </th>                
                <th> {{ trans('messages.keyword_subtotal') }}, {{ trans('messages.keyword_cyclicity') }}, {{ trans('messages.keyword_asterisca') }}</th>                
                <?php /*<!--  <th>{{trans('messages.keyword_order')}}</th>
                <th>{{trans('messages.keyword_code')}}</th>-->
                <th>{{trans('messages.keyword_object')}}</th>
                <th>{{trans('messages.keyword_description')}}</th>
                <th>{{trans('messages.keyword_qty')}}</th>
                <th>{{trans('messages.keyword_unit_price')}}</th>
                <th>{{trans('messages.keyword_subtotal')}}</th>
                <th>{{trans('messages.keyword_cyclicality')}}</th>
                <th>{{trans('messages.keyword_asterisca')}}</th>*/?>
            </thead>
            <tbody id="tabella">
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
		var freqdata=<?php echo json_encode($frequency); ?>;
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
                                    
                                    var ordine = document.createElement("input");
                                    ordine.type = "number";
                                    var qt1 = document.createElement("td");
                                    ordine.value = 1;
                                    ordine.name = "ordine[]";
                                    ordine.className = "form-control priority";
                                    ordine.placeholder="{{ trans('messages.keyword_order') }}";
                                    qt1.appendChild(ordine);
                                    
                                    // Codice
                               
                                  
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
                                    input.placeholder="{{ trans('messages.keyword_object') }}";
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
                                    qt.placeholder="{{ trans('messages.keyword_qty') }}";
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
                                    inputPrezzo.placeholder="{{ trans('messages.keyword_unit_price') }}";
                                    oggettodiv2.appendChild(inputPrezzo);
                                    oggetto.appendChild(oggettorow);
                                    //prezzo.appendChild(inputPrezzo);

                                     // Descrizione
                                    var desc = optional[k]['description'];
                                    var descrizione = document.createElement("td");
                                    var inputDesc = document.createElement("textarea");
                                    //inputDesc.type = "text";
                                    inputDesc.name = "desc[]";
                                    inputDesc.value = desc;
                                    inputDesc.className = "form-control";
                                    inputDesc.placeholder="{{ trans('messages.keyword_description') }}";
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
                                    totale.placeholder="{{ trans('messages.keyword_subtotal') }}";
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
                                    /*freqtd.appendChild(select);*/

                // Asterisca
                var prez = optional[k]['price'];
                
                var compl = document.createElement("td");
                var checkdiv = document.createElement("div");
                checkdiv.className = "switch";
                var check = document.createElement("input");
                check.type = "checkbox";
                check.name = "ast[]";
                check.id = "ast"+count;
                check.className = 'astircflag';
                var checkLabel = document.createElement("label");
                checkLabel.for="ast"+count;
                checkLabel.setAttribute('for', "ast"+count);
                checkdiv.appendChild(check);
                checkdiv.appendChild(checkLabel);      
                totalediv2.appendChild(checkdiv);                                                                 
                //compl.appendChild(checkdiv);
                                    
                                    tdTot.appendChild(totalerow);
                                    
                                    tr.appendChild(td);
                                    tr.appendChild(qt1);
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
            calculateTotal();
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
                    ordine.className = "form-control priority";
                    ordine.placeholder="{{ trans('messages.keyword_order') }}";
                    qt1.appendChild(ordine);
                    tr.appendChild(qt1);
                    // Codice

                    var oggettorow = document.createElement("div");
                    oggettorow.className="row";
                    var oggettodiv1 = document.createElement("div");
                    oggettodiv1.className="col-md-6";
                    var oggettodiv2 = document.createElement("div");
                    oggettodiv2.className="col-md-6";

                    oggettorow.appendChild(oggettodiv1);
                    oggettorow.appendChild(oggettodiv2);


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
                    input.placeholder="{{ trans('messages.keyword_object') }}";
                    oggetto.appendChild(input);
                    oggetto.appendChild(oggettorow);

                    /*oggetto.appendChild(input);
                    tr.appendChild(oggetto);*/
                    // Descrizione
                    
                    // Q.tà
                    var qt = document.createElement("input");
                    qt.type = "number";
                    var tdQt = document.createElement("td");
                    qt.value = 1;
                    qt.name = "qt[]";
                    qt.className = "form-control qt";
                    qt.placeholder="{{ trans('messages.keyword_qty') }}";
                    oggettodiv1.appendChild(qt);
                    /*tdQt.appendChild(qt);
                    tr.appendChild(tdQt);*/

                    // Prezzo unitario
                    var prez = optional[k]['price'];
                    var prezzo = document.createElement("td");
                    var inputPrezzo = document.createElement("input");
                    inputPrezzo.type = "number";
                    inputPrezzo.value = prez;
                    inputPrezzo.name = "pru[]";
                    inputPrezzo.className = "form-control pr";
                    inputPrezzo.placeholder="{{ trans('messages.keyword_unit_price') }}";
                    oggettodiv2.appendChild(inputPrezzo);
                    /*prezzo.appendChild(inputPrezzo);
                    tr.appendChild(prezzo);*/
                    tr.appendChild(oggetto);

                    var desc = optional[k]['description'];
                    var descrizione = document.createElement("td");
                    var inputDesc = document.createElement("textarea");
                    //inputDesc.type = "text";
                    inputDesc.name = "desc[]";
                    inputDesc.value = desc;
                    inputDesc.className = "form-control";
                    inputDesc.placeholder="{{ trans('messages.keyword_description') }}";
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
                    totale.placeholder="{{ trans('messages.keyword_subtotal') }}";
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
                    /*freqtd.appendChild(select);
                    tr.appendChild(freqtd);*/

                    // Asterisca
                    var checkdiv = document.createElement("div");
                    checkdiv.className = "switch";
                    var check = document.createElement("input");
                    check.type = "checkbox";
                    check.name = "ast[]";
                    check.id = "ast"+count;
                    check.className = 'astircflag';
                    var checkLabel = document.createElement("label");
                    checkLabel.for="ast"+count;
                    checkLabel.setAttribute('for', "ast"+count);
                    checkdiv.appendChild(check);
                    checkdiv.appendChild(checkLabel);
                    
                    /*var tdAst = document.createElement("td");
                    tdAst.appendChild(checkdiv);*/
                    totalediv2.appendChild(checkdiv);                    
                    tdTot.appendChild(totalerow);

                    //tr.appendChild(tdAst);
                    // Aggiungo la nuova riga
                    tabella.appendChild(tr); 
					count++;            
                }
            }
            calculateTotal();
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
            ordine.className = "form-control priority";
            ordine.placeholder="{{ trans('messages.keyword_order') }}";
            qt1.appendChild(ordine);
            tr.appendChild(qt1);
            // Oggetto
            var oggetto = document.createElement("td");
            var input = document.createElement("input");
            input.type = "text";
            input.name = "oggetti[]";
            input.className ="form-control";
            input.placeholder="{{ trans('messages.keyword_object') }}";

            //oggetto.appendChild(input);
            //tr.appendChild(oggetto);

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

            
            oggetto.appendChild(input);            
            oggetto.appendChild(oggettorow);
            tr.appendChild(oggetto);

            // Descrizione
            var descrizione = document.createElement("td");
            var inputDesc = document.createElement("textarea");
            //inputDesc.type = "text";
            inputDesc.name = "desc[]";
            inputDesc.className = "form-control";
            inputDesc.placeholder="{{ trans('messages.keyword_description') }}";
            descrizione.appendChild(inputDesc);
            tr.appendChild(descrizione);

            // Q.tà
            var qt = document.createElement("input");
            qt.type = "number";
            var tdQt = document.createElement("td");
            qt.name = "qt[]";
            qt.className = "form-control qt";
            qt.placeholder="{{ trans('messages.keyword_qty') }}";
            oggettodiv1.appendChild(qt);
            /*tdQt.appendChild(qt);
            tr.appendChild(tdQt);*/
            // Prezzo unitario
            var prezzo = document.createElement("td");
            var inputPrezzo = document.createElement("input");
            inputPrezzo.type = "number";
            inputPrezzo.name = "pru[]";
            inputPrezzo.className = "form-control pr";
            inputPrezzo.placeholder="{{ trans('messages.keyword_unit_price') }}";
            oggettodiv2.appendChild(inputPrezzo);
            /*prezzo.appendChild(inputPrezzo);
            tr.appendChild(prezzo);*/
            // Totale
            var totale = document.createElement("input");
            totale.type = "number";
            var tdTot = document.createElement("td");
            totale.name = "tot[]";
            totale.className = "form-control tot";
            totale.placeholder="{{ trans('messages.keyword_subtotal') }}";
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
            /*freqtd.appendChild(select);
            tr.appendChild(freqtd);*/

            // Asterisca
            var checkdiv = document.createElement("div");
            checkdiv.className = "switch";
            var check = document.createElement("input");
            check.type = "checkbox";
            check.name = "ast[]";
            check.id = "ast"+count;
            check.className = 'astircflag';
            var checkLabel = document.createElement("label");
            checkLabel.for="ast"+count;
            checkLabel.setAttribute('for', "ast"+count);
            checkdiv.appendChild(check);
            checkdiv.appendChild(checkLabel);

            //var tdAst = document.createElement("td");
            //tdAst.appendChild(checkdiv);           
            totalediv2.appendChild(checkdiv);
            tdTot.appendChild(totalerow);
            
            //tr.appendChild(tdAst);
            // Aggiungo la nuova riga
            tabella.appendChild(tr); 

            // $('#tabella tr:last' ).css({ backgroundColor: "yellow", fontWeight: "bolder" });
            // $('#tabella tr:last td:first' ).focus();     
            // // $('#tabella tr:last td:first' ).scrollTo( '100%' );  
            // $('#tabella').scroll(function() {
            //   $( "#tabella tr:last" );
            // });

            // $('#tabella tr:last').animate({
            //    scrollTop: $('#tabella tr:last').scrollTop()+10
            // }, 500);
            
            // $('body, html').animate({ scrollTop: $("#tabella tr:last").offset().top }, 1000);

 
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
            return confirm("<?php echo trans('messages.keyword_are_you_sure_you_want_to_delete:');?>: " + n + " pacchetti/optional?");
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
            if ($(this).is(':checked')) {
                $(this).parent().closest('tr').find("input.qt").hide();
                $(this).parent().closest('tr').find("input.pr").hide();
                $(this).parent().closest('tr').find("input.tot").hide();                 
            }
            else {
                $(this).parent().closest('tr').find("input.qt").show();
                $(this).parent().closest('tr').find("input.pr").show();
                $(this).parent().closest('tr').find("input.tot").show();                    
            }
             calculateTotal();
        });
        $(function() {
             $(".astircflag").each(function(index) {            
                if ($(this).is(':checked')) {
                    $(this).parent().closest('tr').find("input.qt").hide();
                    $(this).parent().closest('tr').find("input.pr").hide();
                    $(this).parent().closest('tr').find("input.tot").hide();                 
                }
                else {
                    $(this).parent().closest('tr').find("input.qt").show();
                    $(this).parent().closest('tr').find("input.pr").show();
                    $(this).parent().closest('tr').find("input.tot").show();                    
                }
            });
        });
        
        var tabella = document.getElementById("tabella");
    </script>

        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            	<div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                    <label for="considerazioni"> {{ trans('messages.keyword_considerations') }}</label>
                    <textarea id="considerazioni" name="considerazioni" placeholder=" {{ trans('messages.keyword_budget_considerations') }} " class="form-control required-input considerazioni">{{old('considerazioni')}}</textarea>
                        </div>
                        <div class="form-group">
                    <label for="valenza"> {{ trans('messages.keyword_valenza') }}</label>
                    <input value="{{old('valenza')}}" type="text" id="valenza" name="valenza" placeholder=" {{ trans('messages.keyword_valency_budget') }} " class="form-control required-input">
                        </div>
            
                </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                    <label for="noteimportanti"> {{ trans('messages.keyword_important_notes') }} </label>
                    <textarea id="noteimportanti" name="noteimportanti" placeholder=" {{ trans('messages.keyword_important_notes') }} " class="form-control noteimportanti">{{old('noteimportanti')}}</textarea>
                    </div>
                   
                   <div class="form-group"> 
                    <label for="finelavori"> {{ trans('messages.keyword_end_date_works') }}</label>
                    <input value="{{old('finelavori')}}" type="text" id="finelavori" name="finelavori" placeholder=" {{ trans('messages.keyword_date_expected_end_of_work') }} " class="form-control required-input">
                    </div>
                </div>
                    
                    
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                        <label for="scontoagente"> {{ trans('messages.keyword_agent_discount') }}  <span class="required">(%)</span></label>
                        <input value="{{old('scontoagente')}}" type="number" step="any" id="scontoagente" name="scontoagente" placeholder=" {{ trans('messages.keyword_agent_discount_-_calculated_on_the_total') }} " class="form-control" title="% {{ trans('messages.keyword_of_maximum_discount_attributable_user') }} ">
                        </div>
                	</div>
                    
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
               <div class="form-group">  
                <label for="scontobonus"> {{ trans('messages.keyword_agent_discount_discount') }}  <span class="required">(%)</span></label>
    <input value="{{old('scontobonus')}}" type="number" step=any id="scontobonus" name="scontobonus" placeholder=" {{ trans('messages.keyword_calculated_on_the_total_already_discounted') }} " class="form-control" title="% {{ trans('messages.keyword_discounted_by_the_retailer') }} ">
                </div>
    				</div>
                    
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <div class="none">
                        <label for="lineebianche">{{trans('messages.keyword_number_of_lines')}}</label>
                        <input value="{{old('lineebianche')}}" type="number" id="lineebianche" name="lineebianche" placeholder="{{trans('messages.keyword_number_of_lines')}}" class="form-control" title="{{trans('messages.keyword_enter_how_many_lines_page_of_the_quote')}}">
            
                    </div>
                 </div>
            </div>
            
            
                    
                    
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                        <label for="subtotale"> {{ trans('messages.keyword_total') }}  <span class="required">(€)</span><a onclick="calcola()" class="" title="Compilazione assistita">  {{ trans('messages.keyword_click') }}  <i class="fa fa-info"></i> {{ trans('messages.keyword_for_compilation') }} </a></label>
        <input value="{{old('subtotale')}}" step="any" type="number" id="subtotale" name="subtotale" placeholder="{{ trans('messages.keyword_total_price') }} " class="form-control" title=" {{ trans('messages.keyword_initial_value_calculated_individual_packages') }} "> 
                        </div> </div>
                    
            	<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                 <label for="totale"> {{ trans('messages.keyword_discounted_total') }}  <span class="required">(€)</span></label>
    <input value="{{old('totale')}}" type="number" step=any id="totale" name="totale" placeholder=" {{ trans('messages.keyword_discounted_total') }} " class="form-control" title="{{ trans('messages.keyword_discounted_value_or_overwritten_value') }} ">
                </div>
                </div>
           
            
                    
               <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">     
                <div class="form-group"> 
       <label for="totaledapagare"> {{ trans('messages.keyword_topay') }}  <span class="required">(€)</span></label>
    <input value="{{old('totaledapagare')}}" type="number" step=any id="totaledapagare" name="totaledapagare" placeholder=" {{ trans('messages.keyword_total_price_to_be_paid') }} " class="form-control" title=" {{ trans('messages.keyword_value_to_be_entered_for_any_rounding') }} ">
                </div>
    
            </div>
                    <script>
            var testo = "";
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
            $('#add_preventivo').submit(function(){ //listen for submit event
                var queryString = $('#frmpayments').serialize();
                /*var paymentMethodhtml = $("#paymethod").html();
                $('#add_preventivo').append(queryString);*/

                var x = $("#frmpayments").serializeArray();
                if($('#add_preventivo').valid() && x != "") {                
                    $.each(x, function(i, field){
                        var ht="<input type='text' name='"+field.name+"' value='"+field.value+"' style='display:none;'>";
                        $("#add_preventivo").append(ht);
                    });         
                }       
                return true;
            }); 
    
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
    
              $j('#subtotale').val(totale);
              $j('#scontoagente').val(scontoagente);
              $j('#scontobonus').val(scontobonus);
              $j('#totale').val(totalescontato);
              $j('#totaledapagare').val(dapagare);
            }
      </script>
                
                    
            
           		 </div>
            </div>
            
            
        </div>
      
            
           
       <div class="row"><div class="col-md-12 col-sm-12 col-xs-12 mb16 show-desktop"> <button onclick="mostra2()" type="submit" class="btn btn-warning">{{ trans('messages.keyword_save') }}</button></div></div>
        
	

        </form>
    </div>
    
    <div class="col-md-4 col-sm-12 col-xs-12">
    
	<div class="form-group">
        <label for="statoemotivo">{{ trans('messages.keyword_emotional_state') }}</label>
        <select name="statoemotivo" class="form-control" id="statoemotivo" >
                    <!-- statoemotivoselezionato -->     
                @foreach($statiemotivi as $statoemotivo)
                 <?php $label = (!empty($statoemotivo->language_key)) ?  ucwords(strtolower(trans('messages.'.$statoemotivo->language_key))) : (($statoemotivo->name)); ?>
                 <option  <?php if(old('statoemotivo')==$statoemotivo->id){ echo 'selected'; }?> style="background-color:{{$statoemotivo->color}};color:#ffffff" value="{{$statoemotivo->id}}">{{wordformate($label)}}</option>
                @endforeach     
        </select>
 	</div> 
 
 		<div class="estimate-add-tbl">
                <label for="metodo">{{trans('messages.keyword_payment_method')}}</label>
                 <a class="btn btn-warning" id="addpay"><i class="fa fa-plus"></i></a>
                <a class="btn btn-danger" id="deletepay"><i class="fa fa-trash"></i></a>
                
                
                <div id="paymethod">
                <form id="frmpayments">
                <div class="table-responsive">
                	<div class="set-height-paymethod">
                    <table class="table table-striped table-bordered">                   
                    <tbody id="filespay">
                    @for($i=0;$i< 3;$i++)
                    <tr><td><input class="selezione" id="payment_{{$i}}" type="checkbox"><label for="payment_{{$i}}"></label></td>
                        <td><input class="form-control datapicker" name="datapay[]" value="{{date('d/m/Y')}}" id="datapay{{$i}}" placeholder="Data" type="text"></td>
                        <td><input class="form-control paymentPercentage" name="amountper[]" placeholder="%" value="0" type="text"></td>
                        <td><input class="form-control paymentAmount" name="importo[]" placeholder="importo" value="0" type="text"></td>
                    </tr>
                    @endfor
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
                            perInput.id = "amountper"+kFile3;
                            perInput.placeholder  = "%";
                            perInput.setAttribute("onkeyup", "myFunction(this.value)");
                            perinupt.appendChild(perInput);
                            
                            var importtd = document.createElement("td");
                            var importinput = document.createElement("input");
                            importinput.type = "text";
                            importinput.className = "form-control";
                            importinput.name = "importo[]";
                            importinput.id = "importo"+kFile3;
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

        var j = jQuery.noConflict();
 
        // Do something with jQuery
    
        var selezione = [];
        var n = 0;
        
        j('table').on('click','tr input.selezione',function(e) {
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
        
        j('#deletepay').on("click", function() {
            // Elimino le righe selezionate
            if(check() && n != 0) {
                for(var i = 0; i < n; i++) {
                    selezione[i].remove();
                }
                n = 0;
            }
            
        });
                    </script>
                </table></div></div>
                </form>
                </div>
  
 
   
            </div>
 
 
        <script>
        var yourSelect = document.getElementById( "statoemotivo" );
        document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
        $j('#statoemotivo').on("change", function() {
            var yourSelect = document.getElementById( "statoemotivo" );
            document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
			$("#hdstatoemotivo").val($j(this).val());
        });
        </script>

		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            	<div class="bg-white modifica-blade-estimate-upload">
            <label for="scansione">{{ trans('messages.keyword_attach_administrative_file') }}</label>
            <br>
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="image_upload_div">
                <?php echo Form::open(array('url' => '/estimates/modify/quote/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
{{ csrf_field() }}
                </form>             
                </div><script>
                var urlgetfile = '<?php echo url('/estimates/modify/quote/getfiles/'.$mediaCode); ?>';
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
                    var urlD = '<?php echo url('/estimates/modify/quote/deletefiles/'); ?>/'+id;
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
                <?php /* if(isset($preventivo->id)){?>
                var url1 = '<?php echo url('/estimates/modify/quote/getdefaultfiles/'.$preventivo->id); ?>';
                $j.ajax({url: url1, success: function(result){
                            $j("#files").html(result);
                            $j(".dz-preview").remove();
                            $j(".dz-message").show();
                        }});
                        <?php } */?>
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

                   /* $html .=' <input type="radio" name="rdUtente_'.$prev->id.'"  '.$check.' id="rdUtente_'.$val->ruolo_id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.');"  value="'.$val->ruolo_id.'" /> '.$val->nome_ruolo;*/
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
                    <a target="new" href="{{url('/estimates/files') . '/' . $preventivo->id}}" class="btn btn-info" style="color:#ffffff;text-decoration: none" title="Vedi files"><i class="fa fa-info"></i></a>
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
    
    <div class="col-md-12 col-sm-12 col-xs-12 mb16 show-mobile"> <button onclick="mostra2()" type="submit" class="btn btn-warning">{{ trans('messages.keyword_save') }}</button></div>
    
    
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
<script type="text/javascript">
$('#scontoagente').on('change', function() {     
     calculateTotal();
});
$('#scontobonus').on('change', function() {     
     calculateTotal();
});
$('#subtotale').on('change', function() {     
     calculateTotal();
});
$('#totale').on('change', function() {     
    var total = $("#subtotale").val();  
    var discount = $(this).val();
    var paytotal = (total - discount);
    $("#totaledapagare").val(paytotal);
});

$('table').on('keyup','tr input.paymentPercentage', function() {
    if($(this).val() != ""){       
        $(this).parent().closest('tr').find("input.paymentAmount").val("0");
     $(this).parent().closest('tr').find("input.paymentAmount").attr('disabled',true);   

    }
    else {
        $(this).parent().closest('tr').find("input.paymentAmount").attr('disabled',false);   
    }    
});
$('table').on('keyup','tr input.paymentAmount', function() {
    if($(this).val() != ""){       
    $(this).parent().closest('tr').find("input.paymentPercentage").val("0");
     $(this).parent().closest('tr').find("input.paymentPercentage").attr('disabled',true);   
    }
    else {
        $(this).parent().closest('tr').find("input.paymentPercentage").attr('disabled',false);   
    }    
});


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
        //if(arrchekedp[index]==false){
            totalval = (parseFloat(totalval) + parseFloat($(this).val()));        
        //}
    });
    $("#subtotale").val(totalval);
    var scontoagente = $("#scontoagente").val();
    var scontobonus = $("#scontobonus").val();
    var agentdiscount = ((totalval * scontoagente) / 100);
    var topay = (totalval - agentdiscount);

    var agentbonus = ((topay * scontobonus) / 100);
    var TotalDiscount = (agentdiscount + agentbonus);    
    topay = (topay - agentbonus);
    $("#totale").val(TotalDiscount);
    $("#totaledapagare").val(topay);
    /*$("#agentdiscount").val(agentdiscount);
    $("#agentbonus").val(agentbonus);*/
}
$(document).ready(function() {
     $("#add_preventivo").validate({            
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
            required: "{{ stringformate(trans('messages.keyword_please_enter_considerations'))}}"
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
@endsection