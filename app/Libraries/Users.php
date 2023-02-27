<?php 

namespace App\Libraries;

class Users {

	public function search($params){
		return view('Administration/users/searchUsers.php',$params);
	}

}


?>