<?php
namespace App\Controllers\Administration;
use App\Models\Administration\EmissionFactorsModel;
use App\Models\Administration\PollutantsModel;
use App\Models\Administration\VclassModel;
use App\Models\Administration\FuelsModel;

use App\Libraries\Calculations;
use App\Libraries\Validations;

use App\Controllers\BaseController;
include_once APPPATH.'/ThirdParty/j/j.func.php';

class EmissionFactors extends BaseController{

	public function index(){

	    $model = new EmissionFactorsModel();
	    $pollutantsModel = new PollutantsModel();
	    $fuelsModel = new FuelsModel();

	    $data['title'] = 'Factores de emisión';
	    $data['content'] = 'Administration/emissionFactors/index';

	    $this_year = date('Y');
	    
	    
	    $data['years'] = $model -> getYears();
	    $data['pollutants'] = $pollutantsModel -> findAll();
	    $data['fuels'] = $fuelsModel -> findAll();

	    if( empty($data['years'][$this_year]) ){
	    	// echo "AAA";
	    	// $model -> createEF($this_year);
	    	array_unshift($data['years'],$this_year);
	    }

	    echo view('layout/base',$data);
	}

	public function addForm(){
		// echo '$type';
		$data = [];

		$estados_model = new EstadosModel();
		helper(['form']);
		$data['estados'] = $estados_model -> findAll();
		// print2($data['estados']);

		echo view('Administration/companies/addForm',$data);
	}

	public function save(){
		$model = new EmissionFactorsModel();

		if ($this->request->getMethod() == 'post') {

			$values = $this->request->getPost();

			foreach ($values as $k => $v) {
				$newData = [
					'value' => $v,
				];


				$fe_id = explode('_', $k)[2];
				if($v != null && $v != ''){
					$model -> update($fe_id,$newData);
				}
			}

			return '{"ok":1}';


		}
	}

	public function list($year,$pollutants_code,$fuels_code,$type){
		$model = new EmissionFactorsModel();
		$vclassModel = new VclassModel();
		$pollutantsModel = new PollutantsModel();
		$fuelsModel = new FuelsModel();

		$pollutant = $pollutantsModel -> where('code',$pollutants_code) -> first();
		$fuel = $fuelsModel -> where('code',$fuels_code) -> first();

		$data['measure_year'] = $year;
		$data['pollutant'] = $pollutant;
		$data['pollutants_id'] = $pollutant['id'];
		$data['fuel'] = $fuel;
		$data['fuels_code'] = $fuels_code;
		$data['type'] = $type;

		$data['vclass'] = $vclassModel -> findAll();

		$feDB = $model -> getEF($year,$pollutant['id'],$fuel['id'],$type);

		if(empty($feDB)){
			
			$model -> createEF($year,$pollutant['id'],$fuel['id'],$type);
			$feDB = $model -> getEF($year,$pollutant['id'],$fuel['id'],$type);
		}

		$fe = array();
		switch ($type) {
			case '0':
			case '1':
			case '2':

				if ($pollutants_code != 'CO2') {
					foreach ($feDB as $f) {
						$data['fe'][$f['year']][$f['vclass_id']]['value'] = $f['value'];
						$data['fe'][$f['year']][$f['vclass_id']]['id'] = $f['id'];
					}
					echo view('Administration/emissionFactors/list',$data);
				}else{
					$data['fe'] = $feDB[0];
					echo view('Administration/emissionFactors/listCO2',$data);
				}
				break;
			case '3':
				foreach ($feDB as $f) {
					$data['fe'][$f['vclass_id']][$f['year']][$f['range']]['value'] = $f['value'];
					$data['fe'][$f['vclass_id']][$f['year']][$f['range']]['id'] = $f['id'];
				}
				
				// print2($data['fe']);
				echo view('Administration/emissionFactors/listRV',$data);

				break;

			
			default:
				if ($pollutants_code != 'CO2') {
					echo view('Administration/emissionFactors/list',$data);
				}
				break;
		}

		// $data['fe'] = $fe;
		// print2( $data['fe']);
	}

	public function searchCompanies(){
		$data = [];
		echo view('Administration/companies/searchCompanies',$data);
	}

	public function addFromFile(){
		$data = [];
		helper(['form']);

		echo view('Administration/emissionFactors/addFromFile',$data);
	}

	public function addFromFileRalenti(){
		$data = [];
		helper(['form']);

		echo view('Administration/emissionFactors/addFromFileRalenti',$data);
	}

	public function uploadFiles(){

		// $companiesModel = new CompaniesModel();
		$encrypter = \Config\Services::encrypter();

		// echo "AAA";
		if ($this->request->getMethod() == 'post') {

			$dir = WRITEPATH."uploads";

			$file = '';
			helper('text');
			foreach ($_FILES as $k => $f) {
				$_FILES[$k]['oName'] = $f['name'];
				$_FILES[$k]['name'] = random_string('alnum',12).".csv";
				$file = 'efs_'.$_FILES[$k]['name'];
			}

			$rj =  uploadFiles("efs_",$_FILES,$dir);
			// print2($rj);
			$r = json_decode($rj,true);

			if($r['ok'] == 1){
				// $errors = $companiesModel -> checkCompanies($file);
				if(empty($errors)){
					return '{"ok":1,"errors":[],"file":"'.bin2hex($encrypter->encrypt($file)).'"}';
				}else{
					return '{"ok":1,"errors":'.atj($errors).'}';
				}
			}else{
				return $rj;
			}

		}
	}

	public function runFromFile($file_encryption){
		$encrypter = \Config\Services::encrypter();

		$file = $encrypter -> decrypt(hex2bin($file_encryption));
		// print2($file);
		// print2(WRITEPATH."uploads/$file");

		$vals = array();
		$row = 0;
		if (($handle = fopen(WRITEPATH."uploads/$file", "r")) !== FALSE) {
			while (($col = fgetcsv($handle, 0, ",")) !== FALSE) {
				if($row == 0){
					$row++;
					continue;
				}

				$cy = explode('-', $col[0]);
				$y = trim($cy[0]);
				$ccode = 'c'.trim($cy[1]);
				$vals[ 'desacel_'.$y.'_'.$ccode ] = $col[1];
				$vals[ '40_'.$y.'_'.$ccode ] = $col[2];
				$vals[ '4080_'.$y.'_'.$ccode ] = $col[3];
				$vals[ '80_'.$y.'_'.$ccode ] = $col[4];
				$vals[ 'autopista_'.$y.'_'.$ccode ] = $col[5];

			}
		}

		echo atj($vals);
	}

	public function runFromFileRalenti($file_encryption){
		$encrypter = \Config\Services::encrypter();

		$file = $encrypter -> decrypt(hex2bin($file_encryption));
		// print2($file);
		// print2(WRITEPATH."uploads/$file");

		$vals = array();
		$row = 0;
		if (($handle = fopen(WRITEPATH."uploads/$file", "r")) !== FALSE) {
			while (($col = fgetcsv($handle, 0, ",")) !== FALSE) {
				if($row == 0){
					$row++;
					continue;
				}

				$y = trim($col[0]);

				$vals[ $y.'_c2b' ] = $col[1];
				$vals[ $y.'_c3' ] = $col[2];
				$vals[ $y.'_c4' ] = $col[3];
				$vals[ $y.'_c5' ] = $col[4];
				$vals[ $y.'_c6' ] = $col[5];
				$vals[ $y.'_c7' ] = $col[6];
				$vals[ $y.'_c8a' ] = $col[7];
				$vals[ $y.'_c8b' ] = $col[8];
				

			}
		}

		echo atj($vals);
	}



	//--------------------------------------------------------------------

	public function test($companies_id,$measure_year){

		$library = new Calculations();
		$validations = new Validations($companies_id);
		$category =  $validations -> category($companies_id);
		// print2($category);

		// $library -> evaluate($companies_id,$measure_year);
	}

}



