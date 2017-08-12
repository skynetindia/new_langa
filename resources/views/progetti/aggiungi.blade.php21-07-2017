@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jquery.knob.min.js')}}"></script>
<link href="{{asset('build/css/circle.css')}}" rel="stylesheet" />
<!-- <link rel="stylesheet" href="{{asset('public/css/percircle.css')}}"> -->
<!-- <script type="text/javascript" src="{{asset('public/scripts/jquery-1.10.2.js')}}"></script> -->
<!-- <script type="text/javascript" src="{{asset('public/scripts/percircle.js')}}"></script> -->
<!-- <script src="{{asset('public/css/percircle.css')}}"></script> -->

<!-- Radar chart -->
<!-- <script type="text/javascript" src="http://gc.kis.v2.scr.kaspersky-labs.com/971CFF9C-4385-024E-BA20-CB806B914BAF/main.js" charset="UTF-8"></script> -->

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')

<div class="header-right">
  <div class="float-left">
      <h1>{{trans('messages.keyword_addproject')}}</h1><hr>
    </div>
    <div class="header-svg">
         <img src="{{url('images/HEADER1_RT_PROJECT.svg')}}" alt="header image">
    </div>
</div>

<?php /*<div class="progetti-header">
  <div class="header-svg float-left">
        <img src="{{url('images/HEADER1_LT_PROJECT.svg')}}" alt="header image">
    </div>    
    <div class="header-svg float-right">
        <img src="{{url('images/HEADER1_RT_PROJECT.svg')}}" alt="header image">
    </div>
</div>*/?>

<div class="clearfix"></div>
<div class="height20"></div>

<?php echo Form::open(array('url' => '/progetti/store/', 'files' => true, 'id'=>'project_add')) ?>
  <?php $mediaCode = date('dmyhis');?>
  <input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />
  {{ csrf_field() }}
<div class="progetti-aggiungi-blade">    
<div class="row">
  <?php /*<div class="col-md-12">
      <h1>{{trans('messages.keyword_addproject')}}</h1><hr>
  </div>*/?>
  <div class="col-md-8 col-sm-12 col-xs-12">
    <div class="row">
      <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="form-group">
              <label for="preventivo">{{trans('messages.keyword_n_project')}}</label>
        <input type="text" disabled value=":{{trans('messages.keyword_cod_/_year')}}" class="form-control">
                </div>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12">
          <div class="form-group project-name">
      <label for="prev">{{trans('messages.keyword_linktoquote')}}</label>
        <select class="js-example-basic-multiple form-control" id="prev">
          <option></option>
          @foreach($confirmQuote as $prev)
            <option value="{{$prev->id}}">{{$prev->idente}} - {{$prev->oggetto}}</option>
          @endforeach
        </select>       
        <script>
            $(".js-example-basic-multiple").select2();
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
        </script>
              </div>
    </div>
  </div>
      <div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12">
          <div class="form-group">
      <label for="nomeprogetto">{{trans('messages.keyword_projectname')}}</label>
      <input value="{{ old('nomeprogetto') }}" class="form-control required-input" type="text" name="nomeprogetto" id="nomeprogetto" placeholder="{{trans('messages.keyword_projectname')}}">
          </div>
    </div>
        </div>
    
    <label for="lavorazioni">{{trans('messages.keyword_processing')}}</label><br>
      <a class="btn btn-warning" id="aggiungiLavorazione"><i class="fa fa-plus"></i></a>
      <a class="btn btn-danger"  id="eliminaLavorazione"><i class="fa fa-trash"></i></a>
      
      <div class="height10"></div>
      
      <div class="table-responsive">
      <div class="set-height350 edit-project-height">
          <table class="table table-bordered">
            <thead>
                <th>#</th>
                <th>{{trans('messages.keyword_subject_state')}}</th>
                <th>{{trans('messages.keyword_description')}}</th>   
                <th>{{trans('messages.keyword_processing_comments')}}</th>         
                <th>% {{trans('messages.keyword_of_completion')}}</th>
            </thead>
            <?php $processingCode = date('dmyhis');?>
            <tbody id="lavorazioni">
            </tbody>
             <script>
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

              $j('#aggiungiLavorazione').on("click", function() {
                var countlavorazioni = $j('#lavorazioni').children('tr').length;
                var tabella = document.getElementById("lavorazioni");
                var tr = document.createElement("tr");
                var data = document.createElement("td");
                var ora = document.createElement("td");

                var commentTD = document.createElement("td");
                var commentBTN = document.createElement("a");
                commentBTN.className="btn btn-warning btnprocesscomment";
                commentBTN.id="comment_processing"+countlavorazioni;
                commentBTN.setAttribute('val', countlavorazioni);
                commentBTN.setAttribute('proc', countlavorazioni);                            
                commentBTN.setAttribute('onclick',"commentProcessing(this)");                            
                commentBTN.innerHTML="{{trans('messages.keyword_review')}}";
                var commentCode = document.createElement("input");
                commentCode.type = 'hidden';
                commentCode.id = "processingcode_"+countlavorazioni;
                commentCode.name = "processing_code["+countlavorazioni+"]";
                commentCode.value = "{{$processingCode}}_"+countlavorazioni;
                
                commentTD.appendChild(commentBTN);
                commentTD.appendChild(commentCode);

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
                /*if(isset($partecipante->completato) && $oggettostatoval->id == $partecipante->completato ) { 
                  $oggettostatoption .='<option value="'.$oggettostatoval->id.'" selected>'.$oggettostatoval->nome.'</option>';
                }
                else {*/
                  $label = (!empty($oggettostatoval->language_key)) ?  ucwords(strtolower(trans('messages.'.$oggettostatoval->language_key))) : (($oggettostatoval->nome)); 
                  $oggettostatoption .='<option value="'.$oggettostatoval->id.'">'.$label.'</option>';
                //}
              }
              ?>
              select1.innerHTML = '<?php echo $oggettostatoption; ?>';
              //  var array = ["Coding", "Sleeping", "Eating"];
                compl.appendChild(select1);
                
                /*for(var i = 0; i < array.length; i++) {
                  var option = document.createElement("option");
                  option.value = i;
                  option.text = array[i];
                  select1.appendChild(option);
                }*/
                
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
             /*   var circles = document.createElement("div");
                circles.className = "c100 p0 small boxs counter_"+kLav ;
                circles.setAttribute('data-name', 'counter_'+kLav)  
                circles.innerHTML = '<span><p id="percent-value_'+kLav+'">0</p></span><input type="hidden" class="hoverhidden" value="0" id="hoverover_'+kLav+'"><input type="hidden" class="completepercent" value="0" name="percentvalue[]" id="percentvalue_'+kLav+'"><div class="slice"><div class="bar"></div><div class="fill"></div></div>';
                /*var circles = document.createElement("div");
                circles.className = "progress-radial progress-70 setsize";   
                circles.setAttribute("style", "width:60px;height:60px;");
                var setsize = document.createElement("div");
                  setsize.className = "overlay setsize"; 
                var p = document.createElement("p");
                  p.innerHTML="70%";*/                  
                progress.appendChild(circles);
                /*circles.appendChild(setsize);
                setsize.appendChild(p);*/                    
                    
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

                  //tr.appendChild(input);
                  // tr.appendChild(desc);

                  select.className = "form-control";

                  ora.appendChild(input);
                  ora.appendChild(hr);                  
                  ora.appendChild(select1);
                  
                  
                  tr.appendChild(ora);
                  // tr.appendChild(compl);
                  tr.appendChild(desc);
                  tr.appendChild(commentTD);
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
                  $j("#datepicker" + kLav).datepicker();
                  $j('.selezione').on("click", function() {
                    selezioneLavorazioni[nLav] = $j(this).parent().parent();
                    nLav++;
              });

              $j('#impedisci' + kLav).bind("click", impedisciModifica);
                kLav++;

                progressmove();newfun();
                var jq = jQuery.noConflict();

                jq(".setsize").each(function() {
                    jq(this).height(jq(this).width());
                });

                jq(".setsize").each(function() {
                    jq(this).height(jq(this).width());
                });
              });

              $j('#eliminaLavorazione').on("click", function() {
                 for(var i = 0; i < nLav; i++) {
                     selezioneLavorazioni[i].remove();
                 }
                 nLav = 0;
              });

              if($j(".boxs").length>0)
              progressmove();             
            function progressmove(){
              var box=$j(".boxs");
              var bar=$j(".boxs .bar");
              //var boxCenter=[box.offset().left+box.width()/2, box.offset().top+box.height()/2];
              
              box.mousemove(function(e){
                $class=$j(this).data('name');
                
                $this=$j('.'+$class);
                var boxCenter=[$this.offset().left+$this.width()/2, $this.offset().top+$this.height()/2];
                var hoverid = $this.find('p').attr('id');
                var percenid = $this.find('.hoverhidden').attr('id');
                var completepercent = $this.find('.completepercent').attr('id');
                

                if( $this.find("#"+percenid).val()==0) 
                {   
                  $old=$this.find("#"+hoverid).text();
                  per=0;    
                  var angle = Math.atan2(e.pageX- boxCenter[0],- (e.pageY- boxCenter[1]) )*(180/Math.PI);     
                  if(angle<0) {
                    angle=180+(180 + angle);
                  }
                  per=(angle/360)*100;
                  per=parseInt(Math.round(per/2) *2);
                  $this.find("#"+hoverid).html(per);
                  $this.removeClass('p'+$old);
                  $this.addClass('p'+per);
                }
                 // box.css({ "-webkit-transform": 'rotate(' + angle + 'deg)'});    
                 // box.css({ '-moz-transform': 'rotate(' + angle + 'deg)'});
                 // bar.css({ 'transform': 'rotate(' + angle + 'deg)'});
                
              });
              
              $j('.boxs').on('click',function(e){
                  $j(this).off('click');
                $class=$j(this).data('name');
                
                $this=$j('.'+$class);
                var hoverid = $this.find('p').attr('id');
                var percenid = $this.find('.hoverhidden').attr('id');
                var completepercent = $this.find('.completepercent').attr('id');
                
                var percomp = $this.find("#"+hoverid).text();
                $j("#"+completepercent).val(percomp);
                //console.log($this.find("#"+percenid).val());
                if( $this.find("#"+percenid).val()==0) 
                  $this.find("#"+percenid).val(1);
                else
                  $this.find("#"+percenid).val(0);
              });
            }

            </script>
  <script>
  function newfun()
  {
        $j(function($j) {
            $j(".knob").knob({
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

          </table>
      </div></div>
          <div class="row">
      <div class="col-md-2 col-sm-12 col-xs-12 mb16 show-desktop"><br>
        <button onclick="mostra2()" type="submit" class="btn btn-warning">{{trans('messages.keyword_save')}}</button>
      </div>
          </div>
  </div>
  <div class="modal fade" id="newComment" role="dialog" aria-labelledby="modalTitle">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="modalTitle">Add Comments </h3>
                    </div>
                    <div id="show_alert_msg"></div>
                    <div class="modal-body">
                        <!-- Start form to add a new event -->
                            {!! Form::open(array('url' => '/projectprocessing/addcommen', 'id'=>'frmComments','name'=>'frmComments', 'method'=>'post')) !!}
                            @include('common.errors')
                            <div class="" id="commentlist"></div>
                            <input type="hidden" name="hdprocessingid" id="hdprocessingid" value="0">
                            <input type="hidden" name="hdCode" id="hdCode" value="0">
                            <div class="">
                             <div class="form-group">
                                <label for="ente" class="control-label">{{ trans('messages.keyword_comment') }}</label>
                                <textarea class="form-control required-input" name="comments" id="comments" rows="5" cols="10"></textarea>
                                </div>                    
                            </div>                    
                            <br />
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">{{ trans('messages.keyword_close') }}</button>     
                                <input type="button" id="btnsubmitcomments" class="btn btn-warning" value=" {{ trans('messages.keyword_save') }} ">
                            </div>
                       {!! Form::close() !!}
                        <!-- End form to add a new event -->
                    </div>
                </div>
            </div>
        </div>
  <div class="col-md-4 col-sm-12 col-xs-12">
  <div class="form-group">
    <label for="statoemotivo">{{trans('messages.keyword_emotional_state')}}</label>
    <select name="statoemotivo" class="form-control" id="statoemotivo">
      <!-- statoemotivoselezionato -->
      <option></option>    
        @foreach($statiemotivi as $statoemotivo)
         <?php $labelem = (!empty($statoemotivo->language_key)) ?  ucwords(strtolower(trans('messages.'.$statoemotivo->language_key))) : ucwords($statoemotivo->name); ?>
            <option  value="{{$statoemotivo->id}}" style="background-color:{{$statoemotivo->color}};color:#ffffff">{{$labelem}}</option>
        @endforeach                  
    </select>
    </div>
      <script>
        $j('#statoemotivo').on("change", function() {
            var yourSelect = document.getElementById( "statoemotivo" );
            document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
        });
      </script>
   
    
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
          <div class="form-group">
              <label for="tempo">{{trans('messages.keyword_starttime')}}</label>   
                <input value="" class="form-control" type="text" name="datainizio" id="datainizio" placeholder="{{trans('messages.keyword_starttime')}}">
             </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
          <div class="form-group">
              <label for="preventivo">{{trans('messages.keyword_endtime')}}</label>
                <input value="" class="form-control" type="text" name="datafine" id="datafine" placeholder="{{trans('messages.keyword_endtime')}}">
             </div>   
        </div>    
    </div>
    
    <script>
        $j( function() {
          $j( "#slider-range-max" ).slider({
            range: "max",
            min: 0,
            max: 100,
            value: 10,
            slide: function( event, ui ) {
              $j( "#amount" ).val( ui.value );
            }
          });
          $j( "#amount" ).val( $j( "#slider-range-max" ).slider( "value" ) );
        });
    </script>               
    <script>
        $j.datepicker.setDefaults(
                $j.extend(
                    {'dateFormat':'dd/mm/yy'},
                    $j.datepicker.regional['nl']
                )
            );
        $j('#datainizio').datepicker();
        $j('#datafine').datepicker();
    </script>        
      <!-- Stato emotivo -->
          <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="preventivo">{{trans('messages.keyword_sensitivedata')}}:</label><br>
          <a class="btn btn-warning" id="aggiungiNote"><i class="fa fa-plus"></i></a>
          <a class="btn btn-danger"  id="eliminaNote"><i class="fa fa-trash"></i></a>
          <a class="btn btn-warning" id="btngo">{{trans('messages.keyword_go')}}</a>   
          <div class="height10"></div>
         <div class="set-height">   
          <table class="table table-striped table-bordered">
            <thead>
                <th>#</th>
                <th>{{trans('messages.keyword_url')}}</th>
                <th>{{trans('messages.keyword_user')}}</th>
                <th>{{trans('messages.keyword_password')}}</th>                       
            </thead>
            <tbody id="noteprivate">
            @for($i=0;$i< 3;$i++)
              <tr>
                <td><input class="selezione" id="Sensitiv{{$i}}" val="{{$i}}" type="checkbox"><label for="Sensitiv{{$i}}"></label></td>
                <td><input class="form-control" id="url_{{$i}}" name="nome[]" type="text"></td>
                <td><input class="form-control" name="dett[]" type="text"></td>
                <td><input class="form-control" name="pass[]" type="text"></td>
              </tr>
            @endfor
            </tbody>
            <script>
              $j('#btngo').on("click", function() {             
                $("input:checkbox[class=selezione]:checked").each(function () {
                  if($("#url_"+$(this).attr("val")).val() != ""){                  
                     window.open($("#url_"+$(this).attr("val")).val(), '_blank'); 
                  }              
                });          
              });

              var selezioneServizi = [];

              var nServ = 0;

              var kServ = 0;

              $j('#aggiungiNote').on("click", function() {
                var countnoteprivate = $j('#noteprivate').children('tr').length;
                  var tab = document.getElementById("noteprivate");

                  var tr = document.createElement("tr");

                  var check = document.createElement("td");

                  var checkbox = document.createElement("input");

                  checkbox.type = "checkbox";

                  checkbox.className = "selezione";
                  checkbox.id = "Sensitiv"+countnoteprivate;
                  checkbox.setAttribute('val',countnoteprivate);
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
                  fileInput.id = "url_"+countnoteprivate;
                  

                  var dettagli = document.createElement("input");

                  dettagli.type = "text";

                  dettagli.className = "form-control";

                  dettagli.name = "dett[]";
                
                  var password = document.createElement("input");
                            password.type = "text";
                            password.className = "form-control";
                            password.name = "pass[]";
                
                // var scadenza = document.createElement("input");
                // scadenza.type = "text";
                // scadenza.className = "form-control";
                // scadenza.name = "scad[]";
                // scadenza.id = "datepicker" + kServ;

                td.appendChild(fileInput);
                td1.appendChild(dettagli);
                // td2.appendChild(scadenza);
                td3.appendChild(password);

                  tr.appendChild(check);

                  tr.appendChild(td);

                  tr.appendChild(td1);//username
                  tr.appendChild(td3);//password
                  // tr.appendChild(td2);//scadenza
                

                  tab.appendChild(tr);

                  $j('.selezione').on("click", function() {

                    selezioneServizi[nServ] = $j(this).parent().parent();

                    nServ++;

                 });
                
                  $j("#datepicker" + kServ).datepicker();

                  });

                  $j('#eliminaNote').on("click", function() {

                     for(var i = 0; i < nServ; i++) {

                         selezioneServizi[i].remove();

                     }

                     nServ = 0;

                  });
            </script>

          </table>
    </div>
    </div>
    </div>
                   <!--  <p>

              <label for="progresso">Progresso del progetto </label>

              <input type="text" id="amount" name="progresso" style="border:0; color:#f6931f; font-weight:bold; width:25px;">%

          </p>
 -->
          <!-- <div id="slider-range-max"></div><br>
      <label for="statoemotivo">Stato emotivo</label>
                <select name="statoemotivo" class="form-control" id="statoemotivo" style="color:#ffffff">
                    <option style="background-color:white"></option>
                    @foreach($statiemotivi as $statoemotivo)
                        <option style="background-color:{{$statoemotivo->color}};color:#ffffff">{{$statoemotivo->name}}</option>
                    @endforeach
                </select>
                <br>
                <script>
                $j('#statoemotivo').on("change", function() {
                    var yourSelect = document.getElementById( "statoemotivo" );
                    document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
                });
                </script>
        <label for="notetecniche">Note private per il tecnico</label><a onclick="mostraPrivate()" id="mostra"> <i class="fa fa-eye"></i></a>

            <textarea rows="2" class="form-control" type="text" name="notetecniche" id="notetecniche" title="Note nascoste, clicca l'occhio per mostrare" placeholder="Note tecniche accordate verbalm
            /scritte a mano sul preventivo"></textarea><br>
  
            <label for="noteprivate">Note private del tecnico</p></label><a onclick="mostra()" id="mostra"> <i class="fa fa-eye"></i></a>

            <textarea id="noteenti" style="background-color:#f39538;color:#ffffff" rows="2" class="form-control" type="text" name="noteprivate" title="Note nascoste, clicca l'occhio per mostrare" placeholder="Inserisci note tecniche relative al progetto"></textarea> -->
        <script>

          $j('#notetecniche').on("click", function() {
            this.blur();
          });
          
          var testo = "<?php echo old('noteprivate'); ?>";
          var testoPrivato = "<?php echo old('notetecniche'); ?>";

          function mostra() {
            if($j('#noteenti').val()) {
              testo = $j('#noteenti').val();
              $j('#noteenti').val("");
            } else {
              $j('#noteenti').val(testo);
            }
          }

          function mostraPrivate() {
            if($j('#notetecniche').val()) {
              testoPrivato = $j('#notetecniche').val();
              $j('#notetecniche').val("");
            } else {
              $j('#notetecniche').val(testoPrivato);
            }
          }

          function mostra2() {
            if(!$j('#noteenti').val()) {
              $j('#noteenti').val(testo);
              $j('#notetecniche').val(testoPrivato);
            }
          }
        </script>

        <br>
        <!-- <label for="preventivo">Tempo</label><br>

            <div>

                <input value="{{ old('datainizio') }}" class="form-control" type="text" name="datainizio" id="datainizio" placeholder="Data inizio"><br>

                <input value="{{ old('datafine') }}" class="form-control" type="text" name="datafine" id="datafine" placeholder="Data fine"><br> -->

      <script>

            $j( function() {

              $j( "#slider-range-max" ).slider({

                range: "max",

                min: 0,

                max: 100,

                value: 10,

                slide: function( event, ui ) {

                  $j( "#amount" ).val( ui.value );

                }

              });

              $j( "#amount" ).val( $j( "#slider-range-max" ).slider( "value" ) );

            } );
      </script>
               
      <script>

        $j.datepicker.setDefaults(

                $j.extend(

                    {'dateFormat':'dd/mm/yy'},

                    $j.datepicker.regional['nl']

                )

            );

          $j('#datainizio').datepicker();

          $j('#datafine').datepicker();

      </script>

  </div> 
  
  

  <br>
        <!-- <label for="datisensibili">Dati sensibili</label><br>



                  <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiDati"><i class="fa fa-plus"></i></a>

                  <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaDati"><i class="fa fa-eraser"></i></a>

         <br> -->



              <!-- <table class="table table-striped table-bordered">

                  <thead>

                      <th>#</th>

                      <th>Dati sensibili</th>

                  </thead>

                  <tbody id="datisensibili">

                  </tbody>
 -->
                  <script>

                      var selezioneFile2 = [];

                      var nDati = 0;

                      var kDati = 0;

                      $j('#aggiungiDati').on("click", function() {

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

                      fileInput.rows = "7";

                          fileInput.className = "form-control";

                          fileInput.name = "dati[]";

                          td.appendChild(fileInput);

                          tr.appendChild(check);

                          tr.appendChild(td);

                          tab.appendChild(tr);

                          $j('.selezione').on("click", function() {

                        selezioneFile2[nDati] = $j(this).parent().parent();

                        nDati++;

                      });

                      });

                      $j('#eliminaDati').on("click", function() {

                         for(var i = 0; i < nDati; i++) {

                             selezioneFile2[i].remove();

                         }

                         nDati = 0;

                      });

                  </script>

             <!--  </table>
      <label for="files">Files</label><br>



                  <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiFile"><i class="fa fa-plus"></i></a>

                  <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaFile"><i class="fa fa-eraser"></i></a>

          <br>



              <table class="table table-striped table-bordered">

                  <thead>

                      <th>#</th>

                      <th>Sfoglia</th>

                  </thead>

                  <tbody id="files">

                  </tbody> -->

                  <script>

                      var selezioneFile = [];

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

                          fileInput.name = "file[]";

                          td.appendChild(fileInput);

                          tr.appendChild(check);

                          tr.appendChild(td);

                          tab.appendChild(tr);

                          $j('.selezione').on("click", function() {

                        selezioneFile[nFile] = $j(this).parent().parent();

                        nFile++;

                      });

                      });

                      $j('#eliminaFile').on("click", function() {

                         for(var i = 0; i < nFile; i++) {

                             selezioneFile[i].remove();

                         }

                         nFile = 0;

                      });

                  </script>
<!-- 
              </table>
      <label for="partecipanti">Partecipanti</label><br>
                  <select class="form-control" id="utenti">

                      @foreach($utenti as $utente)

                      <option value="{{$utente->id}}">{{$utente->name}}</option>

                      @endforeach

                  </select><br>



                  <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiPartecipante"><i class="fa fa-plus"></i></a>

                  <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="elimina"><i class="fa fa-eraser"></i></a>


          <br>



              <table class="table table-striped table-bordered">

                  <thead>

                      <th>#</th>

                      <th>Id</th>

                      <th>Utente</th>

                  </thead>

                  <tbody id="partecipanti">

                  </tbody>
 -->
                  <script>

                      var selezione = [];

                      var n = 0;

                      var k = 0;

                      $j('#aggiungiPartecipante').on("click", function() {

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

                          var nomeUtente = document.createTextNode($j("#utenti option:selected").text());

                          var idUtente = document.createElement("input");

                          idUtente.type = "text";

                          idUtente.className = "form-control";

                          idUtente.value = $j("#utenti option:selected").val();

                          idUtente.name = "partecipanti[]";

                          td.appendChild(nomeUtente);

                          td1.appendChild(idUtente);

                          tr.appendChild(check);

                          tr.appendChild(td1);

                          tr.appendChild(td);

                          tab.appendChild(tr);

                          $j('.selezione').on("click", function() {

                        selezione[n] = $j(this).parent().parent();

                        n++;

                      });

                      });

                      $j('#elimina').on("click", function() {

                         for(var i = 0; i < n; i++) {

                             selezione[i].remove();

                         }

                         n = 0;

                      });

                  </script>
        <?php echo Form::close(); ?>        
    
      
        <div class="pull-right col-md-4 col-sm-12 col-xs-12">
           <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="bg-white image-upload-box">
           
           <div class="form-group">
            <label for="scansione">{{trans('messages.keyword_selectfile')}}</label>
           </div>
              <div class="image_upload_div">
                <?php echo Form::open(array('url' => 'progetti/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
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
                    $('#addMediacommnetmodal').on('shown.bs.modal', function(){});
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
                var checkValues = $('input[name=rdUtente_'+fileid+']:checked').map(function(){
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
              <tbody id="files"></tbody>
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
            <hr>
          </div>
          </div>
        </div>
        </div>   
        
        <div class="col-md-2 col-sm-12 col-xs-12 mb16 show-mobile">
        <button onclick="mostra2()" type="submit" class="btn btn-warning">{{trans('messages.keyword_save')}}</button>
      </div>
        
             
<!--    </div>
  </div> -->
</div></div><!-- /row -->
<div class="footer-svg">
  <img src="{{url('images/FOOTER3_ORIZZONTAL_PROJECT.svg')}}" alt="ORIZZONTAL PROJECT">
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
                <form action="{{ url('/progetti/mediacomment/').'/'.$mediaCode }}" name="commnetform" method="post" id="commnetform">
                    {{ csrf_field() }}
                    @include('common.errors')                       
                    <div class="row">
                        <div class="col-md-12">                               
                            <div class="form-group">
                                <label for="title" class="control-label"> {{ ucfirst(trans('messages.keyword_title')) }}  </label>
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
var $ = jQuery.noConflict();
$(document).ready(function() {

  
       $("#project_add").validate({            
            rules: {
                nomeprogetto: {
                    required: true
                }
            },
            messages: {
                nomeprogetto: {
                    required: "{{trans('messages.keyword_please_enter_projectname')}}"
                }
            }
        });

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
  function commentProcessing(e){
    var $jc = jQuery.noConflict();
                            var id = $jc(e).attr('val');
                            var countid = $jc(e).attr('proc');
                            

                            var code = $jc("#processingcode_"+countid).val();
                            $jc("#newComment").modal();
                            $jc('#newComment').on('shown.bs.modal', function(){                              
                                $jc("#hdprocessingid").val(id);
                                $jc("#hdCode").val(code);
                            });
                            //if(id != '0') {
                                var urlD = '<?php echo url('/project/getprocessingcomment'); ?>';
                                $.ajax({
                                    url: urlD,
                                    type: 'post',
                                    data: { "_token": "{{ csrf_token() }}",id: id,code:code },
                                    success:function(data) {                                        
                                        $("#commentlist").html(data);
                                    }
                                });
                           //}
                       }
                        $(document).ready(function (e) {            
                            $("#btnsubmitcomments").on('click', (function (e) { 
                                var urlfile = '<?php echo url('/projectprocessing/addcomment'); ?>';    
                                //e.preventDefault();
                                var formData = new FormData($('#frmComments')[0]);                                 
                                /*formData.append('_token', '{{ csrf_token() }}');*/
                                var comments = $("#comments").val();
                                var processingid = $("#hdprocessingid").val();
                                var hdCode = $("#hdCode").val();
                                $('#show_alert_msg').html("");
                                $.ajax({
                                    url: urlfile,
                                    type: "POST",
                                    data: { "_token": "{{ csrf_token() }}",comments: comments,processingid:processingid,hdCode:hdCode },
                                    success: function (data) {                        
                                      if(data =='fail'){
                                         $('#show_alert_msg').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'+jslang_keyword_the_file_must_be_a_type_of_image+'! </div>');
                                         $('#frmComments')[0].reset();
                                      }
                                      else {
                                        var $jc = jQuery.noConflict();  
                                        //var $jc = jQuery.noConflict();
                                        //$('#frmComments')[0].reset();
                                        $jc("#comments").val("");
                                        $jc("#newComment").modal('hide');
                                        //$('#show_alert_msg').html("");
                                        //$("#frontlogopreview").html(data);
                                      }
                                    },
                                    error: function () {
                                    }
                                });
                            }));
                        });
</script>
@endsection