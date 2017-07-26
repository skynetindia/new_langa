<table>
        <tr>
            <td style="padding:0.53cm 1cm 0;">
                    <table style="margin:0 auto;" width="100%" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left" valign="middle" width="50%">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="font-size:0.3496028cm;"><strong>{{isset($ente_DA->nomereferente) ? $ente_DA->nomereferente : ''}}</strong> di {{isset($ente_DA->nomeazienda) ? $ente_DA->nomeazienda : '' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:0.282222cm; padding-top:0.35cm">{{isset($ente_DA->indirizzo) ? $ente_DA->indirizzo : ''}}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:0.282222cm; padding-top:0.40cm">P.iva {{isset($ente_DA->piva) ? $ente_DA->piva : ''}}<br>C.F, {{isset($ente_DA->cf) ? $ente_DA->cf : ''}}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:0.282222cm; padding-top:0.40cm">e-mail: {{isset($ente_DA->email) ? $ente_DA->email : ''}} | web: www.langa.tv <br> mobile: {{isset($ente_DA->telefonoazienda) ? $ente_DA->telefonoazienda : ''}}</td>
                                </tr>                            
                            </table>
                        </td>
                        <td align="left" valign="middle" width="50%">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="font-size:0.3496028cm;">Data: {{$preventivo->data}}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:0.59760556cm; padding-top:0.40cm, padding-bottom:0.25cm">PREVENTIVO <span style="font-size:0.97331389cm; color:#f28006;">{{':' . $preventivo->id . '/' . $preventivo->anno}}</span> </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0.282222cm; background:rgba(0, 0, 0, 0) url({{asset('images/pdfimages/contact-bg.jpg')}}) no-repeat scroll left top / 100% auto; height:1.64cm; width:7.63cm; padding: 0.4cm; line-height:1.5;" valign="top">
                                    e-mail: manenti202@langa.tv | web: www.langa.tv <br> mobile: +39 346 6133112</td>
                                </tr>                            
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:0cm 1cm;">
                <table style="margin:0 auto;" width="100%" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:0.98cm; background-color:#34393d; font-size:0.48965556cm; color:#fff; width:49.9%; vertical-align:middle; padding-left:0.25cm;"> <strong>DA </strong></td>
                        <td width="0.2%" style="background-color:#fff">&nbsp;  </td>
                        <td style="height:0.98cm; background-color:#34393d; font-size:0.48965556cm; color:#fff; width:49.9%; vertical-align:middle; padding-left:0.25cm;"> <strong>A </strong></td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:0.3cm 0;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td valign="middle" style="padding: 0 0.45cm;">
                                    <img src="{{asset('images/pdfimages/langa-web.jpg')}}" alt="langa web" style="width:1.74cm; display:block;">
                                    </td>
                                    <td style="font-size:0.282222cm; color:#34393d; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff;" valign="middle">
                                        Responsabile Easy LANGA: {{ $owner->nomereferente}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0.282222cm; color:#34393d; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff;" valign="middle">
                                        {{ $owner->nomedipartimento}}
                                    </td>
                                </tr>
                                 <tr>
                                    <td style="font-size:0.282222cm; color:#34393d; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff;" valign="middle"><?php 
                                        $address = (string)$owner->indirizzo;
                                        echo $string = (strlen($address) > 47) ? substr($address,0,47).'...' : $address;
                                    ?></td>
                                </tr>
                                 <tr>
                                    <td style="font-size:0.282222cm; color:#34393d; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.0cm solid #fff;" valign="middle">
                                        {{$owner->telefonodipartimento.' / '.$owner->cellularedipartimento}}
                                    </td>
                                </tr>
                                 <tr>
                                    <td style="font-size:0.282222cm; color:#34393d; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff;" valign="middle">
                                    {{ $owner->email.' / '.$owner->emailsecondaria }}
                                    </td>
                                </tr>
                            </table>
                            
                        </td>
                        <td>&nbsp;</td>
                       <td valign="top" style="padding:0.3cm 0;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td valign="middle" style="padding: 0 0.45cm;">
                                    <img src="{{asset('images/pdfimages/hotel-griselda.jpg')}}" alt="hotel griselda" style="width:1.74cm; display:block;">
                                    </td>
                                    <td style="font-size:0.282222cm; color:#34393d; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff;" valign="middle">
                                        Referente: {{$ente->nomereferente}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0.282222cm; color:#34393d; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff;" valign="middle">
                                        {{$ente->nomeazienda}}
                                    </td>
                                </tr>
                                 <tr>
                                    <td style="font-size:0.282222cm; color:#34393d; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff;" valign="middle"><?php                                         
                                        $address = (string)$ente->indirizzo;
                                       echo $string = (strlen($address) > 47) ? substr($address,0,47).'...' : $address;
                                    ?></td>
                                </tr>
                                 <tr>
                                    <td style="font-size:0.282222cm; color:#34393d; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.0cm solid #fff;" valign="middle">
                                       {{ $ente->telefonoazienda . ' / ' . $ente->cellulareazienda}}
                                    </td>
                                </tr>
                                 <tr>
                                    <td style="font-size:0.282222cm; color:#34393d; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff;" valign="middle"> {{ $ente->email}}                                        
                                    </td>
                                </tr>
                            </table>                            
                        </td>                    
                    </tr>                    
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:0cm 1cm;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="background-color: #34393d;height: 0.98cm; padding: 0 0.45cm; font-size:0.282222cm; color:#fff; vertical-align: middle; "> Q.ta’</td>
                            <td style="background-color: #34393d;height: 0.98cm; padding: 0 0.45cm; font-size:0.282222cm; color:#fff; vertical-align: middle;"> OGGETTO</td>
                            <td style="background-color: #34393d;height: 0.98cm; padding: 0 0.45cm; font-size:0.282222cm; color:#fff; vertical-align: middle;"> DESCRIZIONE</td>
                            <td style="background-color: #34393d;height: 0.98cm; padding: 0 0.45cm; font-size:0.282222cm; color:#fff; vertical-align: middle;"> FREQ.</td>
                            <td style="background-color: #34393d;height: 0.98cm; padding: 0 0.45cm; font-size:0.282222cm; color:#fff; vertical-align: middle;"> PREZZO UNITARIO</td>
                            <td style="background-color: #34393d;height: 0.98cm; padding: 0 0.45cm; font-size:0.282222cm; color:#fff; vertical-align: middle;"> SUBTOTALE</td>
                       </tr>                       
                       @foreach($optional_preventivi as $optional_preventivi_val)                       
                       <tr>
                            <td style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff; text-align:center" valign="middle">{{$optional_preventivi_val->qta}}</td>
                            <td style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff;" valign="middle">{{$optional_preventivi_val->oggetto}}</td>
                            <td style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff;" valign="middle">{{$optional_preventivi_val->descrizione}}</td>
                            <td style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff; text-align:center" valign="middle"><?php echo preg_replace('/\s+/', '_', $optional_preventivi_val->Ciclicita); ?></td>
                            <td style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff; text-align:center" valign="middle">{{number_format($optional_preventivi_val->prezzounitario,2)}}</td>
                            <td style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff; text-align:center" valign="middle">{{number_format($optional_preventivi_val->totale,2)}}</td>                       
                       </tr>
                       @endforeach                                               
                    </table>    
            </td>
        </tr>
        <tr>
            <td style="padding:0.53cm 1cm 0;">
                    <table style="margin:0 auto;" width="100%" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left" valign="middle" width="70%">
                            <table cellpadding="0" cellspacing="0" width="100%" style="font-size:12px; padding:0 15px 0 0;">
                                <tr>
                                    <td style=""><b>CONSIDERAZIONI : {{ $preventivo->id.'/'.$preventivo->anno.' | '.$ente->nomeazienda }} </b></td>
                                </tr>
                                <tr>
                                    <td style="line-height:20px;">{{$preventivo->considerazioni}}</td>
                                </tr>
                                <tr>
                                    <td><b>{{$preventivo->noteimportanti}}</b></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center; font-size:14px; line-height:20px;"> <span style="color:#ed830b;">MODALITA'DI PAGAMENTO: {{$preventivo->metodo}}</span> <br/>
                                        Per maggiori informazioni tecniche o di dettaglio fiscale:
                                        RESPONSABILE LANGA: <b>{{$responsabile->name}} | {{$responsabile->cellulare}}</b> <br/>
                                        <b>VALENZA PREVENTIVO > {{$preventivo->valenza}}</b>
                                    </td>
                                </tr>                                
                            </table>
                         </td>
                       <td align="left" valign="middle" width="30%" style="vertical-align:top;">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr  style="">
                                    <td style="border:2px solid #000; padding:5px; font-size:12px;">TERMINE PRESUNTO DELAVORI</td>
                                    <td style="padding:0px 8px;"><img src="{{asset('images/pdfimages/delivery-bg.jpg')}}"/></td>
                                    <td style="border:2px solid #000; padding:5px; position:relative;font-size:12px;"><b>{{$preventivo->finelavori}}</b> <img src="{{asset('images/pdfimages/box.png')}}" style="position:absolute; height:18px; right:-9px; top:-9px; width:20px;"/></td>
                                </tr>
                                <tr><td style="height:15px;"></td></tr>                                
                                <tr>
                                    <td style="text-align:right; background:#f28006; padding:15px 5px; color:white;">TOTALE DOVUTO</td>
                                </tr>
                            <tr>
                            <td style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff; text-align:right;" valign="middle">TOTALE</td>
                            <td  style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff; text-align:right;" valign="middle"><?php echo "€ ".number_format($preventivo->subtotale, 2)." ";?></td>
                                </tr>
                                <tr>
                            <td style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff; text-align:right;" valign="middle">SCONTO</td>
                            <td style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff; text-align:right;" valign="middle"><?php
                                $valoresconto1 = $preventivo->subtotale * $preventivo->scontoagente / 100;
        $valoresconto2 = ($preventivo->subtotale - $valoresconto1) * $preventivo->scontobonus / 100;
        $sconto = $preventivo->scontoagente . '% + ' . $preventivo->scontobonus . '% ( € '.number_format($valoresconto1,2) . ' + € ' .number_format($valoresconto2,2) . ' )'." ";
                            echo  $sconto; ?>
                            </td>
                                </tr>
                                <tr>
                            <td style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff; text-align:right;" valign="middle">TOTALE SCONTATO</td>
                            <td  style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff; text-align:right;" valign="middle"><?php echo  '€ ' . number_format($preventivo->subtotale-$valoresconto1-$valoresconto2,2)?></td>
                                </tr>
                                <tr>
                            <td style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff; text-align:right;" valign="middle">TOTALE DA PAGARE</td>
                            <td style="font-size:0.282222cm; background-color:#f5f3f4; padding:0.1cm; line-height:1.3; border:0.03cm solid #fff; text-align:right;" valign="middle"><?php echo $daPagare = $preventivo->totaledapagare;
                                    echo "€ ".number_format($daPagare,2)." + IVA ";?></td>
                       </tr></table>
                         </td>
                    </tr>
                </table>
            </td>
        </tr>         
    </table>    