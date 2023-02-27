<?php 

namespace App\Libraries;
use App\Models\Empresas\FleetsModel;
use App\Models\Empresas\Fleets_Fuels_Vclass;
use App\Models\Empresas\CompaniesModel;
use App\Models\Administration\CategoriesModel;
use App\Models\Administration\ValidationsModel;
use App\Models\Administration\ValidationsValuesModel;
use App\Models\Administration\FleetsFuelsVclassQuantity;
use App\Models\Administration\FleetsFuelsVclassTravels;
use App\Models\Administration\FleetsFuelsModel;
use App\Models\Administration\CacheModel;
use App\Models\Administration\CacheVclassModel;
use App\Models\Administration\CacheUsersModel;
use App\Libraries\QR;


// require APPPATH.'/ThirdParty/dompdf/lib/Cpdf.php';
// require_once(APPPATH.'/ThirdParty/tcpdf/config/lang/eng.php');
// require_once(APPPATH.'/ThirdParty/tcpdf/tcpdf.php');


class Results {

	public function getResults($companies_id, $measure_year){

		$fleetModel = new FleetsModel();
		$cacheModel = new CacheModel();
		$cacheVclassModel = new CacheVclassModel();

		$fleets = $fleetModel 
		-> select('Fleets.id as fleets_id, Fleets.name, t.lts_tot, com.name as com_name, Fleets.status, com.rev_year, cv.*,
			t.km_tot, t.km_empty,t.payload_avg, t.ralenti_hours_large, t.lts_tot,
			t.ralenti_hours_short, t.ralenti_days, f.name as fuel_name, vclass.name as vclass_name')
		-> join("Cache_Vclass cv",'cv.fleets_id = Fleets.id','left')
		-> join('Companies com','com.id = Fleets.companies_id','left')
		-> join("Fuels f",'f.code = cv.fuels_code','left')
		-> join("Vclass vclass",'vclass.code = cv.vclass_code','left')
		-> join('Fleets_Fuels ff','ff.fleets_id = Fleets.id AND ff.fuels_id = f.id','left')
		-> join('Fleets_Fuels_Vclass_Travels t','t.fleets_fuels_id = ff.id AND t.vclass_id = vclass.id','left')
		-> join('Fleets_Fuels_Vclass ffv','ffv.Fleets_Fuels_id = ff.id AND ffv.vclass_id = vclass.id','left')
		-> where('cv.deleted_at',null)
		-> where('Fleets.measure_year',$measure_year)
		-> where('com.id',$companies_id)
		-> where('ffv.id !=',null)
		-> orderBy('Fleets.name','ASC')
		-> findAll();

		$fleetsCache = $cacheModel 
		-> select('Cache.*, c.name as cname, f.name as fname')
		-> join('Fleets f','f.id = Cache.fleets_id','left')
		-> join('Companies c','f.companies_id = c.id','left')
		-> where('f.companies_id',$companies_id)
		-> where('f.measure_year',$measure_year)
		-> where('f.deleted_at',null)
		->findAll();


		$resp['fleets'] = $fleets;
		$resp['fleetscache'] = $fleetsCache;
		// print2($fleets);
		return $resp;
	}

	public function getResultsU($companies_id, $measure_year){

		$fleetModel = new FleetsModel();
		$cacheModel = new CacheModel();
		$cacheUsersModel = new CacheUsersModel();
		$cacheVclassModel = new CacheVclassModel();

		$brands = $cacheUsersModel 
		-> select('Cache_Users.*, c.name as cname, f.name as fname, b.status, bf.measure_type,
			bf.ton_km, bf.tot_km, bf.avg_payload')
		-> join('Brands b','b.id = Cache_Users.brands_id','left')
		-> join('Brands_Fleets bf','bf.id = Cache_Users.brand_fleets_id','left')
		-> join('Fleets f','f.id = bf.fleets_id','left')
		-> join('Companies c','f.companies_id = c.id','left')
		-> where('b.companies_id',$companies_id)
		-> where('b.measure_year',$measure_year)
		-> where('b.deleted_at',null)
		->findAll();

		// print2($brands);

		$resp['brands'] = $brands;
		// print2($fleets);
		return $resp;
	}

	public function showResults($companies_id, $measure_year, $complete = true, $type = 'pre'){
		
		// echo "AAA";
		// exit();
		$companiesModel = new CompaniesModel();

		$company = $companiesModel -> where('id',$companies_id) -> first();

		$results = $this -> getResults($companies_id,$measure_year);
		// print2($results);
		$data['type'] = $type;
		$data['fleets'] = $results['fleets'];
		$data['fleetscache'] = $results['fleetscache'];
		$data['title'] = "Informe de desempeño preliminar ". $company['name'];
		switch($type){
			case 'pre':
				$data['title'] = "Informe de desempeño preliminar ". $company['name']." ".$measure_year;
				break;
			case 'fin':
			case 'conf':
				$data['title'] = "Informe de desempeño ". $company['name']." ".$measure_year;
				break;
		}

		$data['content'] = 'general/results';
		

		if($complete){
			// exit('AA');
			echo view('layout/base',$data);
		}else{
			// exit('BB');
			echo view('general/results',$data);
		}
	}

	public function showResultsU($companies_id, $measure_year, $complete = true, $type = 'pre'){
		
		$companiesModel = new CompaniesModel();

		$company = $companiesModel -> where('id',$companies_id) -> first();

		$results = $this -> getResultsU($companies_id,$measure_year);
		// print2($results);
		$data['type'] = $type;
		$data['brands'] = $results['brands'];
		$data['title'] = "Informe de desempeño preliminar ". $company['name'];
		switch($type){
			case 'pre':
				$data['title'] = "Informe de desempeño preliminar ". $company['name']." ".$measure_year;
				break;
			case 'fin':
			case 'conf':
				$data['title'] = "Informe de desempeño ". $company['name']." ".$measure_year;
				break;
		}

		$data['content'] = 'general/resultsU';
		

		if($complete){
			echo view('layout/base',$data);
		}else{
			echo view('general/resultsU',$data);
		}
	}

	public function pdf($companies_id, $measure_year){

		helper('text');
		helper('pdf_helper');

		$encrypter = \Config\Services::encrypter();

		$companiesModel = new CompaniesModel();
		$qr = new QR();

		$company = $companiesModel -> where('id',$companies_id) -> first();

		$results = $this -> getResults($companies_id,$measure_year);
		// print2($results);
		$data['fleets'] = $results['fleets'];
		$data['fleetscache'] = $results['fleetscache'];


		$data['title'] = "Informe de desempeño ". $company['name'].' - '.$measure_year;

		$qrName = "qr_".random_string('alnum',12).".png";
		$companies_id_encrypt = bin2hex($encrypter->encrypt($companies_id));
		$measure_year_encrypt = bin2hex($encrypter->encrypt($measure_year));

		$url = base_url().'/General/Check/Results/'.$companies_id_encrypt.'/'.$measure_year_encrypt;
		$qr -> generate($url,$qrName);

		$data['qrName'] = $qrName;
		$data['html'] = view('general/resultsPDF',$data);
		$data['url'] = $url;
		// $aaa = new tcpdf();
		
		// echo $data['html'];
		echo view('general/pdfDownload',$data);

	}

	public function pdfU($companies_id, $measure_year){

		helper('text');
		helper('pdf_helper');

		$encrypter = \Config\Services::encrypter();

		$companiesModel = new CompaniesModel();
		$qr = new QR();

		$company = $companiesModel -> where('id',$companies_id) -> first();

		$results = $this -> getResultsU($companies_id,$measure_year);
		// print2($results);
		$data['brands'] = $results['brands'];

		$data['title'] = "Informe de desempeño ". $company['name'].' - '.$measure_year;

		$qrName = "qr_".random_string('alnum',12).".png";
		$companies_id_encrypt = bin2hex($encrypter->encrypt($companies_id));
		$measure_year_encrypt = bin2hex($encrypter->encrypt($measure_year));

		$url = base_url().'/General/Check/ResultsU/'.$companies_id_encrypt.'/'.$measure_year_encrypt;
		$qr -> generate($url,$qrName);

		$data['qrName'] = $qrName;
		$data['html'] = view('general/resultsPDFU',$data);
		$data['url'] = $url;
		// $aaa = new tcpdf();
		
		// echo $data['html'];
		echo view('general/pdfDownload',$data);

	}
	// public function 

}


?>