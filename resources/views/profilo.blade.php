@extends('layouts.app')
@section('content')
@include('common.errors')
<div class="row">
  <div class="col-md-12">
        <h1>Profilo</h1>
        <hr/>
  <div class="panel">
  	<div class="panel-body">
      <div class="row">       
         <?php echo Form::open(array('url' => '/profilo/aggiornaimmagine' . "/$utente->id", 'files' => true)) ?> 
         {{ csrf_field() }}                
            <div class="col-md-5">
            	<div class="row">
             <div class="col-md-3">
              <h3>User: {{$utente->name}}</h3>              
              @if(!empty($utente->logo))
                <img src="{{ url('storage/app/images').'/'.$utente->logo }}" class="img-responsive"></img>
              @endif
            </div>            
            <div class="col-md-9">
            <input type="hidden" id="login_user_id" name="login_user_id" value="{{isset($utente->id) ? $utente->id : ''}}">            
              <div class="space40"></div>              
             	<div class="form-group">
                <label for="logo">{{trans('messages.keyword_upload_profile_image')}}</label>
                <input class="form-control" type="file" id="logo" name="logo">
             	</div>
              <input class="form-control btn btn-warning" type="submit" value="Aggiorna immagine">             
            </div>
            </div>
            
            @if($utente->dipartimento != '1')
            <h4>Percentuali</h4>
            <div class="row">
            	<div class="col-md-6">
                <div class="form-group">
                  <label>{{ ucfirst(trans('messages.keyword_discount')) }} <span class="required">(*)</span></label>
                  <input type="text" value="{{$utente->sconto}}" name="sconto" class="form-control">
                </div>
              </div>

              <div class="col-md-6">
              	<div class="form-group">
                 <label>{{ ucfirst(trans('messages.keyword_discountbonus')) }}<span class="required">(*)</span></label>
                  <input type="text" value="{{$utente->sconto_bonus}}" name="sconto_bonus" class="form-control">
                </div>
              </div>
                
              <div class="col-md-12">
               	<div class="form-group">
                 <label>{{ ucfirst(trans('messages.keyword_zone')) }}<span class="required">(*)</span></label>
                  <input type="text" value="{{$utente->sconto_bonus}}" name="sconto_bonus" class="form-control">
                </div>
              </div>                
              <div class="col-md-6">
                <div class="form-group">
                 <label for="url">{{ ucfirst(trans('messages.keyword_revenue')) }} <span class="required">(*)</span></label>
                  <input type="text" placeholder="{{$utente->rendita}}" name="rendita" class="form-control">
                </div>
              </div>                
              <div class="col-md-6">
                <div class="form-group">
                  <label for="url">{{ ucfirst(trans('messages.keyword_resale_on_reseller')) }} <span class="required">(*)</span></label>
                  <input type="text" placeholder="{{$utente->rendita_reseller}}" name="rendita_reseller" class="form-control">
                </div>
              </div>
            </div>
            @endif               
            </div>
            <div class="col-md-7">
            <div class="space40"></div>
             <div class="form-group">
                <label for="name">{{trans('messages.keyword_user_name')}}</label>
                <input type="text" placeholder="{{trans('messages.keyword_user_name')}}" name="name" value="{{$utente->name}}" class="form-control">
              </div>
              <div class="form-group">
                <label for="url">{{trans('messages.keyword_email')}}</label>
                <input type="text" placeholder="{{trans('messages.keyword_email')}}" value="{{$utente->email}}" name="email" class="form-control">
              </div>
              <div class="form-group">
                 <label for="url">{{trans('messages.keyword_password')}}</label>
                 <input type="password" placeholder="{{trans('messages.keyword_password')}}" name="password" class="form-control">
              </div>
                  <div class="form-group">
                	 <label for="url">{{trans('messages.keyword_profile')}}</label>
              		    <input type="text" placeholder="{{trans('messages.keyword_profile')}}" readonly="readonly" value="{{$user_role->nome_ruolo}}" class="form-control">
                    </div>                    
                    <div class="form-group">
                	     <label for="url">{{trans('messages.keyword_entity_connection')}}</label>
              		    <input type="text" placeholder="{{trans('messages.keyword_entity_connection')}}" readonly="readonly" value="{{$utente->nomeazienda}}" class="form-control">
                    </div>
                    @if($utente->dipartimento != '1')
                	 <div class="form-group">
                    	<div class="quiz-check">
                           <span>{{trans('messages.keyword_internalprofile')}}</span><div class="switch"><input value="1" <?php if($utente->is_internal_profile == '1') { echo "selected"; } ?> class="" name="is_internal_profile" id="is_internal_profile" type="checkbox"><label for="escludi_da_quiz"></label></div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-2">
                    <div class="form-group">
                      <input class="form-control btn btn-warning" type="submit" value="{{trans('messages.keyword_save')}}">             
                    </div>
                    </div>                    
                </div>

            <?php /* <div class="table-responsive">               
                                <table class="table">
									@foreach($link as $l)
										<tr><td>{{ $l->name }} | {{ $l->url }} <a  href="{{url('/profilo/link/elimina') . '/' . $l->id}}" title="Elimina questo collegamento rapido" class="btn btn-danger"><span class="fa fa-eraser"></span></a></td></tr>
									@endforeach
								</table>
                
              </div> */?>
            </div>
            </form>

        <div class="space50"></div>
      <div class="row">
        <div class="col-md-12" id="permissionview"><?php

  echo '<div class="table-responsive"><table class="selectable table table-bordered permission-table">';
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
       ?><input type="checkbox" readonly="readonly" disabled="disabled" class="reading input_class_checkbox" id="lettura<?php echo $i; ?>" name="lettura[]"  value="<?php echo $module->id.'|0|lettura';?>" 
       <?php echo (in_array($module->id.'|0|lettura', $permessi) || ($utente->id == '0')) ? 'checked' :'';  ?>> <label for="lettura<?php echo $i; ?>">lettura<?php echo $i; ?> </label>
       
        <?php
            echo "</td><td>"; ?>
              <input type="checkbox" readonly="readonly" disabled="disabled" class="writing input_class_checkbox" id="scrittura<?php echo $i; ?>"  name="scrittura[]"  value="<?php echo $module->id.'|0|scrittura';?>"<?php echo (in_array($module->id.'|0|scrittura', $permessi) || ($utente->id == '0')) ? 'checked' :''; ?>><label for="scrittura<?php echo $i; ?>">lettura<?php echo $i; ?> </label>

              <!-- <div class="class_checkbox writing <?php //echo (in_array($module->id.'|0|scrittura', $permessi)) ? 'checked' :'';  ?> " data-info="scrittura<?php //echo $i; ?>"></div> -->
             
            <?php
        echo "</td></tr>";

        foreach ($submodule as $submodule) {

          echo "<tr>";

            echo "<td>";
            echo $submodule->modulo;
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" readonly="readonly" disabled="disabled" class="lettura<?php echo $i; ?> input_class_checkbox" id="lettura" name="lettura[]" value="<?php echo $module->id.'|'.$submodule->id.'|lettura';?>"<?php echo (in_array($module->id.'|'.$submodule->id.'|lettura', $permessi) || ($utente->id == '0')) ? 'checked' :''; ?> ><label for="lettura<?php echo $i; ?>">lettura<?php echo $i; ?> </label>

              <!-- <div class="class_checkbox lettura <?php //echo (in_array($module->id.'|0|lettura', $permessi)) ? 'checked' :'';  ?> " data-info="lettura<?php //echo $i; ?>"></div> -->

              <?php
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" readonly="readonly" disabled="disabled" class="scrittura<?php echo $i; ?> input_class_checkbox" id="scrittura" name="scrittura[]" value="<?php echo $module->id.'|'.$submodule->id.'|scrittura';?>" <?php echo (in_array($module->id.'|'.$submodule->id.'|scrittura', $permessi) || ($utente->id == '0')) ? 'checked' :''; ?> ><label for="scrittura<?php echo $i; ?>">scrittura<?php echo $i; ?> </label>

              <!-- <div class="class_checkbox scrittura <?php //echo (in_array($module->id.'|0|scrittura', $permessi)) ? 'checked' :'';  ?> " data-info="scrittura<?php //echo $i; ?>"></div> -->

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
            <input type="checkbox" readonly="readonly" disabled="disabled" class="reading input_class_checkbox" id="lettura<?php echo $i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>" <?php echo (in_array($module->id.'|0|lettura', $permessi) || ($utente->id == '0') ) ? 'checked' :''; ?>><label for="lettura<?php echo $i; ?>">lettura<?php echo $i; ?> </label>

             <!-- <div class="class_checkbox reading <?php //echo (in_array($module->id.'|0|lettura', $permessi)) ? 'checked' :'';  ?> " data-info="lettura<?php //echo $i; ?>"></div> -->

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

       ?><input type="checkbox" readonly="readonly" disabled="disabled" class="reading input_class_checkbox" id="lettura<?php echo $i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>">
       <label for="lettura<?php echo $i; ?>">lettura<?php echo $i; ?> </label><?php
            echo "</td><td>"; ?>
              <input type="checkbox" readonly="readonly" disabled="disabled" class="writing input_class_checkbox" id="scrittura<?php echo $i; ?>"  name="scrittura[]"  value="<?php echo $module->id.'|0|scrittura';?>" <?php echo ($utente->id == '0') ? 'checked' :''; ?>><label for="scrittura<?php echo $i; ?>">scrittura<?php echo $i; ?> </label>
            <?php
        echo "</td></tr>";

        foreach ($submodule as $submodule) {

            echo "<tr>";

            echo "<td>";
            echo $submodule->modulo;
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" readonly="readonly" disabled="disabled" class="lettura<?php echo $i; ?> input_class_checkbox" id="lettura" name="lettura[]" value="<?php echo $module->id.'|'.$submodule->id.'|lettura';?>" <?php echo ($utente->id == '0') ? 'checked' :''; ?>><label for="lettura<?php echo $i; ?>">lettura<?php echo $i; ?> </label>
              <?php
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox"  readonly="readonly" disabled="disabled" class="scrittura<?php echo $i; ?> input_class_checkbox" id="scrittura" name="scrittura[]" value="<?php echo $module->id.'|'.$submodule->id.'|scrittura';?>" <?php echo ($utente->id == '0') ? 'checked' :''; ?>><label for="scrittura<?php echo $i; ?>">scrittura<?php echo $i; ?> </label>
              <input type="hidden" id="hidden" name="checkhidden" value="<?php echo $i; ?>">
            <?php
            echo "</td>";

          echo "</tr>";
         
        } $i++;
      } else {
         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
         echo "</td></b>";
          echo "<td>"; ?>
            <input type="checkbox" readonly="readonly" disabled="disabled" class="reading input_class_checkbox" id="lettura<?php echo $i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>" <?php echo ($utente->id == '0') ? 'checked' :''; ?>>
            <label for="lettura<?php echo $i; ?>">lettura<?php echo $i; ?> </label>
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
</div>
</div>

<script type="text/javascript">
  <?php if($utente->id == '0'){ ?>
    $('.reading').prop('checked', this.checked);
    $('.writing').prop('checked', this.checked);
  <?php } ?>
  $('.reading').click(function () {   
    var $id = $(this).attr('id');
    $('.'+$id).prop('checked', this.checked);
  });

  $('.writing').click(function () {
      var $id = $(this).attr('id');
      $('.'+$id).prop('checked', this.checked);
  });

// setTimeout(function(){

// $('.input_class_checkbox').each(function(){
//   if($(this).attr('checked') == true){
//     $(this).hide().after('<div class="class_checkbox checked" />');
//   }else{
//     $(this).hide().after('<div class="class_checkbox" />');
//   }

//   if($(this).hasClass('reading'))
//   {
//     $thisid=$(this).attr('id');
//     $this=$("#"+$thisid);
//     $(document).find($this).next().addClass('reading');
//     $(document).find($this).next().attr('data-info',$thisid);
//   }
  
//   else 
//   {
//     if($(this).hasClass('writing'))
//     {
//       $thisid=$(this).attr('id');
//       $this=$("#"+$thisid);
//       $(document).find($this).next().addClass('writing');
//       $(document).find($this).next().attr('data-info',$thisid);
      
//     }
//     else
//     {
//       $class= $(this).attr("class");
//       $cls=$class.split(' ');
//       $(this).next().addClass($cls[0]);
//     }
//   }

// });
// }, 200);

// $('.class_checkbox').on('click',function(){
//     $(this).toggleClass('checked').prev().prop('checked',$(this).is('.checked'));
//   if($(this).hasClass('writing') || $(this).hasClass('reading'))
//   {
//     $class=$(this).attr('data-info');
//     $(document).find('.'+$class).toggleClass('checked');
//   }
// });
</script>
      </div>
   </div>
    </div>
  </div>
@endsection