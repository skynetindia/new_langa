@extends('adminHome')

@section('page')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>{{ trans('messages.keyword_editpack') }} </h1><hr>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<?php echo Form::open(array('url' => '/admin/tassonomie/update/pacchetto' . "/$pacchetto->id", 'files' => true, 'id'=>'package_editform', 'name'=>'package_editform')) ?>
	{{ csrf_field() }}
	<!-- colonna a sinistra -->
    <div class="row ">
	<div class="col-md-4 col-sm-12 col-xs-12">
        <div class="form-group">
		  <label for="code"> {{ trans('messages.keyword_code') }}  <span class="required">(*)</span></label>
		  <input value="{{ $pacchetto->code }}" class="form-control" type="text" name="code" id="code" placeholder=" {{ trans('messages.keyword_code') }}">
        </div>
		
		
	</div> 
	<!-- colonna centrale -->
	<div class="col-md-4 col-sm-12 col-xs-12">
        <div class="form-group">
		  <label for="label"> {{ trans('messages.keyword_name') }}  <span class="required">(*)</span></label>
		  <input value="{{ $pacchetto->label }}" class="form-control" type="text" name="label" id="label" placeholder=" {{ trans('messages.keyword_name') }}">
        </div>                
	</div>
	<!-- colonna a destra -->
	<div class="col-md-4 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="logo"> {{ trans('messages.keyword_logo') }} </label>
		  <?php echo Form::file('logo', ['class' => 'form-control']); ?>
        </div>
	</div>
      
      <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="department"> {{ trans('messages.keyword_department') }} </label>
            <select class="form-control" name="department" id="department">
                <option value="0">---Select---</option>
                @foreach($department as $keyd => $vald)
                <option value="{{$vald->id}}" <?php echo ($vald->id == $pacchetto->departments_id) ? 'selected' :'';  ?>>{{$vald->nomedipartimento}}</option>
                @endforeach
            </select>
        </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="description"> {{ trans('messages.keyword_description') }} </label>
            <textarea class="form-control" name="description" id="description">{{ $pacchetto->description }}</textarea>
        </div>
        </div>
      

        <div class="col-md-12">
            <div class="table-responsive">
                <label for="optional[]">{{ trans('messages.keyword_optional') }} </label>
                <table class="table table-bordered lblshow">
                    <tr>
                        <?php $check = true; ?>
                    @for($i = 0; $i < count($optional); $i++)
                        @if($i % 4 == 0)
                            </tr><tr>
                        @endif
                        <td class="ciao">
                            @foreach($optionalselezionati as $optsel)
                                @if($optsel->optional_id == $optional[$i]->id)
                                    <input checked type="checkbox" name="optional[]" id="optional<?php echo $optional[$i]->id; ?>" value="<?php echo $optional[$i]->id; ?>">
                                    <label for="optional<?php echo $optional[$i]->id; ?>"> <?php echo " " . $optional[$i]->label; ?></label>
                                    <?php $check = false; ?>
                                @endif
                            @endforeach
                            @if($check==true)
                                <input type="checkbox" name="optional[]" id="optional[]" value="<?php echo $optional[$i]->id; ?>"><label for="optional<?php echo $optional[$i]->id; ?>"><?php echo " " . $optional[$i]->label; ?></label>
                            @endif
                            <?php $check = true; ?>
                        </td>
                    @endfor
                    </tr>
                </table>
            </div>
        </div>    
        
	<div class="col-md-12">		
		<button type="submit" class="btn btn-warning"> {{ trans('messages.keyword_save') }} </button>
        <div class="space50"> </div>
	</div>
    </div>
    <div class="footer-svg">
        <img src="{{asset('images/ADMIN_TASSONOMIE-footer.svg')}}" alt="tassonomie">
    </div>
    <?php echo Form::close(); ?>  

<script>
$('.ciao').on("click", function() {
    $(this).children()[0].click();
});
</script>
<script type="text/javascript">
$(document).ready(function() {
 $("#package_editform").validate({            
            rules: {
                code: {
                    required: true
                },
                label: {
                    required: true
                }
            },
            messages: {
                code: {
                    required: "{{trans('messages.keyword_please_enter_package_code')}}"
                },
                label: {
                    required: "{{trans('messages.keyword_please_enter_a_name')}}"
                }
            }

        });
});
  
</script>
        
@endsection