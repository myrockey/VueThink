<?php

namespace app\admin\controller;

use think\Controller;
use app\common\logic\Docxs as LogicDocxs;
use app\common\logic\Doccon as LogicDoccon;


class Ybcommand extends Controller
{
    
   public function copyfile($fileid){
   	
   	 $fileinfo = model('file')->where(['id'=>$fileid])   ->find();
   	
   	  copy(getfileurl_jd($fileid,0), PATH_UPLOAD.'doc'.DS.$fileinfo['savename']);
   	  
   	  
   	
   }
   public function getactiveurl(){
   	 
   	$curl = curl_init();
   	 
   	 
   	 
   	curl_setopt($curl, CURLOPT_URL, "http://appapi.imzaker.com/api.php/common/checkweburl");
   	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   	curl_setopt($curl, CURLOPT_POST, true);
   
   	$token=sha1('EasySNS' . date("Ymd") . 'l2V|gfZp{8`;jzR~6Y1_');
   	 
   	curl_setopt($curl, CURLOPT_POSTFIELDS, [
   	'access_token'=>$token,
   	'url'=>$_SERVER["SERVER_NAME"],
   	]);
   
   	 
   	 
   	$result = curl_exec($curl);
   	 
   	curl_close($curl);
   	return $result;
   	 
   }
 

}
