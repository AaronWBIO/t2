<?php 

namespace App\Models\Empresas;

use CodeIgniter\Model;


class Fleets_Fuels_Vclass_Travels extends Model{

	protected $table = 'Fleets_Fuels_Vclass_Travels';
	protected $allowedFields = ['id','fleets_fuels_id','vclass_id','km_tot','km_pay','km_empty','lts_tot','lts_bio','payload_avg','load_type','load_volume','avg_volume','highway','less_40','40_80','over_80','deceleration','ralenti_hours_large','ralenti_hours_short','ralenti_days','hybrid_type','delete_at'];

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