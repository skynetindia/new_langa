@extends('layouts.app')
@section('content')
<div class="container">
    <br />
    <br />
    <div class="panel-group" id="accordion">
 <div class="faqHeader">{{trans('messages.keyword_dashboard')}}</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1">{{trans('messages.keyword_what_is_the_easy_langa_bulletin_board?')}}</a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_dasboard_answear')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2">{{trans('messages.keyword_who_can_see_the_easy_langa_bulletin_board')}}</a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_all_easy_langa_profiles')}}
                    <ul><br />
                        <li><b>{{trans('messages.keyword_administrative')}}</b></li>
                        <li><b>{{trans('messages.keyword_technical')}}</b></li>
                        <li><b>{{trans('messages.keyword_commercial')}}</b></li>
                        <li><b>{{trans('messages.keyword_client')}}</b></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3">{{trans('messages.keyword_where_did_you_find_the_easy_langa_bulletin_board?')}}</a>
                </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_menu_find_dashboard')}}
                    <br />
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4">{{trans('messages.keyword_why_use_the_easy_langa_bulletin_board?')}}</a>
                </h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
                <div class="panel-body">
                  {{trans('messages.keyword_faq_answear_one')}}</br></br>
{{trans('messages.keyword_faq_answear_two')}} <span class="fa fa-user" aria-hidden="true"></span> {{trans('messages.keyword_user_at_the_bottom_of_the_bottom_left_menu.')}}
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">{{trans('messages.keyword_institutions')}}</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse5">{{trans('messages.keyword_what_are_the_entities?')}}</a>
                </h4>
            </div>
            <div id="collapse5" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_enti_answear')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse6">{{trans('messages.keyword_who_can_see_the_enti')}}?</a>
                </h4>
            </div>
            <div id="collapse6" class="panel-collapse collapse">
                <div class="panel-body">
                     <ul>
                        <li><b>{{trans('messages.keyword_administrative')}}</b> > {{trans('messages.keyword_can_see,_create,_edit_and_delete_entities')}}</li>
                        <li><b>{{trans('messages.keyword_technical')}}</b> > {{trans('messages.keyword_can_see_create_modify_delete_entities_participan')}}</li>
                        <li><b>{{trans('messages.keyword_commercial')}}</b> > {{trans('messages.keyword_can_see_and_create_enti')}}</li>
                        <li><b>{{trans('messages.keyword_client')}}</b> > {{trans('messages.keyword_can_only_see_and_change_its_body._not_delete.')}}</li>
                    </ul>
                </div>
            </div>
        </div>
                <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse7">{{trans('messages.keyword_where_do_i_find_the_entities?')}}</a>
                </h4>
            </div>
            <div id="collapse7" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_it_is_the_second_entry_in_the_menu,_located_at')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse8">{{trans('messages.keyword_why_use_enti')}}</a>
                </h4>
            </div>
            <div id="collapse8" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_entities_serve_to_order_in_a_registr')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse7a">{{trans('messages.keyword_how_do_i_see_the_enti')}}</a>
                </h4>
            </div>
            <div id="collapse7a" class="panel-collapse collapse">
                <div class="panel-body">            
                    {{trans('messages.keyword_faq_answear_enti_see')}}</br></br>
                    {{trans('messages.keyword_faq_answear_enti_see_two')}}</br></br>{{trans('messages.keyword_faq_answear_enti_see_three')}}
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">{{trans('messages.keyword_calendar')}}</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse9">{{trans('messages.keyword_what_is_the_easy_langa_calendar')}}</a>
                </h4>
            </div>
            <div id="collapse9" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_answear_calendar_see')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse10">{{trans('messages.keyword_who_can_see_the_calendar?')}}</a>
                </h4>
            </div>
            <div id="collapse10" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>{{trans('messages.keyword_administrative')}}</b> > {{trans('messages.keyword_can_see,_create,_edit,_and_delete_events')}}</li>
                        <li><b>{{trans('messages.keyword_technical')}}</b> > {{trans('messages.keyword_can_see,_create,_edit,_and_delete_events')}}</li>
                        <li><b>{{trans('messages.keyword_commercial')}}</b> > {{trans('messages.keyword_can_see,_create,_edit,_and_delete_events')}}</li>
                        <li><b>{{trans(messages.keyword_client)}}</b> > {{trans('messages.keyword_it_can_only_see_events_related_to_its_body')}}</li>
                    </ul>
                    {{trans('messages.keyword_faq_answear_calendat_see')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse11">{{trans('messages.keyword_where_do_i_find_the_calendar?')}}</a>
                </h4>
            </div>
            <div id="collapse11" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_third_item_in_the_menu,_located__under_entities.')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse12">{{trans('messages.keyword_why_use_easy_langa_calendar?')}}</a>
                </h4>
            </div>
            <div id="collapse12" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_answear_calendar_see_why')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse11a">{{trans('messages.keyword_how_do_i_view_calendar_events?')}}</a>
                </h4>
            </div>
            <div id="collapse11a" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_answear_calendar_view_why')}}</br></br>{{trans('messages.keyword_faq_answear_calendar_view_why_two')}}
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">{{trans('messages.keyword_quotes')}}</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse13">{{trans('messages.keyword_what_are_easy_langa_estimates?')}}</a>
                </h4>
            </div>
            <div id="collapse13" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_answear_estimates')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse14">{{trans('messages.keyword_who_can_see_the_estimates?')}}</a>
                </h4>
            </div>
            <div id="collapse14" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>{{trans('messages.keyword_administrative')}}</b> > {{trans('messages.keyword_can_see,_create,_edit,_and_delete_quotes')}}</li>
                        <li><b>{{trans('messages.keyword_technical')}}</b> > {{trans('messages.keyword_you_can_only_see_the_list_of_budgets_executed')}}</li>
                        <li><b>{{trans('messages.keyword_commercial')}}</b> > {{trans('messages.keyword_you_can_only_see_the_list_of_budgets_executed')}}</li>
                        <li><b>{{trans('messages.keyword_client')}}</b> > {{trans('messages.keyword_you_see_the_budgets_associated_with_your_agency')}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse15">{{trans('messages.keyword_where_do_i_find_the_estimates?')}}</a>
                </h4>
            </div>
            <div id="collapse15" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_answear_estimates_one')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse15a">{{trans('messages.keyword_how_do_i_see_my_estimates')}}</a>
                </h4>
            </div>
            <div id="collapse15a" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_answear_estimates_two')}}</br></br>
{{trans('messages.keyword_faq_answear_estimates_three')}}</br></br>{{trans('messages.keyword_faq_answear_estimates_four')}}
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">{{trans('messages.keyword_projects')}}</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse16">{{trans('messages.keyword_what_are_easy_langa_projects?')}}</a>
                </h4>
            </div>
            <div id="collapse16" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_answear_project_one')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse17">{{trans('messages.keyword_who_can_see_the_projects')}}</a>
                </h4>
            </div>
            <div id="collapse17" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul>
                        <li><b>{{trans('messages.keyword_administrative')}}</b> > {{trans('messages.keyword_can_see_projects_one')}}</li>
                        <li><b>{{trans('messages.keyword_technical')}}</b> > {{trans('messages.keyword_can_see_projects_one')}}</li>
                        <li><b>{{trans('messages.keyword_commercial')}}</b> > {{trans('messages.keyword_can_see_projects_two')}}</li>
                        <li><b>{{trans('messages.keyword_client')}}</b> > {{trans('messages.keyword_can_see_projects_three')}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse18">{{trans('messages.keyword_where_do_i_find_the_projects')}}</a>
                </h4>
            </div>
            <div id="collapse18" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_answear_project_two')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse19">{{trans('messages.keyword_why_do_i_need_to_use_easy_langa_projects')}}</a>
                </h4>
            </div>
            <div id="collapse19" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_answear_project_three')}}
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse19a">{{trans('messages.keyword_how_do_i_see_my_projects')}}</a>
                </h4>
            </div>
            <div id="collapse19a" class="panel-collapse collapse">
                <div class="panel-body">
                    {{trans('messages.keyword_faq_answear_project_four')}}</br></br>
{{trans('messages.keyword_faq_answear_project_five')}}</br></br>In "Miei" e "Tutti" puoi ricercare un determinato progetto attraverso una semplice barra posta sopra la lista dei progetti. 
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">Contabilità</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse20">Cos’è la contabilità Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse20" class="panel-collapse collapse">
                <div class="panel-body">
                    La contabilità Easy LANGA è il modulo comprendente le disposizioni di pagamento e le relative fatture. Le disposizioni si trovano all’interno di un contenitore chiamato “quadro”. Ogni quadro è legato a un ente per il quale si può avere più di una disposizione.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse21">Chi può vedere la contabilità?</a>
                </h4>
            </div>
            <div id="collapse21" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> > può vedere, creare, modificare, cancellare tutte le disposizioni e le fatture</li>
                        <li><b>TECNICO</b> > può vedere solamente la lista delle disposizioni e delle fatture</li>
                        <li><b>COMMERCIALE</b> > può vedere, creare, modificare, cancellare solo le sue disposizioni e le sue fatture</li>
                        <li><b>CLIENTE</b> > può vedere solamente le disposizioni e le fatture relative al suo ente</li>
                    </ul>
                    * la profilazione COMMERCIALE non potrà mai vedere, modificare o cancellare le disposizioni e le fatture della profilazione AMMINISTRAZIONE
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse22">Dove trovo la contabilità?</a>
                </h4>
            </div>
            <div id="collapse22" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la sesta voce del menu, si trova a metà del menu, sotto progetti.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse22a">Come faccio a scaricare le mie fatture?</a>
                </h4>
            </div>
            <div id="collapse22a" class="panel-collapse collapse">
                <div class="panel-body">
                    Se vuoi scaricare la fattura relativa a un progetto clicca sul modulo "Contabilità", vai su "Fatture" e accedi alla lista delle tue fatture. Ora seleziona la fattura e clicca sull'icona PDF <span class="fa fa-file-pdf-o"></span> per poterla scaricare sul tuo computer.</br></br>Se hai più progetti e vuoi scaricare una fattura inerente a un determinato progetto clicca sul modulo "Contabilità", vai su "Pagamenti e rinnovi", clicca su "Disposizioni" e accedi alla lista delle tue disposizioni per progetto.</br>Seleziona la disposizione interessata, clicca sull'icona <span class="fa fa-eye"></span> e accedi all'elenco delle fatture inerenti al progetto. Ora seleziona la fattura e clicca sull'icona PDF <span class="fa fa-file-pdf-o"></span> per poterla scaricare sul tuo computer.
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">Mailistica</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse23">Cos’è la mailistica Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse23" class="panel-collapse collapse">
                <div class="panel-body">
                    La mailistica Easy LANGA è un sistema d’invio di mail ufficiali. Le mail verranno inviate attraverso questo modulo direttamente agli enti selezionati dall’utente.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse24">Chi può vedere la mailistica?</a>
                </h4>
            </div>
            <div id="collapse24" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> > può inviare le mail della profilazione AMMINISTRAZIONE e vedere le mail di tutte le profilazioni</li>
                        <li><b>TECNICO</b> > può inviare e vedere solo le mail legate alla profilazione tecnica</li>
                        <li><b>COMMERCIALE</b> > può inviare le mail della profilazione COMMERCIALE e vedere le mail legate alla profilazione TECNICA</li>
                        <li><b>CLIENTE</b> > non può vedere il modulo mailistica</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse25">Dove trovo la mailistica?</a>
                </h4>
            </div>
            <div id="collapse25" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la settima voce del menu, si trova a metà del menu, sotto contabilità.
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">Statistiche</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse26">Cosa sono le statistiche Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse26" class="panel-collapse collapse">
                <div class="panel-body">
                    Le statistiche Easy LANGA comprendono un grafico che tiene aggiornato l’utente sull’andamento di spese, guadagni e ricavi.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse27">Chi può vedere le statistiche?</a>
                </h4>
            </div>
            <div id="collapse27" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> > può visualizzare le statistiche della profilazione AMMINISTRAZIONE e le statistiche della profilazione COMMERCIALE</li>
                        <li><b>TECNICO</b> > non può vedere statistiche</li>
                        <li><b>COMMERCIALE</b> > può solo visualizzare le statistiche della profilazione COMMERCIALE</li>
                        <li><b>CLIENTE</b> > non può vedere statistiche</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse28">Dove trovo le statistiche?</a>
                </h4>
            </div>
            <div id="collapse28" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la prima voce del menu speciale.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse29">Perchè devo utilizzare le statistiche Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse29" class="panel-collapse collapse">
                <div class="panel-body">
                    Le statistiche Easy LANGA danno all’utente una situazione chiara della situazione economica basandosi su un rapporto tra spese e ricavi. Con questo strumento puoi sapere esattamente quanti soldi sono stati spesi un determinato mese, qual’è stato il ricavo  e il relativo guadagno.
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">Info</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse30">Cosa sono le info Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse30" class="panel-collapse collapse">
                <div class="panel-body">
                    Le info Easy LANGA sono il modulo dedicato alle informazioni generali del gestionale. Qui troverete contatti, FAQ e Changelog Easy (una sezione dove l’utente può trovare informazioni su versione in uso, aggiornamenti e correzzioni di bug).
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse31">Chi può vedere le info?</a>
                </h4>
            </div>
            <div id="collapse31" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> > può visualizzare tutte le info</li>
                        <li><b>TECNICO</b> > può visualizzare tutte le info</li>
                        <li><b>COMMERCIALE</b> > può visualizzare tutte le info</li>
                        <li><b>CLIENTE</b> > può visualizzare tutte le info</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse32">Dove trovo le info?</a>
                </h4>
            </div>
            <div id="collapse32" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la seconda voce del menu speciale.
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">Segnalazioni</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse33">Cosa sono le segnalazioni Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse33" class="panel-collapse collapse">
                <div class="panel-body">
                    Le segnalazioni Easy LANGA sono utili a tutti gli utenti che trovano un problema nel nostro gestionale e vogliono comunicarlo a chi di dovere per poterlo risolvere in maniera semplice e veloce. Questo modulo nasce per dare un supporto continuo a tutti gli utenti e migliorare la loro esperienza su Easy LANGA.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse34">Chi può vedere le segnalazioni?</a>
                </h4>
            </div>
            <div id="collapse34" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> > può visualizzare le segnalazioni</li>
                        <li><b>TECNICO</b> = può visualizzare le segnalazioni</li>
                        <li><b>COMMERCIALE</b> > può visualizzare le segnalazioni</li>
                        <li><b>CLIENTE</b> > può visualizzare le segnalazioni</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse35">Dove trovo le segnalazioni?</a>
                </h4>
            </div>
            <div id="collapse35" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la terza ed ultima voce del menu speciale.
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">Errori</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse36">Perchè ottengo un 403?</a>
                </h4>
            </div>
            <div id="collapse36" class="panel-collapse collapse">
                <div class="panel-body">
                    Perchè la profilazione con la quale utilizzi Easy LANGA non ha i permessi per accedere a una determinata pagina.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse37">Perchè ottengo un 404?</a>
                </h4>
            </div>
            <div id="collapse37" class="panel-collapse collapse">
                <div class="panel-body">
                     Perchè hai tentato di accedere a una pagina che su Easy LANGA non esiste.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse38">Perchè ottengo un 503?</a>
                </h4>
            </div>
            <div id="collapse38" class="panel-collapse collapse">
                <div class="panel-body">
                    Perchè la pagina alla quale hai tentato di accedere non è al momento disponibile, è ancora in fase di lavorazione.
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">Altro...</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse39">A cosa mi servono le icone al fondo del menu Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse39" class="panel-collapse collapse">
                <div class="panel-body">
                    <span class="fa fa-user" aria-hidden="true"></span>   Con l'icona profilo cambi le impostazioni della tua profilazione.<br><span class="fa fa-arrows-alt" aria-hidden="true"></span>   Con l'icona fullscreen attivi la modalità a schermo intero.<br><span class="fa fa-trash" aria-hidden="true"></span>   Con l'icona cestino accedi alla pagina cestino, dove puoi visualizzare tutto ciò che hai eliminato.<br><span class="fa fa-sign-out" aria-hidden="true"></span>   Con l'icona logout esci dal sistema.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse40">Come posso visualizzare le notifiche Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse40" class="panel-collapse collapse">
                <div class="panel-body">
                     Per visualizzare le notifiche Easy LANGA clicca sull'icona <i class="fa fa-envelope-o"></i> in alto sulla destra del gestionale, vicino all'immagine del tuo profilo.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse41">Quando compaiono le notifiche Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse41" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul>
                        <li><b>SCADENZA EVENTO CALENDARIO</b> > 1 giorno prima</li>
                        <li><b>SCADENZA PREVENTIVO</b> > 3 giorni prima</li>
                        <li><b>SCADENZA LAVORAZIONE PROGETTO</b> > 1 giorno prima</li>
                        <li><b>SCADENZA DISPOSIZIONE PAGAMENTO</b> > 3 giorno prima</li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br/><br><br/><br><br/><br><br/>

<style>
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Glyphicons Halflings';
        content: "+"; /* "play" icon */
        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
</style>

@endsection