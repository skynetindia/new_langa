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
                        <li><b>{{trans('messages.keyword_client')}}</b> > {{trans('messages.keyword_it_can_only_see_events_related_to_its_body')}}</li>
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
{{trans('messages.keyword_faq_answear_project_five')}}</br></br> 
{{trans('messages.keyword_search_project_simple_bar_list_of_projects')}}

                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader"> {{ trans('messages.keyword_accounting') }} </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse20"> {{ trans('messages.keyword_what_easy_langa_accounting') }}?</a>
                </h4>
            </div>
            <div id="collapse20" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_accounting_form_that_includes_payment_arrangements') }}
                   
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse21">
                    {{ trans('messages.keyword_who_can_see_the_accounting') }}?</a>
                </h4>
            </div>
            <div id="collapse21" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b> {{ trans('messages.keyword_administration') }} </b> > 
                        {{ trans('messages.keyword_can_see_create_modify_delete_invoices') }} </li>
                        <li><b> {{ trans('messages.keyword_technical') }} </b> >{{ trans('messages.keyword_you_can_see_list_provisions_invoices') }}  </li>
                        <li><b> {{ trans('messages.keyword_commercial') }} </b> > {{ trans('messages.keyword_can_see_create_modify_delete_provisions_invoices') }} </li>
                        <li><b> {{ trans('messages.keyword_customer') }} </b> > {{ trans('messages.keyword_can_only_see_provisions_invoices') }} </li>
                    </ul>
                    * {{ trans('messages.keyword_commercia_never_able_view_modify_delete_invoices') }} 
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse22"> 
                    {{ trans('messages.keyword_where_do_find_the_accounting') }} ?</a>
                </h4>
            </div>
            <div id="collapse22" class="panel-collapse collapse">
                <div class="panel-body">
                    {{ trans('messages.keyword_sixth_menu_item_halfway_through_menu') }} 
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse22a">
                    {{ trans('messages.keyword_how_do_download_invoices') }} ?</a>
                </h4>
            </div>
            <div id="collapse22a" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_want_download_project_bill_click_accounting') }}
                    <span class="fa fa-file-pdf-o"></span>  {{ trans('messages.keyword_you_download_computer') }} </br></br> {{ trans('messages.keyword_click_terms_access_project_arrangements') }} </br> {{ trans('messages.keyword_select_relevant_format') }} <span class="fa fa-eye"></span> {{ trans('messages.keyword_access_invoices_related_to_project') }}  <span class="fa fa-file-pdf-o"></span> {{ trans('messages.keyword_you_download_computer') }} 
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader"> {{ trans('messages.keyword_mail') }} </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse23"> 
                    {{ trans('messages.keyword_what_easy_langa_mailing') }} ?</a>
                </h4>
            </div>
            <div id="collapse23" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_mailbox_official_mail_delivery_system') }}
                   
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse24">
                    {{ trans('messages.keyword_who_can_see_mail') }} ?</a>
                </h4>
            </div>
            <div id="collapse24" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b> {{ trans('messages.keyword_administration') }} </b> > {{ trans('messages.keyword_can_send_mails_see_profiles') }}</li>
                        <li><b> {{ trans('messages.keyword_technical') }} </b> > {{ trans('messages.keyword_can_send_see_mail_related_technical') }} </li>
                        <li><b> {{ trans('messages.keyword_commercial') }} </b> > {{ trans('messages.keyword_can_send_mails_shipping_profiles') }} </li>
                        <li><b> {{ trans('messages.keyword_customer') }} </b> > {{ trans('messages.keyword_can_not_see_mail_form') }} </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse25"> {{ trans('messages.keyword_where_do_i_find_the_mail') }} ?</a>
                </h4>
            </div>
            <div id="collapse25" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_seventh_menu_item') }}
                    
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader"> {{ trans('messages.keyword_statistics') }} </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse26">
                    {{ trans('messages.keyword_what_are_easy_langa_statistics') }} ?</a>
                </h4>
            </div>
            <div id="collapse26" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_statistics_include_graph_performance') }}
                   
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse27">
                    {{ trans('messages.keyword_who_can_see_statistics') }}
                    ?</a>
                </h4>
            </div>
            <div id="collapse27" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b> {{ trans('messages.keyword_administration') }} </b> > {{ trans('messages.keyword_can_view_administration_profile_statistics') }} </li>
                        <li><b> {{ trans('messages.keyword_technical') }} </b> > {{ trans('messages.keyword_can_not_see_statistics') }} </li>
                        <li><b> {{ trans('messages.keyword_commercial') }} </b> > {{ trans('messages.keyword_can_only_view_commerce_profiling_statistics') }} </li>
                        <li><b> {{ trans('messages.keyword_customer') }} </b> > {{ trans('messages.keyword_can_not_see_statistics') }} </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse28"> {{ trans('messages.keyword_where_do_i_find_statistics') }} ?</a>
                </h4>
            </div>
            <div id="collapse28" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_first_item_special_menu') }}
                    
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse29"> {{ trans('messages.keyword_why_i_need_use_statistics') }} ?</a>
                </h4>
            </div>
            <div id="collapse29" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_statistics_give_clear_picture_economic_situation') }}                  
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader"> {{ trans('messages.keyword_info') }} </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse30">
                    {{ trans('messages.keyword_what_are_easy_langa_info') }} ?</a>
                </h4>
            </div>
            <div id="collapse30" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_info_module_dedicated_to_general_information') }}
                   
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse31">
                    {{ trans('messages.keyword_who_can_see_info') }} ?</a>
                </h4>
            </div>
            <div id="collapse31" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b> {{ trans('messages.keyword_administration') }} </b> > 
                        {{ trans('messages.keyword_can_view_all_info') }} 
                        </li>
                        <li><b> {{ trans('messages.keyword_technical') }} </b> > 
                        {{ trans('messages.keyword_can_view_all_info') }}
                        </li>
                        <li><b> {{ trans('messages.keyword_commercial') }} </b> > 
                        {{ trans('messages.keyword_can_view_all_info') }}
                        </li>
                        <li><b> {{ trans('messages.keyword_customer') }} </b> > 
                        {{ trans('messages.keyword_can_view_all_info') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse32"> {{ trans('messages.keyword_where_do_i_find_info') }} ?</a>
                </h4>
            </div>
            <div id="collapse32" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_second_entry_in_special_menu') }}
                    
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader"> {{ trans('messages.keyword_notifications') }} </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse33"> {{ trans('messages.keyword_what_are_easy_langa_messages') }} ?</a>
                </h4>
            </div>
            <div id="collapse33" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_module_is_born_to_give_continuous_support') }}                    
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse34">
                    {{ trans('messages.keyword_who_can_see_reports') }} ?</a>
                </h4>
            </div>
            <div id="collapse34" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b> {{ trans('messages.keyword_administration') }} </b> > 
                        {{ trans('messages.keyword_can_display_the_reports') }} </li>
                        <li><b> {{ trans('messages.keyword_technical') }} </b> > 
                        {{ trans('messages.keyword_can_display_the_reports') }} </li>
                        <li><b> {{ trans('messages.keyword_commercial') }} </b> > 
                        {{ trans('messages.keyword_can_display_the_reports') }} </li>
                        <li><b> {{ trans('messages.keyword_customer') }} </b> > 
                        {{ trans('messages.keyword_can_display_the_reports') }} </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse35"> {{ trans('messages.keyword_where_do_i_find_reports') }}?</a>
                </h4>
            </div>
            <div id="collapse35" class="panel-collapse collapse">
                <div class="panel-body">
                    {{ trans('messages.keyword_third__item_of_special_menu') }}
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader"> {{ trans('messages.keyword_mistakes') }} </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse36"> {{ trans('messages.keyword_because_i_get_403') }} 403?</a>
                </h4>
            </div>
            <div id="collapse36" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_because_profiling_does_not_permissions') }}
                    
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse37"> {{ trans('messages.keyword_because_i_get_403') }} 404?</a>
                </h4>
            </div>
            <div id="collapse37" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_because_tried_to_access_page_not_exist') }}
                     
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse38"> {{ trans('messages.keyword_because_i_get_403') }} 503?</a>
                </h4>
            </div>
            <div id="collapse38" class="panel-collapse collapse">
                <div class="panel-body">
                {{ trans('messages.keyword_because_page_tried_to_access_not_available') }}
                   
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader"> {{ trans('messages.keyword_other') }} ...</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse39">
                    {{ trans('messages.keyword_what_need_icons_bottom_menu') }} ?</a>
                </h4>
            </div>
            <div id="collapse39" class="panel-collapse collapse">
                <div class="panel-body">
                    <span class="fa fa-user" aria-hidden="true"></span> {{ trans('messages.keyword_with_profile_icon_change_profiling_settings') }}  <br><span class="fa fa-arrows-alt" aria-hidden="true"></span> {{ trans('messages.keyword_with_fullscreen_icon') }}  <br><span class="fa fa-trash" aria-hidden="true"></span> {{ trans('messages.keyword_trash_icon') }}  <br><span class="fa fa-sign-out" aria-hidden="true"></span> {{ trans('messages.keyword_with_logout_icon_go_out_of_system') }} 
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse40">
                    {{ trans('messages.keyword_how_i_can_see_notifications') }} ?</a>
                </h4>
            </div>
            <div id="collapse40" class="panel-collapse collapse">
                <div class="panel-body"> 
                {{ trans('messages.keyword_view_notifications_click_on_icon') }}
                     <i class="fa fa-envelope-o"></i> 
                {{ trans('messages.keyword_top_right_management') }} 
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse41"> {{ trans('messages.keyword_when_notifications_appear') }} ?</a>
                </h4>
            </div>
            <div id="collapse41" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul>
                        <li><b> {{ trans('messages.keyword_event_calendar_expiry') }} </b> > 1 {{ trans('messages.keyword_day_before') }}</li>
                        <li><b> {{ trans('messages.keyword_quote_expansion') }} </b> > 3 {{ trans('messages.keyword_day_before') }}  </li>
                        <li><b>{{ trans('messages.keyword_project_working_expenditure') }} </b> > 1 {{ trans('messages.keyword_day_before') }}  </li>
                        <li><b> {{ trans('messages.keyword_duration_of_payment') }} </b> > 3 {{ trans('messages.keyword_day_before') }}  </li>
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