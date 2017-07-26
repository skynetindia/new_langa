<div class="pagination_invoice" id="pagination_invoice">
    <div class="row pagamentifolder">
    @foreach($groupdetails as $key => $groupValue)
        <div class="col-md-2">  
            <div class="form-group">
            	<div class="bg-white folder-wrap">
                <div class="text-right"><button id="edit" onclick="showGroupName('{{$groupValue->groupid}}');" class="btn btn-warning text-right" name="remove" title="">
                    <i class="fa fa-pencil"></i>
                </button>
                <button id="delete" onclick="deletegroup('{{$groupValue->groupid}}');" class="btn btn-danger text-right" name="remove" title="">
                    <i class="fa fa-trash"></i>
                </button>
                </div><?php
                $neededObjects = array_filter(
                        $invoiceDetails,
                        function ($e) use($groupValue) {
                            return $e->id_disposizione == $groupValue->id;
                        }
                    );        
                $invoicedetaillink = (count($neededObjects) > 0) ? 'href='.url('pagamenti/mostra/accounting/').'/'.$groupValue->id.'' : '';            
                ?>
            	<a {{$invoicedetaillink}}><img src="{{url('images/folder.jpg')}}">
                	<div class="dot-main"><?php                   
                    foreach ($neededObjects as $keyobj => $valueobj) {
                        ?><div class="dot-green" style="background-color: {{$valueobj->statoemotivo}}"></div><?php
                    }
                   
                    ?></div></a> 
                <label for="logo" id="lblgroupname_{{$groupValue->groupid}}" onDblClick="showGroupName('<?php echo $groupValue->groupid;?>');" >{{$groupValue->groupname}}</label>                
                <input type="text" name="groupnameupdate" class="groupnameTextbox form-control" id="groupnameupdate_{{$groupValue->groupid}}" value="{{$groupValue->groupname}}" style="display: none;">
            </div>
            </div>
            </div>
    @endforeach
    </div>    
    {{ $groupdetails->links() }}
</div>