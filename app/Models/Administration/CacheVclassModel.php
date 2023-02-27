<?php namespace App\Models\Administration;

use CodeIgniter\Model;

class CacheVclassModel extends Model{

	protected $table = 'Cache_Vclass';
	protected $allowedFields = ['fleets_id','json','CO2GKM','NOXGKM','PM25GKM',
	'PM10GKM','CNGKM','CO2GTonKM','NOXGTonKM','PM25GTonKM','PM10GTonKM','CNGTonKM',
	'v_total','km_tot','km_empty','payload_avg','vclass_code','fuels_code',
	'CO2', 'PM10', 'PM25', 'NOX', 'CN', 'avg_year', 'lts_tot', 'delete_at'];

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