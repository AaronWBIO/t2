<?php namespace App\Models\Empresas;

use CodeIgniter\Model;


class CompaniesModel extends Model{

	protected $table = 'Companies';
	protected $allowedFields = ['idPrimaria','username','password','email','type','name','SEMARNAT_ID','website','estado','municipio','direccion','cp','rfc','telefono','delete_at','rev_year','status'];
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