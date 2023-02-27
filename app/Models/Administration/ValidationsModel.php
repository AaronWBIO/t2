<?php namespace App\Models\Administration;

use CodeIgniter\Model;

use App\Models\Administration\VclassModel;
use App\Models\Administration\CategoriesModel;
use App\Models\Administration\ValidationsValuesModel;

class ValidationsModel extends Model{

	protected $table = 'Validations';
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

	public function createValues(){

		$categoriesModel = new CategoriesModel();
		$vclassModel = new VclassModel();
		$validationsValues = new ValidationsValuesModel();

		$vclass = $vclassModel -> findAll();
		$categories = $categoriesModel -> findAll();
		$validations = $this 
		-> whereIn('id',[7,8])
		-> findAll();



		$this -> db -> transStart();
		foreach ($validations as $v) {
			foreach ($categories as $c) {
				foreach ($vclass as $vc) {
					$newData = [
						'validations_id' => $v['id'],
						'categories_id' => $c['id'],
						'vclass_id' => $vc['id'],
					];

					// print2($newData);
					$validationsValues -> insert($newData);
				}
			}
		}
		$this -> db -> transCommit();
		echo 'finish';
	}


}


?>