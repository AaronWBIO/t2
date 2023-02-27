<?php
namespace App\Controllers\General;

use App\Controllers\BaseController;
use App\Libraries\GeneralLibrary;
use App\Libraries\CheckAPI;
include_once APPPATH.'/ThirdParty/j/j.func.php';

class General extends BaseController{

	public function index(){

	}

	public function csrfToken($json = false){
		// if(session() -> get('id')){
			$general = new GeneralLibrary();
			echo $general->csrfToken('json');
		// }
	}

	public function getMunicipios($estados_id){
		$general = new GeneralLibrary();
		echo $general->getMunicipios($estados_id);
	}

	public function confirmation(){

		$data = [];

		if ($this->request->getMethod() == 'post') {
			// Validation;

			$data['html'] = $this->request->getVar('html');

		}

		echo view('general/confirmation',$data);
	}

	public function alert($name = null, $icon = null){

		$data = [];
		$data['name'] = $name;
		$data['icon'] = $icon;

		if ($this->request->getMethod() == 'post') {
			// Validation;

			$data['html'] = $this->request->getVar('html');

		}

		echo view('general/alert',$data);
	}

	public function curp(){
		if ($this->request->getMethod() == 'post') {
			
			$checkAPI = new CheckAPI();
			$data = $checkAPI -> curp($this->request->getVar('curp'));

			echo atj($data);

		}
	}
	
	public function employee_id(){
		if ($this->request->getMethod() == 'post') {
			
			$checkAPI = new CheckAPI();
			$data = $checkAPI -> employee_id($this->request->getVar('employee_id'));

			echo $data;

		}
	}


}