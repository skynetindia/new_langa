@extends('adminHome')

@section('page')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<h1>{{trans('messages.keyword_life_cost_indices')}}</h1><hr>

@include('common.errors')

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif


<div class="container">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-primary" id="myBtn">{{trans('messages.keyword_add')}}</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
      
          <h4><span class=""></span> {{trans('messages.keyword_add_provincie')}}</h4>
        </div>

        <div id="success_message"></div>

        <div class="modal-body" style="padding:40px 50px;">

    <form role="form" id="provincie_form" method="POST" name="provincie" action="">

     <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <?php 
        $stato = DB::table('stato')->get();       
      ?>
            <div class="form-group">
              <label for="stato"><span class=""></span> 
              {{trans('messages.keyword_select_status')}}</label>

            <select id="stato" name="stato[]" class="form-control" required>
                <option></option>
                @foreach($stato as $state)

                  <option value="{{ $state->id_stato }}">
                  {{ $state->nome_stato }}
                  </option>

                @endforeach

              </select>
            </div>

            <div class="form-group">
              <label for="citta"><span class=""></span> 
               {{trans('messages.keyword_enter_city')}} </label>
              <input type="text" class="form-control" id="citta" placeholder="{{trans('messages.keyword_enter_city')}}" required />
            </div>
            <div class="form-group">
              <label for="provincie"> {{trans('messages.keyword_enter_provincie')}} </label>
              <input type="text" class="form-control" id="provincie" placeholder="{{trans('messages.keyword_enter_provincie')}}" name="citta" required />
            </div>
            
            <button type="button" id="btn_save" class="btn btn-success btn-block"><span class="glyphicon"></span> {{trans('messages.keyword_save')}} </button>

          </form>
        </div>

        <div class="modal-footer">
          <button type="button" id="btn_close" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove" ></span> Close</button>
         
        </div>
      </div>
      
    </div>
  </div> 
</div>
 
<script>


$(document).ready(function(){

    $("#myBtn").click(function(){
        $("#myModal").modal();
    });

    $("#btn_close").click(function(){
        location.reload();
    });


    $("#btn_save").click(function(e){
       
        e.preventDefault();

          var stato = $("#stato").val(); 
          var citta = $("#citta").val();
          var provincie = $("#provincie").val(); 
          var _token = $('input[name="_token"]').val();

          $.ajax({
            type:'POST',
            data: {
                    'stato': stato,
                    'citta':citta,
                    'provincie': provincie,
                    '_token' : _token
                  },
            url: '{{ url('addprovincie') }}',
            success:function(data) {
               // console.log(data);
               $('#success_message').html(data);
            }

        });

    });
});
</script>

<?php echo Form::open(array('url' => '/store-provincie')) ?>

<div class="row">   

@php

$i = 1

@endphp

@foreach($stato as $state)

@if($i/3 == 1)

<div class="row">  
  <div class="col-md-4">

    <label for="nome_stato" style="background: GRAY; color: black; width: 350px; text-align: center; font-size: 18px;"> {{ $state->nome_stato }} </label>

        @foreach($provincie as $citta)
    
          @if($citta->id_stato == $state->id_stato)
    
            <input type="text" name="citta[]" value="{{ $citta->nome_citta }}" style="width: 170px;">

            <input type="text" name="provincie[]" value="{{ $citta->provincie }}" style="width: 170px;">

            <input type="hidden" name="id_citta[]" value="{{ $citta->id_citta }}">

          @endif

       @endforeach
  
</div>
</div>
<br>
@else
  
  <div class="col-md-4">

    <label for="nome_stato" style="background: GRAY; color: black; width: 350px; text-align: center; font-size: 18px;"> {{ $state->nome_stato }} </label>

        @foreach($provincie as $citta)
    
          @if($citta->id_stato == $state->id_stato)
    
            <input type="text" name="citta[]" value="{{ $citta->nome_citta }}" style="width: 170px;">

            <input type="text" name="provincie[]" value="{{ $citta->provincie }}" style="width: 170px;">

            <input type="hidden" name="id_citta[]" value="{{ $citta->id_citta }}">

          @endif

       @endforeach
  
</div>

@endif



@php
  $i++
@endphp

@endforeach
</div>

<div class="col-md-12" style="padding-top:10px;padding-bottom:10px;">

  <button type="submit" class="btn btn-primary">{{trans('messages.keyword_save')}}</button>

</div>
  
<?php echo Form::close(); ?>  

@endsection