
	<table class="main-wrapper" cellpadding="0" cellspacing="0">
        <tr>
            <td style="background-color:#f28006; padding:10px 20px;" valign="middle">
                <table style="margin:0 auto;" width="100%" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left" valign="bottom"><img src="{{ (isset($arrSettings->pdflogo) && !empty($arrSettings->pdflogo)) ? asset('storage/app/images/logo/'.$arrSettings->pdflogo) :  asset('images/pdfimages/langa-logo.jpg')}}" alt="langa logo"  style="display:block; width:75.6px; height:75.6px;"> </td>
                        <td align="right" valign="bottom" style="color:#fff; font-size:0.257528cm;">Timbro/Firma per accettazione: ____________________________________</td>
                    </tr>
                </table>
            </td>
        </tr>
       
        <tr>
            <td style="background-color:#363b3f; padding:0.20cm 1cm;">
                    <table style="margin:0 auto;" width="100%" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left" valign="middle"><img src="{{asset('images/pdfimages/langa-group.jpg')}}" alt="langa group"  style="display:block; width:6cm; height:auto;"> </td>
                         @if($preventivo->oggetto != "")
                        <td align="right" valign="middle" style="color:#fff; font-size:0.3496028cm;"><strong>{{trans('messages.keyword_object')}}:</strong>
                          {{ $preventivo->oggetto}}                     
                       </td>
                       @endif  
                    </tr>
                </table>
            </td>
        </tr>
         
        </table>
        