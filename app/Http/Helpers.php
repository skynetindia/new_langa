<?php
/* Here Create the unique function that used anywhere in site */
function demohelper(){
	return 'resds';
}
	function replace_charcter($replaceValue = array(),$content){
		$htmlcontent = $content;
		foreach($replaceValue as $key => $val){
			$htmlcontent = str_replace($key,$val,$htmlcontent);	
		}
		return $htmlcontent;
		/*$htmlcontent = str_replace('[#SPLASHPAGE_TITLE#]',$memberdata->title,$memberdata->content);
		$htmlcontent=str_replace('[#REF_LINK#]',SITEURL.'ref/'.$member_id,$htmlcontent);
		$htmlcontent=str_replace('[#REF_ID#]',$member_id,$htmlcontent);
		$htmlcontent=str_replace('[#LANDING_ID#]',$memberdata->id,$htmlcontent);
		$htmlcontent=str_replace('[#SITEADDRESS#]',SITEURL,$htmlcontent);
		$htmlcontent=str_replace('../../',SITEURL,$htmlcontent);
		$htmlcontent=str_replace('externalimages','external/images',$htmlcontent);
		echo $htmlcontent*/
	}
