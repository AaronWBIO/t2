<?php
namespace App\Controllers\Administration;
use App\Models\Empresas\CompaniesModel;
use App\Models\Administration\FleetsModel;
use App\Models\Administration\CacheModel;

use App\Controllers\BaseController;
include_once APPPATH.'/ThirdParty/j/j.func.php';

class NoPTL extends BaseController{

	public function index(){

		$encrypter = \Config\Services::encrypter();

	    // $data['title'] = 'aaa';
	    $companiesModel = new CompaniesModel();
	    $fleetsModel = new FleetsModel();

		$data['title'] = 'Transportistas NO-PTL';
	    $data['content'] = 'Administration/noptl/index';



	    $noPTLCompany = $companiesModel -> where('type',3) -> first();
	    if(empty($noPTLCompany)){
	    	$newData = [
	    		'name' => 'NO - PTL',
	    		'type' => 3,
	    	];
	    	$nId = $companiesModel -> insert($newData);
	    }

	    $companies_id = empty($noPTLCompany) ? $nId : $noPTLCompany['id'];

	    $fleets = $fleetsModel -> where('companies_id', $companies_id) -> findAll();
	    foreach ($fleets as $k => $f) {
	    	$fleets[$k]['hash_id'] = bin2hex($encrypter -> encrypt($f['id']));
	    }

	    $data['fleets'] = $fleets;

	    echo view('layout/base',$data);
	}

	public function addFleet(){
		$data = [];

		helper(['form']);
		// print2($data['estados']);

		echo view('Administration/noptl/addForm',$data);
	}

	public function add(){
		$companiesModel = new CompaniesModel();
		$fleetsModel = new FleetsModel();
		$cacheModel = new CacheModel();
		$encrypter = \Config\Services::encrypter();

		if ($this->request->getMethod() == 'post') {


			// Validation;
			$rules = [
				'name' => 'required|min_length[3]',
			];

			$errors = [
				'name' => [
					'required' => 'El nombre es obligatorio',
					'min_length' => 'El nombre debe contener al menos 3 caracteres',
					'is_unique' => 'El nombre ya está registrado en el sistema',
				],
			];

			// print2($_POST);
			if(!$this->validate($rules,$errors)){
				$r = [];
				$r['ok'] = 2;
				$r['err'] = $this->validator->listErrors();

				return(atj($r));
			}else{


				// Store user un DB
				$noPTLCompany = $companiesModel -> where('type',3) -> first();

				if(empty($noPTLCompany)){
					$newData = [
						'name' => 'NO - PTL',
						'type' => 3,
					];
					$nId = $companiesModel -> insert($newData);
				}

				$companies_id = empty($noPTLCompany) ? $nId : $noPTLCompany['id'];

				// print2($companies_id);

				$checkName = $fleetsModel 
				-> where('companies_id',$companies_id) 
				-> where('name',$this->request->getVar('name'))
				->findAll();

				if(count($checkName) > 0){
					$r['ok'] = 2;
					$r['err'] = '<div class="errors" role="alert"><ul><li>Ya existe una flota con ese nombre para NO-PTL</li></ul></div>';
					return atj($r);
				}


				$newData = [
					'name' => $this->request->getVar('name'),
					'companies_id' => $companies_id,
				];
				// print2($newData);

				$fId = $fleetsModel -> insert($newData);

				$cacheModel -> insert(['fleets_id' => $fId]);

				$fId = bin2hex($encrypter -> encrypt($fId));
				echo '{"ok":1,"nId":"'.$fId.'"}';

			}

		}
	}

	public function fleetEmissions($hash_fleet_id){

		$fleetsModel = new FleetsModel();
		$cacheModel = new CacheModel();
		$encrypter = \Config\Services::encrypter();

		$fleets_id = $encrypter->decrypt( hex2bin($hash_fleet_id) );

		$data['fleet'] = $fleetsModel -> where('id',$fleets_id) -> first();
		$data['hash_fleet_id'] = $hash_fleet_id;
		$data['cache'] = $cacheModel -> where('fleets_id', $fleets_id) -> first();
		// print2($data['cache']);

		echo view('Administration/noptl/fleetEmissions',$data);
	}

	public function saveEmissions($hash_fleet_id){
		$companiesModel = new CompaniesModel();
		$fleetsModel = new FleetsModel();
		$cacheModel = new CacheModel();
		$encrypter = \Config\Services::encrypter();

		$fleets_id = $encrypter->decrypt( hex2bin($hash_fleet_id) );

		if ($this->request->getMethod() == 'post') {

			$rules = [
				'CO2GKM' => 'numeric',
				'NOXGKM' => 'numeric',
				'PM25GKM' => 'numeric',
				'PM10GKM' => 'numeric',
				'CNGKM' => 'numeric',
				'CO2GTonKM' => 'numeric',
				'NOXGTonKM' => 'numeric',
				'PM25GTonKM' => 'numeric',
				'PM10GTonKM' => 'numeric',
				'CNGTonKM' => 'numeric',
			];

			$errors = [
				'CO2GKM' => [
					'numeric' => 'El campo CO2GKM debe ser numérico',
				],
				'NOXGKM' => [
					'numeric' => 'El campo NOXGKM debe ser numérico',
				],
				'PM25GKM' => [
					'numeric' => 'El campo PM25GKM debe ser numérico',
				],
				'PM10GKM' => [
					'numeric' => 'El campo PM10GKM debe ser numérico',
				],
				'CNGKM' => [
					'numeric' => 'El campo CNGKM debe ser numérico',
				],
				'CO2GTonKM' => [
					'numeric' => 'El campo CO2GTonKM debe ser numérico',
				],
				'NOXGTonKM' => [
					'numeric' => 'El campo NOXGTonKM debe ser numérico',
				],
				'PM25GTonKM' => [
					'numeric' => 'El campo PM25GTonKM debe ser numérico',
				],
				'PM10GTonKM' => [
					'numeric' => 'El campo PM10GTonKM debe ser numérico',
				],
				'CNGTonKM' => [
					'numeric' => 'El campo CNGTonKM debe ser numérico',
				],
			];

			if(!$this->validate($rules,$errors)){
				$r = [];
				$r['ok'] = 2;
				$r['err'] = $this->validator->listErrors();

				return(atj($r));
			}else{

				$newData = [
					'CO2GKM' => empty($this->request->getVar('CO2GKM')) ? null : $this->request->getVar('CO2GKM'),
					'NOXGKM' => empty($this->request->getVar('NOXGKM')) ? null : $this->request->getVar('NOXGKM'),
					'PM25GKM' => empty($this->request->getVar('PM25GKM')) ? null : $this->request->getVar('PM25GKM'),
					'PM10GKM' => empty($this->request->getVar('PM10GKM')) ? null : $this->request->getVar('PM10GKM'),
					'CNGKM' => empty($this->request->getVar('CNGKM')) ? null : $this->request->getVar('CNGKM'),
					'CO2GTonKM' => empty($this->request->getVar('CO2GTonKM')) ? null : $this->request->getVar('CO2GTonKM'),
					'NOXGTonKM' => empty($this->request->getVar('NOXGTonKM')) ? null : $this->request->getVar('NOXGTonKM'),
					'PM25GTonKM' => empty($this->request->getVar('PM25GTonKM')) ? null : $this->request->getVar('PM25GTonKM'),
					'PM10GTonKM' => empty($this->request->getVar('PM10GTonKM')) ? null : $this->request->getVar('PM10GTonKM'),
					'CNGTonKM' => empty($this->request->getVar('CNGTonKM')) ? null : $this->request->getVar('CNGTonKM'),
				];

				$cache = $cacheModel -> where('fleets_id',$fleets_id) -> first();
				// print2($fleets_id);
				$cacheModel -> update($cache['id'],$newData);

				echo '{"ok":1,"nId":"'.$hash_fleet_id.'"}';

			}



		}
	}

	public function dwlFleets(){
		    $companiesModel = new CompaniesModel();
		    $fleetsModel = new FleetsModel();

			$data['title'] = 'Transportistas NO-PTL';
		    $data['content'] = 'Administration/noptl/index';



		    $noPTLCompany = $companiesModel -> where('type',3) -> first();
		    if(empty($noPTLCompany)){
		    	$newData = [
		    		'name' => 'NO - PTL',
		    		'type' => 3,
		    	];
		    	$nId = $companiesModel -> insert($newData);
		    }

		    $companies_id = empty($noPTLCompany) ? $nId : $noPTLCompany['id'];

		    $fleets = $fleetsModel
		    -> select('Fleets.name as name, c.*')
		    -> join('Cache c','c.fleets_id = Fleets.id','left')
		    -> where('c.deleted_at ',null)
		    -> where('companies_id', $companies_id) 
		    -> findAll();

		    // print2($fleets);
		    $data['fleets'] = $fleets;

		    echo view('Administration/noptl/dwlList',$data);

	}

}


