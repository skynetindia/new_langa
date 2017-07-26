<div class="panel panel-default">
    <div class="panel-body">
        <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true"  data-show-columns="true" data-url="<?php echo url('enti/myenti/json'); ?>" data-classes="table table-bordered" id="table">
          <thead>
            <th data-field="id" data-sortable="true">{{trans('messages.keyword_id')}}</th>
            <th data-field="nomeazienda" data-sortable="true">{{trans('messages.keyword_company_name')}}</th>
            <th data-field="nomereferente" data-sortable="true">{{trans('messages.keyword_name')}}</th>
            <th data-field="settore" data-sortable="true">{{trans('messages.keyword_sector')}}</th>
            <th data-field="telefonoazienda" data-sortable="true">{{trans('messages.keyword_telephone_company')}}</th>
            <th data-field="email" data-sortable="true">{{trans('messages.keyword_email')}}</th>
            <th data-field="indirizzo" data-sortable="true">{{trans('messages.keyword_address')}}</th>
            <th data-field="responsabilelanga" data-sortable="true">{{trans('messages.keyword_responsible')}} LANGA</th>
            <th data-field="statoemotivo" data-sortable="true">{{trans('messages.keyword_emotional_state')}}</th>
            <th data-field="tipo" data-sortable="true">{{trans('messages.keyword_guy')}}</th>
           </thead>
        </table>
    </div>
</div>