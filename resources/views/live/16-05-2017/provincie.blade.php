@extends('adminHome')

@section('page')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<h1>Indici Costo Vita</h1><hr>

@include('common.errors')

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif


<div class="container">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-warning" id="myBtn"><i class="fa fa-plus"></i></button>

  <!-- Modal -->
  <div class="modal fade add-provincie" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class=""></span> Add Provincie</h4>
        </div>

      

        <div class="modal-body">
	  <div id="success_message"></div>
    <form role="form" id="provincie_form" method="POST" name="provincie" action="">

     <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <?php 
        $stato = DB::table('stato')->get();       
      ?>
            <div class="form-group">
              <label for="stato"><span class=""></span> 
              select stato</label>

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
              Enter Citta</label>
              <input type="text" class="form-control" id="citta" placeholder="Enter citta" required />
            </div>
            <div class="form-group">
              <label for="provincie"> Enter provincie </label>
              <input type="text" class="form-control" id="provincie" placeholder="Enter provincie" name="citta" required />
            </div>
    
          </form>
        </div>

        <div class="modal-footer text-right">
        <button type="button" id="btn_save" class="btn btn-warning"><span class="glyphicon"></span> Save </button>
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

<div class="row indici-costo-wrap">   

@php

$i = 1

@endphp

@foreach($stato as $state)

@if($i/3 == 1)

<div class="row ">  
  <div class="col-md-4">
<div class="row"><div class="col-md-12">
    <label for="nome_stato" > {{ $state->nome_stato }} </label></div></div>

        @foreach($provincie as $citta)
    
          @if($citta->id_stato == $state->id_stato)
    <div class="row">
<div class="col-md-6"><input type="text" name="citta[]" value="{{ $citta->nome_citta }}" ></div>

<div class="col-md-6"><input type="text" name="provincie[]" value="{{ $citta->provincie }}" ></div>
</div>
            <input type="hidden" name="id_citta[]" value="{{ $citta->id_citta }}">

          @endif

       @endforeach
  
</div>
</div>
<br>
@else
  
  <div class="col-md-4">
<div class="row"><div class="col-md-12">
    <label for="nome_stato" > {{ $state->nome_stato }} </label></div></div>

        @foreach($provincie as $citta)
    
          @if($citta->id_stato == $state->id_stato)
     <div class="row">
<div class="col-md-6">
            <input type="text" name="citta[]" value="{{ $citta->nome_citta }}" ></div>
<div class="col-md-6">
            <input type="text" name="provincie[]" value="{{ $citta->provincie }}" >
</div></div>
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



  <button type="submit" class="btn btn-warning">Salva</button>

  
<?php echo Form::close(); ?>  

<div class="footer-svg">
	<img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
</div>
@endsection
