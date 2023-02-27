<?php
namespace App\Controllers\Administration;
use App\Models\Administration\UsersModel;
use App\Models\Empresas\CompaniesModel;
use App\Models\Administration\FleetsModel;
use App\Models\Administration\CacheModel;
use App\Models\Administration\CacheUsersModel;
use App\Models\Empresas\Fleet_Fuels_Vclass_Quantity;

use App\Controllers\BaseController;
include_once APPPATH.'/ThirdParty/j/j.func.php';

class Dashboard extends BaseController{

	public function index($year = null){

		helper(['form']);

	    $companiesModel = new CompaniesModel();
	    $fleetsModel = new FleetsModel();
	    $cacheModel = new CacheModel();
	    $cacheUsersModel = new CacheUsersModel();
	    $fleet_Fuels_Vclass_Quantity = new Fleet_Fuels_Vclass_Quantity();

	    $measure_year = empty($year) ? date('Y') : $year;
	    $data['measure_year'] = $measure_year;

	    $data['title'] = 'Resumen';

	    $data['fleetYears'] = $fleetsModel 
	    -> select('distinct(measure_year)')
	    -> where('status >=',100)
	    -> findAll();

	    $data['empresasTrTot'] = $companiesModel -> select('count(*) as cuenta') -> where('type',1) -> first();
	    $data['empresasTrRep'] = $companiesModel 
	    -> select('count(*) as cuenta')
	    -> join('Fleets f','f.companies_id = Companies.id','left')
	    -> where('Companies.type',1)
	    -> where('f.measure_year',$measure_year)
	    -> where('f.status >=',100)
	    -> groupBy('Companies.id')
	    -> first();

	    $data['empresasTrValid'] = $companiesModel 
	    -> select('count(*) as cuenta')
	    -> join('Fleets f','f.companies_id = Companies.id','left')
	    -> where('Companies.type',1)
	    -> where('f.measure_year',$measure_year)
	    -> where('f.status >=',200)
	    -> groupBy('Companies.id')
	    -> first();
	    // print2($data['empresasTrRep']);
	    // echo "AAA";

	    $data['empresasUsTot'] = $companiesModel -> select('count(*) as cuenta') -> where('type',1) -> first();
	    $data['empresasUsRep'] = $companiesModel 
	    -> select('count(*) as cuenta')
	    -> join('Brands f','f.companies_id = Companies.id','left')
	    -> where('Companies.type',2)
	    -> where('f.measure_year',$measure_year)
	    -> where('f.status >=',100)
	    -> where('rev_year',$measure_year)
	    -> first();

	    $data['empresasUsValid'] = $companiesModel 
	    -> select('count(*) as cuenta')
	    -> join('Brands f','f.companies_id = Companies.id','left')
	    -> where('Companies.type',2)
	    -> where('f.measure_year',$measure_year)
	    -> where('f.status >=',200)
	    -> where('rev_year',$measure_year)
	    -> first();

	    $data['tot_v'] = $fleet_Fuels_Vclass_Quantity 
	    -> select('SUM(quantity) as cuenta')
	    -> join('Fleets_Fuels ff','ff.id = Fleet_Fuels_Vclass_Quantity.fleets_fuels_id','left')
	    -> join('Fleets_Fuels_Vclass ffv','ffv.Fleets_Fuels_id = ff.id AND ffv.vclass_id = Fleet_Fuels_Vclass_Quantity.vclass_id','left')
	    -> join('Fleets f','ff.fleets_id = f.id','left')
	    -> where('f.measure_year',$measure_year)
	    -> where('ffv.id != ',null)
	    -> where('ff.active',1)
	    -> where('f.status >=',200)
	    -> first();

	    $data['emisiones'] = $cacheModel 
	    -> select('SUM(CO2) as CO2 ,SUM(PM25) as PM25 ,SUM(PM10) as PM10 ,SUM(NOX) as NOX ,SUM(CN) as CN ')
	    -> join('Fleets f','Cache.fleets_id = f.id','left')
	    -> where('f.measure_year',$measure_year)
	    -> where('f.status >=',200)
	    -> first();

	    $data['emisionesU'] = $cacheUsersModel 
	    -> select('SUM(CO2) as CO2 ,SUM(PM25) as PM25 ,SUM(PM10) as PM10 ,SUM(NOX) as NOX ,SUM(CN) as CN ')
	    -> join('Brands b','Cache_Users.brands_id = b.id','left')
	    -> where('b.measure_year',$measure_year)
	    -> where('b.status >=',200)
	    -> first();

	    // print2($data['emisiones']);


	    $data['content'] = 'Administration/dashboard/index';

	    echo view('layout/base',$data);

	}



}


