<?php namespace App\Models\Empresas;

use CodeIgniter\Model;

class BrandsFleetsModel extends Model{

	protected $table = 'Brands_Fleets';
	protected $allowedFields = ['measure_year','brands_id','fleets_id','no_ptl','carrier','measure_type','ton_km','tot_km','avg_payload','deleted_at'];

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