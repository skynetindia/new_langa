@extends('layouts.app')
@section('content')

<div class="header-lst-img">
	<div class="header-svg text-left float-left">
        <img src="http://betaeasy.langa.tv/images/HEADER1_LT_ACCOUNTING.svg" alt="header image">
    </div>
    <div class="float-right text-right">
        	<h3>{{ trans('messages.keyword_banking_coordinates_services') }}  <strong>LANGA</strong></h3><hr>
    </div>
</div>

<div class="clearfix"></div>
<div class="height20"></div>


<h5>

<br><br>La fattura verrà generata dall'amministrazione <strong>LANGA</strong> al momento della chiusura di determinate lavorazioni del Team tecnico e potrà essere scaricata nella sezione dedicata alle sue <strong>Disposizioni</strong> / <strong>Fatture</strong>.<br><br>

Il formato della fattura fiscale potrà essere .jpg, .png o .pdf.<br><br><br>

<strong>DATI SOCIETARI FISCALI</strong><br><br><br>

<strong>Azienda</strong>: LANGA WEB INFORMATICA snc<br><br>
<strong>Sede legale</strong>: Via Coppa, 3/B Alba 12051 (CN)<br><br>
<strong>Banca</strong>: Unicredit Bank SpA<br><br>
<strong>Filale di</strong>: Piazza Michele Ferrero, Alba (CN)<br><br>
ABI 02008 CAB 22500 CONTO CORRENTE 000103796280<br><br>
<strong>IBAN</strong> IT26B 02008 22500 000103796280<br><br>

<strong>BIC/SWIFT:</strong> UNCRITM1CB1<br><br><br>

Nota bene: Si ricorda che in caso di pagamento con bonifico è necessario versare l’importo al netto delle eventuali commissioni bancarie.
</h5>

<div class="footer-svg">
  <img src="http://betaeasy.langa.tv/images/FOOTER2_RB_ACCOUNTING.svg" alt="footer enti image">
</div>

@endsection
