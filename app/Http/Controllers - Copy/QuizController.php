<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Redirect;
use DB;
use Storage;
use Mail;

use App\Http\Requests;

class QuizController extends Controller
{
	
	public function __construct(){
	   $this->middleware('auth');
	}   

	public function index(Request $request){

		return view('quiz.quiz', [          
			'optional' => DB::table('optional')
						->get(),
			'default' => DB::table('optional')
						->first()        
		]);
	}

	public function stepone(Request $request){
	  	return view('quiz.step-one');
	}

	public function checkentity(Request $request){	  	

		$step = DB::table('corporations')
			->where('nomeazienda', $request->company_name)
			->first();
 		
		if(!empty($step->nomeazienda)) {			
			
			$quiz_user = DB::table('quiz_user')
				->where('ente_id', $step->id)
				->where('user_id', $request->user()->id)
				->get();

			if(!empty($quiz_user)) {
				return json_encode($step);
			} else {
				return "true";
			}      
		} else {
			return "true";
		}
	}

	public function storestepone(Request $request){
	  	
		$validator = Validator::make($request->all(), [
		  'nome_azienda' => 'required',
		  'ref_name' => 'required',
		  'settore_merceologico' => 'required',
		  'vat' => 'required',
		  'indirizzo' => 'required',
		  'telefono' => 'required',
		  'email' => 'required',
		]);
				
		if($validator->fails()) {
		  return Redirect::back()
			->withInput()
			->withErrors($validator);
		}       

		$step = DB::table('corporations')
				->select('id','nomeazienda')
				->where('nomeazienda', $request->nome_azienda)
				->first();
 
		if(!empty($step->nomeazienda)) {
				 
				$quiz_user = DB::table('quiz_user')
					->where('ente_id', $step->id)
					->where('user_id', $request->user()->id)
					->get();

				if(!empty($quiz_user)) {
					return "false";

				} else {

					DB::table('quiz_user')
						->insert([
							'ente_id' => $step->id,
							'user_id' => $request->user()->id
					]);
		  
					return "true";
				}           
		} 


		// Storage::put('images/quiz/'. $request->file('file')->getClientOriginalName(), file_get_contents($request->file('file')->getRealPath())
		// );	

		$ente_id = DB::table('corporations')
			->insertGetId([
				'nomeazienda' => $request->nome_azienda,
				'user_id' => $request->user()->id,
				'nomereferente' => $request->ref_name,
				'settore' => $request->settore_merceologico,
				'piva' => $request->vat,
				'indirizzo' => $request->indirizzo,
				'telefonoazienda' => $request->telefono,
				'email' => $request->email,
				'logo' => $request->filename
		]);         
	  
		$quiz_id = DB::table('quiz_dati')
			->insertGetId([
				'nome_azienda' => $request->nome_azienda,
				'user_id' => $request->user()->id,
				'ref_name' => $request->ref_name,
				'settore_merceologico' => $request->settore_merceologico,
				'vat_number' => $request->vat,
				'indirizzo' => $request->indirizzo,
				'telefono' => $request->telefono,
				'email' => $request->email,
				'logo' => $request->filename
		]);

		DB::table('quiz_user')
			->insert([
				'quiz_id' => $quiz_id,
				'ente_id' => $ente_id,
				'user_id' => $request->user()->id
		]);
		
		return $quiz_id;

	}

	public function checkpayment(Request $request)
	{   
		$comp_name = $request->input('nome_azienda');
		
		$step = DB::table('corporations')
				->select('id','nomeazienda')
				->where('nomeazienda', $comp_name)
				->orderBy('created_at', 'desc')
				->first();
 
		if(!empty($step->nomeazienda)) {

			$status = DB::table('payment_status')
				->select('payment_status')
				->where('nome_azienda', $step->nomeazienda)
				->first();

			if(!empty($status->payment_status)) {
				return $status->payment_status;
			}
		} else {
			return "false";
		}
 
	}

	public function oldente(Request $request)
	{   
		
		$step = DB::table('corporations')
				->select('id','nomeazienda')
				->where('nomeazienda', $request->nome_azienda)
				->first();
		
		$quiz_user = DB::table('quiz_user')
			->where('ente_id', $step->id)
			->where('user_id', $request->user()->id)
			->orderBy('created_at', 'desc')
			->first();

		return $quiz_user->quiz_id;
 
	}

	public function newente(Request $request)
	{   
		$ente = DB::table('corporations')
				->select('id','nomeazienda')
				->where('nomeazienda', $request->nome_azienda)
				->first();

		$quiz_id = DB::table('quiz_dati')
		->insertGetId([
			'nome_azienda' => isset($request->nome_azienda) ? $request->nome_azienda : '',
			'user_id' => $request->user()->id,
			'ref_name' => isset($request->ref_name) ? $request->ref_name : '',
			'settore_merceologico' => isset($request->settore_merceologico) ? $request->settore_merceologico : '',
			'vat_number' => isset($request->vat) ? $request->vat : '',
			'indirizzo' => isset($request->indirizzo) ? $request->indirizzo : '',
			'telefono' => isset($request->telefono) ? $request->telefono : '', 
			'email' => isset($request->email) ? $request->email : '',
		]);

		DB::table('quiz_user')
			->insert([
				'quiz_id' => $quiz_id,
				'ente_id' => $ente->id,
				'user_id' => $request->user()->id
		]);
		
		return $quiz_id;
 
	}


	public function logoupload(Request $request){
		
		return $request->all();

		Storage::put(
			'images/quiz/' . $request->file('file')->getClientOriginalName(), file_get_contents($request->file('file')->getRealPath())
		);

		$nome = $request->file('file')->getClientOriginalName();	

	}


	public function steptwo(Request $request){ 

		$last_show = DB::table('demo_detail_show')
			->where('user_id', $request->user()->id)
			->where('quiz_id', $request->id)
			->orderBy('show_date', 'desc')
			->first();	

		if($last_show) {
	 		
			return view('quiz.step-two', [
				'quizdemodettagli' => DB::table('quizdemodettagli')->get(),
				'demodettagli' => DB::table('quizdemodettagli')               
		 			->where('id', $last_show->quizdemodettagli_id)
		 			->first(),	
		 		'alreadyrate' => DB::table('quiztype_user_rat')
					->where('quiz_id', $request->id)
					->first(),
				'ratType' => DB::table('quiz_rating_type')->get(),
				'payment_status' => DB::table('payment_status')
					->where('quiz_id', $request->id)
					->first(),				
				'quizid'=>$request->id,                 
				'detail_id'=>$request->id,
				'last_show' => $last_show,
			]);

		} else {

			return view('quiz.step-two', [          
			'quizdemodettagli' => DB::table('quizdemodettagli')->get(),
			'quizid' =>$request->id,            
			]);

		}
		
	}

	public function getQuizDetails(Request $request){

		DB::table('demo_detail_show')
			->insert([
				'quizdemodettagli_id' => $request->id,
				'user_id' => $request->user()->id,
				'quiz_id' => $request->quizid
		]);

		return view('quiz.step-two-details', [
			'demodettagli' => DB::table('quizdemodettagli')                 
					->where('id', $request->id)
					->first(),
			'alreadyrate' => DB::table('quiztype_user_rat')                 
					->where('quiz_rating_type_id', $request->id)
					->where('quiz_id', $request->quizid)
					->first(),
			'ratType' => DB::table('quiz_rating_type')->get(),					
			'quizid'=>$request->quizid,                 
			'detail_id'=>$request->id,
		]);
	}

	public function saveRatDetails(Request $request){

		$alreadyRat = DB::table('quiztype_user_rat')			
			->where('demo_detail_id', $request->demo_detail_id)
			->where('quiz_id', $request->quiz_id)
			->where('user_id', $request->user()->id)
			->where('quiz_rating_type_id', $request->quiz_rating_type_id)->count();     
		if($alreadyRat>0){
			   DB::table('quiztype_user_rat')
			   		->where('demo_detail_id', $request->demo_detail_id)
				    ->where('quiz_id', $request->quiz_id)
				    ->where('user_id', $request->user()->id)
				    ->where('quiz_rating_type_id', $request->quiz_rating_type_id)
				    ->update(array('rating' => $request->rating));
		}
		else {
			DB::table('quiztype_user_rat')
				->insert([
					'quiz_id' => $request->quiz_id,
					'user_id' => $request->user()->id,
					'demo_detail_id' => $request->demo_detail_id,
					'quiz_rating_type_id' => $request->quiz_rating_type_id,
					'rating' => $request->rating					
			]);
		}

		// getting avg rate
		$rating_type_avg = DB::table('quiztype_user_rat')
			->select(DB::raw('AVG(rating) as average'))
			->where('quiz_rating_type_id', $request->quiz_rating_type_id)
			->where('demo_detail_id', $request->demo_detail_id)->get();

		// check already rated or not
		$already = DB::table('quiz_avg_rate')			
			->where('demo_detail_id', $request->demo_detail_id)
			->where('rating_type_id', $request->quiz_rating_type_id)->count();  

		if($already > 0){			
		   	$true = DB::table('quiz_avg_rate')
		   		->where('demo_detail_id', $request->demo_detail_id)
			    ->where('rating_type_id', $request->quiz_rating_type_id)
			    ->update(array('average' => round($rating_type_avg[0]->average)));
		} else {
			
			$true = DB::table('quiz_avg_rate')->insert([
				'demo_detail_id' => $request->demo_detail_id,
				'rating_type_id' => $request->quiz_rating_type_id,
				'average' => round($rating_type_avg[0]->average)
			]);		                  	
		}

		// DB::table('quiz_rating_type')
	 //   		->where('rating_id', $request->quiz_rating_type_id)
		//     ->update(array('avg_rate' => $rating_type_avg[0]->average));
		
		$rating_demo_avg = DB::table('quiz_avg_rate')
			->select(DB::raw('AVG(average) as average'))
			->where('demo_detail_id', $request->demo_detail_id)->get();

		DB::table('quizdemodettagli')
	   		->where('id', $request->demo_detail_id)
		    ->update(array('tassomedio' => round($rating_demo_avg[0]->average)));

		return round($rating_demo_avg[0]->average);

		/* before 14-06-2017 1:00 pm */

		// $totalRater = DB::table('quiztype_user_rat')->where('quiz_rating_type_id', $request->quiz_rating_type_id)->count();     
		// $toatRating = DB::table('quiztype_user_rat')->where('quiz_rating_type_id', $request->quiz_rating_type_id)->sum('rating');
		// $averageRat = ($toatRating / $totalRater);      

		// DB::table('quiztype_average_rat')
		// 	->insert([
		// 		'quiz_id' => $request->quiz_id,
		// 		'quiz_rating_type_id' => $request->quiz_rating_type_id,
		// 		'average_rat' => $averageRat
		// ]);

		// $avgrat = DB::table('quiztype_user_rat')
		// 	->select('rating')						
		// 	->where('quiz_rating_type_id', $request->quiz_rating_type_id)
		// 	->get();  
		// $count = $avgrat->count();

		// $total = 0;
		// foreach ($avgrat as $value) {
		// 	$total = $total + $value->rating;
		// }

		// $avg = $total/$count;

		// if($avg){

		// 	DB::table('quiz_rating_type')
		// 		->where('rating_id', $request->quiz_rating_type_id)
		// 		->update(array('avg_rate' => $avg));

		// 	DB::table('quizdemodettagli')
		// 		->where('id', $request->detail_id)
		// 		->update(array('tassomedio' => $avg));
		// }
		
	}
	
	public function stepthree(Request $request){

	  return view('quiz.step-three', [              
			'quizid' => $request->id,
			'fontsize' => DB::table('quiz_fontsize')->get(),
			'fontfamily' => DB::table('quiz_fontfamily')->get(),                
			'payment_status' => DB::table('payment_status')
					->where('quiz_id', $request->id)->first(),
			'oldquiz' => DB::table('quiz_dati')
				->leftjoin('quiz_pages', 'quiz_pages.quiz_id', '=',
					'quiz_dati.id')
				->select(DB::raw('quiz_pages.*, quiz_dati.*'))
				->where('quiz_dati.id', $request->id)->first()       
		]);
	}

	public function storeStepthree(Request $request){
	  
		$validator = Validator::make($request->all(), [
			'pages' => 'required',
			'colore_primario' => 'required',
		]);
				
		if($validator->fails()) {
		  return Redirect::back()
			->withInput()
			->withErrors($validator);
		}   

		$pacchetto = DB::table('pacchetto')
				->where('id', 1)
				->first();

		$quiz = DB::table('quiz_user')
			->leftjoin('quiz_dati', 'quiz_user.quiz_id', '=',
				'quiz_dati.id')
			->select(DB::raw('quiz_user.*, quiz_dati.id as quiz_id, quiz_dati.nome_azienda, quiz_dati.settore_merceologico,quiz_dati.indirizzo, quiz_dati.telefono'))
			->where('quiz_user.quiz_id', $request->quiz_id)
			->first();

		$pacchetto_pages = $pacchetto->pagine_totali;
		$pacchetto_price = $pacchetto->prezzo_pacchetto;
		$price_perpage = $pacchetto->per_pagina_prezzo;

		$pages = $request->input('pages');
		$total_pages = substr_count($pages, ',') + 1;

		if( $total_pages > $pacchetto_pages ) {
			$extra_pages = $total_pages - $pacchetto_pages;
			$additional_price = $price_perpage * $extra_pages;
			$pacchetto_price = $pacchetto_price + $additional_price;
		} 

		$get =DB::table('quiz_pages')
			->where('quiz_id', $quiz->quiz_id)
			->first();

		if($get) {
			
			$true = DB::table('quiz_pages')
				->where('id', $get->id)
				->update(array(                 
					'pagine' => $pages,
					'totale_pagine' => $total_pages,                
					'colore_primario' => $request->colore_primario,
					'colore_secondario' => isset($request->colore_secondario) ? 					$request->colore_secondario : '',
					'colore_alternativo' => isset($request->colore_alternativo) ? $request->colore_alternativo : '',
					'font_dimensione' => isset($request->fontsize) ? $request->fontsize : '',
					'font_famiglia' => isset($request->fontfamily) ? $request->fontfamily : '',
					'paragrafo' => isset($request->font_preview) ? $request->font_preview : ''
				));  
				
				DB::table('order_record')
				->where('quiz_id', $get->quiz_id)
				->where('pacchetto_id', '!=', 0)
				->update(array(             
					'qty' => $total_pages,
					'prezzo_base' => $pacchetto->prezzo_pacchetto,
					'prezzo_totale' => $pacchetto_price
				));  

				$updated =DB::table('order_record')
					->where('quiz_id', $quiz->quiz_id)
					->get();

				$updated_price = 0;
				foreach ($updated as $update) {
					$updated_price = $updated_price + $update->prezzo_totale;
				}

				DB::table('quiz_order')
				->where('quiz_id', $get->quiz_id)
				->update(array(             
					'totale_prezzo' => $updated_price
				)); 

		} else {

			$true = DB::table('quiz_pages')
			->insert([
				'user_id' => $request->user()->id,
				'quiz_id' => $quiz->quiz_id,
				'pagine' => $pages,
				'totale_pagine' => $total_pages,                
				'colore_primario' => $request->colore_primario,
				'colore_secondario' => isset($request->colore_secondario) ? $request->colore_secondario : '',
				'colore_alternativo' => isset($request->colore_alternativo) ? $request->colore_alternativo : '',
				'font_dimensione' => isset($request->fontsize) ? $request->fontsize : '',
				'font_famiglia' => isset($request->fontfamily) ? $request->fontfamily : '',
				'paragrafo' => isset($request->font_preview) ? $request->font_preview : ''
				
			]);

			$order_id = DB::table('quiz_order')
				->insertGetId([
					'quiz_id' => $quiz->quiz_id,
					'user_id' => $request->user()->id,
					'nome_azienda' => $quiz->nome_azienda,
					'settore_merceologico' => $quiz->settore_merceologico,
					'indirizzo' => $quiz->indirizzo,
					'telefono' => $quiz->telefono,
					'totale_elementi' => 1,             
					'totale_prezzo' => $pacchetto_price
				]);

				DB::table('order_record')
				->insert([
					'order_id' => $order_id,
					'quiz_id' => $quiz->quiz_id,
					'nome_azienda' => $quiz->nome_azienda,  
					'pacchetto_id' => $pacchetto->id,
					'optional_id' => '',
					'tipo' => 'pacchetto',
					'qty' => $total_pages,
					'prezzo_base' => $pacchetto->prezzo_pacchetto,
					'prezzo_totale' => $pacchetto_price
				]);

		}
		
		if($true){                  
			return "success";
		} else {
			return "fail";
		}
	}

	public function stepfour(Request $request){
	  
	  return view('quiz.step-four', [
	  		'cart' => DB::table('store_optioanl')
	  			->where('quiz_id', $request->id)
	  			->orderBy('id', 'desc')->get(),
			'optional' => DB::table('optional')->get(),
			'payment_status' => DB::table('payment_status')
					->where('quiz_id', $request->id)->first(),
			'default' => DB::table('optional')->first(),
			'quizid' =>$request->id
		]);
	}

	public function storestepfour(Request $request){
	  
		$quiz = DB::table('quiz_user')
			->leftjoin('quiz_dati', 'quiz_user.quiz_id', '=',
				'quiz_dati.id')
			->select(DB::raw('quiz_user.*, quiz_dati.id as quiz_id, quiz_dati.nome_azienda, quiz_dati.settore_merceologico,quiz_dati.indirizzo, quiz_dati.telefono'))
			->where('quiz_user.quiz_id', $request->quiz_id)
			->first();

		$order = DB::table('quiz_order')
			->where('quiz_id', $quiz->quiz_id)
			->first();

		$totale_elementi = $order->totale_elementi + 1;
		$totale_prezzo = $order->totale_prezzo + $request->price;

		$true = DB::table('store_optioanl')
			->insert([
				'user_id' => $request->user()->id,
				'quiz_id' => $quiz->quiz_id,
				'optional_id' => $request->optioan_id,
				'label' => $request->icon_label,                
				'description' => $request->icon_description, 
				'price' => $request->price              
		]);

		if($true){

			DB::table('order_record')
			->insert([
				'order_id' => $order->order_id,
				'quiz_id' => $quiz->quiz_id,
				'nome_azienda' => $quiz->nome_azienda,  
				'pacchetto_id' => '',
				'optional_id' => $request->optioan_id,
				'label' => $request->icon_label,                
				'description' => $request->icon_description,
				'tipo' => 'optional',
				'qty' => 1,
				'prezzo_base' => $request->price,
				'prezzo_totale' => $request->price
			]);

			DB::table('quiz_order')
				->where('quiz_id', $quiz->quiz_id)               
				->update(array(
					'totale_elementi' => $totale_elementi,
					'totale_prezzo' => $totale_prezzo
				));

			return "true";

		} else {
			return "false";
		}
	}

	public function stepfive(Request $request){
	  
	  	return view('quiz.step-five', [
  			'quizfiles' => DB::table('media_files')->select('*')->where('master_id', $request->id)->where('master_type', '4')->get(),
	      	'quizid' =>$request->id,
	      	'lastupdated' => DB::table('media_files')->select('*')
	      		->where('master_id', $request->id)->where('master_type', '4')
	      		->orderBy('updated_at', 'desc')->first(),
	      	'payment_status' => DB::table('payment_status')
					->where('quiz_id', $request->id)->first(),
	    ]);
	}

	public function storestepfive(Request $request)
	{
		return $request->dataX;
		  		
		$step = DB::table('corporations')
	    		->select('id','nomeazienda')
	    		->where('nomeazienda', $request->nome_azienda)
                ->first();
        		 
		$quiz_user = DB::table('quiz_user')
			->where('ente_id', $step->id)
			->where('user_id', $request->user()->id)
			->orderBy('created_at', 'desc')
            ->first();

        return $quiz_user->quiz_id;
 
	}

	public function stepfivesaveimage(Request $request){
	  
	  	$imgid = $request->input('imgid');
	  	$img = $request->input('img');	  
	  	
	  	define('UPLOAD_DIR', 'storage/app/images/quiz/');
	    $base64img = str_replace('data:image/jpeg;base64,', '', $img);
	    $data = base64_decode($base64img);

	    $date = date("h:i:sa");	  
	    $date = str_replace(':', '-', $date);
	    $filename = "img_".$date.".jpg";
	    $file = UPLOAD_DIR . $filename;
	    file_put_contents($file, $data);

  		$true = DB::table('media_files')
			->where('id', $imgid)               
			->update(array( 'name' => $filename, 'updated_at' => date("Y-m-d H:i:s")));
		return $true;
	}

	public function fileviewer(Request $request)
	{
		$src='http://betaeasy.langa.tv/storage/app/images/appunti%202%20per%20langa.docx';

		return "<iframe src='https://view.officeapps.live.com/op/embed.aspx?src='".$src."' width='100%' height='100%' frameborder='0'></iframe>";
		
	}

	public function fileupload(Request $request){
			
		Storage::put(
			'images/quiz/' . $request->file('file')->getClientOriginalName(), file_get_contents($request->file('file')->getRealPath())
		);

		$nome = $request->file('file')->getClientOriginalName();	

		DB::table('media_files')->insert([
			'name' => $nome,
			'code' => $request->code,
			'master_type' => 4,
			'master_id' => isset($request->quizid) ? $request->quizid : 0
		]);						

	}
	
	public function fileget(Request $request){
			
		if(isset($request->quote_id)){
			$updateData = DB::table('media_files')->where('master_id', $request->quote_id)->get();										
		}
		else {
			$updateData = DB::table('media_files')->where('code', $request->code)->get();
		}
		
		foreach($updateData as $prev) {
			$imagPath = url('/storage/app/images/quiz/'.$prev->name);
			$titleDescriptions = (!empty($prev->title)) ? '<hr><strong>'.$prev->title.'</strong><p>'.$prev->description.'</p>' : "";			
			$html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100" onclick="displayFile(this, '.$prev->id.' )"><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-trash"></i></a>'.$titleDescriptions.'</td></tr>';
			$html .='<tr class="quoteFile_'.$prev->id.'"><td>';

			$utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', 0)->get();							
			foreach($utente_file as $key => $val){
				if($request->user()->dipartimento == $val->ruolo_id){
					$response = DB::table('media_files')->where('id', $prev->id)->update(array('type' => $val->ruolo_id));	    
					
					$specailcharcters = array("'", "`");
                    $rolname = str_replace($specailcharcters, "", $val->nome_ruolo);
                    $html .=' <div class="cust-checkbox"><input type="checkbox" checked="checked" name="rdUtente_'.$prev->id.'" id="'.$rolname.'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.',this.id);"  value="'.$val->ruolo_id.'" /><label for="'.$rolname.'_'.$prev->id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';
				}
				else {
					$specailcharcters = array("'", "`");
                    $rolname = str_replace($specailcharcters, "", $val->nome_ruolo);
                    $html .=' <div class="cust-checkbox"><input type="checkbox" name="rdUtente_'.$prev->id.'" id="'.$rolname.'_'.$prev->id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.',this.id);"  value="'.$val->ruolo_id.'" /><label for="'.$rolname.'_'.$prev->id.'"> '.$val->nome_ruolo.'</label><div class="check"><div class="inside"></div></div></div>';
				}
			}
			echo $html .='</td></tr>';
		}
		exit;		
		
	}
		
	public function filedelete(Request $request){
	
	    $response = DB::table('media_files')->where('id', $request->id)->delete();
		if($response){
			echo 'success';
		}
		else {
			echo 'fail';
		}
		exit;
	}

	public function quizupdatemediaComment(Request $request){	

		$updateData = DB::table('media_files')->where('code', $request->code)->orderBy('id', 'desc')->first();

		$title = $request->title;
		$descriptions = $request->descriptions;	

		$response = DB::table('media_files')->where('date_time', $updateData->date_time)->update(array('description' => $descriptions,'title'=>$title));	   

		echo ($response) ? 'success' :'fail';   	

		exit;
	}

	public function stepsix(Request $request){
 		
 		$departments = DB::table('departments')
			->where('nomedipartimento', 'LANGA WEB')->first();

		$reference = DB::table('corporations')
			->where('nomeazienda', 'LANGA WEB INFORMATICA')->first();

	  	return view('quiz.step-six', [
	    	'quizid' => $request->id,
	    	'quiz_logo' =>  DB::table('quiz_dati')
	    		->select('logo')->where('id', $request->id)->first(),
	    	'order' =>  DB::table('quiz_order')
		    	->where('quiz_id', $request->id)->first(),
		    'quote' =>  DB::table('quotes')
		    	->where('quiz_id', $request->id)
		    	->orderBy('created_at', 'desc')->first(),
		    'order_record' => DB::table('order_record')
		    	->where('quiz_id', $request->id)->get(),
		    'vat' =>  DB::table('tassazione')
		    	->where('tassazione_nome', 'iva')->first(),
		    'payment_status' => DB::table('payment_status')
					->where('quiz_id', $request->id)->first(),			
	    ])->with('departments', $departments)->with('reference', $reference);
	}

	public function stepsixSendEmail(Request $request){

		$emails = explode(",", $request->input('email'));
		$quizid = $request->input('quizid');

		$departments = DB::table('departments')
			->where('nomedipartimento', 'LANGA WEB')->first();

		$reference = DB::table('corporations')
			->where('nomeazienda', 'LANGA WEB INFORMATICA')->first();

		$quote = DB::table('quotes')->where('quiz_id', $quizid)
		    	->orderBy('created_at', 'desc')->first();

		$order = DB::table('quiz_order')
		    	->where('quiz_id', $quizid)->first();
		
		foreach ($emails as $email) {

			Mail::send('layouts.payment', ['quote' => $quote, 'departments' => $departments, 'reference' => $reference, 'order' => $order,'emailutente' => $email], function ($m) use ($email) {
	            $m->from('easy@langa.tv', 'Easy LANGA');            
	            $m->to($email)->subject('Payment Confirmation');
       		});
		}
	}

	public function stepsixconfirm(Request $request){

		$quizid = $request->input('quizid');
		$payment_status = $request->input('payment_status');

		$order = DB::table('quiz_order')->where('quiz_id', $quizid)
				->first();
		
		$quoteid = DB::table('quotes')->insertGetId([
			'quiz_id' => $order->quiz_id,
			'user_id' => $order->user_id,
			'nome_azienda' => $order->nome_azienda,
			'email' => $order->nome_azienda,
			'settore_merceologico' => $order->settore_merceologico,	
			'vat_number' => $order->vat_number,
			'indirizzo' => $order->indirizzo,
			'telefono' => $order->telefono,	
			'totale_elementi' => $order->totale_elementi,
			'totale' => $order->totale_prezzo
		]);	

		DB::table('payment_status')->insert([
			'quiz_id' => $order->quiz_id,
			'user_id' => $order->user_id,
			'nome_azienda' => $order->nome_azienda,
			'email' => $order->nome_azienda,
			'vat_number' => $order->vat_number,
			'indirizzo' => $order->indirizzo,
			'telefono' => $order->telefono,	
			'totale' => $order->totale_prezzo,
			'payment_status' => $payment_status
		]);	

		return $quoteid;	
	}

}
