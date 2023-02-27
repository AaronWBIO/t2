<?php
namespace App\Controllers\Administration;
use App\Models\Administration\VclassModel;
use App\Models\Administration\CategoriesModel;
use App\Models\Administration\ValidationsModel;
use App\Models\Administration\ValidationsValuesModel;

use App\Models\Administration\FleetsModel;
use App\Models\Administration\CacheModel;
use App\Models\Administration\CacheVclassModel;

use App\Libraries\Calculations;
use App\Libraries\CheckAPI;
use App\Libraries\Validations as ValLib;
use App\Libraries\Results;
use App\Libraries\Email;
use App\Libraries\GeneralLibrary;
use App\Libraries\Report;



use App\Controllers\BaseController;
include_once APPPATH.'/ThirdParty/j/j.func.php';

class Validations extends BaseController{

	public function index(){

	    $validationsModel = new ValidationsModel();


	    $data['title'] = 'Validaciones';
	    $data['content'] = 'Administration/validations/index';


	    $this_year = date('Y');
	    
	    $data['validations'] = $validationsModel -> findAll();
	    
	    
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
		$model = new ValidationsValuesModel();

		if ($this->request->getMethod() == 'post') {

			$values = $this->request->getPost();

			// print2($values);
			foreach ($values as $k => $v) {
				foreach ($v as $key => $value) {
					$v[$key] = $value == ''?null:$value;
				}
				$newData = $v;

				$vv_id = explode('_', $k)[2];
				if(!empty($v)){
					$model -> update($vv_id,$newData);
				}
			}

			return '{"ok":1}';


		}
	}

	public function list($validations_id){

		$validationsValuesModel = new ValidationsValuesModel();
		$vclassModel = new VclassModel();
		$validationsModel = new ValidationsModel();
		$categoriesModel = new CategoriesModel();

		$data['validationsValues'] = $validationsValuesModel -> getAll($validations_id);
		$data['vclass'] = $vclassModel -> orderBy('name','ASC') -> findAll();
		$data['validation'] = $validationsModel -> where('id',$validations_id) -> first();
		$data['categories'] = $categoriesModel -> orderBy('name','ASC') -> findAll();


		echo view('Administration/validations/list',$data);
	}

	public function searchCompanies(){
		$data = [];
		echo view('Administration/companies/searchCompanies',$data);
	}

	public function addFromFile(){
		$data = [];
		helper(['form']);

		echo view('Administration/validations/addFromFile',$data);
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
				if(empty($col[0])){
					continue;
				}
				// echo $col[0];
				$cy = explode('-', $col[0]);

				$cat = trim($cy[1]);
				$ccodeArr = explode(' ', $cy[0]);;
				$ccode = 'c'.trim($ccodeArr[1]);
				if(isset($cy[2])){
					$cat .= '-'.trim($cy[2]);
				}
				$vals[ $ccode.'_'.$cat.'_min' ] = str_replace(',', '', trim($col[1]));
				$vals[ $ccode.'_'.$cat.'_rl' ] = str_replace(',', '', trim($col[2]));
				$vals[ $ccode.'_'.$cat.'_yl' ] = str_replace(',', '', trim($col[3]));
				$vals[ $ccode.'_'.$cat.'_lh' ] = str_replace(',', '', trim($col[4]));
				$vals[ $ccode.'_'.$cat.'_rh' ] = str_replace(',', '', trim($col[5]));
				$vals[ $ccode.'_'.$cat.'_max' ] = str_replace(',', '', trim($col[6]));

			}
		}

		echo atj($vals);
	}

	public function exampleCSV(){
		$vclassModel = new VclassModel();
		$categoriesModel = new CategoriesModel();

		$vclass = $vclassModel -> orderBy('name','ASC') -> findAll();
		$categories = $categoriesModel -> orderBy('name','ASC')  -> findAll();

		header('Content-Type: text/html; charset=utf-8'); 
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=ejemplo.csv");

		$csv = '"Clase - Categoría", "Mínimo absoluto", "Rojo bajo", "Amarillo bajo", "Amarillo alto", "rojo alto", "Máximo absoluto"'."\n";
		foreach ($vclass as $c) {
			foreach ($categories as $cat) {
				$csv .= '"'.$c['name'].'-'.$cat['code'].'", "", "", "", "", "", ""'."\n";
			}
		}
		
		echo $csv;
	}

	// ------------------------------- // ------------------------------- //

	public function test($companies_id){

		$vals = new CacheModel();

		$a = $vals -> first();
		print2($a);


		// $calculations = new Calculations();
		// $calculations -> evaluate($companies_id,2021);


		// $library = new Results();
		// $library -> showResults($companies_id,2021);

	}

	public function qr(){
		$report = new Results();

		$report -> pdf(3,2021);
	}

}



