<?php namespace App\Models\General;

use CodeIgniter\Model;


class EstadosModel extends Model{

	protected $table = 'Estados';
	// protected $allowedFields = ['email','name','password'];
	protected $beforeInsert = ['beforeInsert'];
	protected $beforeUpdate = ['beforeUpdate'];
	// protected $useSoftDeletes = true;
	
	protected function beforeInsert(array $data){

		// $data['data']['uploaded_by'] = session()->get('id');
		// $data['data']['created_at'] = date('Y-m-d H:i:s');
		return $data;
	}

	protected function beforeUpdate(array $data){

		// $data = $this->passwordHash($data);
		return $data;
	}


	

}


?>