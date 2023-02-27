<?php namespace App\Models\Empresas;

use CodeIgniter\Model;

class FleetsFuelsModel extends Model{

	protected $table = 'Fleets_Fuels';
	protected $allowedFields = ['id','fleets_id','fuels_id','deleted_at','active'];

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