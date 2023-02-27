<?php 

namespace App\Libraries;
// include_once APPPATH.'ThirdParty/php/i18n_setup.php';


class Content {


	public function title($params){
		if(!empty($params['title']) ){
			return view('layout/title',$params);
		}
	}

	public function content($params){
		if($params['content'] ){
			return view($params['content'],$params);
		}
	}

	public function navBar($params){
		if($params['navbar'] ){
			return view($params['navbar'],$params);
		}

	}
	
}


?>