<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Redirect;
use DB;
use Storage;
use App\Http\Requests;

class SocialController extends Controller
{
    public function index(Request $request){

		return view('social', [
			'socials' => DB::table('social')->orderBy('social_id', 'desc')->get()
		]);
	}

    public function addsocial(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required'
        ]);

        if ($request->image != null) {					
			Storage::put('images/social/' . $request->file('image')->getClientOriginalName(), file_get_contents($request->file('image')->getRealPath())
			);
			$request->image = $request->file('image')->getClientOriginalName();
		}

        DB::table('social')->insert([
            'title' => isset($request->title) ? $request->title : '',
            'url' => isset($request->url) ? $request->url : '',
            'image' => isset($request->image) ? $request->image : '',
            'is_active' => isset($request->is_active) ? $request->is_active : 0
        ]);

        return Redirect::back()->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_addsuccessmsg').' </div>');
    }

    public function updatesocial(Request $request) 
    {
		

    	foreach($request->social as $key => $val) {   

            if($request->action == 'delete') {
				DB::table('social')->where('social_id', $key)->delete();
            } else {  
			$title = isset($request->title[$key]) ? $request->title[$key] : '';
    		$image = isset($request->image[$key]) ? $request->image[$key] : '';
    		$url = isset($request->url[$key]) ? $request->url[$key] : '';
    		$is_active = isset($request->is_active[$key]) ? $request->is_active[$key] : 0;

    		$image = DB::table('social')->select('image')
		        ->where('social_id', $key)->first();

  			$arr = json_decode(json_encode($image), true);  			
			$imagename = $arr['image'];   
    		$arrfiles = $request->file('image'); 

    		if (isset($arrfiles[$key]) && $arrfiles[$key] != null) {   			
                Storage::put('images/social/' . $arrfiles[$key]->getClientOriginalName(), file_get_contents($arrfiles[$key]->getRealPath()));                
                $imagename = $arrfiles[$key]->getClientOriginalName();
            }    
	            DB::table('social')->where('social_id', $key)->update(array('title'=> $title, 'image' => $imagename, 'url' => $url, 
	            	'is_active' => $is_active));
            }
        }

        $msg = ($request->action == 'delete') ? '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_deletesuccessmsg').' </div>' : '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.trans('messages.keyword_editsuccessmsg').' </div>';

        return Redirect::back()->with('msg', $msg);
    } 
	public function image(Request $request)
	{
		$val=$request->all();
		$socialdetail=check_media($val['idval']);
		$newval='';
		foreach($socialdetail as $social)
		{
			$newval.="<div class='col-md-3 col-sm-4 col-xs-4'>
                    <a href='$social->url' class='img-responsive'>
                       <img src='".url('storage/app/images/social/'.$social->image)."' alt='$social->title' width='50'>
						<span>$social->title</span>
                    </a>
                    </div> "; 
		}
		return $newval;
	}
	public function share(Request $request)
	{
		$val=$request->id;
		$filedetail=DB::table('media_files')->where('id',$val)->first();
		return view('social-detail', [
			'social' => $filedetail
		]);
	}

}
