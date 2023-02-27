<?php namespace App\Models\Administration;

use CodeIgniter\Model;


class FleetsFuelsVclassQuantity extends Model{

	protected $table = 'Fleet_Fuels_Vclass_Quantity';
	// protected $allowedFields = [];

	protected $beforeInsert = ['beforeInsert'];
	protected $beforeUpdate = ['beforeUpdate'];
	protected $useSoftDeletes = true;
	
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