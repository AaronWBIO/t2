<?php
namespace App\Controllers\General;

use App\Controllers\BaseController;
use App\Libraries\Results;

include_once APPPATH.'/ThirdParty/j/j.func.php';

class Check extends BaseController{

	public function index(){

	}

	public function results($companies_id_encrypt,$measure_year_encrypt){

		$results = new Results();
		$encrypter = \Config\Services::encrypter();
		$companies_id = $encrypter -> decrypt(hex2bin($companies_id_encrypt));
		$measure_year = $encrypter -> decrypt(hex2bin($measure_year_encrypt));

		$results -> showResults($companies_id, $measure_year, true,'conf');
		// print2([$companies_id,$measure_year]);
		// echo "Certificado válido";

	}

	public function resultsU($companies_id_encrypt,$measure_year_encrypt){

		$results = new Results();
		$encrypter = \Config\Services::encrypter();
		$companies_id = $encrypter -> decrypt(hex2bin($companies_id_encrypt));
		$measure_year = $encrypter -> decrypt(hex2bin($measure_year_encrypt));

		$results -> showResultsU($companies_id, $measure_year, true,'conf');
		// print2([$companies_id,$measure_year]);
		// echo "Certificado válido";

	}


}