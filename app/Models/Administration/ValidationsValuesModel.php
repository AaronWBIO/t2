<?php namespace App\Models\Administration;

use CodeIgniter\Model;

use App\Models\Administration\VclassModel;
use App\Models\Administration\CategoriesModel;
use App\Models\Administration\ValidationsModel;



class ValidationsValuesModel extends Model{

	protected $table = 'Validations_Values';
	protected $allowedFields = ['validations_id','vclass_id','categories_id',
	'min','red_low','yellow_low','yellow_high','red_high','max',];

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

	public function getAll($validations_id){
		// $validationsModel = new ValidationsModel();

		$dbdata = $this 
		-> select('Validations_Values.*, c.code as ccode, c.id as cid, vc.id as vcid, vc.code as vccode')
		-> join('Vclass vc','Validations_Values.vclass_id = vc.id','left')
		-> join('Categories c','Validations_Values.categories_id = c.id','left')
		-> where('validations_id',$validations_id) 
		-> orderBy('vc.name','ASC')
		-> orderBy('c.name','ASC')
		-> findAll();

		$data = array();
		foreach ($dbdata as $d) {
			$data[$d['vccode']][$d['ccode']] = $d;
		}

		return $data;

	}

	

}


?>