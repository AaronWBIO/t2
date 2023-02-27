<?php

namespace App\Controllers\Administration;

use App\Models\Administration\UsersModel;
use App\Models\Empresas\CompaniesModel;
use App\Models\Administration\FleetsModel;
use App\Models\Administration\CacheModel;
use App\Models\Administration\CacheVclassModel;
use App\Models\Administration\FuelsModel;
use App\Models\Administration\VclassModel;
use App\Models\Administration\CategoriesModel;
use App\Models\Administration\PollutantsModel;
use App\Libraries\Results;

use App\Controllers\BaseController;
include_once APPPATH.'/ThirdParty/j/j.func.php';

class Inquiries extends BaseController{

    public function index(){

        helper(['form']);

        $companiesModel = new CompaniesModel();
        $fleetsModel = new FleetsModel();
        $cacheModel = new CacheModel();
        $categoriesModel = new CategoriesModel();

        $data['fleetYears'] = $fleetsModel 
        -> select('distinct(measure_year) as year')
        -> where('status >=',100)
        -> findAll();

        $data['categories'] = $categoriesModel
        -> orderBy('name','ASC')
        -> findAll();

        $data['title'] = "Consultas";
        $data['content'] = 'Administration/inquiries/index';

        echo view('layout/base',$data);
    }

    public function results(){

        $fleetsModel = new FleetsModel();

        if ($this->request->getMethod() == 'post') {
            $years = $this->request->getVar('years');
            $categories = $this->request->getVar('categories');

            if(!empty($years)){
                $fleetsModel
                -> whereIn('measure_year',$years);
            }
            if(!empty($categories)){
                $fleetsModel
                -> whereIn('categories_id',$categories);
            }


            $fleets = $fleetsModel 
            -> select('Fleets.*, c.name as cname, cache.*, com.name as comname')
            -> join('Categories c','c.id = Fleets.categories_id','left')
            -> join('Companies com','com.id = Fleets.companies_id','left')
            -> join('Cache cache','cache.fleets_id = Fleets.id','left')
            -> where('status >=',200)
            -> where('com.type',1)
            -> orderBy('measure_year','ASC')
            -> orderBy('c.name','ASC')
            -> findAll();

            $fleetsCats = [];
            $fleetsYears = [];

            $data['fleets'] = $fleets;
            // $data['fleetsCats'] = $fleetsCats;
            $data['fleetsYears'] = $fleetsYears;
            // print2($fleetsYears);

            if(!empty($years)){
                $fleetsModel
                -> whereIn('measure_year',$years);
            }
            if(!empty($categories)){
                $fleetsModel
                -> whereIn('categories_id',$categories);
            }

            $fields = '
                SUM(CO2GKM) as CO2GKM, SUM(NOXGKM) as NOXGKM, SUM(PM25GKM) as PM25GKM, 
                SUM(PM10GKM) as PM10GKM, SUM(CNGKM) as CNGKM, SUM(CO2GTonKM) as CO2GTonKM, 
                SUM(NOXGTonKM) as NOXGTonKM, SUM(PM25GTonKM) as PM25GTonKM, 
                SUM(PM10GTonKM) as PM10GTonKM, SUM(CNGTonKM) as CNGTonKM
            ';

            $data['fleetsCats'] = $fleetsModel 
            -> select('c.name as group, '.$fields)
            -> join('Categories c','c.id = Fleets.categories_id','left')
            -> join('Companies com','com.id = Fleets.companies_id','left')
            -> join('Cache cache','cache.fleets_id = Fleets.id','left')
            -> where('status >=',200)
            -> where('com.type',1)
            -> groupBy('c.name')
            -> orderBy('measure_year','ASC')
            -> orderBy('c.name','ASC')
            -> findAll();

            if(!empty($years)){
                $fleetsModel
                -> whereIn('measure_year',$years);
            }
            if(!empty($categories)){
                $fleetsModel
                -> whereIn('categories_id',$categories);
            }


            $data['fleetsYears'] = $fleetsModel 
            -> select('Fleets.measure_year as group, '.$fields)
            -> join('Categories c','c.id = Fleets.categories_id','left')
            -> join('Companies com','com.id = Fleets.companies_id','left')
            -> join('Cache cache','cache.fleets_id = Fleets.id','left')
            -> where('status >=',200)
            -> where('com.type',1)
            -> groupBy('Fleets.measure_year')
            -> orderBy('measure_year','ASC')
            -> orderBy('c.name','ASC')
            -> findAll();

            if(!empty($years)){
                $fleetsModel
                -> whereIn('measure_year',$years);
            }
            if(!empty($categories)){
                $fleetsModel
                -> whereIn('categories_id',$categories);
            }

            $fleetsYearsCatsDB = $fleetsModel 
            -> select('Fleets.measure_year as group, c.name as cname, c.code as ccode, '.$fields)
            -> join('Categories c','c.id = Fleets.categories_id','left')
            -> join('Companies com','com.id = Fleets.companies_id','left')
            -> join('Cache cache','cache.fleets_id = Fleets.id','left')
            -> where('status >=',200)
            -> where('com.type',1)
            -> groupBy('Fleets.measure_year, c.name')
            -> orderBy('measure_year','ASC')
            -> orderBy('c.name','ASC')
            -> findAll();

            $fleetsYearsCats = array();
            foreach ($fleetsYearsCatsDB as $f) {
                $fleetsYearsCats[$f['cname']][] = $f;
            }

            $data['fleetsYearsCats'] = $fleetsYearsCats;
            // print2($fleetsYears);

            echo view('Administration/inquiries/results',$data);
        }
    }

    public function companiesByYear($csv = 0){

        $companiesModel = new CompaniesModel();
        $fleetsModel = new FleetsModel();

        $fleetsDB = $fleetsModel 
        -> select('c.id, c.name as cname, Fleets.measure_year')
        -> join('Companies c','c.id = Fleets.companies_id','left')
        -> where('c.type',1)
        
        -> where('Fleets.status >=',200)
        -> groupBy('Fleets.measure_year,c.name')
        -> orderBy('c.name','ASC')
        -> orderBy('Fleets.measure_year','ASC')
        -> findAll();

        $years = array();
        $companies = array();
        foreach ($fleetsDB as $f) {
            $companies[$f['id']]['years'][$f['measure_year']] = 1;
            $companies[$f['id']]['cname'] = $f['cname'];
            $companies[$f['id']]['cid'] = $f['id'];

            $years[$f['measure_year']] = $f['measure_year'];
        }
        // ksort($years);
        // print2($fleets);
        // print2($years);
        $data['csv'] = $csv;
        $data['years'] = $years;
        $data['companies'] = $companies;

        echo view('Administration/inquiries/companiesByYear',$data);
    }

    public function metricsSearch(){

        $data = array();

        $fleetsModel = new FleetsModel();
        $fuelsModel = new FuelsModel();
        $vclassModel = new VclassModel();
        $pollutantsModel = new PollutantsModel();

        $years = $fleetsModel 
        -> select('DISTINCT(measure_year) as year')
        -> where('Fleets.status >=',100)
        -> orderBy('measure_year','ASC')
        -> findAll();

        $fuels = $fuelsModel -> orderBy('name','ASC') -> findAll();
        $vclass = $vclassModel -> orderBy('name','ASC') -> findAll();
        $pollutants = $pollutantsModel -> orderBy('name','ASC') -> findAll();



        $data['years'] = $years;
        $data['fuels'] = $fuels;
        $data['vclass'] = $vclass;
        $data['pollutants'] = $pollutants;

        echo view('Administration/inquiries/metricsSearch',$data);
    }

    public function showResults(){
        $library = new Results();

        if ($this->request->getMethod() == 'post') {
            $measure_year = $this->request->getVar('year');
            $companies_id = $this->request->getVar('companies_id');

            $companiesModel = new CompaniesModel();
            $company = $companiesModel -> where('id',$companies_id) -> first();

            echo '<div class="modal-header" >
                    <div style="text-align: center;">
                        <h4 class="modal-title">
                            Informe de desempeño
                        </h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" 
                        style="color:grey;top:0px;right:0px;position: absolute;">
                      <span aria-hidden="true">&times;</span>
                    </button>

                </div>

                <div class="modal-body">
                ';
                echo "<h2>$company[name] - $measure_year</h2>";
                 $library -> showResults($companies_id,$measure_year,false, 'fin');
            echo '</div>

                <div class="modal-footer">
                    <a class="btn btn-primary" data-dismiss="modal" id="envOkModal">Cerrar</a>
                </div>
                ';
        }
    }

    public function metrics($view,$type,$measure_year = null){

        $cacheVclassModel = new CacheVclassModel();
        $measure_year = empty($measure_year) ? date('Y') : $measure_year;

        switch ($type) {
            case 'all':
                $results = $cacheVclassModel
                -> select('Cache_Vclass.*, c.name as cname, f.name as fname, vc.name as classname, 
                    cat.name as catname, fuel.name as fuelname, payload_avg')
                -> join('Fleets f','f.id = Cache_Vclass.fleets_id','left')
                -> join('Vclass vc','vc.code = Cache_Vclass.vclass_code','left')
                -> join('Companies c', 'c.id = f.companies_id','left')
                -> join('Categories cat','cat.id = f.categories_id','left')
                -> join('Fuels fuel','fuel.code = Cache_Vclass.fuels_code','left')

                // -> where('f.status >=', 200)
                -> where('f.measure_year',$measure_year)
                -> where('f.status >=',200)
                -> orderBy('c.name','ASC')
                -> orderBy('f.name','ASC')
                // -> groupBy('vclass_code')
                -> findAll();

                $columns[] = ['Empresa','cname','text',1,',',];
                $columns[] = ['Flota','fname','text',1,',',];
                $columns[] = ['Clase','classname','text',1,',',];
                $columns[] = ['Categoría','catname','text',1,',',];
                $columns[] = ['Combustible','fuelname','text',1,',',];
                $columns[] = ['Número de vehículos','v_total','int',1,',',];
                $columns[] = ['Litros*','lts_tot','int',1,',',];
                $columns[] = ['kilómetros','km_tot','int',1,',',];
                $columns[] = ['Año promedio','avg_year','int',1,'',];
                $columns[] = ['Carga útil promedio','payload_avg','int',1,',',];
                $columns[] = ['CO2','CO2','float',1000000,',',];
                $columns[] = ['PM25','PM25','float',1000000,',',];
                $columns[] = ['PM10','PM10','float',1000000,',',];
                $columns[] = ['NOX','NOX','float',1000000,',',];
                $columns[] = ['CN','CN','float',1000000,',',];

                // $columns[] = ['Clase','class','text',1,',',];
                // $columns[] = ['Número de vehículos','v_total','int',1,',',];
                
                break;
            case 'class':
                $results = $cacheVclassModel
                -> select('SUM(CO2) as CO2 ,SUM(PM25) as PM25 ,SUM(PM10) as PM10 ,SUM(NOX) as NOX ,SUM(CN) as CN, 
                    SUM(v_total) as v_total, SUM(km_tot) as km_tot, SUM(lts_tot) as lts_tot, vc.name as class,
                    SUM((avg_year*v_total))/SUM(v_total) as avg_year')
                -> join('Fleets f','f.id = Cache_Vclass.fleets_id','left')
                -> join('Vclass vc','vc.code = Cache_Vclass.vclass_code','left')
                // -> where('f.status >=', 200)
                -> where('f.measure_year',$measure_year)
                -> where('f.status >=',200)
                -> groupBy('vclass_code')
                -> findAll();

                $columns[] = ['Clase','class','text',1,',',];
                $columns[] = ['Número de vehículos','v_total','int',1,',',];
                $columns[] = ['Año promedio','avg_year','int',1,'',];
                $columns[] = ['Litros*','lts_tot','int',1,',',];
                $columns[] = ['kilómetros','km_tot','int',1,',',];
                $columns[] = ['CO2','CO2','float',1000000,',',];
                $columns[] = ['PM25','PM25','float',1000000,',',];
                $columns[] = ['PM10','PM10','float',1000000,',',];
                $columns[] = ['NOX','NOX','float',1000000,',',];
                $columns[] = ['CN','CN','float',1000000,',',];

                break;
            case 'fuels':
                $results = $cacheVclassModel
                -> select('SUM(CO2) as CO2 ,SUM(PM25) as PM25 ,SUM(PM10) as PM10 ,SUM(NOX) as NOX ,SUM(CN) as CN, 
                    SUM(v_total) as v_total, SUM(km_tot) as km_tot, SUM(lts_tot) as lts_tot, fuel.name as fuel,
                    SUM((avg_year*v_total))/SUM(v_total) as avg_year')
                -> join('Fuels fuel','fuel.code = Cache_Vclass.fuels_code','left')
                -> join('Fleets f','f.id = Cache_Vclass.fleets_id','left')
                // -> where('f.status >=', 200)
                -> where('f.measure_year',$measure_year)
                -> where('f.status >=',200)
                -> groupBy('fuels_code')
                -> findAll();

                $columns[] = ['Combustible','fuel','text',1,',',];
                $columns[] = ['Número de vehículos','v_total','int',1,',',];
                $columns[] = ['Año promedio','avg_year','int',1,'',];
                $columns[] = ['Litros*','lts_tot','int',1,',',];
                $columns[] = ['kilómetros','km_tot','int',1,',',];
                $columns[] = ['CO2','CO2','float',1000000,',',];
                $columns[] = ['PM25','PM25','float',1000000,',',];
                $columns[] = ['PM10','PM10','float',1000000,',',];
                $columns[] = ['NOX','NOX','float',1000000,',',];
                $columns[] = ['CN','CN','float',1000000,',',];

                break;

            case 'categories':
                $results = $cacheVclassModel
                -> select('SUM(CO2) as CO2 ,SUM(PM25) as PM25 ,SUM(PM10) as PM10 ,SUM(NOX) as NOX ,SUM(CN) as CN,
                    AVG(CO2GKM) as CO2GKM ,AVG(PM25GKM) as PM25GKM ,AVG(PM10GKM) as PM10GKM ,AVG(NOXGKM) as NOXGKM ,AVG(CNGKM) as CNGKM,
                    SUM(v_total) as v_total, SUM(km_tot) as km_tot, SUM(lts_tot) as lts_tot, f.categories_id, cat.name as category,
                    SUM((avg_year*v_total))/SUM(v_total) as avg_year')
                -> join('Fuels fuel','fuel.code = Cache_Vclass.fuels_code','left')
                -> join('Fleets f','f.id = Cache_Vclass.fleets_id','left')
                -> join('Categories cat','cat.id = f.categories_id','left')
                // -> where('f.status >=', 200)
                -> where('f.measure_year',$measure_year)
                -> where('f.status >=',200)
                -> groupBy('f.categories_id')
                -> findAll();

                // print2($results);
                // exit();
                $columns[] = ['Categoría','category','text',1,',',];
                $columns[] = ['Número de vehículos','v_total','int',1,',',];
                $columns[] = ['Año promedio','avg_year','int',1,'',];
                $columns[] = ['Litros*','lts_tot','int',1,',',];
                $columns[] = ['kilómetros','km_tot','int',1,',',];
                $columns[] = ['CO2','CO2','float',1000000,',',];
                $columns[] = ['PM25','PM25','float',1000000,',',];
                $columns[] = ['PM10','PM10','float',1000000,',',];
                $columns[] = ['NOX','NOX','float',1000000,',',];
                $columns[] = ['CN','CN','float',1000000,',',];
                $columns[] = ['CO2GKM','CO2GKM','float',1,',',];
                $columns[] = ['PM25GKM','PM25GKM','float',1,',',];
                $columns[] = ['PM10GKM','PM10GKM','float',1,',',];
                $columns[] = ['NOXGKM','NOXGKM','float',1,',',];
                $columns[] = ['CNGKM','CNGKM','float',1,',',];

                break;
            
            case 'class_fuels':
                $results = $cacheVclassModel
                -> select('SUM(CO2) as CO2 ,SUM(PM25) as PM25 ,SUM(PM10) as PM10 ,SUM(NOX) as NOX ,SUM(CN) as CN, 
                    SUM(v_total) as v_total, SUM(km_tot) as km_tot, SUM(lts_tot) as lts_tot, vc.name as class, fuel.name as fuel,
                    SUM((avg_year*v_total))/SUM(v_total) as avg_year')
                -> join('Fuels fuel','fuel.code = Cache_Vclass.fuels_code','left')
                -> join('Fleets f','f.id = Cache_Vclass.fleets_id','left')
                -> join('Vclass vc','vc.code = Cache_Vclass.vclass_code','left')

                // -> join('Categories cat','cat.id = f.categories_id')
                // -> where('f.status >=', 200)
                -> where('f.measure_year',$measure_year)
                -> where('f.status >=',200)
                -> groupBy('vclass_code, fuels_code')
                -> findAll();

                // print2($results);
                // exit();
                $columns[] = ['Clase','class','text',1,',',];
                $columns[] = ['Combustible','fuel','text',1,',',];
                $columns[] = ['Número de vehículos','v_total','int',1,',',];
                $columns[] = ['Año promedio','avg_year','int',1,'',];
                $columns[] = ['Litros*','lts_tot','int',1,',',];
                $columns[] = ['kilómetros','km_tot','int',1,',',];
                $columns[] = ['CO2','CO2','float',1000000,',',];
                $columns[] = ['PM25','PM25','float',1000000,',',];
                $columns[] = ['PM10','PM10','float',1000000,',',];
                $columns[] = ['NOX','NOX','float',1000000,',',];
                $columns[] = ['CN','CN','float',1000000,',',];
                break;
            
            default:
                // code...
                break;
        }

        $data['type'] = $type;
        $data['columns'] = $columns;
        $data['results'] = $results;
        $data['measure_year'] = $measure_year;
        if($view == 'html'){
            echo view('Administration/inquiries/metrics',$data);
        }elseif($view == 'csv'){

            echo view('Administration/inquiries/metricsCSV',$data);
        }
    }
}


