<?php 

namespace App\Models\Empresas;

use CodeIgniter\Model;


class Fleets_Fuels_Vclass extends Model{

	protected $table = 'Fleets_Fuels_Vclass';
	protected $allowedFields = ['Fleets_Fuels_id','vclass_id','euro5','euro6','id','delete_at'];

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