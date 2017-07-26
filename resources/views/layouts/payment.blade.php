<h1> Your Payment is Confirm. </h1>
<hr>

<div class="row">
	<div class="col-md-6">
		<p>
        <b> {{ $reference->nomereferente }} </b> {{ trans('messages.keyword_of') }} {{ $reference->nomeazienda }}<br>
        
        {{ $reference->sedelegale }} <br><br>
               
    </p>
  	</div>

  	<div class="col-md-6">
      	 <p>
            <b> {{ trans('messages.keyword_date') }}: @isset($quote->created_at) </b>
            {{  Carbon\Carbon::parse($quote->created_at)->format('d/m/Y') }} @endisset  <br>
            <b> {{ trans('messages.keyword_quote') }}: </b> @isset($quote->id) #{{ $quote->id }} @endisset <br>
            <b> {{ trans('messages.keyword_agent') }} / {{ trans('messages.keyword_retailer') }}: </b> {{ $reference->nomereferente }} <br>
            <b> {{ trans('messages.keyword_contacts') }}: </b> 
            {{ $reference->telefonoresponsabile }} / {{ $reference->email }}
          </p>
  	</div>
</div>

<div class="row">
	<div class="col-md-6">
    	<h3> <b> {{ trans('messages.keyword_from') }}  </b> </h3>
       <b> {{ trans('messages.keyword_responsible') }} Easy Langa: </b> {{ $departments->nomereferente }} <br>
          {{ $departments->nomedipartimento }} <br>
          {{ $departments->indirizzo }} <br>
          {{ $departments->telefonodipartimento }} / {{ $departments->cellularedipartimento }} <br>
          {{ $departments->email }} / {{ $departments->emailsecondaria }} <br>
  	</div>

    <div class="col-md-6">
        <h3> <b> {{ trans('messages.keyword_to') }}  </b> </h3> 
         <b> {{ trans('messages.keyword_contact') }}: </b> {{ $order->nome_azienda }} <br>
           {{ $order->indirizzo }} <br>
          {{ $order->telefono }} <br>
          {{ $order->email }} <br>
  	</div>
</div>