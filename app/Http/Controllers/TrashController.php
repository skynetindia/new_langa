<?php
namespace App\Http\Controllers;

use DB;
use Storage;
use Redirect;
use App\Corporation;
use App\Repositories\CorporationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TrashController extends Controller
{
	
	protected $corporations;
	protected $chiave;
	protected $stato;
	protected $logmainsection;

	protected $module;
	protected $sub_id;
	
	 public function __construct(CorporationRepository $corporations) {
         $this->middleware('auth');
        $this->corporations = $corporations;
		$this->logmainsection = 'Entity';

		$request = parse_url($_SERVER['REQUEST_URI']);
		$path = ($_SERVER['HTTP_HOST'] == 'localhost') ? rtrim(str_replace('/easylanganew/', '', $request["path"]), '/') : $request["path"];		
		$result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
		$current_module = DB::select('select * from modulo where TRIM(BOTH "/" FROM modulo_link) = :link', ['link' => $result]);  
    	
        $this->module = (isset($current_module[0]->modulo_sub)) ? $current_module[0]->modulo_sub : 1;
        $this->sub_id = (isset($current_module[0]->id)) ? $current_module[0]->id : 12;
		
	 }	
	 
	 public function getenti(Request $request){
		 
		if(!checkpermission($this->module, $this->sub_id, 'lettura')){
    		return redirect('/unauthorized');
    	}
		
		return view('trashentity', [
                'tabellatipi' => DB::table('masterdatatypes')->get(),
                'tabellastatiemotivi' => DB::table('statiemotivitipi')->get(),
				'loginuser' => $request->user(),
        ]);
	 }
	
	 public function getentijson(Request $request) {
		
		
		if($request->user()->id == 0){
           $data = DB::table('corporations')
			   	->join('users', 'corporations.user_id', '=', 'users.id')
				->select('corporations.*')
				->where('is_deleted','1')
				->where('users.is_delete', '=', 0)
				->where('corporations.is_approvato', 1)
				->orderBy('corporations.id', 'desc')
				->get();
			foreach($data as $data) {				
				if($data->statoemotivo != ""){
					$statiemotivitipi = DB::table('statiemotivitipi')->where('name',$data->statoemotivo)->orderBy('id', 'asc')->first();
					if(isset($statiemotivitipi->color)){
						$data->statoemotivo = '<span style="color:'.$statiemotivitipi->color.'">'.$data->statoemotivo.'</span>';
					}
				}
				$ente_return[] = $data;	
			}	
			return $ente_return;
		    /*return Corporation::where('is_deleted', 0)
        		->where('is_approvato', 1)
				->orderBy('id', 'asc')
                ->get();*/
		}
		/*else {
			 $enti = Corporation::join('users', 'corporations.user_id', '=', 'users.id')
				->select('corporations.*')
				->where('privato', 0)
        		->where('users.is_delete', '=', 0)
        		->orderBy('corporations.id', 'asc')->get();
			foreach($enti as $ente) {
				if($ente->is_deleted == 1){
					if($ente->statoemotivo != ""){
						$statiemotivitipi = DB::table('statiemotivitipi')->where('name',$ente->statoemotivo)->orderBy('id', 'asc')->get();
						if(isset($statiemotivitipi->color)){
							$ente->statoemotivo = '<span style="color:'.$statiemotivitipi->color.'">'.$ente->statoemotivo.'</span>';
						}
					}
					$ente_return[] = $ente;
				}
			}
			return $ente_return;
		}*/
		
		
		
		//$this->compilaStatiEmotivi($enti);
		//$this->compilaTipi($enti);
		return json_encode($enti);
	}
}

?>