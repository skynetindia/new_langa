@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jquery.knob.min.js')}}"></script>


<!-- Radar chart -->
<!-- <script type="text/javascript" src="http://gc.kis.v2.scr.kaspersky-labs.com/971CFF9C-4385-024E-BA20-CB806B914BAF/main.js" charset="UTF-8"></script> -->
 <script src="http://d3js.org/d3.v3.min.js"></script> 
 <script src="{{asset('public/scripts/RadarChart.js')}}"></script> 
<!-- end radar chart js -->


<script type="text/javascript">
	$( document ).ready(function() {
	    $(".setsize").each(function() {
	        $(this).height($(this).width());
	    });
	});
	$(window).on('resize', function(){
	    $(".setsize").each(function() {
	        $(this).height($(this).width());
	    });
	});
</script>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

@include('common.errors')

<div class="header-right">
  <div class="float-left">
      <h1>{{trans('messages.keyword_editproject')}} <?php echo '::' . $progetto->id . '/' . substr($progetto->datainizio, -2) ?></h1><hr>
    </div>
    <div class="header-svg">
         <img src="{{url('images/HEADER1_RT_PROJECT.svg')}}" alt="header image">
    </div>
</div>
<?php /*
<div class="progetti-header">
	<div class="header-svg float-left">
        <img src="{{url('images/HEADER1_LT_PROJECT.svg')}}" alt="header image">
    </div>
    
    <div class="header-svg float-right">
        <img src="{{url('images/HEADER1_RT_PROJECT.svg')}}" alt="header image">
    </div>
</div>*/?>

<div class="clearfix"></div>
<div class="height20"></div>

<?php echo Form::open(array('url' => '/progetti/modify/project/' . $progetto->id, 'files' => true)) ?>
    <?php $mediaCode = date('dmyhis');?>
    <input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />
	{{ csrf_field() }}
	@if(isset($dapreventivo))
    	@if($dapreventivo==1)
        	<input name="dapreventivo" value="{{$idpreventivo}}" type="hidden">
        @endif
    @endif
<div class="row">
<?php /*<div class="col-md-12">
	<h1>{{trans('messages.keyword_editproject')}} <?php echo '::' . $progetto->id . '/' . substr($progetto->datainizio, -2) ?></h1><hr>
</div>*/?>
		<div class="col-md-8">
    	    	<script>
				/*var $ = jQuery.noConflict();
    	    		var clickEvent = new MouseEvent("click", {
					    "view": window,
					    "bubbles": true,
					    "cancelable": false
					});
    	    		$('#prev').on("change", function() {
    	    			var id = $("#prev").val();
    	    			var link = document.createElement("a");
    	    			link.href = "{{ url('/progetti/add') }}" + '/' + id;
						link.dispatchEvent(clickEvent);
    	    		});
					*/
    	</script>
        <div class="form-group project-name">
            <label for="preventivo"><p>{{trans('messages.keyword_noproject')}}</p>
				<input type="text" disabled value="<?php echo '::' . $progetto->id . '/' . substr($progetto->datainizio, -2) ?>" class="form-control">
			</label>
			<div class="btn-group"><?php           		
				$link_prev = url('/estimates/pdf/quote/') . '/'.  $progetto->id_preventivo;
				$link_prev_noprezzi = url('/estimates/noprezzi/pdf/quote/') . '/'.  $progetto->id_preventivo;
				?>        		    
    		</div>
            
            	<div class="modifica-blade-progetto">
                    @if(isset($progetto->id_preventivo) && $progetto->id_preventivo != "")
                    <a id="pdf" target="_blank" href="{{$link_prev}}" class="btn">

                            <i class="fa fa-file-pdf-o"></i>
                    </a>
                    @endif
    			<a href="#" class="btn btn-warning">{{trans('messages.keyword_goallentity')}}</a>
				
    				<a href="#" class="btn btn-warning">{{trans('messages.keyword_onlinereview')}}</a>
                	
                </div>
    	</div>
        	
            <div class="form-group">
				<label for="nomeprogetto">{{trans('messages.keyword_projectname')}} <span class="required">(*)</span></label>
        		<input value="{{ $progetto->nomeprogetto }}" class="form-control" type="textarea" name="nomeprogetto" id="nomeprogetto" placeholder="{{trans('messages.keyword_projectname')}}">
            </div>    
                
                <div class="form-group">
				<label for="lavorazioni">{{trans('messages.keyword_processing')}} </label> <br/>
	                <a class="btn btn-warning"  id="aggiungiLavorazione"><i class="fa fa-plus"></i></a>
	                <a class="btn btn-danger" id="eliminaLavorazione"><i class="fa fa-trash"></i></a>
                    </div>
                    
                <div class="table-responsive">
                <div class="set-height edit-project-height">
	            <table class="table table-bordered">
	                <thead>
	                   <th>#</th>
	                    <th>{{trans('messages.keyword_subject_state')}}</th>
	                    <th>{{trans('messages.keyword_description')}}</th>	          
	                    <th>% {{trans('messages.keyword_of_completion')}}</th>
	                </thead>
	                <tbody id="lavorazioni">
	                	<?php $p = 0; ?>
	                    @foreach($lavorazioni as $partecipante)
	                        <tr>
	                            <td>
	                                <input type="checkbox" id="checkNuL{{$p}}" class="selezione"><label for="checkNuL{{$p}}"></label>
	                            </td>
                            <td>
                                <input type="text" name="ric[]" value="<?php echo $partecipante->nome; ?>" class="form-control">
                                <hr>
                                <select class="form-control" name="completato[]">
								@foreach($oggettostato as $key => $oggettostatoval)
                                	<option value="{{$oggettostatoval->id}}" <?php if(isset($partecipante->completato) && $oggettostatoval->id == $partecipante->completato ) { echo 'selected';}?>>{{ $oggettostatoval->nome }}</option>
                                 @endforeach
                                </select>
                            </td>
                            <td>
                                <textarea class="form-control" name="descrizione[]">{{$partecipante->descrizione}}</textarea>
                            </td>
                           <td class="bar-progress">
                           <input id="process{{$p}" class="knob" name="percentvalue[]" value="<?php if(isset($partecipante->completamento) && $partecipante->completamento != ""){ echo $partecipante->completamento;} else { echo '0';}?>" data-width="30%" data-skin="tron" data-thickness=".15" data-fgcolor="#FF851b" data-displayprevious="true" >
                          <?php /* <div class="c100 <?php if(isset($partecipante->completamento) && $partecipante->completamento != ""){ echo 'p'.$partecipante->completamento;} else { echo 'p0';}?> small boxs counter_<?php echo $partecipante->id;?>" data-name="counter_<?php echo $partecipante->id;?>">
                            <span><p id="percent-value_<?php echo $partecipante->id;?>"><?php if(isset($partecipante->completamento) && $partecipante->completamento != ""){ echo $partecipante->completamento;} else { echo '0';}?></p></span>
                            <input type="hidden" class="hoverhidden" value="0" id="hoverover_<?php echo $partecipante->id;?>">
                            <input type="hidden" value="<?php if(isset($partecipante->completamento) && $partecipante->completamento != ""){ echo $partecipante->completamento;} else { echo '0';}?>" class="completepercent" name="percentvalue[]" id="percentvalue_<?php echo $partecipante->id;?>">
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>*/?>
                           		
                       		<!-- <section class="progress"> -->  	
							<?php /*  <div class="progress-radial progress-70 setsize" style="width:60px;height:60px;"> 
							    <div class="overlay setsize">
							      <p>70%</p>
							    </div>
							  </div>*/?>
							<!-- </section> -->
                           </td>
	                            <script>
	                                $('.selezione').on("click", function() {
                				selezioneLavorazioni[nLav] = $(this).parent().parent();
				                nLav++;
                			});
                			$('#impedisc<?php echo $p; ?>').bind("click", function() {
                				this.blur();
                				this.value = "<?php echo $partecipante->programmato ?>";
                			});                			
                			<?php $p++; ?>							
							
	                            </script>
	                        </tr>
	                    @endforeach
	                </tbody>
	                <script>
						var jq = jQuery.noConflict();					
	                    var selezioneLavorazioni = [];
	                    var nLav = 0;
	                    var kLav = 0;
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
                		var test = vecchiaData.toString();
                		var impedisciModifica = function(e) {
                			this.blur();
                			this.value = test;
                		}
	            jq('#aggiungiLavorazione').on("click", function() {
                    var countlavorazioni = jq('#lavorazioni').children('tr').length;
	                        var tabella = document.getElementById("lavorazioni");
                			var tr = document.createElement("tr");
                			var data = document.createElement("td");
                			var ora = document.createElement("td");
                			var check = document.createElement("input");
                            var checkboxLabel = document.createElement("label");                                        
                            checkboxLabel.setAttribute('for', "checkNuL"+countlavorazioni);
                			var checkbox = document.createElement("td");
                			check.type = "checkbox";
                			check.className = "selezione";
                            check.id = "checkNuL"+countlavorazioni;

                			var select1 = document.createElement("select");
                            var hr = document.createElement("hr");
                			var compl = document.createElement("td");
                			select1.name = "completato[]";
                			select1.className = "form-control";
							var oggettostato = '';
							<?php	
							$oggettostatoption = '';						
							foreach($oggettostato as $key => $oggettostatoval){
								if(isset($partecipante->completato) && $oggettostatoval->id == $partecipante->completato ) { 
									$oggettostatoption .='<option value="'.$oggettostatoval->id.'" selected>'.$oggettostatoval->nome.'</option>';
								}
								else {
                               		$oggettostatoption .='<option value="'.$oggettostatoval->id.'">'.$oggettostatoval->nome.'</option>';
								}
							}
							?>
							select1.innerHTML = '<?php echo $oggettostatoption; ?>';
                			
                			compl.appendChild(select1);
                			
                			
                			var select = document.createElement("select");
                			
                			for(var i = 0; i < 24; i++) {
                				var opz = document.createElement("option");
                				var opz2 = document.createElement("option");
                				opz.appendChild(document.createTextNode(i + ":00"));
                				opz2.appendChild(document.createTextNode(i + ":30"));
                				select.appendChild(opz);
                				select.appendChild(opz2);
                			}

            			var input = document.createElement("input");
            			input.name = "datainserimento[]";
            			input.id = "impedisci" + kLav;
            			input.className = "form-control";
            			input.value = vecchiaData;
            			data.appendChild(input);
						var desc = document.createElement("td");
            			var descrizione = document.createElement("textarea");
                        // descrizione.type = "textarea";
                        descrizione.className = "form-control";
                        descrizione.name = "descrizione[]";
                        desc.appendChild(descrizione);
						
                    var progress = document.createElement("td");
        			progress.className="bar-progress";
					var circles = document.createElement("input");
					
					circles.name = "percentvalue[]";
					circles.id = "process" + kLav;
					circles.className = "knob";
					circles.value = 0;
					circles.setAttribute('data-width', '30%') ;
					circles.setAttribute('data-skin', 'tron') ;	
					circles.setAttribute('data-thickness', '.15') ;	
					circles.setAttribute('data-fgColor', '#FF851b') ;	
					circles.setAttribute('data-displayPrevious', 'true') ;	
                    


                    progress.appendChild(circles);
                  
                    
            		var appunti = document.createElement("td");	

            			var input = document.createElement("input");
                			input.placeholder = "{{trans('messages.keyword_writehere')}}";
                			input.name = "ric[]";
                			input.className = "form-control";
                			input.id = "editable" + kLav;
                			appunti.appendChild(input);

                			var ric = document.createElement("td");
                			checkbox.appendChild(check);
                            checkbox.appendChild(checkboxLabel);
                			tr.appendChild(checkbox);
                			
                            ora.appendChild(input);
                            ora.appendChild(hr);                  
                            ora.appendChild(select1);                			
                			tr.appendChild(ora);
                            select.className = "form-control";                      
                			// tr.appendChild(compl);
                			tr.appendChild(desc);
                			tr.appendChild(progress);

                			var input = document.createElement("input");
                			input.className = "form-control";
                			input.id = "datepicker" + kLav;
                			input.placeholder = "__/__/____";
                			input.name = "ricontattare[]";
                			ric.appendChild(input);
                			/*
                				Appunti = appunti
                				Ricontattare il giorno = ric
                				Alle = select
                				Data inserimento = data
                			*/
                			select.name = "alle[]";
                			tabella.appendChild(tr);
                			//$("#datepicker" + kLav).datepicker();
                			$('.selezione').on("click", function() {
                				selezioneLavorazioni[nLav] = jq(this).parent().parent();
				                nLav++;
							});
                			jq('#impedisci' + kLav).bind("click", impedisciModifica);
                			kLav++;
							newfun();
              

			  	jq(".setsize").each(function() {
			        jq(this).height(jq(this).width());
			    });

			    jq(".setsize").each(function() {
			        jq(this).height(jq(this).width());
			    });
				
				
        });
	                    jq('#eliminaLavorazione').on("click", function() {
	                       for(var i = 0; i < nLav; i++) {
	                           selezioneLavorazioni[i].remove();
	                       }
	                       nLav = 0;
	                    });
						if(jq(".boxs").length>0)
							progressmove();							
					

	                </script>
                    
	            </table>
            </div>
            </div>
           <div class="row"> <div class="col-md-2" >
	           <button onclick="mostra2()" type="submit" class="btn btn-warning">{{trans('messages.keyword_save')}}</button>
            </div></div>
		</div>


		<div class="col-md-4">
			<div class="form-group"> <div class="height6"></div>
             	<label for="statoemotivo">{{trans('messages.keyword_emotional_state')}}</label>
                <select name="statoemotivo" class="form-control" id="statoemotivo">
                    <!-- statoemotivoselezionato -->
                    <option></option>
                    @if($statoemotivoselezionato!=null)
                        @foreach($statiemotivi as $statoemotivo)
                            <option @if($statoemotivo->id == $progetto->emotion_stat_id) selected @endif style="background-color:{{$statoemotivo->color}};color:#ffffff" value="{{$statoemotivo->id}}">{{$statoemotivo->name}}</option>
                        @endforeach
                    @else
                        @foreach($statiemotivi as $statoemotivo)
                            <option value="{{$statoemotivo->id}}" style="background-color:{{$statoemotivo->color}};color:#ffffff" >{{$statoemotivo->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>   
               
                <script>
                var yourSelect = document.getElementById( "statoemotivo" );
                    document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
                jq('#statoemotivo').on("change", function() {
                    var yourSelect = document.getElementById( "statoemotivo" );
                    document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
                });
                </script>
			<div class="row">            	
                <div class="col-md-6">
                	<div class="form-group">
               		 	<label for="preventivo">{{trans('messages.keyword_starttime')}}</label>
                        <input value="{{ $progetto->datainizio }}" class="form-control" type="text" name="datainizio" id="datainizio" placeholder="{{trans('messages.keyword_starttime')}}">
                    </div>    
                </div>
                <div class="col-md-6">
                	<div class="form-group">
		                <label for="preventivo">{{trans('messages.keyword_endtime')}}</label>
                        <input value="{{ $progetto->datafine }}" class="form-control" type="text" name="datafine" id="datafine" placeholder="{{trans('messages.keyword_endtime')}}">
                    </div>    
                </div>
            </div>
            
        		    <script>
					 
        		    jq.datepicker.setDefaults(
                        jq.extend(
                            {'dateFormat':'dd/mm/yy'},
                            jq.datepicker.regional['nl']
                        )
                    );
        		    jq('#datainizio').datepicker();
        		    jq('#datafine').datepicker();					
        		    </script>
       <div class="height10"></div>
         	<div class="row">
            <div class="col-md-12">
            	  <div class="bg-white image-upload-box">
        			<div class="height10">
                    <label> {{trans('messages.keyword_project_graph')}}</label></div>
        		<div id="body">
				  <div id="chart"></div>
			    </div>			    
                </div>
        	</div>
			<div class="col-md-12">
				<div class="height10"></div>
                <div class="form-group">
                <label for="preventivo">{{trans('messages.keyword_sensitivedata')}}: </label> <br/>
				<a class="btn btn-warning" id="aggiungiNote"><i class="fa fa-plus"></i></a>
	                <a class="btn btn-danger"  id="eliminaNote"><i class="fa fa-trash"></i></a>
	        	</div>
	        </div>
            </div>
            <div class="set-height">
		            <table class="table table-striped table-bordered">
		                <thead>
		                    <th>#</th>
		                    <th>{{trans('messages.keyword_url')}}</th>
		                    <th>{{trans('messages.keyword_user')}}</th>
                            <th>{{trans('messages.keyword_password')}}</th>                         
		                </thead>
		                <tbody id="noteprivate">
                        <?php $k = 0; ?>
							@foreach($noteprivate as $nota)
		                        <tr>
		                            <td>
		                                <input type="checkbox" id="Sensitiv{{$k}}" class="selezione"><label for="Sensitiv{{$k}}"></label>
		                            </td>
		                            <td>
		                                <input name="nome[]" class="form-control" value="{{$nota->nome}}">
		                            </td>
		                            <td>
		                            	<input name="dett[]" class="form-control" value="{{$nota->user}}">
		                            </td>
                                    <td>
		                            	<input name="pass[]" class="form-control" value="{{$nota->password}}">
		                            </td>
                                    <!-- <td>
		                            	<input id="datepicker<?php echo $k;?>" type="text" name="scad[]" class="form-control" value="{{$nota->scadenza}}">
		                            </td> -->
		                            <script>
										jq("#datepicker<?php echo $k; ?>").datepicker();<?php $k++; ?>
		                                jq('.selezione').on("click", function() {
	        				                selezioneServizi[nServ] = jq(this).parent().parent();
	        				                nServ++;
			                	        });
		                            </script>
		                        </tr>
	                    	@endforeach
		                </tbody>
		                <script>                
		                    var selezioneServizi = [];

		                    var nServ = 0;

							var kServ = <?php echo $k; ?>;


		                    jq('#aggiungiNote').on("click", function() {
                                var countnoteprivate = jq('#noteprivate').children('tr').length;
		                       var tab = document.getElementById("noteprivate");

		                        var tr = document.createElement("tr");

		                        var check = document.createElement("td");

		                        var checkbox = document.createElement("input");

		                        checkbox.type = "checkbox";

		                        checkbox.className = "selezione";
                                checkbox.id = "Sensitiv"+countnoteprivate;
                                var checkboxlabel = document.createElement("label");
                                checkboxlabel.for = "Sensitiv"+countnoteprivate;
                                checkboxlabel.setAttribute('for', "Sensitiv"+countnoteprivate);

		                        check.appendChild(checkbox);
                                check.appendChild(checkboxlabel);

		                        kServ++;

		                        var td = document.createElement("td");

		                        var td1 = document.createElement("td");
								
								var td2 = document.createElement("td");
								var td3 = document.createElement("td");

		                        var fileInput = document.createElement("input");

		                        fileInput.type = "text";

		                        fileInput.className = "form-control";

		                        fileInput.name = "nome[]";

		                        var dettagli = document.createElement("input");

		                        dettagli.type = "text";

		                        dettagli.className = "form-control";

		                        dettagli.name = "dett[]";
								
								var password = document.createElement("input");
		                        password.type = "text";
		                        password.className = "form-control";
		                        password.name = "pass[]";
								
								var scadenza = document.createElement("input");
		                        scadenza.type = "text";
		                        scadenza.className = "form-control";
		                        scadenza.name = "scad[]";
								scadenza.id = "datepicker" + kServ;

		                        td.appendChild(fileInput);
		                        td1.appendChild(dettagli);
								// td2.appendChild(scadenza);
								td3.appendChild(password);

		                        tr.appendChild(check);

		                        tr.appendChild(td);

		                        tr.appendChild(td1);//username
								tr.appendChild(td3);//password
								tr.appendChild(td2);//scadenza
								

		                        tab.appendChild(tr);

		                        jq('.selezione').on("click", function() {

					                selezioneServizi[nServ] = $(this).parent().parent();

					                nServ++;

			                	});
								
								jq("#datepicker" + kServ).datepicker();

		                    });

		                    jq('#eliminaNote').on("click", function() {

		                       for(var i = 0; i < nServ; i++) {

		                           selezioneServizi[i].remove();

		                       }

		                       nServ = 0;

		                    });

		                </script>

		            </table>
                    </div>
                    
              
				<script>
				jq('#notetecniche').on("click", function() {
					this.blur();
				});
				
				var testo = "<?php echo $progetto->noteprivate; ?>";
				var testoPrivato = "<?php echo $progetto->notetecniche; ?>";
				function mostra() {
					if(jq('#noteenti').val()) {
						testo = jq('#noteenti').val();
						jq('#noteenti').val("");
					} else {
						jq('#noteenti').val(testo);
						testo = "";
					}
				}
				function mostraPrivate() {
					if(jq('#notetecniche').val()) {
						testoPrivato = $('#notetecniche').val();
						jq('#notetecniche').val("");
					} else {
						jq('#notetecniche').val(testoPrivato);
						testoPrivato = "";
					}
				}
				function mostra2() {
					if(!jq('#noteenti').val()) {
						jq('#noteenti').val(testo);
						jq('#notetecniche').val(testoPrivato);
					}
				}
				</script>
				<br>				
        		</div>
				<!-- <br>
				<label for="datisensibili">Dati sensibili</label><br>

	                <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiDati"><i class="fa fa-plus"></i></a>
	                <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaDati"><i class="fa fa-eraser"></i></a>
	        <br> -->

	           <!--  <table class="table table-striped table-bordered">
	                <thead>
	                    <th>#</th>
	                    <th>Dati sensibili</th>
	                </thead>
	                <tbody id="datisensibili">
	                    @foreach($datisensibili as $dato)
	                        <tr>
	                            <td>
	                                <input type="checkbox" class="selezione">
	                            </td>
	                            <td>
	                                <textarea name="dati[]" class="form-control"><?php echo $dato->dettagli; ?></textarea>
	                            </td>
	                            <script>
	                                $('.selezione').on("click", function() {
        				                selezioneFile2[nDati] = $(this).parent().parent();
        				                nDati++;
		                	        });
	                            </script>
	                        </tr>
	                    @endforeach
	                </tbody>
	                <script>
	                    var selezioneFile2 = [];
	                    var nDati = 0;
	                    var kDati = 0;
	                    $('#aggiungiDati').on("click", function() {
	                        var tab = document.getElementById("datisensibili");
	                        var tr = document.createElement("tr");
	                        var check = document.createElement("td");
	                        var checkbox = document.createElement("input");
	                        checkbox.type = "checkbox";
	                        checkbox.className = "selezione";
	                        check.appendChild(checkbox);
	                        kDati++;
	                        var td = document.createElement("td");
	                        var fileInput = document.createElement("textarea");
	                        fileInput.className = "form-control";
	                        fileInput.name = "dati[]";
	                        td.appendChild(fileInput);
	                        tr.appendChild(check);
	                        tr.appendChild(td);
	                        tab.appendChild(tr);
	                        $('.selezione').on("click", function() {
				                selezioneFile2[nDati] = $(this).parent().parent();
				                nDati++;
		                	});
	                    });
	                    $('#eliminaDati').on("click", function() {
	                       for(var i = 0; i < nDati; i++) {
	                           selezioneFile2[i].remove();
	                       }
	                       nDati = 0;
	                    });
	                </script>
	            </table> -->				
			<!-- <label for="files">Files</label><br>
            	<?php
					$son_files = json_decode(json_encode($files), true);
					$isNew = false;
					if(!empty($son_files)) {
						if(is_null($son_files[0]['id_preventivo'])) {
							$isNew = true;
						}
					} else {
						$isNew = true;
					}
				?>
                @if($isNew)
	                <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiFile"><i class="fa fa-plus"></i></a>
	                <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaFile"><i class="fa fa-eraser"></i></a>
	                <a target="new" href="{{url('/progetti/files') . '/' . $progetto->id}}" class="btn btn-info" style="color:#ffffff;text-decoration: none" title="Vedi files"><i class="fa fa-info"></i></a>											
                @else
                    <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiFile"><i class="fa fa-plus"></i></a>
                    <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaFile"><i class="fa fa-eraser"></i></a>
                    <input type="hidden" name="salvafiles" value="{{$son_files[0]['id_preventivo']}}">
                @endif
	        <br>



	            <table class="table table-striped table-bordered">
	                <thead>
	                    <th>#</th>
	                    <th>Sfoglia</th>
	                </thead>
	                <tbody id="files">
	                </tbody>
	                <script>
	                    var selezioneFile = [];
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
	                        var nomeFile = document.createElement("td");
	                        var nomeFileInput = document.createElement("input");
	                        nomeFileInput.type = "file";
	                        nomeFileInput.className = "form-control";
	                        nomeFileInput.name = "file[]";
	                        nomeFile.appendChild(nomeFileInput);
	                        kFile++;
	                        tr.appendChild(check);
	                  		tr.appendChild(nomeFile);
	                        tab.appendChild(tr);
	                        $('.selezione').on("click", function() {
				                selezioneFile[nFile] = $(this).parent().parent();
				                nFile++;
		                	});
	                    });
	                    $('#eliminaFile').on("click", function() {
	                       for(var i = 0; i < nFile; i++) {
	                           selezioneFile[i].remove();
	                       }
	                       nFile = 0;
	                    });
	                </script>
	            </table>
				
			<label for="partecipanti">Partecipanti</label><br>
	                <select class="form-control" id="utenti">

                	    @foreach($utenti as $utente)

                	    <option value="{{$utente->id}}">{{$utente->name}}</option>

                	    @endforeach

        	        </select><br>



	                <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiPartecipante"><i class="fa fa-plus"></i></a>

	                <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="elimina"><i class="fa fa-eraser"></i></a>


	            <table class="table table-striped table-bordered">
	                <thead>
	                    <th>#</th>
	                    <th>Id</th>
	                    <th>Utente</th>
	                </thead>
	                <tbody id="partecipanti">
	                    @foreach($partecipanti as $partecipante)
	                        <tr>
	                            <td>
	                                <input type="checkbox" class="selezione">
	                            </td>
	                            <td>
	                                <input type="text" name="partecipanti[]" value="<?php echo $partecipante->id_user; ?>" class="form-control">
	                            </td>
	                            <td>
	                                @foreach($utenti as $utente)
	                                	@if($utente->id == $partecipante->id_user)
	                                		{{$utente->name}}
	                                		@break
	                                	@endif
	                                @endforeach
	                            </td>
	                            <script>
	                                $('.selezione').on("click", function() {
				                selezione[n] = $(this).parent().parent();
				                n++;
		                	});
	                            </script>
	                        </tr>
	                    @endforeach
	                </tbody>
	                <script>
	                    var selezione = [];
	                    var n = 0;
	                    var k = 0;
	                    $('#aggiungiPartecipante').on("click", function() {
	                        var tab = document.getElementById("partecipanti");
	                        var tr = document.createElement("tr");
	                        var check = document.createElement("td");
	                        var checkbox = document.createElement("input");
	                        checkbox.type = "checkbox";
	                        checkbox.className = "selezione";
	                        check.appendChild(checkbox);
	                        
	                        k++;
	                        var td = document.createElement("td");
	                        var td1 = document.createElement("td");
	                        var nomeUtente = document.createTextNode($("#utenti option:selected").text());
	                        var idUtente = document.createElement("input");
	                        idUtente.type = "text";
	                        idUtente.className = "form-control";
	                        idUtente.value = $("#utenti option:selected").val();
	                        idUtente.name = "partecipanti[]";
	                        td.appendChild(nomeUtente);
	                        td1.appendChild(idUtente);
	                        tr.appendChild(check);
	                        tr.appendChild(td1);
	                        tr.appendChild(td);
	                        tab.appendChild(tr);
	                        $('.selezione').on("click", function() {
				                selezione[n] = $(this).parent().parent();
				                n++;
		                	});
	                    });
	                    $('#elimina').on("click", function() {
	                       for(var i = 0; i < n; i++) {
	                           selezione[i].remove();
	                       }
	                       n = 0;
	                    });
	                </script>
	            </table> -->
  <?php echo Form::close(); ?> 
         <div class="pull-right col-md-4">
         <div class="row">
          <div class="col-md-12">
          	<div class="bg-white image-upload-box">
         <label for="scansione">{{trans('messages.keyword_dropzone_for_multiple_file_upload')}}</label><br/>
        <div class="image_upload_div"><?php echo Form::open(array('url' => 'progetti/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
                  {{ csrf_field() }}
                  </form>       
        </div>
        <script>
		var $ = jQuery.noConflict();
        var urlgetfile = '<?php echo url('progetti/getfiles/'.$mediaCode); ?>';
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
                $('#addMediacommnetmodal').on('shown.bs.modal', function(){                    
                });
            }
          }
          });
        });        
        
        function deleteQuoteFile(id){
          var urlD = '<?php echo url('/progetti/deletefiles/'); ?>/'+id;
            $.ajax({url: urlD, success: function(result){
              $(".quoteFile_"+id).remove();
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
            var urlD = '<?php echo url('/progetti/updatefiletype'); ?>/'+typeid+'/'+fileid;
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
                    if(isset($progetto->id) && isset($projectmediafiles)){
                    foreach($projectmediafiles as $prev) {
                $imagPath = url('/storage/app/images/projects/'.$prev->name);
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
                </table>
                </div>
	            </div>
                </div>
                </div>
            </div>
<!-- 
	            </table> -->
		</div>
        
        <div class="footer-svg">
      <img src="{{url('images/FOOTER3_ORIZZONTAL_PROJECT.svg')}}" alt="ORIZZONTAL PROJECT">
    </div>
        
	</div>
		</div>
	</div>
        
</div><!-- /row -->

<div class="modal fade" id="addMediacommnetmodal" role="dialog" aria-labelledby="modalTitle">
    <div class="modal-dialog modal-l">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="modalTitle">{{trans('messages.keyword_add_title_and_description')}}</h3>
            </div>
            <div class="modal-body">
                <!-- Start form to add a new event -->
                <form action="{{ url('/progetti/mediacomment/').'/'.$mediaCode }}" name="commnetform" method="post" id="commnetform">
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
                url:'{{ url('/progetti/mediacomment/').'/'.$mediaCode }}',
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
var w = 250,
	h = 250;
var colorscale = d3.scale.category10();
//Legend titles
var LegendOptions = [];
<?php $value=0.10;?>
//value1=parseFloat(value1) + 0.1;
counter=0;
//Data
var d = [
		  [
		  @foreach($chartdetails as $key => $oggettostatoval)		 
			{axis:"{{ $oggettostatoval->nome }}",value:{{($oggettostatoval->completedPercentage/100)}}},
			@endforeach
		  ]
		];
//Options for the Radar chart, other than default
var mycfg = {
  w: w,
  h: h,
  maxValue: 1.0,
  levels: 10,
  ExtraWidthX: 100
}

//Call function to draw the Radar chart
//Will expect that data is in %'s
RadarChart.draw("#chart", d, mycfg);

////////////////////////////////////////////
/////////// Initiate legend ////////////////
////////////////////////////////////////////

var svg = d3.select('#body')
	.selectAll('svg')
	.append('svg')
	.attr("width", w+250)
	.attr("height", h)

//Create the title for the legend
/*var text = svg.append("text")
	.attr("class", "title")
	.attr('transform', 'translate(90,0)') 
	.attr("x", w - 60)
	.attr("y", 10)
	.attr("font-size", "12px")
	.attr("fill", "#404040")
	.text("What % of owners use a specific service in a week");*/
		
//Initiate Legend	
var legend = svg.append("g")
	.attr("class", "legend")
	.attr("height", 200)
	.attr("width", 200)
	.attr('transform', 'translate(90,20)') 
	;
	//Create colour squares
	legend.selectAll('rect')
	  .data(LegendOptions)
	  .enter()
	  .append("rect")
	  .attr("x", w - 65)
	  .attr("y", function(d, i){ return i * 20;})
	  .attr("width", 10)
	  .attr("height", 10)
	  .style("fill", function(d, i){ return colorscale(i);})
	  ;
	//Create text next to squares
	legend.selectAll('text')
	  .data(LegendOptions)
	  .enter()
	  .append("text")
	  .attr("x", w - 52)
	  .attr("y", function(d, i){ return i * 20 + 9;})
	  .attr("font-size", "11px")
	  .attr("fill", "#737373")
	  .text(function(d) { return d; })
	  ;	
</script>

<script>
  var jn = jQuery.noConflict();
jn(window).load(function(e) {
	newfun();  
	//alert();
});
	function newfun()
	{
        jn(function(e) {
           jn(".knob").knob({
                change : function (value) {
                    //console.log("change : " + value);
                },
                release : function (value) {
                    //console.log(this.$.attr('value'));
                    console.log("release : " + value);
                },
                cancel : function () {
                    console.log("cancel : ", this);
                },
                /*format : function (value) {
                 return value + '%';
                 },*/
                draw : function () {

                    // "tron" case
                    if(this.$.data('skin') == 'tron') {

                        this.cursorExt = 0.1;

                        var a = this.arc(this.cv)  // Arc
                                , pa                   // Previous arc
                                , r = 1;

                        this.g.lineWidth = this.lineWidth;

                        if (this.o.displayPrevious) {
                            pa = this.arc(this.v);
                            this.g.beginPath();
                            this.g.strokeStyle = this.pColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
                            this.g.stroke();
                        }

                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
                        this.g.stroke();

                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc( this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();

                        return false;
                    }
                }
            });

          
          
        });
	}
    </script>
@endsection