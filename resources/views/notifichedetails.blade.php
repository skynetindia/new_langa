@extends('adminHome')
@section('page')

@include('common.errors')

<style>
tr:hover {
  background: #f39538;
}
.selected {
  font-weight: bold;
  font-size: 16px;
}
th {
  cursor: pointer;
}
li label {
  padding-left: 10px;
}
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 3px 15px;
    padding-bottom: 6px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
    border-radius: 4px;
}
.button2 { /* blue */
    background-color: white;
    color: black;
    border: 2px solid #337ab7;
}

.button2:hover {
    background-color: #337ab7;
    color: white;
}

.button3 { /* red */
    background-color: white;
    color: black;
    border: 2px solid #d9534f;
}

.button3:hover {
    background-color: #d9534f;
    color: white;
}
</style>

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<!-- ckeditor -->
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<h1>Elenco Enti</h1><hr>

<div class="table-responsive table-custom-design">

<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php if(isset($notification_id)){ echo url('/notifica/detail/json/'.$notification_id); } else { echo url('/notifica/detail/json'); } ?>" data-classes="table table-bordered" id="table">
    <thead>
    <th data-field="id" data-sortable="true">ente </th>
    <th data-field="nome_azienda" data-sortable="true">Nome azienda </th>
    <th data-field="nome_referente" data-sortable="true">Nome referente </th>
    <th data-field="settore" data-sortable="true">Settore </th>
    <th data-field="telefono_azienda" data-sortable="true">Telefono azienda </th>
    <th data-field="email" data-sortable="true">Email </th>
    <th data-field="data_lettura" data-sortable="true">Data ora di Lettura </th>
    <th data-field="comment" data-sortable="true">Comment </th>
    <th data-field="conferma" data-sortable="true">Conferma </th>

    </thead>

</table>

</div>



<!-- <div class="table-responsive">

<table class="selectable table table-hover table-bordered" id="table" cellspacing="0" cellpadding="0">

<thead>

<tr style="background: #999; color:#ffffff"> -->

<!-- Intestazione tabella dipartimenti -->

<!-- <th>ente</th>

<th>Nome azienda</th>

<th>Nome referente</th>

<th>Settore</th>

<th>Telefono azienda</th>

<th>Email</th>

<th>Data ora di Lettura</th>

<th>Comment</th>

<th>Conferma</th>

</tr>

</thead>

<tbody>
 -->
<!-- @if(isset($detail_notifica))

    @foreach($detail_notifica as $detail_notifica) -->

     <!--  <tr>

        <td>{{ $detail_notifica->id }}</td>

        <td>{{ $detail_notifica->nome_azienda }}</td>

        <td>{{ $detail_notifica->nome_referente }}</td>

        <td>{{ $detail_notifica->settore }}</td>

        <td>{{ $detail_notifica->telefono_azienda }}</td>

        <td>{{ $detail_notifica->email }}</td>

        <td>{{ $detail_notifica->data_lettura }}</td>

        <td>{{ $detail_notifica->comment }}</td>

        <td>{{ $detail_notifica->conferma }}</td>
      
      </tr>

    @endforeach

@else  -->
  
  <?php //echo "<h3 style='text-align:center;'>Nessuno utenti trovato</h3>"; ?>

<!-- @endif

</tbody>

</table> -->
  

@endsection
