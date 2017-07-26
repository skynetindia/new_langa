@extends('adminHome')
@section('page')
@include('common.errors') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> 
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script> 
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script> 
<script type="text/javascript">
     $('.color').colorPicker();
</script> 
@if(!empty(Session::get('msg'))) 
<script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script> 
@endif
<div class="res-role-permission">

<h1>{{ trans('messages.keyword_permission') }}</h1>
<hr>
<h5>{{ trans('messages.keyword_profiling') }} Easy <b> LANGA </b></h5>
<hr>
<?php $ruolo = DB::table('ruolo_utente')->where('is_delete', '=', 0)->where('ruolo_id', '!=', '0')->get(); ?>
<?php echo Form::open(array('url' => '/store-permessi', 'id' => 'addroleform', 'name' => 'addroleform' )) ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 text-right">

<?php $currentRoleName = "";?>
  @if(isset($ruolo_id))    
    <div class="form-group permission-role">
    <label for="dipartimento">{{ trans('messages.keyword_profiling') }} <span class="required">(*)</span></label>
    <select id="nome_ruolo" class="form-control" name="nome_ruolo">
          @foreach($ruolo as $ruolo)
          <?php if($ruolo_id==$ruolo->ruolo_id){
              $currentRoleName = $ruolo->nome_ruolo;
            }
          ?><option  value="{{ $ruolo->ruolo_id }}" <?php echo ($ruolo_id==$ruolo->ruolo_id) ? 'selected="selected"':'';?>>{{ ucwords(strtolower($ruolo->nome_ruolo)) }}</option>      
          @endforeach
    </select>
  </div>  
  @endif 
  <div class="form-group permission-role">
  <label for="dipartimento">{{trans('messages.keyword_profiling_name')}} <span class="required">(*)</span></label>
    <input type="text" name="new_ruolo" class="form-control pull-left" value="{{ ucwords(strtolower($currentRoleName)) }}" placeholder="{{trans('messages.keyword_profiling_name')}}">
  </div>
</div>
</div>
<?php

  echo "<div class='table-responsive'> <table class='table table-bordered'>";
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
       ?>
<input type="checkbox" class="reading" id="lettura<?php echo $module->modulo.$i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>" <?php echo (in_array($module->id.'|0|lettura', $permessi)) ? 'checked' :''; ?>>
<label for="lettura<?php echo $module->modulo.$i; ?>"> lettura<?php echo $i; ?> </label>
<?php
            echo "</td><td>"; ?>
<input type="checkbox" class="writing" id="scrittura<?php echo $module->modulo.$i; ?>"  name="scrittura[]"  value="<?php echo $module->id.'|0|scrittura';?>"<?php echo (in_array($module->id.'|0|scrittura', $permessi)) ? 'checked' :''; ?>>
<label for="scrittura<?php echo $module->modulo.$i; ?>"> scrittura<?php echo $i; ?> </label>
<?php
        echo "</td></tr>";

        foreach ($submodule as $submodule) {

          echo "<tr>";

            echo "<td class='submodule'>";
            echo $submodule->modulo;
            echo "</td>";

            echo "<td class='submodule'>"; ?>
<input type="checkbox" class="lettura<?php echo $module->modulo.$i; ?>" id="lettura<?php echo $module->modulo.$submodule->modulo.$i; ?>" name="lettura[]" value="<?php echo $module->id.'|'.$submodule->id.'|lettura';?>"<?php echo (in_array($module->id.'|'.$submodule->id.'|lettura', $permessi)) ? 'checked' :''; ?> >
<label for="lettura<?php echo $module->modulo.$submodule->modulo.$i; ?>"> lettura<?php echo $i; ?> </label>
<?php
            echo "</td>";

            echo "<td class='submodule'>"; ?>
<input type="checkbox" class="scrittura<?php echo $module->modulo.$i; ?>" id="scrittura<?php echo $module->modulo.$submodule->modulo.$i; ?>" name="scrittura[]" value="<?php echo $module->id.'|'.$submodule->id.'|scrittura';?>" <?php echo (in_array($module->id.'|'.$submodule->id.'|scrittura', $permessi)) ? 'checked' :''; ?> >
<label for="scrittura<?php echo $module->modulo.$submodule->modulo.$i; ?>"> scrittura<?php echo $i; ?> </label>
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
<input type="checkbox" class="reading" id="lettura<?php echo $module->modulo.$i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>" <?php echo (in_array($module->id.'|0|lettura', $permessi)) ? 'checked' :''; ?>>
<label for="lettura<?php echo $module->modulo.$i; ?>"> lettura<?php echo $i; ?> </label>
<?php
          echo "</td>";

          echo "<td>"; ?>
<?php
          echo "</td>";

        echo "</tr>";
      }  
    }
  
  echo "</table> </div>";
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
       ?>
<input type="checkbox" class="reading" id="lettura<?php echo $module->modulo.$i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>">
<label for="lettura<?php echo $module->modulo.$i; ?>"> lettura<?php echo $i; ?> </label>
<?php
            echo "</td><td>"; ?>
<input type="checkbox" class="writing" id="scrittura<?php echo $module->modulo.$i; ?>"  name="scrittura[]"  value="<?php echo $module->id.'|0|scrittura';?>">
<label for="scrittura<?php echo $module->modulo.$i; ?>"> scrittura<?php echo $i; ?> </label>
<?php
        echo "</td></tr>";

        foreach ($submodule as $submodule) {

            echo "<tr>";

            echo "<td>";
            echo $submodule->modulo;
            echo "</td>";

            echo "<td>"; ?>
<input type="checkbox" class="lettura<?php echo $module->modulo.$i; ?>" id="lettura<?php echo $module->modulo.$submodule->modulo.$i; ?>" name="lettura[]" value="<?php echo $module->id.'|'.$submodule->id.'|lettura';?>">
<label for="lettura<?php echo $module->modulo.$submodule->modulo.$i; ?>"> lettura<?php echo $i; ?> </label>
<?php
            echo "</td>";

            echo "<td>"; ?>
<input type="checkbox" class="scrittura<?php echo $module->modulo.$i; ?>" id="scrittura<?php echo $module->modulo.$submodule->modulo.$i; ?>" name="scrittura[]" value="<?php echo $module->id.'|'.$submodule->id.'|scrittura';?>">
<label for="scrittura<?php echo $module->modulo.$submodule->modulo.$i; ?>"> scrittura<?php echo $i; ?> </label>
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
<input type="checkbox" class="reading" id="lettura<?php echo $module->modulo.$i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>">
<label for="lettura<?php echo $module->modulo.$i; ?>"> lettura<?php echo $i; ?> </label>
<?php
          echo "</td>";

          echo "<td>"; ?>
<?php
          echo "</td>";

        echo "</tr>";
      }  
    }
  
  echo "</table></div>";
?>
@endif 
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
<div class="row">
<div class="col-md-12">
  <button type="submit" class="btn btn-warning">{{ trans('messages.keyword_save') }}</button>
</div>
</div>
</div>
<?php echo Form::close(); ?> 
<script>
$(document).ready(function() {
//
  // validate add role form on keyup and submit
        $("#addroleform").validate({            
            rules: {
                new_ruolo: {
                    required: true,
                }
            },
            messages: {
                new_ruolo: {
                    required: "{{trans('messages.keyword_please_enter_a_role_name')}}"
                }
            }
        });
      });
</script>

<script>
$('#nome_ruolo').change(function() {
  var url = '<?php echo url('/role-permessi');?>';
  window.location = url+'/'+$(this).val();
});
</script> 
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}"></script>
@endsection