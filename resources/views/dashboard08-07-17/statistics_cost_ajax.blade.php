<div class="panel panel-default">
        <div class="panel-body">
        <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('estimates/miei/confirmed');?>" data-classes="table table-bordered" id="table">
            <thead>
                <th data-field="id" data-sortable="true">{{trans('messages.keyword_no_estimate')}}</th>
                <th data-field="ente" data-sortable="true">{{trans('messages.keyword_entity')}}</th>
                <th data-field="oggetto" data-sortable="true">{{trans('messages.keyword_object')}}</th>
                <th data-field="data" data-sortable="true">{{trans('messages.keyword_execution_date')}}</th>
                <th data-field="valenza" data-sortable="true">{{trans('messages.keyword_expiry_date')}}</th>
                <th data-field="dipartimento" data-sortable="true">{{trans('messages.keyword_department')}}</th>
                <th data-field="finelavori" data-sortable="true">{{trans('messages.keyword_end_date_works')}}</th>
            </thead>
        </table>
    </div>
    </div>