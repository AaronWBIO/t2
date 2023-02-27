<?php 

namespace App\Libraries;

class Companies {

	public function search($params){
		
		return view('Administration/companies/searchCompanies.php',$params);
	}

}


?>