<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Redirect;
use DB;
use Storage;

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

	public function storestepone(Request $request){
	  
		$validator = Validator::make($request->all(), [
		  'nome_azienda' => 'required',
		  'ref_name' => 'required',
		  'settore_merceologico' => 'required',
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


		$ente_id = DB::table('corporations')
			->insertGetId([
				'nomeazienda' => $request->nome_azienda,
				'user_id' => $request->user()->id,
				'nomereferente' => $request->ref_name,
				'settore' => $request->settore_merceologico,
				'indirizzo' => $request->indirizzo,
				'telefonoazienda' => $request->telefono,
				'email' => $request->email,
		]);         
	  
		$quiz_id = DB::table('quiz_dati')
			->insertGetId([
				'nome_azienda' => $request->nome_azienda,
				'user_id' => $request->user()->id,
				'ref_name' => $request->ref_name,
				'settore_merceologico' => $request->settore_merceologico,
				'indirizzo' => $request->indirizzo,
				'telefono' => $request->telefono,
				'email' => $request->email,
		]);

		DB::table('quiz_user')
			->insert([
				'quiz_id' => $quiz_id,
				'ente_id' => $ente_id,
				'user_id' => $request->user()->id
		]);
		
		return $quiz_id;

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
				'nome_azienda' => $request->nome_azienda,
				'user_id' => $request->user()->id,
				'ref_name' => $request->ref_name,
				'settore_merceologico' => $request->settore_merceologico,
				'indirizzo' => $request->indirizzo,
				'telefono' => $request->telefono,
				'email' => $request->email,
		]);

		DB::table('quiz_user')
			->insert([
				'quiz_id' => $quiz_id,
				'ente_id' => $ente->id,
				'user_id' => $request->user()->id
		]);
		
		return $quiz_id;
 
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
			->where('quiz_id', $request->quiz_id)
			->where('user_id', $request->user()->id)
			->where('quiz_rating_type_id', $request->quiz_rating_type_id)->count();     
		if($alreadyRat>0){
			   DB::table('quiztype_user_rat')
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
					'quiz_rating_type_id' => $request->quiz_rating_type_id,
					'rating' => $request->rating,
			]);
		}

		$totalRater = DB::table('quiztype_user_rat')->where('quiz_rating_type_id', $request->quiz_rating_type_id)->count();     
		$toatRating = DB::table('quiztype_user_rat')->where('quiz_rating_type_id', $request->quiz_rating_type_id)->sum('rating');
		$averageRat = ($toatRating / $totalRater);      

		DB::table('quiztype_average_rat')
			->insert([
				'quiz_id' => $request->quiz_id,
				'quiz_rating_type_id' => $request->quiz_rating_type_id,
				'average_rat' => $averageRat
		]);

		$avgrat = DB::table('quiztype_user_rat')
			->select('rating')						
			->where('quiz_rating_type_id', $request->quiz_rating_type_id)
			->get();  
		$count = $avgrat->count();

		$total = 0;
		foreach ($avgrat as $value) {
			$total = $total + $value->rating;
		}

		$avg = $total/$count;

		if($avg){

			DB::table('quiz_rating_type')
				->where('rating_id', $request->quiz_rating_type_id)
				->update(array('avg_rate' => $avg));

			DB::table('quizdemodettagli')
				->where('id', $request->detail_id)
				->update(array('tassomedio' => $avg));
		}
		
	}
	
	public function stepthree(Request $request){

	  return view('quiz.step-three', [              
			'quizid' => $request->id,

			'fontsize' => DB::table('quiz_fontsize')            
				->get(),

			'fontfamily' => DB::table('quiz_fontfamily')        
				->get(),                

			'oldquiz' => DB::table('quiz_dati')
				->leftjoin('quiz_pages', 'quiz_pages.quiz_id', '=',
					'quiz_dati.id')
				->select(DB::raw('quiz_pages.*, quiz_dati.*'))
				->where('quiz_dati.id', $request->id)
				->first()       
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
	  			->orderBy('id', 'desc')
				->get(),
			'optional' => DB::table('optional')
						->get(),
			'default' => DB::table('optional')
						->first(),
			'quizid' =>$request->id
		]);
	}

	public function storestepfour(Request $request){
	  
	  $validator = Validator::make($request->all(), [
		 
	  ]);
				
		if($validator->fails()) {
		  return Redirect::back()
			->withInput()
			->withErrors($validator);
		}   

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
            'quizid' =>$request->id
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

	public function fileviewer(Request $request)
	{
		$src='http://betaeasy.langa.tv/storage/app/images/appunti%202%20per%20langa.docx';

		return "<iframe src='https://view.officeapps.live.com/op/embed.aspx?src='".$src."' width='100%' height='100%' frameborder='0'></iframe>";
		
	}

	public function fileupload(Request $request){
			
		Storage::put(
			'images/quote/' . $request->file('file')->getClientOriginalName(), file_get_contents($request->file('file')->getRealPath())
		);

		$nome = $request->file('file')->getClientOriginalName();			
			DB::table('media_files')->insert([
			'name' => $nome,
			'code' => $request->code,
		]);					
	}
	
	public function fileget(Request $request){
			
		if(isset($request->quote_id)){
			$updateData = DB::table('media_files')->where('quote_id', $request->quote_id)->get();										
		}
		else {
			$updateData = DB::table('media_files')->where('code', $request->code)->get();				
		}
						
		foreach($updateData as $prev) {
			$imagPath = url('/storage/app/images/quote/'.$prev->name);
			$html = '<tr class="quoteFile_'.$prev->id.'"><td><img id="crop" onclick="displayFile(this)" src="'.$imagPath.'" height="100" width="100"><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-eraser"></i></a></td></tr>';
			$html .='<tr class="quoteFile_'.$prev->id.'"><td>';
			
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

}
