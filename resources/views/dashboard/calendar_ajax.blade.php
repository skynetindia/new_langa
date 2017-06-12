<div class="header-right">
    <div class="float-left">        
        <a class="btn btn-warning" style="color:#ffffff;text-decoration: none" onclick="aggiungiEvento()" title="{{ trans('messages.keyword_addnewevent') }} "><i class="fa fa-plus"></i></a>
        <a id="miei" class="button button2" href="{{url('/calendario/0')}}" name="miei" title="{{ trans('messages.keyword_eventfilter') }}">
            {{ trans('messages.keyword_my') }}
        </a>
        <a id="tutti" class="button button3" href="{{url('/calendario/1')}}"  name="tutti" title="{{ trans('messages.keyword_allevent') }} ">
         {{ trans('messages.keyword_all') }}
        </a>
    </div>
</div>
<div class="clearfix"></div>
<div class="table-responsive">
    <table class="table calender-tbl table-striped table-bordered">
        <tr><td colspan="5"><?php
            if($month == 1) {
                $link1 = "/calendario/show/" . $tipo . "/day/0/month/12/year/" . ($year - 1);
                $link2 = "/calendario/show/" . $tipo . "/day/0/month/" . ($month+1) . "/year/" . $year;
            } else if($month == 12) {
                $link1 = "/calendario/show/" . $tipo . "/day/0/month/" . ($month-1) . "/year/" . $year;
                $link2 = "/calendario/show/" . $tipo . "/day/0/month/1/year/" . ($year + 1);
            } else {
                $link1 = "/calendario/show/" . $tipo . "/day/0/month/" . ($month-1) . "/year/" . $year;
                $link2 = "/calendario/show/" . $tipo . "/day/0/month/" . ($month+1) . "/year/" . $year;
            }            
        ?>
        <a href="{{ url($link1) }}"><span class="glyphicon glyphicon-chevron-left"></span>{{ $nomiMesi[$month-1] or $nomiMesi[12] }} </a>
        {{ $nomiMesi[$month] }} {{ $year }}
        <a href="{{ url($link2) }}"> {{ $nomiMesi[$month+1] or $nomiMesi[1] }}<span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
        <tr>
        @for ($i = 1; $i <= $giorniMese; $i++)
            <td class="day"<?php if($i == $day) echo " style='color:#fff;background: #f37f0d;'"; ?> onclick="mostraEventi(<?php echo $i; ?>)">
                {{ $i }}
                <br>
                <?php $giorno = strftime('%A', mktime(0, 0, 0, $month, $i, $year));
                if($giorno == "Monday")
                    $giorno = trans('messages.keyword_mon');
                else if($giorno == "Tuesday")
                    $giorno = trans('messages.keyword_tues');
                else if($giorno == "Wednesday")
                    $giorno = trans('messages.keyword_wed');
                else if($giorno == "Thursday")
                    $giorno = trans('messages.keyword_thur');
                else if($giorno == "Friday")
                    $giorno = trans('messages.keyword_fri');
                else if($giorno == "Saturday")
                    $giorno = trans('messages.keyword_sat');
                else if($giorno == "Sunday")
                    $giorno = trans('messages.keyword_sun');
                echo $giorno;
                $elenco_eventi = [];                
                ?><hr>
                <table>
                    <tr style="color:#fff">
                    @foreach ($events as $event)
                        @if($year == $event->annoFine)
                            @if($month <= $event->meseFine)
                                <?php 
                                    $utente = DB::table('users')
                                                ->where('id', $event->user_id)
                                                ->first();                                  
                                    $colore = (isset($utente->color))?$utente->color:'#fff';
                                ?>
                                @if($month == $event->mese)
                                    @if($i >= $event->giorno)
                                        @if($event->mese == $event->meseFine)
                                            @if($i <= $event->giornoFine)
                                                <td class="pointer" style="background-color:<?php echo $colore; ?>"> • </td>
                                                <?php $event->color = $colore ?>
                                                <?php $event->utente = (isset($utente->name))?$utente->name:'' ?>
                                            @endif
                                        @else
                                            <td class="pointer" style="background-color:<?php echo $colore; ?>"> • </td>
                                            <?php $event->color = $colore ?>
                                            <?php $event->utente = (isset($utente->name))?$utente->name:'' ?>
                                        @endif
                                    @endif
                                @elseif($month == $event->meseFine)
                                    @if($i <= $event->giornoFine)
                                        <td class="pointer" style="background-color:<?php echo $colore; ?>"> • </td>
                                        <?php $event->color = $colore ?>
                                        <?php $event->utente = (isset($utente->name))?$utente->name:'' ?>
                                    @endif
                                @elseif($month > $event->mese && $month < $event->meseFine)
                                    <td class="pointer" style="background-color:<?php echo $colore; ?>"> • </td>
                                    <?php $event->color = $colore ?>
                                    <?php $event->utente = (isset($utente->name))?$utente->name:'' ?>
                                @endif
                            @endif
                        @endif
                    @endforeach
                    </tr>
                </table>
            </td>
            @if ($i % 5 == 0)
                </tr><tr>
            @endif
        @endfor
        </tr>
    </table>
</div>