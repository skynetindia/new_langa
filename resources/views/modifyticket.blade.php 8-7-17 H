@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<!-- ckeditor -->
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

@include('common.errors')

<style type="text/css">
   
#msg {
    border-radius: 25px;
    background-color: #73AD21;
    padding: 10px;  
    color: black;  
    font-size: 14;
}

#msg1 {
    border-radius: 25px;
    background-color: #717D7E;
    padding: 10px;  
    color: black; 
    text-align: right; 
    font-size: 14;
}

#time {
    font-size: 8;   
    text-align: right; 
}

</style>

<div class="header-right">
  <div class="float-left">
      <h1>{{trans('messages.keyword_problem')}}</h1><hr>
    </div>
</div>

<?php echo Form::open(array('url' => '', 'files' => true)) ?>

{{ csrf_field() }}

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label> {{ trans('messages.keyword_message') }} </label>
            <textarea name="message" id="message" rows="10" cols="40" class="form-control"></textarea>
            <input type="hidden" id="ticketid" name="ticketid" value="{{ $ticket_problem->random_tid }}">
            <br>
            <input type="file" id="image" name="image" class="form-control">
        </div>
    </div>

    

    <div class="col-md-4">
        <div class="form-group"> 
        <label> {{ trans('messages.keyword_ticket_status') }}: </label>
        <div class="switch">
            <input value="1" <?php if($ticket_problem->ticket_status == 0) echo "checked"; ?> class="" type="checkbox" name="classic" id="status" name="status">
            <label for="status"></label>
        </div>
        </div>
    </div>
    <br>
</div>

<button id="reply" type="button" class="btn btn-warning" <?php if($ticket_problem->ticket_status == 0) echo "disabled"; ?> >{{trans('messages.keyword_send')}}</button>

<a href="{{ url('tickets')}}" id="cancel" name="cancel" class="btn btn-danger">{{trans('messages.keyword_clear')}}</a>

<br><br>
<div class="row">
    <div class="col-md-8">

        <div class="myproblem">
            <div id="msg"> 
                <p style="font-size: 18px;">{{ $ticket_problem->path }}</p>
                <p style="text-align: right;font-size: 10px;">
            <?php            
                $date = date('d-m-Y H:i:s', strtotime($ticket_problem->created_at));                     
            ?>  {{ $date }} </p>
            </div>
        </div>
        <div class="hidden" id="hidden">
            <div class="col-md-8" >
                <p> {{ $ticket_problem->problem }} </p>    
            </div>
            <div class="col-md-4">
                <img src="{{ asset('storage/app/images/problems/'.$ticket_problem->image)}}" height="150" width="150">
            </div>
        </div>
        
        <div class="reply">
        <?php   if(isset($ticket_reply)){ 
                foreach ($ticket_reply as $value) { ?>
                <div id="<?php if($value->user_id == Auth::user()->id) echo 'msg1'; else echo 'msg';?>"> <?php echo $value->reply;

                $date = date('d-m-Y H:i:s', strtotime($value->created_at));
                echo $date; ?> </div>

        <?php } } ?>

        </div>
        <div class="append"></div>
    </div>
</div>

<script type="text/javascript">
    
CKEDITOR.replace('message');

$(document).ready(function () { 

    $('.myproblem').on("click", function() {
        var className = $('#hidden').attr('class');
        if(className){
            $("#hidden").removeClass("hidden");    
        } else {
             $("#hidden").addClass("hidden");
        }
    });


    $('#status').on("change", function() {

        if($(this).prop("checked") == true){
            $('#reply').prop('disabled', true)
        }
        else if($(this).prop("checked") == false){
            $('#reply').prop('disabled', false)
        }
        

        var ticketid = $('#ticketid').val();
        var _token = $('input[name="_token"]').val();
        var status = $("#status").is(':checked') ? 0 : 1;

        $.ajax({
            type:'POST',
            data:{ 'ticketid':ticketid, 'status':status, '_token':_token },
            url:'{{ url("ticket/status/update") }}',
            success:function( data ){
                // console.log(data);
            }
        });

    });

    $("#reply").on("click", function() {
    
        var message = CKEDITOR.instances['message'].getData();
        var ticketid = $('#ticketid').val();
        var _token = $('input[name="_token"]').val();
        var image =  $('#image').val().split('\\').pop();

        $.ajax({
            type:'POST',
            data:{ 'ticketid': ticketid, 'message': message, '_token' : _token, 'image': image },
            url:'{{ url("/store/reply") }}',
            success:function( data ){
                console.log(data);
                var reply = JSON.parse(data);
                $(".append").attr('id', 'msg1');
                $( ".append" ).append(reply.reply +" "+ reply.created_at);
                $('#message').val('');
                CKEDITOR.instances['message'].setData('');
                // console.log(reply.reply + " " + reply.created_at);
            }
        });
    });
});

</script>

@endsection