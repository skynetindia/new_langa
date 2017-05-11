@extends('adminHome')
@section('page')

@include('common.errors')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">
     $('.color').colorPicker();
</script>



<script type="text/javascript">
 
 $(document).ready(function() {

  $("#dipartimento").change(function(){

    if( $(this).val() == 1) {

        $("#sconto_section").hide();       
        $("#rendita").hide();
        $("#rendita_reseller").hide();
        $("#zone").hide();

    } else if( $(this).val() == 3) {

        $("#sconto_section").hide();    
        $("#rendita").hide();
        $("#rendita_reseller").hide();
        $("#zone").hide();

    } else if( $(this).val() == 4) {

        $("#sconto_section").show();      
        $("#rendita").show();
        $("#rendita_reseller").hide();
        $("#zone").show();

    } else {

      $("#sconto_section").show(); 
      $("#rendita").show();
      $("#rendita_reseller").show();
      $("#zone").show();

    }

  });

});

</script>

@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif

    <script type="text/javascript">

        $(document).on("click", "#profilazioneinterna", function () {
            
            if ($(this).is(":unchecked")) {
                $("#rendita").show();
            } else {
                $("#rendita").hide();
            }
        });

    </script>


@include('common.errors')


  <h1>{{ trans('messages.keyword_edituser') }} </h1><hr>

  
  <!-- echo $utente->id -->
	
  <?php $redirct=(isset($utente))? ("/".$utente->id):"";
   echo Form::open(array( 'url' => '/admin/update/utente' .$redirct, 'files' => true, 'id' => 'user_modification'));
	
   ?>

    {{ csrf_field() }}

    <!-- colonna a sinistra -->

  <div id="profilazione" class="pull-right">

    <label for="profilazione" >
        <input type="checkbox" id="profilazioneinterna" <?php if(isset($utente->dipartimento)){ if($utente->dipartimento == 1 || $utente->dipartimento == 3) { ?> checked="checked" <?php } }?> />
        {{ trans('messages.keyword_internalprofile') }}?
    </label>

  </div>

   <div class="col-md-4">

    <label for="name">{{ trans('messages.keyword_name') }} <p style="color:#f37f0d;display:inline">(*)</p></label>

    <input type="hidden" name="user_id" value=" <?php if(isset($utente->id)){ echo $utente->id; } ?>">

    <input value="<?php if(isset($utente->name)){ echo $utente->name; } ?>" class="form-control" type="text" name="name" id="name" placeholder="enter name"><br>
                
    <label for="colore">{{ trans('messages.keyword_color') }}</label>

    <input value="<?php if(isset($utente->color)){ echo $utente->color; } ?>" class="form-control color no-alpha" type="text" name="colore" id="colore" placeholder="choose color"><br>

    <div id="sconto_section"  <?php if(isset($utente->dipartimento)){ if($utente->dipartimento == 1 || $utente->dipartimento == 3) { ?> style="display: none" <?php } } ?>>

    <div id="sconto">

    <label for="sconto">{{ trans('messages.keyword_discount') }} <p style="color:#f37f0d;display:inline">(*)</p></label>

    <input value="<?php if(isset($utente->sconto)){ echo $utente->sconto; } ?>" class="form-control" type="text" name="sconto" id="sconto" placeholder="enter discont"><br>

    </div>

    <div id="sconto_bonus">

    <label for="sconto_bonus">{{ trans('messages.keyword_discount') }} {{ trans('messages.keyword_bonus') }} <p style="color:#f37f0d;display:inline">(*)</p></label>

    <input value="<?php if(isset($utente->sconto_bonus)){ echo $utente->sconto_bonus; } ?>" class="form-control" type="text" name="sconto_bonus" id="sconto_bonus" placeholder="enter discount bonus"><br>

    </div></div>  

    </div>

    <!-- colonna centrale -->

    <div class="col-md-4">

    <label for="id_ente">
    {{ trans('messages.keyword_associate') }}  <p style="color:#f37f0d;display:inline">(*)</p></label>

      <div class="col-xs-6">

      <br>

      <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiente"><i class="fa fa-plus"></i></a>

      <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaente"><i class="fa fa-eraser"></i></a>
              
      </div>

    <div class="col-md-12">

      <table class="table table-striped table-bordered">
                  
      <tbody id="ente">

      <?php 


      $ente = (isset($utente->id_ente))?explode(",", $utente->id_ente):array();
        
      $i=0;
          
      foreach ($ente as $ente_value) { ?>
          
      <tr>
                      
      <label class="checkente<?php echo $i;?>">
      <select name="idente[]" class="form-control" id="id_ente" style="width: 200px">

      <option style="background-color:white" selected disabled>-- select --</option>  
      <?php  
        foreach ($enti as $enti_value) { ?> 

         <option <?php if($enti_value->id == $ente_value){ echo 'selected'; } ?> value="<?php if(isset($enti_value->id)){ echo $enti_value->id; } ?>">
         <?php if(isset($enti_value->nomereferente)){ echo $enti_value->nomereferente; }  ?> </option> 

      <?php  }  ?>
    
    </select>
      
    <input id="checkente<?php echo $i;?>" type="checkbox" class="checkente">  

    </label>

    <?php $i++; ?>
    </tr>
    <?php  } 

    ?>
    <input type="hidden" id="hidden" name="check" value="<?php echo $i; ?>">
    
    </tbody>

    <script>
                    
    $('#aggiungiente').on("click", function() {
    var i = $("#hidden").val();
      
      $('#ente').append("<label class='checkente"+i+"'><select name='idente[]' class='form-control' id='id_ente'> <?php $check = false; ?> <option selected style='background-color:white'></option><?php for($i = 0; $i < count((array)$enti); $i++){if(isset($utente->id_ente) && $enti[$i]->id == $utente->id_ente){ ?><option selected value='<?php echo $enti[$i]->id ?>'><?php echo $enti[$i]->nomereferente ?></option><?php $check = true; } if($check==false){ ?> <option value='<?php echo $enti[$i]->id ?>'><?php echo $enti[$i]->nomereferente ?> </option>+<?php } $check = false; }?></select><input id='checkente"+i+"' type='checkbox' class='checkente'></label>" );
        i++;
        $('#hidden').val(i);

            });

              $('#eliminaente').on("click", function() {

                  if($('#checkente0').prop('checked') == true) {

                      alert("Can not remove default ente");
                      $('input:checkbox').removeAttr('checked');

                  } else {

                     $(".checkente").each(function(){

                      var i = $("#hidden").val();

                        if($(this).prop('checked') ==true) {

                          var newclass = $(this).prop('id');
                          $("."+newclass).remove(); 
                          
                            i--;
                            $('#hidden').val(i);
                      }

                    });

                  }                 
              });

                  </script>
              </table>
        </div>  
      <br>

      <label for="email">{{ trans('messages.keyword_email') }} </label><p style="color:#f37f0d;display:inline"> (*) </p></label>

      <input value="<?php if(isset($utente->email)){ echo $utente->email; } ?>" class="form-control" type="email" name="email" id="email" placeholder="enter email"><br>

      <div id="rendita" <?php if( isset($utente->dipartimento) && ($utente->dipartimento == 1 || $utente->dipartimento == 3)) { ?> style="display: none" <?php } ?>>

      <label for="rendita">{{ trans('messages.keyword_revenue') }} <p style="color:#f37f0d;display:inline"> (*) </p></label>

      <input value="<?php if(isset($utente->rendita)){ echo $utente->rendita; } ?> " class="form-control" type="text" name="rendita" id="rendita" placeholder="enter revenue l'annuità"><br>
    
      </div>


      <div id="rendita_reseller" <?php echo (isset($utente->dipartimento) && ($utente->dipartimento == 1 || $utente->dipartimento == 3 || $utente->dipartimento == 4))?"style='display: none'":""; ?>>

     <label for="rendita_reseller">{{ trans('messages.keyword_revenuereseller') }}<p style="color:#f37f0d;display:inline"> (*) </p></label>

      <input value="<?php if(isset($utente->rendita_reseller)){ echo $utente->rendita_reseller; } ?> " class="form-control" type="text" name="rendita_reseller" id="rendita_reseller" placeholder="enter revenue of reseller"><br>

      </div>

      </div>

    <!-- colonna a destra -->


    <div class="col-md-4">

    <label for="dipartimento">{{ trans('messages.keyword_profile') }} <p style="color:#f37f0d;display:inline">(*)</p></label>

    <select id="dipartimento" class="form-control" name="dipartimento">
         
         @foreach($ruolo as $ruolo)
           <option  value="{{ $ruolo->ruolo_id }}" <?php echo (isset($utente->dipartimento) && $utente->dipartimento == $ruolo->ruolo_id) ? 'selected="selected"':'';?>>{{ $ruolo->nome_ruolo }}</option>  
        @endforeach 

      </select><br>

      <div class="role" > </div>

      <script>
      
        $('#dipartimento').change(function() {

          var url = '<?php echo url('/admin/role/permission');?>';
          var fullurl = url+'/'+$(this).val();

          $.get( fullurl, function( data ) {
            var permessi = $( "#permissionview" ).html( data );       
          });


        });



      </script>

      <label for="password">{{ trans('messages.keyword_password') }}</label>

      <input class="form-control" type="password" name="password" id="password" placeholder="enter password" > <br>

      <div id="zone" <?php if(isset($utente->dipartimento) && ( $utente->dipartimento == 1 || $utente->dipartimento == 3)) { ?> style="display: none" <?php } ?>>

      <label for="zone">{{ trans('messages.keyword_zone') }} <p style="color:#f37f0d;display:inline">(*)</p></label>

      <div class="col-xs-6">
      <br><a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungizone"><i class="fa fa-plus"></i></a>

      <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminazone"><i class="fa fa-eraser"></i></a>

    </div>

    <div class="col-md-12">
    
    <table class="table table-striped table-bordered">
                  
    <tbody id="zone">

    <?php 
      $city = (isset($utente->id_citta))?explode(",", $utente->id_citta):[];

      $i=0;

    foreach ($city as $city_value) { ?>

    <tr>

    <label class="checkzone<?php echo $i;?>">                    

    <select name="zone[]" class="form-control" id="zone" style="width: 200px">
          <option style="background-color:white" selected disabled>-- select --</option>  
    <?php  

    foreach ($citta as $citta_value) { ?> 

     <option <?php if($citta_value->id_citta == $city_value){ echo 'selected'; } ?> value="<?php echo $citta_value->id_citta ?>"><?php echo $citta_value->nome_citta ?> </option> 
    <?php    }
    ?>

    </select>

    <input id="checkzone<?php echo $i;?>" type="checkbox" class="checkzone"> 
    </label>
    <?php $i++; ?>
        </tr>
    <?php  } ?>

    <input type="hidden" id="hiddenzone" name="checkhidden" value="<?php echo $i; ?>">
    
    </tbody>


    <script>
                  
      $('#aggiungizone').on("click", function() {

      var i = $("#hiddenzone").val();

      $('#zone').append("<label class='checkzone"+i+"'><select name='zone[]' class='form-control' id='zone' style='width: 250px'> <?php $check = false; ?> <option selected style='background-color:white'></option><?php for($i = 0; $i < count((array)$citta); $i++){if(isset($utente->id_citta) && $citta[$i]->id_citta == $utente->id_citta){ ?><option selected value='<?php echo $citta[$i]->id_citta ?>'><?php echo $citta[$i]->nome_citta ?></option><?php $check = true; } if($check==false){ ?> <option value='<?php echo $citta[$i]->id_citta ?>'><?php echo $citta[$i]->nome_citta ?> </option>+<?php } $check = false; }?></select><input id='checkzone"+i+"' type='checkbox' class='checkzone'></label>");

          i++;
          $('#hiddenzone').val(i);

          });

        $('#eliminazone').on("click", function() {

            if($('#checkzone0').prop('checked') == true) {

              alert("Can not remove default zone");
              $('input:checkbox').removeAttr('checked');

          } else {

              $(".checkzone").each(function(){

              var i = $("#hiddenzone").val();

                if($(this).prop('checked') ==true) {

                  var newclass = $(this).prop('id');
                  $("."+newclass).remove(); 
                  
                    i--;
                    $('#hiddenzone').val(i);
              }

            });

          }                 
      });

      </script>
             
      </table>

      </div>
      
     </div>    

  </div> 


<div class="col-md-12" id="permissionview">
<?php

  echo "<table class='table table-striped table-bordered'>";
    echo "<tr>";
      echo "<th>";
        echo trans('messages.keyword_module');
      echo "</th> ";
      echo "<th>";
        echo  trans('messages.keyword_reading');
      echo "</th> ";
      echo "<th>";
        echo  trans('messages.keyword_writing');
      echo "</th> ";
    echo "</tr>";

    $i=0;
?>

@if(isset($permessi))

<?php

    foreach ($module as $module) {

      $submodule = DB::table('modulo')
            ->where('modulo_sub', $module->id)
            ->get();
      if($submodule) {

         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
            echo "</td></b> <td>";
       ?><input type="checkbox" class="reading" id="lettura<?php echo $i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>" <?php echo (in_array($module->id.'|0|lettura', $permessi)) ? 'checked' :''; ?>>        <?php
            echo "</td><td>"; ?>
              <input type="checkbox" class="writing" id="scrittura<?php echo $i; ?>"  name="scrittura[]"  value="<?php echo $module->id.'|0|scrittura';?>"<?php echo (in_array($module->id.'|0|scrittura', $permessi)) ? 'checked' :''; ?>>
            <?php
        echo "</td></tr>";

        foreach ($submodule as $submodule) {

          echo "<tr>";

            echo "<td>";
            echo $submodule->modulo;
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" class="lettura<?php echo $i; ?>" id="lettura" name="lettura[]" value="<?php echo $module->id.'|'.$submodule->id.'|lettura';?>"<?php echo (in_array($module->id.'|'.$submodule->id.'|lettura', $permessi)) ? 'checked' :''; ?> >
              <?php
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" class="scrittura<?php echo $i; ?>" id="scrittura" name="scrittura[]" value="<?php echo $module->id.'|'.$submodule->id.'|scrittura';?>" <?php echo (in_array($module->id.'|'.$submodule->id.'|scrittura', $permessi)) ? 'checked' :''; ?> >
              <input type="hidden" id="hidden" name="checkhidden" value="<?php echo $i; ?>">
            <?php
            echo "</td>";

          echo "</tr>";
         
        } $i++;
      } else {

         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
         echo "</td></b> ";

          echo "<td>"; ?>
            <input type="checkbox" class="reading" id="lettura<?php echo $i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>" <?php echo (in_array($module->id.'|0|lettura', $permessi)) ? 'checked' :''; ?>>
            <?php
          echo "</td>";

          echo "<td>"; ?>
          
          <?php
          echo "</td>";

        echo "</tr>";
      }  
    }
  
  echo "</table>";
 ?>

@else
 <?php  
    foreach ($module as $module) {

      $submodule = DB::table('modulo')
            ->where('modulo_sub', $module->id)
            ->get();

      if($submodule) {

         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
            echo "</td></b> <td>";
       ?><input type="checkbox" class="reading" id="lettura<?php echo $i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>">        <?php
            echo "</td><td>"; ?>
              <input type="checkbox" class="writing" id="scrittura<?php echo $i; ?>"  name="scrittura[]"  value="<?php echo $module->id.'|0|scrittura';?>">
            <?php
        echo "</td></tr>";

        foreach ($submodule as $submodule) {

            echo "<tr>";

            echo "<td>";
            echo $submodule->modulo;
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" class="lettura<?php echo $i; ?>" id="lettura" name="lettura[]" value="<?php echo $module->id.'|'.$submodule->id.'|lettura';?>">
              <?php
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" class="scrittura<?php echo $i; ?>" id="scrittura" name="scrittura[]" value="<?php echo $module->id.'|'.$submodule->id.'|scrittura';?>">
              <input type="hidden" id="hidden" name="checkhidden" value="<?php echo $i; ?>">
            <?php
            echo "</td>";

          echo "</tr>";
         
        } $i++;
      } else {

         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
         echo "</td></b> ";

          echo "<td>"; ?>
            <input type="checkbox" class="reading" id="lettura<?php echo $i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>">
            <?php
          echo "</td>";

          echo "<td>"; ?>
          
          <?php
          echo "</td>";

        echo "</tr>";
      }  
    }
  
  echo "</table>";
?>
@endif
</div>
<script type="text/javascript">
  
  $('.reading').click(function () {    
       // $('#sublettura').prop('checked', this.checked); 
        var $id = $(this).attr('id');
        $('.'+$id).prop('checked', this.checked);
   });

  $('.writing').click(function () {    
       var $id = $(this).attr('id');
        $('.'+$id).prop('checked', this.checked);
   });

</script>

	<div class="col-md-12" style="padding-top:10px;padding-bottom:10px;">

		<button type="submit" class="btn btn-primary">Salva</button>

    {!! link_to(URL::previous(), 'Cancel', ['class' => 'btn btn-danger']) !!}

	</div>

    <?php echo Form::close(); ?>  

<script>

$('.ciao').on("click", function() {

    $(this).children()[0].click();

});

</script>

<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">
@endsection