<div class="panel panel-default">
    <div class="panel-body">
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('progetti/miei/json'); ?>" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="codice" data-sortable="true">{{ucwords(trans('messages.keyword_noproject'))}}</th>
            <th data-field="ente" data-sortable="true">{{ucwords(trans('messages.keyword_entity'))}}</th>
            <th data-field="nomeprogetto" data-sortable="true">{{ucwords(trans('messages.keyword_projectname'))}}</th>
            <th data-field="da" data-sortable="true">{{ucwords(trans('messages.keyword_from'))}}</th>
            <th data-field="datainizio" data-sortable="true">{{ucwords(trans('messages.keyword_startdate'))}}</th>
            <th data-field="datafine" data-sortable="true">{{ucwords(trans('messages.keyword_enddate'))}}</th>
            <th data-field="progresso" data-sortable="true">{{ucwords(trans('messages.keyword_progress'))}}</th>
            <th data-field="statoemotivo" data-sortable="true">{{ucwords(trans('messages.keyword_emotional_state'))}}</th>
        </thead>
    </table>
    </div>
</div>
