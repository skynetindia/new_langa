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
<h1>Elenco Enti</h1>
<hr>
<div class="table-responsive">
<table class="selectable table table-hover table-bordered grey-heading" id="table" cellspacing="0" cellpadding="0">
  <thead>
    <tr> 
      
      <!-- Intestazione tabella dipartimenti -->
      
      <th>ente</th>
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
  
  @if(isset($detail_notifica))
  
  @foreach($detail_notifica as $detail_notifica)
  <tr>
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
  
  @else <?php echo "<h3 style='text-align:center;'>Nessuno utenti trovato</h3>"; ?> @endif
    </tbody>
  
</table>
</div>
<div class="footer-svg">
	<img src="{{asset('images/ADMIN_AVVISI-footer.svg')}}" alt="avvisi">
</div>
@endsection 