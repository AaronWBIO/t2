<?php 

namespace App\Models\Empresas;

use CodeIgniter\Model;


class Fleet_Fuels_Vclass_Reduction extends Model{

	protected $table = 'Fleet_Fuels_Vclass_Reduction';
	protected $allowedFields = ['fleets_fuels_id','vclass_id','year','quantity','delete_at'];

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