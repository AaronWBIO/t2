<?php namespace App\Models\Administration;

use CodeIgniter\Model;


class CategoriesModel extends Model{

	protected $table = 'Categories';
	// protected $allowedFields = ['vclass_id','fuels_id','range_1','range_2','range_3','deceleration'];

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

	public function getCodes(){

		$catsDB = $this -> findAll();

		$categories = array();
		foreach ($catsDB as $c) {
			$categories[$c['code']] = $c;
		}

		return $categories;

	}

}


?>