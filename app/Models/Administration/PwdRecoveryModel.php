<?php namespace App\Models\Administration;

use CodeIgniter\Model;

class PwdRecoveryModel extends Model{

	protected $table = 'PwdRecovery';
	protected $allowedFields = ['hash','used','elem_id','email','contacts_id','type','timestamp'];
	protected $beforeInsert = ['beforeInsert'];
	protected $beforeUpdate = ['beforeUpdate'];

	protected function beforeInsert(array $data){

		// $data = $this->passwordHash($data);
		return $data;
	}

	protected function beforeUpdate(array $data){

		// $data = $this->passwordHash($data);
		return $data;
	}


	public function pwdRecoveryInsert($hash,$users_id){
		
	}


}


?>