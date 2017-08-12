<div class="panel panel-default">
    <div class="panel-body">
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('/pagamenti/tranche/json');?>" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="id" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_noprovision')) }} </th>
            <th data-field="idfattura" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_invoicenumber')) }} </th>
            <th data-field="ente" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_entity')) }}</th>
            <th data-field="nomequadro" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_picturename')) }}</th> 
            <th data-field="tipo" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_types')) }} </th>
            <th data-field="datainserimento" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_inserting')) }} </th>
            <th data-field="datascadenza" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_deadline')) }} </th>
            <th data-field="percentuale" data-sortable="true">%
            <th data-field="dapagare" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_topay')) }} </th>
            <th data-field="statoemotivo" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_emotional_state')) }} </th>
        </thead>
    </table>
    </div>
</div>

