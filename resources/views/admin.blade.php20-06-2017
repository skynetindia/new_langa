@extends('adminHome')

@section('page')
<h1>Dashboard</h1>
<hr>
<div class="panel panel-default">
	 <div class="panel-body">
<div class="row">
  <div class="col-md-6">
    <div class="col-md-10"> {!! Form::open(array('url' => 'admin/globali/store', 'files' => true)) !!}
      <div class="form-group">
        <label for="logo"><strong>Front Logo</strong></label>
        <input type="file" name="logo" required="required" class="form-control">
        <!-------------- <?php echo Form::file('logo',['required']); ?> -------> 
      </div>
      <div class="form-group">
        <input value="Salva" type="submit" class="btn btn-warning" >
      </div>
      {!! Form::close() !!} </div>
    <div class="col-md-2">
      <div class="dashboard-logo"> <img class="img-responsive" src="data:image/png;base64,<?php echo $logo; ?>"></img> </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="col-md-10"> {!! Form::open(array('url' => 'admin/globali/store', 'files' => true)) !!}
      <div class="form-group">
        <label for="logo"><strong>Admin Logo</strong></label>
        <input type="file" name="logo" required="required" class="form-control">
        <!-------------- <?php echo Form::file('logo',['required']); ?> -------> 
      </div>
      <div class="form-group">
        <input value="Salva" type="submit" class="btn btn-warning" >
      </div>
      {!! Form::close() !!} </div>
    <div class="col-md-2">
      <div class="dashboard-logo"> <img class="img-responsive" src="data:image/png;base64,<?php echo $logo; ?>"></img> </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="col-md-10"> {!! Form::open(array('url' => 'admin/globali/store', 'files' => true)) !!}
      <div class="form-group">
        <label for="logo"><strong>Front Favicon</strong></label>
        <input type="file" name="logo" required="required" class="form-control">
        <!-------------- <?php echo Form::file('logo',['required']); ?> -------> 
      </div>
      <div class="form-group">
        <input value="Salva" type="submit" class="btn btn-warning" >
      </div>
      {!! Form::close() !!} </div>
    <div class="col-md-2">
      <div class="dashboard-logo"> <img class="img-responsive" src="data:image/png;base64,<?php echo $logo; ?>"></img> </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="col-md-10"> {!! Form::open(array('url' => 'admin/globali/store', 'files' => true)) !!}
      <div class="form-group">
        <label for="logo"><strong>Admin Favicon</strong></label>
        <input type="file" name="logo" required="required" class="form-control">
        <!-------------- <?php echo Form::file('logo',['required']); ?> -------> 
      </div>
      <div class="form-group">
        <input value="Salva" type="submit" class="btn btn-warning" >
      </div>
      {!! Form::close() !!} </div>
    <div class="col-md-2">
      <div class="dashboard-logo"> <img class="img-responsive" src="data:image/png;base64,<?php echo $logo; ?>"></img> </div>
    </div>
  </div>
</div>
	</div>
</div>
<div class="space40"></div>
<div class="panel panel-default">
	 <div class="panel-body">
<h1 class="cst-datatable-heading">Elenco Utenti</h1>
<div class="row">
  <div class="col-md-12">
  <!------------------ Static user list ------------->
    <div class="table-responsive table-custom-design">
      <div class="bootstrap-table">
        <div class="fixed-table-toolbar">
          <div class="columns columns-right btn-group pull-right">
            <button title="Aggiorna" name="refresh" type="button" class="btn btn-default"><i class="glyphicon glyphicon-refresh icon-refresh"></i></button>
            <div title="Colonne" class="keep-open btn-group">
              <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="glyphicon glyphicon-th icon-th"></i> <span class="caret"></span></button>
              <ul role="menu" class="dropdown-menu">
                <li>
                  <label>
                    <input type="checkbox" checked="checked" value="0" data-field="id">
                    ID </label>
                </li>
                <li>
                  <label>
                    <input type="checkbox" checked="checked" value="1" data-field="name">
                    Nome </label>
                </li>
                <li>
                  <label>
                    <input type="checkbox" checked="checked" value="2" data-field="nome_ruolo">
                    Profilazione</label>
                </li>
                <li>
                  <label>
                    <input type="checkbox" checked="checked" value="3" data-field="cellulare">
                    Cellulare </label>
                </li>
                <li>
                  <label>
                    <input type="checkbox" checked="checked" value="4" data-field="email">
                    Email </label>
                </li>
                <li>
                  <label>
                    <input type="checkbox" checked="checked" value="5" data-field="id_ente">
                    ID Ente </label>
                </li>
              </ul>
            </div>
          </div>
          <div class="pull-right search">
            <input type="text" placeholder="Cerca" class="form-control">
          </div>
        </div>
        <div class="fixed-table-container" style="padding-bottom: 0px;">
          <div class="fixed-table-header" style="display: none;">
            <table>
            </table>
          </div>
          <div class="fixed-table-body">
            <div class="fixed-table-loading" style="top: 42px; display: none;">Caricamento in corso...</div>
            <table id="table" data-classes="table table-bordered" data-url="http://betaeasy.langa.tv/users/json" data-show-columns="true" data-show-refresh="true" data-id-field="id" data-pagination="true" data-search="true" data-toggle="table" class="table table-bordered">
              <thead>
                <tr>
                  <th tabindex="0" data-field="id" style="" class="id"><div class="th-inner sortable both">ID </div>
                    <div class="fht-cell"></div></th>
                  <th tabindex="0" data-field="name" style=""><div class="th-inner sortable both">Nome </div>
                    <div class="fht-cell"></div></th>
                  <th tabindex="0" data-field="nome_ruolo" style="" class="profilazione"><div class="th-inner sortable both">Profilazione</div>
                    <div class="fht-cell"></div></th>
                  <th tabindex="0" data-field="cellulare" style=""><div class="th-inner sortable both">Cellulare </div>
                    <div class="fht-cell"></div></th>
                  <th tabindex="0" data-field="email" style=""><div class="th-inner sortable both">Email </div>
                    <div class="fht-cell"></div></th>
                  <th tabindex="0" data-field="id_ente" style=""><div class="th-inner sortable both">ID Ente </div>
                    <div class="fht-cell"></div></th>
                </tr>
              </thead>
              <tbody>
                <tr data-index="0">
                  <td style="" class="id">1</td>
                  <td style="">prata1201</td>
                  <td style="" class="profilazione">Administrative</td>
                  <td style="">+39 320 4486586</td>
                  <td style="">prata1201@langa.tv</td>
                  <td style="">1201</td>
                </tr>
                <tr data-index="1">
                  <td style="" class="id">2</td>
                  <td style="">tarasco1250</td>
                  <td style="" class="profilazione">Administrative</td>
                  <td style="">+39 389 8914196</td>
                  <td style="">tarasco1250@langa.tv</td>
                  <td style="">1250</td>
                </tr>
                <tr data-index="2">
                  <td style="" class="id">16</td>
                  <td style="">perrone1236</td>
                  <td style="" class="profilazione">Tecnico</td>
                  <td style="">+39 348 3348053</td>
                  <td style="">perrone1236@langa.tv</td>
                  <td style="">1236</td>
                </tr>
                <tr data-index="3">
                  <td style="" class="id">17</td>
                  <td style="">dotta1235</td>
                  <td style="" class="profilazione">Tecnico</td>
                  <td style="">+39 333 8346258</td>
                  <td style="">dotta1235@langa.tv</td>
                  <td style="">1235</td>
                </tr>
                <tr data-index="4">
                  <td style="" class="id">18</td>
                  <td style="">ventura1252</td>
                  <td style="" class="profilazione">Commercial</td>
                  <td style="">+39 340 4276890</td>
                  <td style="">ventura1252@langa.tv</td>
                  <td style="">1252</td>
                </tr>
                <tr data-index="5">
                  <td style="" class="id">53</td>
                  <td style="">robino1239</td>
                  <td style="" class="profilazione">Commercial</td>
                  <td style="">+39 339 6836214</td>
                  <td style="">robino1239@langa.tv</td>
                  <td style="">1239</td>
                </tr>
                <tr data-index="6">
                  <td style="" class="id">54</td>
                  <td style="">bevilacqua1249</td>
                  <td style="" class="profilazione">Commercial</td>
                  <td style="">-</td>
                  <td style="">bevilacqua1249@langa.tv</td>
                  <td style="">1249</td>
                </tr>
                <tr data-index="7">
                  <td style="" class="id">55</td>
                  <td style="">aragona1251</td>
                  <td style="" class="profilazione">Commercial</td>
                  <td style="">+39 348 0958581</td>
                  <td style="">info@aragonastore.langa.tv</td>
                  <td style="">1251</td>
                </tr>
                <tr data-index="8">
                  <td style="" class="id">56</td>
                  <td style="">manenti1202</td>
                  <td style="" class="profilazione">Commercial</td>
                  <td style="">+39 346 6133112</td>
                  <td style="">manenti1202@langa.tv</td>
                  <td style="">1202</td>
                </tr>
                <tr data-index="9">
                  <td style="" class="id">61</td>
                  <td style="">SkyDevelopers</td>
                  <td style="" class="profilazione">Administrative</td>
                  <td style="">-</td>
                  <td style="">developer5@skynettechnologies.com</td>
                  <td style="">0</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="fixed-table-footer" style="display: none;">
            <table>
              <tbody>
                <tr></tr>
              </tbody>
            </table>
          </div>
          <div class="fixed-table-pagination" style="">
            <div class="pull-left pagination-detail"><span class="pagination-info">Pagina 1 di 10 (10 elementi)</span><span class="page-list" style="display: none;"><span class="btn-group dropup">
              <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><span class="page-size">10</span> <span class="caret"></span></button>
              <ul role="menu" class="dropdown-menu">
                <li class="active"><a href="javascript:void(0)">10</a></li>
                <li><a href="javascript:void(0)">25</a></li>
              </ul>
              </span> elementi per pagina</span></div>
            <div class="pull-right pagination" style="display: none;">
              <ul class="pagination">
                <li class="page-pre"><a href="javascript:void(0)">‹</a></li>
                <li class="page-number active"><a href="javascript:void(0)">1</a></li>
                <li class="page-next"><a href="javascript:void(0)">›</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      
      <!-- <div class="table-responsive">

<table class="selectable table table-hover table-bordered" id="table" cellspacing="0" cellpadding="0">

<thead>

<tr style="background: #999; color:#ffffff"> --> 
      
      <!-- Intestazione tabella dipartimenti --> 
      
      <!-- <th>#</th>

<th>Codice</th>

<th>Nome</th>

<th>Profilazione</th>

<th>Cellulare</th>

<th>Email</th>

<th>ID Ente</th>

</tr>

</thead>

<tbody>
 --> 
      
      <!--

'sconti'

'entisconti' = legame tra l'id_sconto e l'id_tipo ente,

'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)

--> 
      
      <!--  --> 
      
      <!-- <tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>1</td>

                <td>prata1201</td>

                                <td>
                    Administrative
                </td>

                <td>+39 320 4486586</td>

                <td>prata1201@langa.tv</td> --> 
      
      <!-- 
                        <td><a href="http://betaeasy.langa.tv/enti/modify/corporation/1201">1201</a></td> --> 
      
      <!--  --> 
      
      <!-- <tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>2</td>

                <td>tarasco1250</td>

                                <td>
                    Administrative
                </td>

                <td>+39 389 8914196</td>

                <td>tarasco1250@langa.tv</td> --> 
      
      <!-- 
                        <td><a href="http://betaeasy.langa.tv/enti/modify/corporation/1250">1250</a></td> --> 
      
      <!--  --> 
      
      <!-- <tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>16</td>

                <td>perrone1236</td>

                                <td>
                    Tecnico
                </td>

                <td>+39 348 3348053</td>

                <td>perrone1236@langa.tv</td> --> 
      
      <!-- 
                        <td><a href="http://betaeasy.langa.tv/enti/modify/corporation/1236">1236</a></td> --> 
      
      <!--  --> 
      
      <!-- <tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>17</td>

                <td>dotta1235</td>

                                <td>
                    Tecnico
                </td>

                <td>+39 333 8346258</td>

                <td>dotta1235@langa.tv</td> --> 
      
      <!-- 
                        <td><a href="http://betaeasy.langa.tv/enti/modify/corporation/1235">1235</a></td> --> 
      
      <!--  --> 
      
      <!-- <tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>18</td>

                <td>ventura1252</td>

                                <td>
                    Commercial
                </td>

                <td>+39 340 4276890</td>

                <td>ventura1252@langa.tv</td> --> 
      
      <!-- 
                        <td><a href="http://betaeasy.langa.tv/enti/modify/corporation/1252">1252</a></td> --> 
      
      <!--  --> 
      
      <!-- <tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>53</td>

                <td>robino1239</td>

                                <td>
                    Commercial
                </td>

                <td>+39 339 6836214</td>

                <td>robino1239@langa.tv</td> --> 
      
      <!-- 
                        <td><a href="http://betaeasy.langa.tv/enti/modify/corporation/1239">1239</a></td> --> 
      
      <!--  --> 
      
      <!-- <tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>54</td>

                <td>bevilacqua1249</td>

                                <td>
                    Commercial
                </td>

                <td></td>

                <td>bevilacqua1249@langa.tv</td> --> 
      
      <!-- 
                        <td><a href="http://betaeasy.langa.tv/enti/modify/corporation/1249">1249</a></td> --> 
      
      <!--  --> 
      
      <!-- <tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>55</td>

                <td>aragona1251</td>

                                <td>
                    Commercial
                </td>

                <td>+39 348 0958581</td>

                <td>info@aragonastore.langa.tv</td> --> 
      
      <!-- 
                        <td><a href="http://betaeasy.langa.tv/enti/modify/corporation/1251">1251</a></td> --> 
      
      <!--  --> 
      
      <!-- <tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>56</td>

                <td>manenti1202</td>

                                <td>
                    Commercial
                </td>

                <td>+39 346 6133112</td>

                <td>manenti1202@langa.tv</td> --> 
      
      <!-- 
                        <td><a href="http://betaeasy.langa.tv/enti/modify/corporation/1202">1202</a></td> --> 
      
      <!--  --> 
      
      <!-- <tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>61</td>

                <td>SkyDevelopers</td>

                                <td>
                    Administrative
                </td>

                <td></td>

                <td>developer5@skynettechnologies.com</td> --> 
      
      <!-- 
                        <td><a href="http://betaeasy.langa.tv/enti/modify/corporation/0">0</a></td> --> 
      
      <!-- 		 --> 
      
    </div>
  <!------------------ STatic user list End ------------->
  </div>
</div>
</div>
</div>
<div class="space40"></div>
<div class="panel panel-default">
	 <div class="panel-body">
<h1 class="cst-datatable-heading">Preventivi</h1>
<div class="row">
	<div class="col-md-12">
  <!------------------ Static Preventivi Start ------------->
	<div class="bootstrap-table"><div class="fixed-table-toolbar"><div class="columns columns-right btn-group pull-right"><button class="btn btn-default" type="button" name="refresh" title="Aggiorna"><i class="glyphicon glyphicon-refresh icon-refresh"></i></button><div class="keep-open btn-group" title="Colonne"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-th icon-th"></i> <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li><label><input data-field="id" value="0" checked="checked" type="checkbox"> n° preventivo
            </label></li><li><label><input data-field="ente" value="1" checked="checked" type="checkbox"> Ente
            </label></li><li><label><input data-field="oggetto" value="2" checked="checked" type="checkbox"> Oggetto
            </label></li><li><label><input data-field="data" value="3" checked="checked" type="checkbox"> Data esecuzione
            </label></li><li><label><input data-field="valenza" value="4" checked="checked" type="checkbox"> Data scadenza
            </label></li><li><label><input data-field="dipartimento" value="5" checked="checked" type="checkbox"> Dipartimento
            </label></li><li><label><input data-field="finelavori" value="6" checked="checked" type="checkbox"> Data fine lavori
            </label></li><li><label><input data-field="statoemotivo" value="7" checked="checked" type="checkbox"> Stato Emotivo
        </label></li></ul></div></div><div class="pull-right search"><input class="form-control" placeholder="Cerca" type="text"></div></div><div class="fixed-table-container" style="padding-bottom: 0px;"><div class="fixed-table-header" style="display: none;"><table></table></div><div class="fixed-table-body"><div class="fixed-table-loading" style="top: 42px; display: none;">Caricamento in corso...</div><table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="http://betaeasy.langa.tv/preventivi/miei/json" data-classes="table table-bordered" id="table" class="table table-bordered">
        <thead><tr><th style="" data-field="id" tabindex="0"><div class="th-inner sortable both">n° preventivo
            </div><div class="fht-cell"></div></th><th style="" data-field="ente" tabindex="0"><div class="th-inner sortable both">Ente
            </div><div class="fht-cell"></div></th><th style="" data-field="oggetto" tabindex="0"><div class="th-inner sortable both">Oggetto
            </div><div class="fht-cell"></div></th><th style="" data-field="data" tabindex="0"><div class="th-inner sortable both">Data esecuzione
            </div><div class="fht-cell"></div></th><th style="" data-field="valenza" tabindex="0"><div class="th-inner sortable both">Data scadenza
            </div><div class="fht-cell"></div></th><th style="" data-field="dipartimento" tabindex="0"><div class="th-inner sortable both">Dipartimento
            </div><div class="fht-cell"></div></th><th style="" data-field="finelavori" tabindex="0"><div class="th-inner sortable both">Data fine lavori
            </div><div class="fht-cell"></div></th><th style="" data-field="statoemotivo" tabindex="0"><div class="th-inner sortable both">Stato Emotivo
        </div><div class="fht-cell"></div></th></tr></thead>
    <tbody><tr data-index="0"><td style="">:162/16</td><td style="">ADMIN</td><td style="">PROVA PREVENTIVO2</td><td style="">27/07/2016</td><td style="">16/10/2016</td><td style="">FOO99</td><td style="">31/07/2016</td><td style=""><span style="color:#F3DA0D">IN ATTESA DI CONFERMA</span></td></tr><tr data-index="1"><td style="">:163/16</td><td style="">ADMIN</td><td style="">SITO WEB LANGA WEB - PACCHETTO %WEB</td><td style="">29/07/2016</td><td style="">19/08/2016</td><td style="">LANGA WEB</td><td style="">20/11/2016</td><td style=""><span style="color:#000000">NON CONFERMATO</span></td></tr><tr data-index="2"><td style="">:164/16</td><td style="">SAN GIOVENALE ONORANZE</td><td style="">CALENDARIO DA TAVOLO A GRAFFA ORIZZONTALE</td><td style="">16/08/2016</td><td style="">19/08/2016</td><td style="">LANGA PRINT</td><td style="">23/09/2016</td><td style=""><span style="color:#000000">NON CONFERMATO</span></td></tr><tr data-index="3"><td style="">:165/16</td><td style="">AZ. AGRICOLA CASSINELLI MARIA</td><td style="">SITO WEB RESPONSIVE - PACCHETTO WEB</td><td style="">23/08/2016</td><td style="">20/09/2016</td><td style="">LANGA WEB</td><td style="">20/12/2016</td><td style="">-</td></tr><tr data-index="4"><td style="">:166/16</td><td style="">SAN GIOVENALE ONORANZE</td><td style="">CALENDARIO CLASSICO DA APPENDERE A GRAFFA ORIZZONTALE</td><td style="">23/08/2016</td><td style="">26/08/2016</td><td style="">LANGA PRINT</td><td style="">19/10/2016</td><td style=""><span style="color:#000000">NON CONFERMATO</span></td></tr><tr data-index="5"><td style="">:167/16</td><td style="">LUCREZIA SANDRI</td><td style="">GADGET PORTACHIAVI + FISCHIETTI LEVA</td><td style="">25/08/2016</td><td style="">28/08/2016</td><td style="">LANGA PRINT</td><td style="">08/09/16</td><td style=""><span style="color:#f37f0d">CONFERMATO</span></td></tr><tr data-index="6"><td style="">:168/16</td><td style="">GOLDEN CAR Srl | Automotive</td><td style="">SITO WEB LANGA WEB - PACCHETTO %WEB</td><td style="">30/08/2016</td><td style="">14/09/2016</td><td style="">LANGA WEB</td><td style="">23/12/2016</td><td style=""><span style="color:#000000">NON CONFERMATO</span></td></tr><tr data-index="7"><td style="">:169/16</td><td style="">IL PICCOLO | Giornale</td><td style="">SITO WEB LANGA WEB - PACCHETTO %COMMERCE</td><td style="">06/09/2016</td><td style="">28/09/2016</td><td style="">LANGA WEB</td><td style="">16/06/2017</td><td style=""><span style="color:#F3DA0D">IN ATTESA DI CONFERMA</span></td></tr><tr data-index="8"><td style="">:170/16</td><td style="">MAGLIANO PARRUCCHIERI</td><td style="">BORSETTE IN CARTA + GRAFICA PERSONALIZZATA</td><td style="">02/09/2016</td><td style="">08/09/2016</td><td style="">LANGA PRINT</td><td style="">30/09/2016</td><td style=""><span style="color:#f37f0d">CONFERMATO</span></td></tr><tr data-index="9"><td style="">:171/16</td><td style="">TOPPINO Fuoco &amp; Design</td><td style="">SITO WEB LANGA WEB - PACCHETTO %WEB</td><td style="">08/09/2016</td><td style="">23/09/2016</td><td style="">LANGA WEB</td><td style="">15/12/2016</td><td style=""><span style="color:#F3DA0D">IN ATTESA DI CONFERMA</span></td></tr></tbody></table></div><div class="fixed-table-footer" style="display: none;"><table><tbody><tr></tr></tbody></table></div><div class="fixed-table-pagination" style=""><div class="pull-left pagination-detail"><span class="pagination-info">Pagina 1 di 10 (33 elementi)</span><span class="page-list"><span class="btn-group dropup"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="page-size">10</span> <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li class="active"><a href="javascript:void(0)">10</a></li><li><a href="javascript:void(0)">25</a></li><li><a href="javascript:void(0)">50</a></li></ul></span> elementi per pagina</span></div><div class="pull-right pagination"><ul class="pagination"><li class="page-pre"><a href="javascript:void(0)">‹</a></li><li class="page-number active"><a href="javascript:void(0)">1</a></li><li class="page-number"><a href="javascript:void(0)">2</a></li><li class="page-number"><a href="javascript:void(0)">3</a></li><li class="page-number"><a href="javascript:void(0)">4</a></li><li class="page-next"><a href="javascript:void(0)">›</a></li></ul></div></div></div></div>
<!------------------ STatic Preventivi End ------------->
	</div>
</div>
</div>
</div>

<div class="space40"></div>

<div class="row">

	<div class="col-md-6">
    <div class="panel panel-default">
	 <div class="panel-body">
    	<h1 class="cst-datatable-heading">Progetti</h1>
         <!------------------ Static Progetti Start ------------->
         
         <div class="bootstrap-table"><div class="fixed-table-toolbar"><div class="columns columns-right btn-group pull-right"><button class="btn btn-default" type="button" name="refresh" title="Aggiorna"><i class="glyphicon glyphicon-refresh icon-refresh"></i></button><div class="keep-open btn-group" title="Colonne"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-th icon-th"></i> <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li><label><input data-field="codice" value="0" checked="checked" type="checkbox"> n° progetto
            </label></li><li><label><input data-field="ente" value="1" checked="checked" type="checkbox"> Ente
            </label></li><li><label><input data-field="nomeprogetto" value="2" checked="checked" type="checkbox"> Nome progetto
            </label></li><li><label><input data-field="datainizio" value="3" checked="checked" type="checkbox"> Data inizio
            </label></li><li><label><input data-field="datafine" value="4" checked="checked" type="checkbox"> Data fine
            </label></li><li><label><input data-field="progresso" value="5" checked="checked" type="checkbox"> Progresso
            </label></li><li><label><input data-field="statoemotivo" value="6" checked="checked" type="checkbox"> Stato emotivo
        </label></li></ul></div></div><div class="pull-right search"><input class="form-control" placeholder="Cerca" type="text"></div></div><div class="fixed-table-container" style="padding-bottom: 0px;"><div class="fixed-table-header" style="display: none;"><table></table></div><div class="fixed-table-body"><div class="fixed-table-loading" style="top: 42px; display: none;">Caricamento in corso...</div><table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="http://betaeasy.langa.tv/progetti/miei/json" data-classes="table table-bordered" id="table" class="table table-bordered">
        <thead><tr><th style="" data-field="codice" tabindex="0"><div class="th-inner sortable both">n° progetto
            </div><div class="fht-cell"></div></th><th style="" data-field="ente" tabindex="0"><div class="th-inner sortable both">Ente
            </div><div class="fht-cell"></div></th><th style="" data-field="nomeprogetto" tabindex="0"><div class="th-inner sortable both">Nome progetto
            </div><div class="fht-cell"></div></th><th style="" data-field="datainizio" tabindex="0"><div class="th-inner sortable both">Data inizio
            </div><div class="fht-cell"></div></th><th style="" data-field="datafine" tabindex="0"><div class="th-inner sortable both">Data fine
            </div><div class="fht-cell"></div></th><th style="" data-field="progresso" tabindex="0"><div class="th-inner sortable both">Progresso
            </div><div class="fht-cell"></div></th><th style="" data-field="statoemotivo" tabindex="0"><div class="th-inner sortable both">Stato emotivo
        </div><div class="fht-cell"></div></th></tr></thead>
    <tbody><tr data-index="0"><td style="">::30/15</td><td style="">-</td><td style="">SITO ANTA VIGNA - RESORT</td><td style="">13/05/2015</td><td style=""></td><td style="">10</td><td style="">STRUTTURAZIONE CODICE/DESIGN</td></tr><tr data-index="1"><td style="">::19/15</td><td style="">-</td><td style="">MARKETING LANGA VIDEO</td><td style="">01/07/2015</td><td style=""></td><td style="">50</td><td style="">CODIFICAZIONE MODIFICHE</td></tr><tr data-index="2"><td style="">::20/15</td><td style="">-</td><td style="">MARKETING LANGA PRINT</td><td style="">01/06/2015</td><td style=""></td><td style="">50</td><td style="">CODIFICAZIONE MODIFICHE</td></tr><tr data-index="3"><td style="">::28/16</td><td style="">-</td><td style="">SITO AN PAIS - HOTEL</td><td style="">15/01/2016</td><td style=""></td><td style="">100</td><td style="">FINE PROGETTO</td></tr><tr data-index="4"><td style="">::29/15</td><td style="">-</td><td style="">MARKETING WHYINN GROUP</td><td style="">10/05/2015</td><td style=""></td><td style="">10</td><td style="">CODIFICAZIONE MODIFICHE</td></tr><tr data-index="5"><td style="">::16/16</td><td style="">-</td><td style="">MARKETING LANGA</td><td style="">15/02/2016</td><td style=""></td><td style="">50</td><td style="">CODIFICAZIONE MODIFICHE</td></tr><tr data-index="6"><td style="">::18/15</td><td style="">-</td><td style="">MARKETING LANGA WEB</td><td style="">01/06/2015</td><td style=""></td><td style="">50</td><td style="">CODIFICAZIONE MODIFICHE</td></tr><tr data-index="7"><td style="">::31/16</td><td style="">-</td><td style="">SITO WEB AN FRONT</td><td style="">10/03/2016</td><td style=""></td><td style="">10</td><td style="">RICHIESTA 1° REVISIONE</td></tr><tr data-index="8"><td style="">::32/15</td><td style="">-</td><td style="">SITO WEB PIANBELLO VINI</td><td style="">12/04/2015</td><td style="">12/07/2015</td><td style="">100</td><td style="">FINE PROGETTO</td></tr><tr data-index="9"><td style="">::33/15</td><td style="">-</td><td style="">SITO WEB ANTA VIGNA</td><td style="">14/10/2015</td><td style=""></td><td style="">10</td><td style="">ANALISI E SCELTA TEMA/TEMPLATE/FOOTAGE</td></tr></tbody></table></div><div class="fixed-table-footer" style="display: none;"><table><tbody><tr></tr></tbody></table></div><div class="fixed-table-pagination" style=""><div class="pull-left pagination-detail"><span class="pagination-info">Pagina 1 di 10 (72 elementi)</span><span class="page-list"><span class="btn-group dropup"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="page-size">10</span> <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li class="active"><a href="javascript:void(0)">10</a></li><li><a href="javascript:void(0)">25</a></li><li><a href="javascript:void(0)">50</a></li><li><a href="javascript:void(0)">100</a></li></ul></span> elementi per pagina</span></div><div class="pull-right pagination"><ul class="pagination"><li class="page-pre"><a href="javascript:void(0)">‹</a></li><li class="page-number active"><a href="javascript:void(0)">1</a></li><li class="page-number"><a href="javascript:void(0)">2</a></li><li class="page-number"><a href="javascript:void(0)">3</a></li><li class="page-number"><a href="javascript:void(0)">4</a></li><li class="page-number"><a href="javascript:void(0)">5</a></li><li class="page-last-separator disabled"><a href="javascript:void(0)">...</a></li><li class="page-last"><a href="javascript:void(0)">8</a></li><li class="page-next"><a href="javascript:void(0)">›</a></li></ul></div></div></div></div>
         
    	<!------------------ Static Progetti End ------------->
    </div>
    </div>
   </div>
   
    
    <div class="col-md-6">
    <div class="panel panel-default">
	 <div class="panel-body">
    	<h1 class="cst-datatable-heading">Statistiche</h1>
        
          <!------------------ Static Statistiche Start - Can use chart here ------------->
    		<div class="bootstrap-table"><div class="fixed-table-toolbar"><div class="columns columns-right btn-group pull-right"><button class="btn btn-default" type="button" name="refresh" title="Aggiorna"><i class="glyphicon glyphicon-refresh icon-refresh"></i></button><div class="keep-open btn-group" title="Colonne"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-th icon-th"></i> <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li><label><input data-field="id" value="0" checked="checked" type="checkbox"> Codice
                </label></li><li><label><input data-field="ente" value="1" checked="checked" type="checkbox"> Ente
                </label></li><li><label><input data-field="oggetto" value="2" checked="checked" type="checkbox"> Oggetto
                </label></li><li><label><input data-field="costo" value="3" checked="checked" type="checkbox"> Costo
                </label></li><li><label><input data-field="datainserimento" value="4" checked="checked" type="checkbox"> Data inserimento
            </label></li></ul></div></div><div class="pull-right search"><input class="form-control" placeholder="Cerca" type="text"></div></div><div class="fixed-table-container" style="padding-bottom: 0px;"><div class="fixed-table-header" style="display: none;"><table></table></div><div class="fixed-table-body"><div class="fixed-table-loading" style="top: 42px; display: none;">Caricamento in corso...</div><table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="http://betaeasy.langa.tv/costi/json" data-classes="table table-bordered" id="table" class="table table-bordered">
            <thead><tr><th style="" data-field="id" tabindex="0"><div class="th-inner sortable both">Codice
                </div><div class="fht-cell"></div></th><th style="" data-field="ente" tabindex="0"><div class="th-inner sortable both">Ente
                </div><div class="fht-cell"></div></th><th style="" data-field="oggetto" tabindex="0"><div class="th-inner sortable both">Oggetto
                </div><div class="fht-cell"></div></th><th style="" data-field="costo" tabindex="0"><div class="th-inner sortable both">Costo
                </div><div class="fht-cell"></div></th><th style="" data-field="datainserimento" tabindex="0"><div class="th-inner sortable both">Data inserimento
            </div><div class="fht-cell"></div></th></tr></thead>
        <tbody><tr data-index="0"><td style="">930</td><td style="">Galleri dei Fiori Bra</td><td style="">DOMINIO + HOST</td><td style="">-15</td><td style="">01/07/2016</td></tr><tr data-index="1"><td style="">1342</td><td style="">FABRIZIO TARICCO COSTRUZIONI S.r.l.</td><td style="">DOMINIO + HOST</td><td style="">-15</td><td style="">01/07/2016</td></tr><tr data-index="2"><td style="">1319</td><td style="">CANTINA ROBERTO VOERZIO</td><td style="">DOMINIO + HOSTING CONDIVISO</td><td style="">-15</td><td style="">08/09/2015</td></tr><tr data-index="3"><td style="">1376</td><td style="">LANGA WEB</td><td style="">PLUGIN - SEO Icons - Animated SVG's for WordPress</td><td style="">-9</td><td style="">29/10/2015</td></tr><tr data-index="4"><td style="">1480</td><td style="">LANGA Group</td><td style="">Swift Security Bundle - Hide WordPress, Firewall, Code Scanner</td><td style="">-32</td><td style="">31/08/2016</td></tr><tr data-index="5"><td style="">1328</td><td style="">ONORANZA FUNEBRE PALMA ROBERTO</td><td style="">DOMINIO + HOSTING CONDIVISO</td><td style="">-15</td><td style="">26/04/2016</td></tr><tr data-index="6"><td style="">1352</td><td style="">GUELFO COSTRUZIONI</td><td style="">TEMA - PRO Business - Responsive Multi-Purpose Theme</td><td style="">-53</td><td style="">25/06/2015</td></tr><tr data-index="7"><td style="">1354</td><td style="">GUELFO COSTRUZIONI</td><td style="">DOMINIO + HOSTING CONDIVISO</td><td style="">-15</td><td style="">29/10/2015</td></tr><tr data-index="8"><td style="">1353</td><td style="">GUELFO COSTRUZIONI</td><td style="">DOMINIO + HOSTING CONDIVISO</td><td style="">-15</td><td style="">27/11/2015</td></tr><tr data-index="9"><td style="">1479</td><td style="">LANGA Group</td><td style="">Row Scroll Animations for Visual Composer</td><td style="">-12</td><td style="">29/08/2016</td></tr></tbody></table></div><div class="fixed-table-footer" style="display: none;"><table><tbody><tr></tr></tbody></table></div><div class="fixed-table-pagination" style=""><div class="pull-left pagination-detail"><span class="pagination-info">Pagina 1 di 10 (114 elementi)</span><span class="page-list"><span class="btn-group dropup"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="page-size">10</span> <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li class="active"><a href="javascript:void(0)">10</a></li><li><a href="javascript:void(0)">25</a></li><li><a href="javascript:void(0)">50</a></li><li><a href="javascript:void(0)">100</a></li></ul></span> elementi per pagina</span></div><div class="pull-right pagination"><ul class="pagination"><li class="page-pre"><a href="javascript:void(0)">‹</a></li><li class="page-number active"><a href="javascript:void(0)">1</a></li><li class="page-number"><a href="javascript:void(0)">2</a></li><li class="page-number"><a href="javascript:void(0)">3</a></li><li class="page-number"><a href="javascript:void(0)">4</a></li><li class="page-number"><a href="javascript:void(0)">5</a></li><li class="page-last-separator disabled"><a href="javascript:void(0)">...</a></li><li class="page-last"><a href="javascript:void(0)">12</a></li><li class="page-next"><a href="javascript:void(0)">›</a></li></ul></div></div></div></div>
    
      <!------------------ Static Statistiche END ------------->
    </div>

</div>
</div>
</div>
@endsection