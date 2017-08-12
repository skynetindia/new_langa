@extends('layouts.app')
@section('content')

<h1>{{ trans('messages.keyword_optional_budget_llist') }}: <strong>{{$preventivo->oggetto}}</strong></h1>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<a class="btn btn-info" onclick="window.close();" title=" {{ trans('messages.keyword_back_to_project') }}"><span class="fa fa-arrow-left"></span></a>

<br>
<form action="{{url('/estimates/optional/aggiorna') . '/' . $preventivo->id}}" method="post">
    {{ csrf_field() }}

<!-- hide Salva button  -->

   <!--  <div class="row">
        <div class="col-md-12">
            <input type="submit" class="btn btn-warning btn-sm" value="Salva">
        </div>
    </div> -->
    <div class="table-responsive">
        <table class="table table-bordered">
        <?php $i = 1;  ?>
            @foreach($optional as $opt)
                <tr>   
                    <input type="hidden" name="ord[]" value="{{$opt->ordine}}" class="form-control">
                    <td>
                       {{ trans('messages.keyword_object') }}: <input type="text" name="oggetti[]" value="{{$opt->oggetto}}" class="form-control">
                    </td>
                    <td>
                       {{ trans('messages.keyword_description') }}:                                                                                  <input type="text" name="desc[]" value="{{$opt->descrizione}}" class="form-control">
                    </td>
                    <td>
                       {{ trans('messages.keyword_qty') }}: <input type="number" name="qt[]" value="{{$opt->qta}}" class="form-control">
                    </td>
                    <td>
                       {{ trans('messages.keyword_unit_price') }}: <input type="number" step=any name="pru[]" value="{{$opt->prezzounitario}}" class="form-control">
                    </td>
                    <td>
                       {{ trans('messages.keyword_subtotal') }}: <input type="number" name="tot[]" step=any value="{{$opt->totale}}" class="form-control">
                    </td>

                    <td>
                       {{ trans('messages.keyword_cyclicity') }}: 

                       <select name="cicli[]" class="form-control valid">

                        <?php foreach($frequency as $key => $frequencyval){ 
                            if($opt->Ciclicita == $frequencyval->id){  ?>

                                <option value="{{ $frequencyval->id }}" selected="selected"> 
                                    {{ $frequencyval->rinnovo }} 
                                    {{ trans('messages.keyword_days') }}  
                                </option>
                        <?php } else { ?>
                                <option value="{{ $frequencyval->id }}"> 
                                    {{ $frequencyval->rinnovo }} 
                                    {{ trans('messages.keyword_days') }}  
                                </option>
                        <?php } } ?>
                    </td>

                    <td>
                        {{ trans('messages.keyword_asterisca') }}:                        
                        <div class="switch">

                            @if($opt->asterisca == 1)
                            <input type="checkbox" name="ast[]" id="ast" checked="checked">
                            @else 
                            <input type="checkbox" name="ast[]" id="ast"> 
                            @endif

                            <label for="ast"></label>
                        </div>
                    </td>

                    <td>
                        <a onclick="return confirm('{{ trans('messages.keyword_sure') }}');" href="{{url('/preventivi/optional/elimina') . '/' . $opt->id}}" class="btn btn-danger">{{ trans('messages.keyword_delete_optional') }}</a>
                    </td>
                </tr>
                <?php $i++; ?>
            @endforeach
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="submit" class="btn btn-warning btn-sm" value="{{ trans('messages.keyword_save') }}">
        </div>
    </div>
</form>

@endsection