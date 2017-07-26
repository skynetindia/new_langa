<div class="panel panel-default">
    <div class="panel-body">
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('costi/json');?>" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="id" data-sortable="true">
            {{ ucwords(trans('messages.keyword_code')) }} </th>
            <th data-field="ente" data-sortable="true">
            {{ ucwords(trans('messages.keyword_entity')) }} </th>
            <th data-field="oggetto" data-sortable="true">
            {{ ucwords(trans('messages.keyword_object')) }} </th>
            <th data-field="costo" data-sortable="true"> 
            {{ ucwords(trans('messages.keyword_cost')) }} </th>
            <th data-field="datainserimento" data-sortable="true">
            {{ ucwords(trans('messages.keyword_insertion_date')) }} </th>
        </thead>
    </table>
    </div>
</div>