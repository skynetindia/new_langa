<div class="bg-white">
    <div class="image_upload_div" id="droptarget" ondrop="drop(event)" ondragover="allowDrop(event)">  
       <p> {{trans('messages.keyword_drag_module_here')}} </p>
    </div>
</div>
<div class="dropdown-screen">
    <div class="row">
    	<div class="col-md-12 col-sm-12 col-xs-12"><?php $arrmodules = getModules(); ?>
        @foreach($arrmodules as $key => $val)
            <div class="ui-widget-content" valid="{{$val->id}}" ondragstart="dragStart(event)" draggable="true" id="dragtarget_{{$val->id}}">
                {{trans('messages.'.$val->phase_key)}}
            </div>
        @endforeach                                                    
        </div>
    </div>
</div>
<style>
/*#droptarget {
float: left; 
width: 200px; 
height: 35px;
margin: 55px;
margin-top: 155px;
padding: 10px;
border: 1px solid #aaaaaa;
}*/
</style>
<script type="text/javascript">
jq223 = jQuery.noConflict(false);    
function dragStart(event) {
    event.dataTransfer.setData("Text", event.target.id);
	  event.target.style.opacity = "1";
}

function allowDrop(event) {
    event.preventDefault();    
    /*event.target.style.border = "4px dotted #f37f0d";*/
}
function drop(event) {
    event.preventDefault();
    var data = event.dataTransfer.getData("Text");
    var module_id = $("#"+data).attr('valid');    
    event.target.appendChild(document.getElementById(data));       
    widgetupdate('add',module_id);
}
function widgetupdate(action,module_id){
    if(action=='delete'){
     var confirmation = confirm("{{trans('messages.keyword_are_you_sure?')}}");
        if (!confirmation)            
            return confirmation ;
    }
     $.ajax({
        type:'POST',
        data: { 'module_id': module_id,'action':action, '_token': '{{ csrf_token() }}' },
        url: '{{ url('dashboard/widgetupdate') }}',
        success:function(data) {
            if(data == 'success'){
                $("#droptarget").html("Drag Module Here");                        
                window.location.reload(true);
            }
        }
    });
}
</script>