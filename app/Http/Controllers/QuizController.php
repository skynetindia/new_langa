<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Redirect;
use DB;
use Storage;
use Mail;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\PaypalController;
use Paypal;

class QuizController extends Controller
{
	
	 private $_apiContext;
	 protected $logmainsection;


    public function __construct()
    {
		 $this->middleware('auth');
        $this->_apiContext = PayPal::ApiContext(

            config('services.paypal.client_id'),

            config('services.paypal.secret'));


        $this->_apiContext->setConfig(array(

            'mode' => 'sandbox',

            'service.EndPoint' => 'https://api.sandbox.paypal.com',

            'http.ConnectionTimeOut' => 30,

            'log.LogEnabled' => true,

            'log.FileName' => storage_path('logs/paypal.log'),

            'log.LogLevel' => 'FINE'

        ));


    }


	public function index(Request $request){
		
		return view('quiz.quiz', [          
			'optional' => DB::table('optional')->where('escludi_da_quiz', 1)->get(),
			'default' => DB::table('optional')->where('escludi_da_quiz', 1)->first()        
		]);
	}

	public function stepone(Request $request){
	  	return view('quiz.step-one');
	}

	public function checkentity(Request $request){	  	
		DB::enableQueryLog();
		$step = DB::table('corporations')
		->select("nomeazienda as label","nomereferente","settore","piva","indirizzo","telefonoazienda","email","user_id","id")
			->where("nomeazienda", 'like','%'.$request->company_name.'%')->where('is_deleted',0)
			->get()->toarray();
 		
		return json_encode($step);
	}
	/*public function checkentity(Request $request){	  	

		$step = DB::table('corporations')
		->select("nomeazienda","nomereferente","settore","piva","indirizzo","telefonoazienda","email","user_id","id")
			->where("nomeazienda", 'like','%'.$request->company_name.'%')
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
	}*/

	public function storestepone(Request $request){
	  	
		/*$validator = Validator::make($request->all(), [
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
		} */      

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
				} 
				else {
					DB::table('quiz_user')
						->insert([
							'ente_id' => $step->id,
							'user_id' => $request->user()->id
					]);		  
					return "true";
				}           
		} 
		$logoquiz="";
		// Memorizzo l'immagine nella cartella public/imagesavealpha
		//Storage::put('images/quiz/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath()));
		//$logoquiz = $request->file('logo')->getClientOriginalName();

		/*Storage::put('images/quiz/'. $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath()));*/

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
				'logo' => isset($logoquiz) ? $logoquiz : ''
		]);         
	  
		$quiz_id = DB::table('quiz_dati')
			->insertGetId([
				'nome_azienda' => $request->nome_azienda,
				'user_id' => $request->user()->id,
				'ref_name' => $request->ref_name,
				'settore_merceologico' => $request->settore_merceologico,
				'vat_number' => $request->vat,
				'indirizzo' => $request->indirizzo,
				/*'state_id' => $request->state,
				'city_id' => $request->city,*/
				'telefono' => $request->telefono,
				'email' => $request->email,
				'logo' => isset($logoquiz) ? $logoquiz : ''
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
		$alltheme=DB::table('quiztype_user_rat')->select('demo_detail_id')
			->where('user_id', $request->user()->id)
			->where('quiz_id', $request->id)->distinct()->get();
		$last_show = DB::table('demo_detail_show')
			->where('user_id', $request->user()->id)
			->where('quiz_id', $request->id)
			->first();	
			$quizdetail=DB::table('quiz_dati')
		 			->where('id', $request->id)
		 			->first();

		if($last_show) {
			$alldemo=[];
	 		foreach($alltheme as $allt):
			$alldemo[]=$allt->demo_detail_id;
			endforeach;
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
				'alldemo'=>$alldemo,                 
				'detail_id'=>$request->id,
				'last_show' => $last_show,
				'quizdetail'=>$quizdetail,
				]);

		} else {

			return view('quiz.step-two', [          
			'quizdemodettagli' => DB::table('quizdemodettagli')->get(),
			'quizid' =>$request->id, 
			'quizdetail'=>$quizdetail ,	          
			]);

		}
		
	}

	public function getQuizDetails(Request $request){
		$curr_timestamp = date('Y-m-d H:i:s');
		DB::table('quiz_dati')
			->where('id', $request->quizid)
			
			->increment('rate_counter',1,['rate_id'=>$request->id,'updated_at'=>$curr_timestamp]);
		
		$demodettagli = DB::table('demo_detail_show')
			->where('quiz_id', $request->quizid)
			->first();
		
		if(isset($demodettagli)){
			
			DB::table('demo_detail_show')
			    ->where('quiz_id', $demodettagli->quiz_id)
				->update(array('view_count' => $request->view_count, 'quizdemodettagli_id' => $request->id, 'show_date' => $curr_timestamp));
		} else {
			DB::table('demo_detail_show')->insert([
				'quizdemodettagli_id' => $request->id,
				'user_id' => $request->user()->id,
				'quiz_id' => $request->quizid,
				'view_count' => $request->view_count,
				'show_date' => $curr_timestamp
			]);
		}

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
		
		$avg_rate = DB::table('quiztype_user_rat')
			->select(DB::raw('AVG(rating) as average'))
			->where('quiz_rating_type_id', $request->quiz_rating_type_id)
			->get();
			
			DB::table('quiz_rating_type')
			->where('rating_id', $request->quiz_rating_type_id)
			->increment('tot_counter',1,['avg_rate'=>$avg_rate[0]->average]);
			
			
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
		
		$rating_demo_avg = DB::table('quiztype_user_rat')
			->select(DB::raw('AVG(rating) as average'))
			->where('demo_detail_id', $request->demo_detail_id)->where('quiz_id', $request->quiz_id)->get();

		// $rating_demo_avg = DB::table('quiz_avg_rate')
		// 	->select(DB::raw('AVG(average) as average'))
		// 	->where('demo_detail_id', $request->demo_detail_id)->get();
		// return $rating_demo_avg;

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
				->where('is_active', 1)
				->first();

		$quiz = DB::table('quiz_user')
			->leftjoin('quiz_dati', 'quiz_user.quiz_id', '=',
				'quiz_dati.id')
			->select(DB::raw('quiz_user.*, quiz_dati.id as quiz_id, quiz_dati.nome_azienda, quiz_dati.vat_number, quiz_dati.settore_merceologico,quiz_dati.indirizzo, quiz_dati.telefono'))
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
					'colore_secondario' => isset($request->colore_secondario) ?$request->colore_secondario : '',
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
					'label' => isset($pacchetto->nome_pacchetto) ?$pacchetto->nome_pacchetto : '-',
					'description' => isset($pacchetto->description) ? $pacchetto->description."-". $pages: '-',
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
					'vat_number' => $quiz->vat_number,
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
					'label' => isset($pacchetto->nome_pacchetto) ?$pacchetto->nome_pacchetto : '-',
					'description' => isset($pacchetto->description) ? $pacchetto->description."-". $pages: '-',
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
		
		$optioanl = DB::table('store_optioanl')
			->select('label','optional_id','id')->where('quiz_id', $request->id)
	  		->orderBy('id', 'desc')->get()->toArray();

		$quizDetails = DB::table('quiz_dati')->where('id', $request->id)->orderBy('id', 'desc')->first();
		$address = $quizDetails->indirizzo;
		$parts = explode(',', $address);
		$last = array_pop($parts);
		$parts = array(implode(',', $parts), $last);		
	  	if(isset($parts[0])){		
	  		$indexocdetails = DB::table('citta')->where('nome_citta', $parts[0])->first();
		}
		$percentage = (isset($indexocdetails->provincie) && $indexocdetails->provincie != '0') ? $indexocdetails->provincie : '1';

	  	$cart = [];
	  	foreach ($optioanl as $value) {
	  		$cart[] = $value->label;
	  	}
	  	$cart = implode(',', $cart);

	  	return view('quiz.step-four', [	  		
			'optional' => DB::table('optional')->where('escludi_da_quiz', 1)->where('dipartimento',1)->get(),
			'payment_status' => DB::table('payment_status')->where('quiz_id', $request->id)->first(),
			'default' => DB::table('optional')->where('escludi_da_quiz', 1)->where('dipartimento',1)->first(),
			'quizid' =>$request->id,
			'locationpercentage'=>$percentage,
			'cartdetail'=>$optioanl,
		])->with('cart', $cart);
	}

	public function removecart(Request $request){
		$cartid = $request->cartid;
		$response=DB::table('store_optioanl')->where('id',$cartid)->first();
		DB::table('order_record')->where(['quiz_id'=>$response->quiz_id,'optional_id'=>$response->optional_id])->delete();
		$response = DB::table('store_optioanl')->where('id',$cartid)->delete();
		return "true";
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
		$optional=DB::table('optional')->where('id', $request->optioan_id)->first();
		$true = DB::table('store_optioanl')
			->insertGetId([
				'user_id' => $request->user()->id,
				'quiz_id' => $quiz->quiz_id,
				'optional_id' => $request->optioan_id,
				'label' => isset($request->icon_label) ? $request->icon_label : "",                
				'description' => isset($request->icon_description) ? $request->icon_description : "", 
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
				'label' => isset($request->icon_label) ? $request->icon_label : '-',                
				'description' => isset($request->icon_description) ? $request->icon_description : '-',
				'tipo' => 'optional',
				'qty' => 1,
				'frequency'=>$optional->frequenza,
				'prezzo_base' => $request->price,
				'prezzo_totale' => $request->price
			]);

			DB::table('quiz_order')
				->where('quiz_id', $quiz->quiz_id)               
				->update(array(
					'totale_elementi' => $totale_elementi,
					'totale_prezzo' => $totale_prezzo
				));

			return $true;

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

			$utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', 0)->where('ruolo_id','!=','0')->get();							
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

	public function filetypeupdate(Request $request){	

		$request->ids = isset($request->ids) ? implode(",",$request->ids) : "";
		
		$response = DB::table('media_files')->where('id', $request->fileid)->update(array('type' => $request->ids));
		echo ($response) ? 'success' :'fail';   			    		
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
 		$this->stepsixsetup($request);
 		$departments = DB::table('departments')
			->where('nomedipartimento', 'LANGA WEB')->first();
		$quiz_detail = DB::table('quiz_dati')
	    	->where('id', $request->id)->first();
			
		$reference = DB::table('corporations')
			->where('nomeazienda', $quiz_detail->nome_azienda)->first();
		
		

	  	return view('quiz.step-six', [
	    	'quizid' => $request->id,
	    	'quiz_province' =>  DB::table('citta')
	    		->where('id_citta', $quiz_detail->city_id)->first(),
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
	    ])->with('departments', $departments)->with('reference', $reference)->with('quiz_detail', $quiz_detail);
	}
	
	public function stepsixsetup($request){
		$quizid = $request->id;
		$order = DB::table('quiz_order')
			->where('quiz_id', $quizid)->first();
		$entity = DB::table('corporations')
			->where('nomeazienda', $order->nome_azienda)->first();
		$date = date("d/m/Y"); $time = date("his");

		$departments = DB::table('departments')
			->where('nomedipartimento', 'LANGA WEB')->first();

		$total_project = DB::table('projects')->where('is_deleted', 0)->where('statoemotivo', '!=', 11)->count();

		$avg_project = DB::table('projects')->where('is_deleted', 0)->where('statoemotivo', '!=', 11)->avg('progresso');

		$projects = DB::table('projects')
			->select(DB::raw('AVG(progresso) as average'))
			->where('is_deleted', 0)->where('statoemotivo', '!=', 11)
			->get();

		$days = isset($total_project) ? $total_project*5 : 5;
		$remaining_avg = isset($avg_project) ? 100 - $avg_project : 0;
		
		$days = ceil($days*$remaining_avg/100);
		$year = date("Y");
		$valence = date('d/m/Y', strtotime("+ $days days"));
		$show_date = date('Y-m-d', strtotime("+ $days days"));
		$enddate = date("d/m/Y",strtotime($show_date."+7 day"));
		$quote=DB::table('quotes')->where('quiz_id',$quizid)->first();
		if(!$quote)
		{
			$quoteid = DB::table('quotes')->insertGetid([	
				'quiz_id' =>$quizid ,
				'user_id' => isset($order->user_id) ? $order->user_id : Auth::user()->id,
				'idutente' => isset($order->user_id) ? $order->user_id : Auth::user()->id,
				'idente' => $entity->id,
				'data' => isset($date) ? $date : '',
				'oggetto' => isset($order->nome_azienda) ? trans('messages.keyword_quiz_pacchetto').' '.$order->nome_azienda : '',
				'dipartimento' => isset($departments->id) ? $departments->id : 0,
				'valenza' => isset($valence) ? $valence : '',
				'finelavori' => isset($enddate) ? $enddate : '',
				'progress' => isset($remaining_avg) ? $remaining_avg : 0,
				'subtotale'=> isset($order->totale_prezzo) ? $order->totale_prezzo : 0,
				'totale' => isset($order->totale_prezzo) ? $order->totale_prezzo : 0,
				'totale_elementi' => isset($order->totale_elementi) ? $order->totale_elementi : 0,
				'anno' => date('y'),
				
			]);	
			
			$optional = DB::table('order_record')
			->where('quiz_id', $quizid)->get();
			foreach($optional as $optional)
			{
				DB::table('optional_preventivi')->insert([
				'oggetto' =>  $optional->label,
				'descrizione' =>  $optional->description,
				'qta'=>$optional->qty,
				'prezzounitario'=>$optional->prezzo_base,
				'totale'=>$optional->prezzo_totale,
				'Ciclicita'=>isset($optional->frequency)?$optional->frequency:1,
				'id_preventivo'=>$quoteid
				]);
			}
		}
		else{
			$quoteid = DB::table('quotes')->where('quiz_id',$quizid)->update([	
				
				'user_id' => isset($order->user_id) ? $order->user_id : Auth::user()->id,
				'idutente' => isset($order->user_id) ? $order->user_id : Auth::user()->id,
				'idente' => $entity->id,
				'data' => isset($date) ? $date : '',
				'oggetto' => isset($order->nome_azienda) ? trans('messages.keyword_quiz_pacchetto').' '.$order->nome_azienda : '',
				'dipartimento' => isset($departments->id) ? $departments->id : 0,
				'valenza' => isset($valence) ? $valence : '',
				'finelavori' => isset($enddate) ? $enddate : '',
				'progress' => isset($remaining_avg) ? $remaining_avg : 0,
				'subtotale'=> isset($order->totale_prezzo) ? $order->totale_prezzo : 0,
				'totale' => isset($order->totale_prezzo) ? $order->totale_prezzo : 0,
				'totale_elementi' => isset($order->totale_elementi) ? $order->totale_elementi : 0,
				'anno' => date('y'),
				
			]);	
			DB::table('optional_preventivi')->where('id_preventivo',$quote->id)->delete();
			$optional = DB::table('order_record')
			->where('quiz_id', $quizid)->get();
			foreach($optional as $optional)
			{
				DB::table('optional_preventivi')->insert([
				'oggetto' =>  $optional->label,
				'descrizione' =>  $optional->description,
				'qta'=>$optional->qty,
				'prezzounitario'=>$optional->prezzo_base,
				'totale'=>$optional->prezzo_totale,
				'Ciclicita'=>isset($optional->frequency)?$optional->frequency:1,
				'id_preventivo'=>$quote->id
				]);
			}
		}
		
			
	}
	

	public function stepsixSendEmail(Request $request){
		
		$emails = explode(",", $request->input('email'));
		$entityids = explode(",", $request->input('entityids'));
		$quizid = $request->input('quizid');

		$entities = DB::table('corporations')->wherein('id', $entityids)->get();		
		$departments = DB::table('departments')
			->where('nomedipartimento', 'LANGA WEB')->first();

		$reference = DB::table('corporations')
			->where('nomeazienda', 'LANGA WEB INFORMATICA')->first();

		$quote = DB::table('quotes')->where('quiz_id', $quizid)
		    	->orderBy('created_at', 'desc')->first();

		$order = DB::table('quiz_order')
		    	->where('quiz_id', $quizid)->first();
		
		foreach ($entities as $entitieskey => $entitiesval) {
			$email = (isset($entitiesval->email) && $entitiesval->email != "" && $entitiesval->email != null) ? $entitiesval->email : (isset($entitiesval->emailsecondaria) && $entitiesval->emailsecondaria != "" && $entitiesval->emailsecondaria != null) ? $entitiesval->emailsecondaria : "";
			if($email != ""){
			Mail::send('layouts.payment', ['quote' => $quote, 'departments' => $departments, 'reference' => $reference, 'order' => $order,'emailutente' => $email], function ($m) use ($email) {			
	            $m->from('easy@langa.tv', 'Easy LANGA');            
	            $m->to($email)->subject('Payment Confirmation');
       		});
			}
		}
		return 'true';
	}
	
	
	
	public function getentity(Request $request){
		 $label = $request->term;
		 $entity = DB::table('corporations')->where('is_deleted', '=', 0)->limit('10')->get(); 
		 if($request->user()->id != 0){               		 
				$arrwhere = array('enti_partecipanti.id_user' => $request->user()->id,'corporations.is_deleted'=> 0);           
		        $arrorwhere = array('corporations.user_id' => $request->user()->id,'corporations.is_deleted'=> 0);           
                $entity =   DB::table('corporations')     
                ->leftjoin('enti_partecipanti', 'enti_partecipanti.id_ente', '=', 'corporations.id')
                ->where($arrwhere)
                ->select('corporations.*')
                ->orwhere($arrorwhere)
				->where('nomeazienda', 'LIKE', "%$label%")						
                ->groupBy('corporations.id')
                ->limit('10')
                ->get();
            }			
			$data_return= array();
			foreach($entity as $data) {											
				 $data_return[] = array (
          		  'label' => $data->nomeazienda,
            	  'value' => $data->nomeazienda,
            	  'id' => $data->id,
            	  'email'=>$data->emailprimaria
        		);
			}
		return json_encode($data_return);	
	
	}

public function stepsixconfirm(Request $request){
	

		$quizid = $request->input('quizid');
		$payment_status = $request->input('payment_status');
		$order = DB::table('quiz_order')
			->where('quiz_id', $quizid)->first();
		
		$quote = DB::table('quotes')->where('quiz_id',$quizid)->first();
		$quoteid = DB::table('quotes')->where('quiz_id',$quizid)->update([			
			'scontoagente' => isset($request->agent_discount) ? $request->agent_discount : 0,
			'subtotale'=> isset($request->total) ? $request->total : 0,
			'totale' => isset($request->discount) ? ($request->total - $request->discount) : 0,
			'totaledapagare' => isset($request->discount_tax) ? $request->discount_tax : 0,
			'prezzo_confermato' => isset($request->discount_tax) ? $request->discount_tax : 0,
		]);	
		    
		// Get confirm state id
		$tipo = DB::table('statiemotivipreventivi')->where('id', '6')->first();
		DB::table('statipreventivi')->where('id_preventivo', $quote->id)->delete();
		DB::table('statipreventivi')->insert([
				'id_tipo' => $tipo->id,
				'id_preventivo' => $quote->id,
				'created_at'=>date('Y-m-d H:i:s')
			]);
		$payment=DB::table('payment_status')->where('quiz_id',$quizid)->first();
		if(!$payment)
		{
			DB::table('payment_status')->insert([
				'quiz_id' => isset($order->quiz_id) ? $order->quiz_id : 0,
				'user_id' => isset($order->user_id) ? $order->user_id : 0,
				'nome_azienda' => isset($order->nome_azienda) ? $order->nome_azienda : '',
				'email' => isset($order->email) ? $order->email : '',
				'vat_number' => isset($order->vat_number) ? $order->vat_number : '',
				'indirizzo' => isset($order->indirizzo) ? $order->indirizzo : '',
				'telefono'=> isset($order->telefono)?$order->telefono : '',	
				'totale' => isset($request->discount_tax) ? $request->discount_tax : 0,
				'payment_status' => $payment_status
			]);	
		}
		else
		{
			DB::table('payment_status')->where('quiz_id',$quizid)->update([
				'quiz_id' => isset($order->quiz_id) ? $order->quiz_id : 0,
				'user_id' => isset($order->user_id) ? $order->user_id : 0,
				'nome_azienda' => isset($order->nome_azienda) ? $order->nome_azienda : '',
				'email' => isset($order->email) ? $order->email : '',
				'vat_number' => isset($order->vat_number) ? $order->vat_number : '',
				'indirizzo' => isset($order->indirizzo) ? $order->indirizzo : '',
				'telefono'=> isset($order->telefono)?$order->telefono : '',	
				'totale' => isset($request->discount_tax) ? $request->discount_tax : 0,
				'payment_status' => $payment_status
			]);	
		}
		//$paypal=new PaypalController();
		return $redirect=$this->getCheckout(['amount'=>$request->total,'description'=>'Payment for quiz section purchase under '.$order->nome_azienda.'for quiz id '.$quizid]);
		 
		//return $quoteid;	
	}

	public function stepseven(Request $request){
	  	return view('quiz.step-seven');
	}
	
	public function comic(Request $request)
	{
		return view('quiz/quiz_comic', [
			'quiz_comics' => DB::table('quiz_comic')->orderBy('id', 'desc')->get()
		]);
    }

    public function addcomic(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'url' => 'required',
        ]);

        if ($request->image != null) {					
			Storage::put('images/quiz/' . $request->file('image')->getClientOriginalName(), file_get_contents($request->file('image')->getRealPath())
			);
			$request->image = $request->file('image')->getClientOriginalName();
		}

		$lang_key=$this->comiclanguage($request->title,$request->description);
		
        DB::table('quiz_comic')->insert([
            'title' => isset($request->title) ? $request->title : '',
            'description' => isset($request->description) ? $request->description : '',
            'image' => isset($request->image) ? $request->image : '',
            'url' => isset($request->url) ? $request->url : '',
            'lang_key' => isset($lang_key) ? $lang_key : ''
        ]);

        return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');
    }

    public function updatecomic(Request $request) 
    {
    	foreach($request->comic as $key => $val) {   

    		$title = isset($request->title[$key]) ? $request->title[$key] : '';
    		$description = isset($request->description[$key]) ? $request->description[$key] : '';
    		$image = isset($request->image[$key]) ? $request->image[$key] : '';
    		$url = isset($request->url[$key]) ? $request->url[$key] : '';
    		$image = DB::table('quiz_comic')->select('image')
		        ->where('id', $key)->first();
  			$arr = json_decode(json_encode($image), true);  			
			$imagename = $arr['image'];   
    		$arrfiles = $request->file('image'); 

    		if (isset($arrfiles[$key]) && $arrfiles[$key] != null) {   			
                Storage::put('images/quiz/' . $arrfiles[$key]->getClientOriginalName(), file_get_contents($arrfiles[$key]->getRealPath()));                
                $imagename = $arrfiles[$key]->getClientOriginalName();
            }    

            if($request->action == 'delete') {
				DB::table('quiz_comic')->where('id', $key)->delete();
            } else {      
	            DB::table('quiz_comic')->where('id', $key)->update(array('title'=> $title, 'description' => $description, 'image' => $imagename, 'url' => $url));
            }
        }

        $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';

        return Redirect::back()->with('msg', $msg);
    }   

    public function comiclanguage($title, $description){

	    $keyword_key = 'keyword_comic_'.str_replace(" ","_", strtolower($title));

	    $translationval =  DB::table('language_transalation')->select('*')->where('language_key', '=', $keyword_key)->first();

		if(count($translationval) > 0){
		    return $translationval->language_key;
		} else {

	        $arrLanguages =  DB::table('languages')->select('*')->where('id', '!=', 0)->get();
	        $collection = collect($arrLanguages);
	        $arrLanguages = $collection->toArray();

	        foreach($arrLanguages as $key => $val){ 
			    DB::table('language_transalation')->insert([
			        'language_key' => $keyword_key, 'language_label' =>$title,
			        'language_value' => $description, 'code' => $val->code
			    ]);               
	        }

	        \App::call('App\Http\Controllers\AdminController@writelanguagefile');
	        return $keyword_key;
        }
    }
	
	public function getDone(Request $request)
	{
	    $id = $request->get('paymentId');
	    $token = $request->get('token');
	    $payer_id = $request->get('PayerID');


	    $payment = PayPal::getById($id, $this->_apiContext);


	    $paymentExecution = PayPal::PaymentExecution();


	    $paymentExecution->setPayerId($payer_id);

	   $executePayment = $payment->execute($paymentExecution, $this->_apiContext);
	  // dd($executePayment);
	   //exit();
		//echo $description=json_encode($executePayment);
		$response=json_decode($executePayment,true);
		$trans_id=$response['id'];
		$cart=$response['cart'];
		$state=$response['state'];
		$payer=$response['payer'];
		$status=$payer['status'];
		$email=$payer['payer_info']['email'];
		$address=implode(',',$payer['payer_info']['shipping_address']);
		$transaction=$response['transactions'];
		
		$amount=$transaction[0]['amount']['total'];
		$currency=$transaction[0]['amount']['currency'];
		$description=$transaction[0]['description'];
		$quiz=explode('quiz id ',$description);
		$quizid=$quiz[1];
		$quote=DB::table('quotes')->select('id')->where('quiz_id',$quizid)->first();
		$quoteid=$quote->id;
		DB::table('payment_history')->insertGetId([
                        'user_id' 		=> Auth::user()->id,
						'type'			=>1,
						'ref_id'		=>$quizid,
						'trans_id'		=>$trans_id,
						'state'			=>$state,
						'status'		=>$status,
						'email'			=>$email,
						'cart'			=>$cart,
						'address'		=>$address,
						'amount'		=>$amount,
						'currency'		=>$currency,
						'description'	=>$description,
						'message'		=>$executePayment,
						'create_time'	=>$response['create_time']
					]);
					
		DB::table('quotes')->where('id',$quoteid)
						->update([
									'totaledapagare'		=>$amount,
									'metodo'				=>'Paypal',
									'updated_at'			=>$response['create_time']
					
					]);
		$paymentid=	DB::table('quote_paymento')->insertGetId([
									'qp_quote_id'		=>$quoteid,
									'qp_data'			=>date('Y-m-d'),
									'qp_amnt'			=>$amount,
									'qp_create_dt'		=>$response['create_time'],
									'qp_update_dt'		=>$response['create_time'],
									'qp_entryby'		=>Auth::user()->id
					
					]);
		$invoiceid=$this->createquoteinvoice($quizid);
		return view('quiz/thank-you',['invoice'=>$invoiceid]);
	}

	public function quizthanks(){
		$invoiceid=123;
		return view('quiz/thank-you',['invoice'=>$invoiceid]);

	}

	public function getCancel(Request $request)
	{
		//dd($request);
	    return Redirect::back();
		

	}
	
	public function createquoteinvoice($quoteId = "") {		
    	
    	if($quoteId=="") {
    		return false;
    	}
		$quote = DB::table('quotes')->where('quiz_id', $quoteId)->first();
		$dipartimento= (isset($quote->dipartimento) && !empty($quote->dipartimento)) ? $quote->dipartimento : '1';
		$ente = DB::table('corporations')->where('id', $quote->idente)->first();

    	$project = DB::table('projects')->where('id_preventivo', $quoteId)->first();  	  
		$tipofattura = "FATTURA DI VENDITA"; 	
		$datainserimento = date('Y-m-d', time());
	
		$enddate= isset($quote->finelavori) ? date('Y-m-d',strtotime(str_replace('/', '-',$quote->finelavori))):date('Y-m-d',strtotime("+ $this->endday days"));
	
		$emissione = date('Y-m-d', time());

		$tranche = DB::table('tranche')->insertGetId([
                        'user_id' => Auth::user()->id,
                        'id_disposizione' => isset($project->id) ? $project->id : '0',/* Project id */
						'id_quote'=> isset($quoteId) ? $quoteId: "0", /* Quote Id */
						'tipo' => 0,
						'datainserimento' => $datainserimento,
						'datascadenza' => $enddate,
						'percentuale' => 0,
						'dettagli' => isset($quote->considerazioni) ? $quote->considerazioni : '',
						'note' => isset($quote->considerazioni) ? $quote->considerazioni : '',
						'DA' => isset($quote->dipartimento) ? $quote->dipartimento : 1,
						'A' => isset($quote->idente) ? $quote->idente : '',
						'idfattura' => isset($request->idfattura) ? $request->idfattura : '',
						'emissione' => $emissione,
						'indirizzospedizione' => isset($ente->indirizzospedizione) ? $ente->indirizzospedizione : '',
						'privato' => 0,
						'base' => $quote->oggetto,
						'modalita' => 'Paypal',
						'tipofattura' => $tipofattura,
						'iban' => isset($ente->iban) ? $ente->iban : '',
						'netto' => $quote->subtotale,
						'scontoaggiuntivo' => $quote->totale,
						'imponibile' => ($quote->subtotale - $quote->totale),
						'prezzoiva' => ($quote->prezzo_confermato-($quote->subtotale - $quote->totale)),
						
						'dapagare' => $quote->prezzo_confermato,
                      ]);
		/* Medai files from project to qoute */
		$arrwhere = (isset($project->id)) ? array('master_id'=>$project->id,'master_type'=>'1') : array('master_id'=>$quoteId,'master_type'=>'0');
		$medifilesQuote = DB::table('media_files')->where($arrwhere)->get();
		foreach ($medifilesQuote as $keymq => $valuemq) {
			$mediafileid = DB::table('media_files')->insertGetId([
					'name' => 'inv'.$valuemq->name,
				    'master_id' => $tranche,
					'type' => Auth::user()->dipartimento,					
					'master_type' => 3,
					'title' => $valuemq->title,
					'description' =>$valuemq->description,
					'created_at'=>time()
				]);
			if(isset($project->id)){
				if(file_exists('storage/app/images/projects/'.$valuemq->name)){			
					copy('storage/app/images/projects/'.$valuemq->name, 'storage/app/images/invoice/inv'.$valuemq->name);
				}
			}
			else {
				if(file_exists('storage/app/images/quote/'.$valuemq->name)){			
					copy('storage/app/images/quote/'.$valuemq->name, 'storage/app/images/invoice/inv'.$valuemq->name);
				}	
			}
		}

		$logs = $this->logmainsection.' -> Add New Invoice (ID: '. $tranche . ')';
		storelogs(Auth::user()->id, $logs);

		//if($request->statoemotivo!=null) {
			// Memorizzo lo stato emotivo
			$tipo = DB::table('statiemotivipagamenti')->where('id', '12')->first();
			if(isset($tipo->id)){
				DB::table('statipagamenti')->insert([
					'id_pagamento' => $tranche,
					'id_tipo' => $tipo->id,
					'created_at'=>date('Y-m-d H:i:s')
				]);
			}
		//}
		
		/* ================= Invoice Body Sections ==================== */
		$ordine = isset($quote->id) ? ':'.$quote->id.'/'.$quote->anno : '';
		$project_refer_no = isset($project->id) ? ':'.$project->id.'/'.substr($project->datainizio, -2) : '';		
		if(isset($quote->id)) {
			$quote_optional = DB::table('optional_preventivi')->where('id_preventivo', $quote->id)->get();		
			foreach ($quote_optional as $quoteopkey => $quoteopvalue) {
				DB::table('corpofattura')->insert([
						'id_tranche' => $tranche,
						'ordine' => $ordine,
						'project_refer_no'=>$project_refer_no,
						'descrizione' => $quoteopvalue->descrizione,
						'qta' => $quoteopvalue->qta,
						'subtotale' =>$quoteopvalue->totale,
						/*'scontoagente' => isset($scontoagente[$i]) ? $scontoagente[$i] : 0 ,
						'scontobonus' => $scontobonus[$i],*/
						'netto' => $quoteopvalue->prezzounitario,						
						'percentualeiva' => 0,
						'is_active' => 0,
					]);
			}
		}
		return true;
		/*return redirect('/pagamenti/tranche/modifica/' . $tranche)
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').'!</div>');*/
	}
	
	public function getCheckout($data)

	{
		
	    $payer = PayPal::Payer();

	    $payer->setPaymentMethod('paypal');


	    $amount = PayPal:: Amount();

	    $amount->setCurrency('EUR');

	    //$amount->setTotal($data['amount']);
		 $amount->setTotal(100);

	    $transaction = PayPal::Transaction();

	    $transaction->setAmount($amount);

	    $transaction->setDescription($data['description']);


	    $redirectUrls = PayPal:: RedirectUrls();

	    $redirectUrls->setReturnUrl(route('getDone'));

	    $redirectUrls->setCancelUrl(route('getCancel'));


	    $payment = PayPal::Payment();

	    $payment->setIntent('sale');

	    $payment->setPayer($payer);

	    $payment->setRedirectUrls($redirectUrls);

	    $payment->setTransactions(array($transaction));


	    $response = $payment->create($this->_apiContext);

	   $redirectUrl = $response->links[1]->href;
		 
      
	    return $redirectUrl;

	}

}
