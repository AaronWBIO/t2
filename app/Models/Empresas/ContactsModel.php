<?php namespace App\Models\Empresas;

use CodeIgniter\Model;


class ContactsModel extends Model{

	protected $table = 'Contacts';
	protected $allowedFields = ['idPrimaria','nombre','curp','companies_id','type','position','email','phone','ext','phone2','ext2','delete_at'];
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