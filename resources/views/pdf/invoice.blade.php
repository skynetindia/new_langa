<style>
@font-face {
    font-family: 'nexa_lightregular';
    src: url('fonts/nexa_light-webfont.woff2') format('woff2'),
         url('fonts/nexa_light-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}
@font-face {
    font-family: 'nexa_boldregular';
    src: url('fonts/nexa_bold-webfont.woff2') format('woff2'),
         url('fonts/nexa_bold-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}
body {
   font-family: 'nexa_lightregular';
   font-weight: normal;
   color:#000;
}
strong, bold{
	 font-family: 'nexa_boldregular';
	  font-weight: normal;
}
.main-wrapper {
  background: white;
  margin: 0 auto;
  margin-bottom: 0.5cm;
 
  width: 21cm; 
}
</style>

<table class="main-wrapper" width="" cellpadding="0" cellspacing="0" align="center">
    <tbody>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td valign="top" style="width:50%;" align="left">
                            <img src="{{ (isset($arrSettings->pdflogo) && !empty($arrSettings->pdflogo)) ? asset('storage/app/images/logo/'.$arrSettings->pdflogo) : asset('images/pdfimages/logo.jpg')}}" width="100" height="100" alt="Logo"/>
                        </td>
                        <td valign="top" style="color:#000; font-size:12px;" align="right">
                            <?php echo nl2br($ente_DA->sedelegale);?>
                        </td>
                    </tr>
                </table>        
            </td>
        </tr>               
        <tr>
            <td style="border-bottom:2px solid #000;border-top:2px solid #000;text-align:center;margin:0px;  padding:7px; font-size:11px;">
                <p style=""><?php 
                if($tranche->tipofattura == 0) {
                    echo $tipofattura = strtoupper(trans('messages.keyword_sales_invoice'));
                } 
                else {
                    echo $tipofattura = strtoupper(trans('messages.keyword_credit_note'));
                } 
                ?> <b>{{$tranche->idfattura}}</b> {{strtoupper(trans('messages.keyword_issue_of_the'))}} <b>{{$tranche->emissione}}</b> {{strtoupper(trans('messages.keyword_on_the_base'))}} <b>{{$tranche->base}}</b></p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 0px 5px;">
                    <table style="margin:0 auto; border:2px solid #000;" width="100%" cellspacing="0" cellpadding="0" align="center">
                    <tbody><tr>
                        <td width="50%" valign="middle" align="left" style="border-right: 2px solid #000;">
                            <table width="100%" cellspacing="0" cellpadding="0" style="padding:10px 6px;">
                                <tbody><tr>
                                    <td style="font-size:12px; border-bottom:2px solid #000; padding-bottom:5px;"><b>{{strtoupper(trans('messages.keyword_registered_office'))}} {{strtoupper(trans('messages.keyword_client'))}}</b></td>
                                </tr>
                                <tr>
                                    <td style="font-size:12px; padding-top:10px;"><?php echo nl2br($ente_A->sedelegale);?></td>
                                </tr>
                            </tbody></table>
                         </td>
                         
                       <td width="50%" valign="middle" align="left" style="vertical-align:top;" >
                            <table width="100%" cellspacing="0" cellpadding="0" style="padding:10px 6px;">
                                <tbody>
                                <tr>
                                    <td style="font-size:12px; border-bottom:2px solid #000; padding-bottom:5px;"><b>{{strtoupper(trans('messages.keyword_shipping_address'))}}</b></td>
                                </tr>
                                <tr>
                                    <td style="font-size:12px; padding-top:10px;">{{$tranche->indirizzospedizione}}</td>
                                </tr>                            
                            </tbody></table>
                         </td>                         
                    </tr>
                </tbody></table>
            </td>            
        </tr>
        <tr>
            <td style="font-size:12px; padding-top:28px; line-height:25px;">
                {{trans('messages.keyword_current_document')}} <b>EUR(€)</b><br/>
                {{trans('messages.keyword_payment_methods')}}: <span style="border-bottom:2px dotted #323232; padding:0px 15px;"><b>{{$tranche->modalita}}</b></span> {{trans('messages.keyword_with_the_disposal_of')}} <span style="color:#f38400; border-bottom:2px dotted #323232; padding:0px 15px;"><b>{{$tranche->datascadenza}}</b></span> {{trans('messages.keyword_in_favor_of_companies_on_iban')}} <span style="border-bottom:2px dotted #323232; padding:0px 15px;"><b>{{$tranche->iban}}</b></span><br/>
                @if($tranche->percentuale == 0)
                <p style="margin:0px; font-size:15px; padding-top:8px; padding-bottom:0px;">{{trans('messages.keyword_income_for_a_euro_concorded_trade')}} <b>{{$tranche->testoimporto}}</b></p>
                @else
                <p style="margin:0px; font-size:15px; padding-top:8px; padding-bottom:0px;">{{trans('messages.keyword_invoice_on_total_work_of')}} <b>{{$tranche->percentuale.'%'}}</b></p>
                @endif

                @if($tranche->tipo == 1)
                    <p style="margin:0px; font-size:15px; padding-top:8px; padding-bottom:0px;">{{trans('messages.keyword_renewal_for')}} {{$tranche->frequenza}} {{trans('messages.keyword_date_from_date_emission')}}</p>
                @endif
                <!--FATTURA INVIA AI SENSI DELL'ARTICOLO 21 COMMA 4 DPR 633/72 NOTE: <b><span style="border-bottom:2px dotted #323232;padding:0px 15px;">ESENTE IVA ART. 7</span></b>-->                
            </td>
        </tr>
        <tr>
            <td>
                <table style="margin-top:15px; border:2px solid #000; font-size:12px;" width="100%" cellspacing="0" cellpadding="0" align="center">
                    <tbody>
                        <tr>
                            <th style="border-bottom:2px solid #000; border-right:2px solid #cdcdcd; padding:3px 7px;">{{strtoupper(trans('messages.keyword_references'))}}</th>
                            <th style="border-bottom:2px solid #000; border-right:2px solid #cdcdcd; padding:3px 7px;">{{strtoupper(trans('messages.keyword_description'))}}</th>
                            <th style="border-bottom:2px solid #000; border-right:2px solid #cdcdcd; padding:3px 7px;">{{strtoupper(trans('messages.keyword_qty'))}}</th>
                            <th style="border-bottom:2px solid #000; border-right:2px solid #cdcdcd; padding:3px 7px;">{{strtoupper(trans('messages.keyword_subtotal'))}}</th>
                            <th style="border-bottom:2px solid #000;  padding:3px 7px;">{{strtoupper(trans('messages.keyword_total'))}}</th>
                        </tr>
                        @foreach($corpofattura as $corpofatturas)
                        <tr>
                            <td style="border-right:2px solid #cdcdcd; padding:3px 7px;">{{$corpofatturas->ordine}}</td>
                            <td style=" border-right:2px solid #cdcdcd; padding:3px 7px;">{{$corpofatturas->descrizione}}</td>
                            <td style=" border-right:2px solid #cdcdcd; padding:3px 7px;">{{$corpofatturas->qta}}</td>
                            <td style=" border-right:2px solid #cdcdcd; padding:3px 7px;"><?php echo number_format($corpofatturas->subtotale,2)?></td>
                            <td style="  padding:3px 7px;"><?php echo number_format($corpofatturas->netto,2)?></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    <tr><?php 
        if($tranche->peso == "") $tranche->peso = 0;
        if($tranche->netto == "") $tranche->netto = 0;
        if($tranche->scontoaggiuntivo == "") $tranche->scontoaggiuntivo = 0;
        if($tranche->imponibile == "") $tranche->imponibile = 0;
        if($tranche->prezzoiva == "") $tranche->prezzoiva = 0;
        if($tranche->percentualeiva == "") $tranche->percentualeiva = 0;
        if($tranche->dapagare == "") $tranche->dapagare = 0;
        ?><td>
                <table style="margin-top:15px; border:2px solid #000; font-size:12px;" width="100%" cellspacing="0" cellpadding="0" align="center">
                    <tbody>
                        <tr>
                            <td style="border-bottom:2px solid #000;padding:3px 7px;">{{strtoupper(trans('messages.keyword_weight'))}}</td>
                            <td style="border-bottom:2px solid #000;padding:3px 7px;">{{strtoupper(trans('messages.keyword_net_price'))}}</td>
                            <td style="border-bottom:2px solid #000;padding:3px 7px;">{{strtoupper(trans('messages.keyword_additional_discount'))}}</td>
                            <td style="border-bottom:2px solid #000;padding:3px 7px;">{{strtoupper(trans('messages.keyword_taxable'))}}</td>
                            <td style="border-bottom:2px solid #000;padding:3px 7px;">{{strtoupper(trans('messages.keyword_vat'))}}</td>
                            <td style="border-bottom:2px solid #000;padding:3px 7px;">%</td>
                            <td style="border-bottom:2px solid #000;padding:3px 7px;">{{strtoupper(trans('messages.keyword_to_pay'))}}</td>
                        </tr>
                        <tr>
                            <td  style="padding:3px 7px;">{{number_format((float)$tranche->peso,2)}}</td>
                            <td  style="padding:3px 7px;">{{number_format((float)$tranche->netto,2)}}</td>
                            <td  style="padding:3px 7px;">{{number_format((float)$tranche->scontoaggiuntivo,2)}}</td>
                            <td  style="padding:3px 7px;">{{number_format((float)$tranche->imponibile,2)}}</td>
                            <td  style="padding:3px 7px;">{{number_format((float)$tranche->prezzoiva,2)}}</td>
                            <td  style="padding:3px 7px;">{{$tranche->percentualeiva}}</td>
                            <td  style="padding:3px 7px;">{{number_format((float)$tranche->dapagare,2)}} €</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
 </tbody>    
</table>