<?php namespace App\Models\Empresas;

use CodeIgniter\Model;

class Comments extends Model{

	protected $table = 'Comments';
	protected $allowedFields = ['id','field','fleets_fuels_id','comment','color','vclass_id'];

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