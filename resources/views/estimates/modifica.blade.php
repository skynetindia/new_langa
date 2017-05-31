@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
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
        <img src="http://betaeasy.langa.tv/images/HEADER2-RT_QUOTES.svg" alt="header image">
    </div>
</div>

<script>$.datepicker.setDefaults(
    $.extend(
        {'dateFormat':'dd/mm/yy'},
         $.datepicker.regional['nl']
    )
);</script>
<div class="row">
    <div class="col-md-8">
    <?php echo Form::open(array('url' => '/estimates/modify/quote' . '/' . $preventivo->id, 'files' => true, 'name' => 'edit_estimate', 'id' => 'edit_estimate')) ?>
    <?php $mediaCode = date('dmyhis');?>
{{ csrf_field() }}
<input type="hidden" name="idutente" value="{{$preventivo->idutente}}">
<input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />
<?php $selectedVal = 'NON CONFERMATO'; ?>
@if($statoemotivoselezionato!=null)
	@foreach($statiemotivi as $statoemotivo)
		@if($statoemotivo->id == $statoemotivoselezionato->id_tipo) 
	        <?php $selectedVal = $statoemotivo->name; ?>        	 
       	@endif 
	@endforeach
@endif
<input type="hidden" id="hdstatoemotivo" name="statoemotivo" value="{{$selectedVal}}" />
<input type="hidden" id="hdPrezzo" name="prezzo" value="{{$preventivo->prezzo_confermato}}" />

	<div class="row">
    	<div class="col-md-12">
        <label for="id"> {{ trans('messages.keyword_noquote') }} 
			<input disabled value=":{{$preventivo->id}}/{{$preventivo->anno}}" type="text" id="id" name="id" placeholder="{{ trans('messages.keyword_budget_code') }} " class="form-control">
		</label>
		<div class="btn-group btn-group-top-space">
        	<a target="new" href="{{url('/preventivi/pdf/quote/') . '/' . $preventivo->id}}" class="btn btn-default" title=" 
            {{ trans('messages.keyword_see_budget') }} "><i class="fa fa-file-pdf-o"></i></a>
        </div>

        <div class="btn-group">
            <a target="new" href="{{ url('enti/myenti') }}" class="btn btn-warning" title=" {{ trans('messages.keyword_gotoentity') }} "> {{ trans('messages.keyword_gotoentity') }}</a>
        </div>

        </div>
    </div>    
        
        <br>
		<label for="oggetto"> {{ trans('messages.keyword_quotename') }} <span class="required">(*)</span></label>
        <input value="{{$preventivo->oggetto}}" type="text" id="oggetto" name="oggetto" placeholder=" {{ trans('messages.keyword_subject_of_budget') }}" class="form-control"><br>
        <div class="row">
    			<div class="col-md-4">
    				<label for="dipartimento"> {{ trans('messages.keyword_from') }} <span class="required">(*)</span></label>
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
    				<label for="idente"> {{ trans('messages.keyword_to') }} </label>
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
    				<label for="data"> {{ trans('messages.keyword_date') }} <span class="required">(*)</span> </label> 
                    <input value="{{$preventivo->data}}"type="text" id="data" name="data" placeholder=" {{ trans('messages.keyword_date_creation_quote') }}" class="form-control"><br>
    			</div>
        </div>

		<div class="row">

    	<div class="col-md-12"><h4> {{ trans('messages.keyword_packages_and_optional') }} </h4><hr></div>
    <div class="col-md-2">    
    	<div class="space20"></div>    
       
	    <a class="btn btn-warning"  id="add"><i class="fa fa-plus"></i></a>
	    <a class="btn btn-danger"  id="delete"><i class="fa fa-trash"></i></a>
    </div>
    <div class="col-md-5">
            <label> {{ trans('messages.keyword_list_of_packages') }} </label>
        <select id="pacchetti" class="js-example-basic-single form-control">
            <option></option>
            @foreach($pacchetti as $pacchetto)
                <option value="{{$pacchetto->id}}">{{$pacchetto->label}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-5">
            <label> {{ trans('messages.keyword_optional_list') }} </label>
        <select id="optional" class="js-example-basic-single form-control">
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
                <th> {{ trans('messages.keyword_object') }} </th>
                <th> {{ trans('messages.keyword_description') }} </th>
                <th> {{ trans('messages.keyword_qty') }} </th>
                <th> {{ trans('messages.keyword_unit_price') }} </th>
                <th> {{ trans('messages.keyword_subtotal') }} </tH>
                <th> {{ trans('messages.keyword_cyclicity') }} </th>
                <th> {{ trans('messages.keyword_asterisca') }} </th>
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
        count=0;
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
									
									
                                    var radio1 = document.createElement("input");
                                    radio1.type = "radio";

                                    var radio2 = document.createElement("input");
                                    radio2.type = "radio";

                                    var radio3 = document.createElement("input");
                                    radio3.type = "radio";

                                    var radio4 = document.createElement("input");
                                    radio4.type = "radio";

                                    var radio5 = document.createElement("input");
                                    radio5.type = "radio";

                                    var ciclicita = document.createElement("td");
                                    radio1.name = "cicli["+count+"]";
                                    radio2.name = "cicli["+count+"]";
                                    radio3.name = "cicli["+count+"]";
                                    radio4.name = "cicli["+count+"]";
                                    radio5.name = "cicli["+count+"]";
									
									radio1.value = "1_M";
									radio2.value = "2_M";
									radio3.value = "3_M";
									radio4.value = "4_M";
									radio5.value = "5_M";

                                    
                                    ciclicita.appendChild(radio1);
                                    ciclicita.appendChild(document.createTextNode(" 1 M. "));

                                    ciclicita.appendChild(radio2);
                                    ciclicita.appendChild(document.createTextNode(" 2 M. "));

                                    ciclicita.appendChild(radio3);
                                    ciclicita.appendChild(document.createTextNode(" 3 M. "));

                                    ciclicita.appendChild(radio4);
                                    ciclicita.appendChild(document.createTextNode(" 6 M. "));

                                    ciclicita.appendChild(radio5);
                                    ciclicita.appendChild(document.createTextNode(" 1 A. "));

									
									// Asterisca
									/*var check = document.createElement("input");
									check.type = "checkbox";
									var compl = document.createElement("td");
									check.name = "ast[]";
									compl.appendChild(check);
									//tr.appendChild(tdAst);*/
                                    var compl = document.createElement("td");
                                    var checkdiv = document.createElement("div");
                                    checkdiv.className = "switch";
                                    var check = document.createElement("input");
                                    check.type = "checkbox";
                                    check.name = "ast[]";
                                    check.id = "ast"+count;
                                    var checkLabel = document.createElement("label");
                                    checkLabel.for="ast"+count;
                                    checkLabel.setAttribute('for', "ast"+count);
                                    checkdiv.appendChild(check);
                                    checkdiv.appendChild(checkLabel);									
									compl.appendChild(checkdiv);
									
									tr.appendChild(td);
									//tr.appendChild(qt1);
									//tr.appendChild(codice);
									tr.appendChild(oggetto);
									tr.appendChild(descrizione);
									tr.appendChild(tdQt);
									tr.appendChild(prezzo);
									tr.appendChild(tdTot);
                                    tr.appendChild(ciclicita);
									tr.appendChild(compl);
									
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
            for(var k = 0; k < optionalLength; k++) {
                if(optional[k]['id'] == id) {
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
					
					
                     var radio1 = document.createElement("input");
                    radio1.type = "radio";

                    var radio2 = document.createElement("input");
                    radio2.type = "radio";

                    var radio3 = document.createElement("input");
                    radio3.type = "radio";

                    var radio4 = document.createElement("input");
                    radio4.type = "radio";

                    var radio5 = document.createElement("input");
                    radio5.type = "radio";

                    var ciclicita = document.createElement("td");
                    radio1.name = "cicli["+count+"]";
                    radio2.name = "cicli["+count+"]";
                    radio3.name = "cicli["+count+"]";
                    radio4.name = "cicli["+count+"]";
                    radio5.name = "cicli["+count+"]";
					
					radio1.value = "1_M";
					radio2.value = "2_M";
					radio3.value = "3_M";
					radio4.value = "4_M";
					radio5.value = "5_M";

                    
                    ciclicita.appendChild(radio1);
                    ciclicita.appendChild(document.createTextNode(" 1 M. "));

                    ciclicita.appendChild(radio2);
                    ciclicita.appendChild(document.createTextNode(" 2 M. "));

                    ciclicita.appendChild(radio3);
                    ciclicita.appendChild(document.createTextNode(" 3 M. "));

                    ciclicita.appendChild(radio4);
                    ciclicita.appendChild(document.createTextNode(" 6 M. "));

                    ciclicita.appendChild(radio5);
                    ciclicita.appendChild(document.createTextNode(" 1 A. "));
                    tr.appendChild(ciclicita);
					
                    // Asterisca
                    var checkdiv = document.createElement("div");
                    checkdiv.className = "switch";
                    var check = document.createElement("input");
                    check.type = "checkbox";
                    check.name = "ast[]";
                    check.id = "ast"+count;
                    var checkLabel = document.createElement("label");
                    checkLabel.for="ast"+count;
                    checkLabel.setAttribute('for', "ast"+count);
                    checkdiv.appendChild(check);
                    checkdiv.appendChild(checkLabel);

                    var tdAst = document.createElement("td");                    
                    tdAst.appendChild(checkdiv);
                    tr.appendChild(tdAst);
                    // Aggiungo la nuova riga
                    tabella.appendChild(tr);   
					count++;          
                }
            }
        });
        
        
        $('#add').on("click", function() {
            // Aggiungo una riga vuota
            var tr = document.createElement("tr");
            var count = j('#tabella').children('tr').length;
            // Checkbox                        
            var checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.className = "selezione";
            checkbox.id = "checkNu"+count;
            var checkboxlabel = document.createElement("label");
            checkboxlabel.for = "checkNu"+count;
            checkboxlabel.setAttribute('for', "checkNu"+count);

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
            tr.appendChild(descrizione);
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
			
			 var radio1_optional = document.createElement("input");
            radio1_optional.type = "radio";

            var radio2_optional = document.createElement("input");
            radio2_optional.type = "radio";

            var radio3_optional = document.createElement("input");
            radio3_optional.type = "radio";

            var radio4_optional = document.createElement("input");
            radio4_optional.type = "radio";

            var radio5_optional = document.createElement("input");
            radio5_optional.type = "radio";

            var ciclicita_optional = document.createElement("td");
            radio1_optional.name = "cicli["+count+"]";
            radio2_optional.name = "cicli["+count+"]";
            radio3_optional.name = "cicli["+count+"]";
            radio4_optional.name = "cicli["+count+"]";
            radio5_optional.name = "cicli["+count+"]";
			
			radio1_optional.value = "1_M";
            radio2_optional.value = "2_M";
            radio3_optional.value = "3_M";
            radio4_optional.value = "4_M";
            radio5_optional.value = "5_M";
            
            
            ciclicita_optional.appendChild(radio1_optional);
            ciclicita_optional.appendChild(document.createTextNode(" 1 M. "));

            ciclicita_optional.appendChild(radio2_optional);
            ciclicita_optional.appendChild(document.createTextNode(" 2 M. "));

            ciclicita_optional.appendChild(radio3_optional);
            ciclicita_optional.appendChild(document.createTextNode(" 3 M. "));

            ciclicita_optional.appendChild(radio4_optional);
            ciclicita_optional.appendChild(document.createTextNode(" 6 M. "));

            ciclicita_optional.appendChild(radio5_optional);
            ciclicita_optional.appendChild(document.createTextNode(" 1 A. "));

            tr.appendChild(ciclicita_optional);
			
            // Asterisca
            var checkdiv = document.createElement("div");
            checkdiv.className = "switch";
            var check = document.createElement("input");
            check.type = "checkbox";
            check.name = "ast[]";
            check.id = "ast"+count;
            var checkLabel = document.createElement("label");
            checkLabel.for="ast"+count;
            checkLabel.setAttribute('for', "ast"+count);
            checkdiv.appendChild(check);
            checkdiv.appendChild(checkLabel);
            

            var tdAst = document.createElement("td");
            
            tdAst.appendChild(checkdiv);
            tr.appendChild(tdAst);
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
			<div class="col-md-4">
				<label for="considerazioni"> {{ trans('messages.keyword_considerations') }} <span class="required">(*)</span></label>
    <textarea id="considerazioni" name="considerazioni" placeholder=" {{ trans('messages.keyword_budget_considerations') }} " class="form-control">{{$preventivo->considerazioni}}</textarea><br>
				<label for="valenza"> {{ trans('messages.keyword_valenza') }}<span class="required">(*)</span> </label>
    <input value="{{$preventivo->valenza}}" type="text" id="valenza" name="valenza" placeholder=" {{ trans('messages.valency_budget') }} " class="form-control"><br>
				<label for="scontoagente"> {{ trans('messages.keyword_agent_discount') }}  <span class="required">(%)</span></label>
    <input value="{{$preventivo->scontoagente}}" type="number" step=any id="scontoagente" name="scontoagente" placeholder=" {{ trans('messages.keyword_agent_discount_-_calculated_on_the_total') }} " class="form-control" title="% {{ trans('messages.keyword_of_maximum_discount_attributable_user') }} "><br>
				
			</div>
			<div class="col-md-4">
				<label for="noteimportanti"> {{ trans('messages.keyword_important_notes') }} </label>
    <textarea id="noteimportanti" name="noteimportanti" placeholder=" {{ trans('messages.keyword_important_notes') }} " class="form-control">{{$preventivo->noteimportanti}}</textarea><br>
				<label for="finelavori"> {{ trans('messages.keyword_end_date_works') }} <span class="required">(*)</span></label>
    <input value="{{$preventivo->finelavori}}" type="text" id="finelavori" name="finelavori" placeholder=" {{ trans('messages.keyword_date_expected_end_of_work') }} " class="form-control"><br>
				<label for="scontobonus"> {{ trans('messages.keyword_agent_discount_discount') }}  <span class="required">(%)</span></label>
    <input value="{{$preventivo->scontobonus}}" type="number" step=any id="scontobonus" name="scontobonus" placeholder=" {{ trans('messages.keyword_calculated_on_the_total_already_discounted') }} " class="form-control" title="% {{ trans('messages.keyword_discounted_by_the_retailer') }} "><br>
			</div>
			<div class="col-md-4">
				<label for="metodo"> {{ trans('messages.keyword_payment_method') }} </label>
                 <a class="btn btn-warning" id="addpay"><i class="fa fa-plus"></i></a>
	    <a class="btn btn-danger" id="deletepay"><i class="fa fa-trash"></i></a>
    <div id="paymethod"><table class="table table-striped table-bordered" >
	               
	                <tbody id="filespay">
                    @foreach($quote_paymento as $quote_paymento)
                    <tr>
                    	<td><input class="selezione" id="payment_{{ $quote_paymento->qp_id}}" type="checkbox"><label for="payment_{{ $quote_paymento->qp_id}}"></label></td>
                        <td><input class="form-control datapicker" name="datapay[]" value="{{ $quote_paymento->qp_data}}" id="datapay{{ $quote_paymento->qp_id }}" placeholder="Data" type="text"></td>
                        <td><input class="form-control" name="amountper[]" placeholder="%" value="{{ $quote_paymento->qp_percenti}}" type="text"></td>
                        <td><input class="form-control" name="importo[]" placeholder="importo" value="{{ $quote_paymento->qp_amnt}}" type="text"></td>
                    </tr>
                    @endforeach
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

	                </script>
	            </table></div>
  
				<label for="subtotale"> {{ trans('messages.keyword_total') }}  <span class="required">(€)</span><a onclick="calcola()" class="" title="Compilazione assistita">  {{ trans('messages.keyword_click') }}  <i class="fa fa-info"></i> {{ trans('messages.keyword_for_compilation') }} </a></label>
                
                <div class="height53"></div>
                
    <input value="{{$preventivo->subtotale}}" step=any type="number" id="subtotale" name="subtotale" placeholder="{{ trans('messages.keyword_initial_price') }} " class="form-control" title=" {{ trans('messages.keyword_initial_value_calculated_individual_packages') }} "><br>
    <label for="totale"> {{ trans('messages.keyword_discounted_total') }}  <span class="required">(€)</span></label>
    <input value="{{$preventivo->totale}}" type="number" step=any id="totale" name="totale" placeholder=" {{ trans('messages.keyword_total_price') }} " class="form-control" title="{{ trans('messages.keyword_discounted_value_or_overwritten_value') }} "><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				
				<label for="totaledapagare"> {{ trans('messages.keyword_topay') }}  <span class="required">(€)</span></label>
    <input value="{{$preventivo->totaledapagare}}" type="number" step=any id="totaledapagare" name="totaledapagare" placeholder=" {{ trans('messages.   keyword_total_price_to_be_paid') }} " class="form-control" title=" {{ trans('messages.keyword_value_to_be_entered_for_any_rounding') }} "><br>
            </div>
			<div class="col-md-4">
			
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
        
  
    		<div class="row">
                <div class="col-md-12">
                    <button onclick="mostra2()" type="submit" class="btn btn-warning">{{ trans('messages.keyword_save') }} </button>
                </div>
    		</div>
            
        </form>
	</div>
	<div class="col-md-4">
	

		<label for="statoemotivo"> {{ trans('messages.keyword_emotional_state') }} </label>
		<select name="statoemotivo" class="form-control" id="statoemotivo">
            <!-- statoemotivoselezionato -->
            @if($statoemotivoselezionato!=null)
                @foreach($statiemotivi as $statoemotivo)
                    <option @if($statoemotivo->id == $statoemotivoselezionato->id_tipo) selected @endif style="background-color:{{$statoemotivo->color}};color:#ffffff" value="{{$statoemotivo->name}}">{{$statoemotivo->name}}</option>
                @endforeach
            @else
                @foreach($statiemotivi as $statoemotivo)
                    <option  value="{{$statoemotivo->name}}">{{$statoemotivo->name}}</option>
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
			$("#hdstatoemotivo").val($j(this).val());
		});		
		</script>
     <div class="row">   <div class="col-md-12" id="prezzo" <?php if((Auth::user()->dipartimento == 2 ) || (Auth::user()->id == 0 )){ ?>  <?php } else{?> <?php }?>>

            <label for="prezzo"> {{ trans('messages.keyword_confirmpriceto') }} :</label>
            <br>            
            <input type="textarea" id="prezzo_confermato" name="prezzo" class="form-control" value="{{$preventivo->prezzo_confermato}}">
            <br>

        </div></div><script>
		$j('#prezzo_confermato').on("change", function() {
			$("#hdPrezzo").val($j(this).val());
		});	
        </script>

		<div class="row">
            <div class="col-md-12">
            	<div class="bg-white modifica-blade-estimate-upload">
	        <label for="scansione"> 
            {{ trans('messages.keyword_attach_administrative_file') }} </label><br>
	      
            <div class="row">
	        <div class="col-md-12">

            	<div class="image_upload_div">
                <?php echo Form::open(array('url' => '/estimates/modify/quote/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
                        {{ csrf_field() }}
                        <input type="hidden" name="idpreventivo" name="idpreventivo" value="{{ $preventivo->id }}">
    			</form>				
				</div><script>
				var url = '<?php echo url('/estimates/modify/quote/getfiles/'.$mediaCode); ?>';

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
					var urlD = '<?php echo url('/estimates/modify/quote/deletefiles/'); ?>/'+id;
						$j.ajax({url: urlD, success: function(result){
							$j(".quoteFile_"+id).remove();
					    }});
				}

				function updateType(typeid,fileid){
					var urlD = '<?php echo url('/estimates/modify/quote/updatefiletype/'); ?>/'+typeid+'/'+fileid;
						$j.ajax({url: urlD, success: function(result){
							//$j(".quoteFile_"+id).remove();
					    }});
				}				

			
                </script>

			<div class="set-height">
	            <table class="table table-striped table-bordered">	                
	                <tbody><?php
					if(isset($preventivo->id) && isset($quotefiles)){
					foreach($quotefiles as $prev) {
				$imagPath = url('/storage/app/images/quote/'.$prev->name);
				$html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a class="btn btn-danger pull-right"  onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-trash"></i></a></td></tr>';
				$html .='<tr class="quoteFile_'.$prev->id.'"><td>';
				$utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', '=', 0)->get();							
				foreach($utente_file as $key => $val){
					$check = '';
					if($val->ruolo_id == $prev->type){
						$check = 'checked';
					}
					/*$html .=' <input type="radio" name="rdUtente_'.$prev->id.'"  '.$check.' id="rdUtente_'.$val->ruolo_id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.');"  value="'.$val->ruolo_id.'" /> '.$val->nome_ruolo;*/
                    $html .=' <div class="cust-radio"><input type="radio" name="rdUtente_'.$prev->id.'" '.$check.' id="'.$val->nome_ruolo.'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.');"  value="'.$val->ruolo_id.'" /><label for="'.$val->nome_ruolo.'_'.$prev->id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';
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
	            </table></div><hr>
	            </div>
                
                </div>

            </div>
            
            </div>
            </div>
            
	</div>
</div>

</div>

<div class="footer-svg">
  <img src="http://betaeasy.langa.tv/images/FOOTER3-ORIZZONTAL_QUOTES.svg" alt="avvisi">
</div>

<script>

    
$j('#data').datepicker();
$j('#valenza').datepicker();
$j('#finelavori').datepicker();
$j('.datapicker').datepicker();

</script> 

@endsection