<div class="">
	<div class="">
        <div class="fixed-table-container" style="padding-bottom: 0px;">
            <div class="fixed-table-body">
        <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-classes="table table-bordered" id="table" class="table table-bordered">
            <thead>
                <tr>
                <th style="" data-field="id" tabindex="0"><div class="th-inner sortable both">{{trans('messages.keyword_id')}}</div><div class="fht-cell"></div></th>
                <th style="" data-field="nomeazienda" tabindex="0"><div class="th-inner sortable both">{{trans('messages.keyword_comment')}}</div><div class="fht-cell"></div></th>
                <th style="" data-field="nomereferente" tabindex="0"><div class="th-inner sortable both">{{trans('messages.keyword_date')}}</div><div class="fht-cell"></div></th>
                @if(checkpermission('3', '18', 'scrittura','true'))
                <th style="" data-field="nomereferente" tabindex="0"><div class="th-inner sortable both">{{trans('messages.keyword_action')}}</div><div class="fht-cell"></div></th>
                @endif
                </tr>
        </thead>
        <tbody>
            @foreach($comments as $key => $val)
            <tr id="commentList_{{$val->id}}">            
                <td>{{$val->id}}</td>            
                <td>{{$val->comments}}</td>            
                <td>{{dateFormate($val->date)}}</td>            
                @if(checkpermission('3', '18', 'scrittura','true'))
                 <td>               
                    <a class="btn btn-danger" id="btnDelete" onclick="deleteComment('{{$val->id}}')" ><i class="fa fa-trash"></i></a>                
                </td>            
                @endif
            </tr>
            @endforeach                
        </tbody>
        </table>
        </div>
    </div>
    </div>
</div>    
<script>
function deleteComment(commentid){
	var urlD = '<?php echo url('/project/deleteprocessingcomment'); ?>';
	$.ajax({
		url: urlD,
		type: 'post',
		data: { "_token": "{{ csrf_token() }}",commentid: commentid },
		success:function(data) {                                        
			$("#commentList_"+commentid).remove();
		}
	});                            
}

var selezione = [];
var indici = [];
var n = 0;
$('#table').on('click-row.bs.table', function (row, tr, el) {
	var cod = /\d+/.exec($(el[0]).children()[0].innerHTML);
	if (!selezione[cod]) {
         $('#table tr.selected').removeClass("selected");       
		$(el[0]).addClass("selected");
		selezione[cod] = cod;
		indici[n] = cod;
		n++;
	} else {
		$(el[0]).removeClass("selected");
		selezione[cod] = undefined;
		for(var i = 0; i < n; i++) {
			if(indici[i] == cod) {
				for(var x = i; x < indici.length - 1; x++)
					indici[x] = indici[x + 1];
				break;	
			}
		}
		n--;
        $('#table tr.selected').removeClass("selected");       
        $(el[0]).addClass("selected");
        selezione[cod] = cod;
        indici[n] = cod;
        n++;
	}
});

</script>
