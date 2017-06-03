@extends('adminHome')
@section('page')

@include('common.errors')
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<!-- ckeditor -->
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
<h1>{{trans('messages.keyword_entelist')}} </h1><hr>

<div class="table-responsive table-custom-design">
<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php if(isset($notification_id)){ echo url('/notification_id/detail/json/'.$notification_id); } else { echo url('/notification/detail/json'); } ?>" data-classes="table table-bordered" id="table">
    <thead>
    <th data-field="id" data-sortable="true"> {{trans('messages.keyword_entity')}}  </th>
    <th data-field="nome_azienda" data-sortable="true"> {{trans('messages.keyword_compname')}} </th>
    <th data-field="nome_referente" data-sortable="true"> {{trans('messages.keyword_refname')}} </th>
    <th data-field="settore" data-sortable="true"> {{trans('messages.keyword_sector')}}  </th>
    <th data-field="telefono_azienda" data-sortable="true"> {{trans('messages.keyword_comptele')}} </th>
    <th data-field="email" data-sortable="true"> {{trans('messages.keyword_email')}} </th>
    <th data-field="data_lettura" data-sortable="true"> {{trans('messages.keyword_readdatetime')}}  </th>
    <th data-field="comment" data-sortable="true"> {{trans('messages.keyword_comment')}}  </th>
    <th data-field="conferma" data-sortable="true"> {{trans('messages.keyword_confirm')}} </th>
    </thead>
</table>
</div>
@endsection
