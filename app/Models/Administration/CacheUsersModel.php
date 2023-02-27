<?php namespace App\Models\Administration;

use CodeIgniter\Model;


class CacheUsersModel extends Model{

	protected $table = 'Cache_Users';
	protected $allowedFields = ['brands_id','CO2','PM10','PM25','NOX','CN',
	'GKMCO2','GKMNOX','GKMPM25','GKMPM10','GKMCN','GTONKMCO2','GTONKMNOX','GTONKMPM25','GTONKMPM10','GTONKMCN',
	'json','delete_at','brand_fleets_id'];

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