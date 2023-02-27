<?php namespace App\Models\Administration;

use CodeIgniter\Model;


class PollutantsModel extends Model{

	protected $table = 'Pollutants';
	// protected $allowedFields = ['measure_year','fuels_id','vclass_id','year','pollutants_idÍndice','ralenti','value','delete_at'];

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