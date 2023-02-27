<?php

namespace App\Controllers\Empresas;

use App\Models\Administration\UsersModel;
use App\Models\Empresas\CompaniesModel;
use App\Models\Administration\FleetsModel;
use App\Models\Administration\CacheModel;
use App\Models\Administration\CategoriesModel;

use App\Controllers\BaseController;
include_once APPPATH.'/ThirdParty/j/j.func.php';

class Inquiries extends BaseController
{

    public function index(){

        helper(['form']);

        $companiesModel = new CompaniesModel();
        $fleetsModel = new FleetsModel();
        $cacheModel = new CacheModel();
        $categoriesModel = new CategoriesModel();

        $data['fleetYears'] = $fleetsModel 
        -> select('distinct(measure_year)')
        -> join('Companies c','c.id = Fleets.companies_id','left')
        -> where('status >=',100)
        -> where('c.id',session()->get('id'))
        -> findAll();

        $data['categories'] = $categoriesModel
        -> select('Categories.*')
        -> join('Fleets f','f.categories_id = Categories.id','left')
        -> join('Companies c','c.id = f.companies_id','left')
        -> where('c.id',session()->get('id'))
        -> orderBy('Categories.name','ASC')
        -> groupBy('c.id')
        -> findAll();

        $data['title'] = "Consultas";
        $data['content'] = 'Empresas/inquiries/index';

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
            -> where('c.id',session()->get('id'))
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
            -> where('c.id',session()->get('id'))
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
            -> where('c.id',session()->get('id'))
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
            -> where('c.id',session()->get('id'))
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

            echo view('Empresas/inquiries/results',$data);
        }
    }

    public function fleetReport($fleets_id){
        $fleetsModel = new FleetsModel();

        $fleet = $fleetsModel
        -> select("Fleets.*,Cache.*,c.name as cname, Fleets.id as fleets_id")
        -> join('Companies c','c.id = Fleets.companies_id', 'left')
        -> join('Cache','Cache.fleets_id = Fleets.id','left')
        -> where('id',$fleets_id) 
        -> first();

        return $fleet;


    }

    private function companyReport($companies_id, $measure_year){

        $companiesModel = new CompaniesModel();
        $fleetsModel = new FleetsModel();

        $fleets = $fleetsModel
        -> select("Fleets.*,Cache.*,c.name as cname, Fleets.id as fleets_id")
        -> join('Companies c','c.id = Fleets.companies_id', 'left')
        -> join('Cache','Cache.fleets_id = Fleets.id','left')
        -> where('companies_id',$companies_id) 
        -> where('measure_year',$measure_year)
        -> where('Cache.deleted_at',null)
        -> orderBy("Fleets.name",'ASC')
        -> findAll();

        $inds = $fleetsModel
        -> select("SUM(CO2GKM) as CO2GKM, SUM(NOXGKM) as NOXGKM, SUM(PM25GKM) as PM25GKM,
            SUM(PM10GKM) as PM10GKM, SUM(CNGKM) as CNGKM, SUM(CO2GTonKM) as CO2GTonKM,
            SUM(NOXGTonKM) as NOXGTonKM, SUM(PM25GTonKM) as PM25GTonKM, SUM(PM10GTonKM) as PM10GTonKM,
            SUM(CNGTonKM) as CNGTonKM ")
        -> join('Companies c','c.id = Fleets.companies_id', 'left')
        -> join('Cache','Cache.fleets_id = Fleets.id','left')
        -> where('companies_id',$companies_id) 
        -> where('measure_year',$measure_year)
        -> where('Cache.deleted_at',null)
        -> first();

        $r['fleets'] = $fleets;
        $r['inds'] = $inds;
        return $r;

    }


    public function reports(){

        $fleetsModel = new FleetsModel();

        $years = $fleetsModel 
        -> select('DISTINCT(measure_year) as year') 
        -> where('companies_id',session() -> get('id'))
        -> where('Fleets.status >=',200)
        -> orderBy('measure_year','DESC')
        -> findAll();

        $data['title'] = "Reportes";
        $data['content'] = 'Empresas/inquiries/reports';
        $data['years'] = $years;

        echo view('layout/base',$data);


    }

    public function report($measure_year){
        $data['info'] = $this -> companyReport(session()->get('id'), $measure_year);
        $data['measure_year'] = $measure_year;

        echo view('Empresas/inquiries/report',$data);
        // print2($info);
    }


}


