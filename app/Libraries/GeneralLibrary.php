<?php
namespace App\Libraries;
include_once APPPATH.'/ThirdParty/j/j.func.php';

use App\Models\General\EstadosModel;
use App\Models\General\MunicipiosModel;
use App\Models\Administration\VclassModel;


class GeneralLibrary {

	public function index(){

	}

	public function csrfToken($json = false){
		$data['csrfName'] = csrf_token();
		$data['csrfHash'] = csrf_hash();
		$data[$data['csrfName']] = csrf_hash();

		helper(['form']);

		if($json == 'json')
			return atj($data);
		else{
			return $data;
		}		
	}

	public function getMunicipios($estados_id){
		$model = new MunicipiosModel();

		$municipios = $model 
		-> select('id as val, "class" as clase, nombre as nom')
		-> where('estados_id',$estados_id)
		-> findAll();

		echo atj($municipios);
	}

	public function vclass_weight(){

		$vclassModel = new VclassModel();

		$weights = [
			["id"=>"1", "code" => "c2b", "weight" => "4 - 4.5 ton"],
			["id"=>"2", "code" => "c3", "weight" => "4.5 - 6.5 ton"],
			["id"=>"3", "code" => "c4", "weight" => "6.5 - 7.5 ton"],
			["id"=>"4", "code" => "c5", "weight" => "7.5 - 9 ton"],
			["id"=>"5", "code" => "c6", "weight" => "9 - 12 ton"],
			["id"=>"6", "code" => "c7", "weight" => "12 - 15 ton"],
			["id"=>"7", "code" => "c8a", "weight" => "15 - 27 ton"],
			["id"=>"8", "code" => "c8b", "weight" => "27 ton y mas"],
		];


		foreach ($weights as $w) {
			$vclassModel -> update($w['id'],$w);
		}
	}






}