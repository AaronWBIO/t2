<?php

namespace App\Libraries;

use App\Models\Empresas\BrandsModel;
use App\Models\Empresas\BrandsFleetsModel;
use App\Models\Empresas\CompaniesModel;
use App\Models\Empresas\ContactsModel;
use App\Models\Empresas\FleetsModel;

/*=====================================
VALIDANDO PASOS
true = completado
false = no completado
=====================================*/

class EmpresaVerificarPasos
{
    public static function paso1()
    {
        return true;
    }

    public static function paso2()
    {
        $company_model = new CompaniesModel();
        $company = $company_model->where('id', session()->id)->first();

        $contactos = new ContactsModel();
        $company['contactos'] = $contactos
            ->where('companies_id', session()->id)
            ->findAll();

        //Validamos paso 2
        if (isset($company['direccion']) && !empty($company['contactos'])) {
            return true;
        }

        return false;
    }
    public static function paso3()
    {
        $status = false;

        if (session()->type == 1) {
            $fleetsModel = new FleetsModel();

            $flotas = $fleetsModel
                ->where('companies_id', session()->id)->findAll();

            //Validamos paso 3

            foreach ($flotas as $key => $value) {
                //Identificar flotas
                if (isset($value['name']) && isset($value['type'])) {
                    $status = true;
                } else {
                    $status = false;
                }

                //Operacion            
                $carga_dedicada = isset($value['carga_dedicada']) ? $value['carga_dedicada'] : 0;
                $carga_consolidada = isset($value['carga_consolidada']) ? $value['carga_consolidada'] : 0;
                $acarreo = isset($value['acarreo']) ? $value['acarreo'] : 0;
                $paqueteria = isset($value['paqueteria']) ? $value['paqueteria'] : 0;
                $expedito = isset($value['expedito']) ? $value['expedito'] : 0;

                $total_operacion =
                    $carga_dedicada +
                    $carga_consolidada +
                    $acarreo +
                    $paqueteria +
                    $expedito;

                //Carroceria
                $caja_seca = isset($value['caja_seca']) ? $value['caja_seca'] : 0;
                $refrigerado = isset($value['refrigerado']) ? $value['refrigerado'] : 0;
                $plataforma = isset($value['plataforma']) ? $value['plataforma'] : 0;
                $cisterna = isset($value['cisterna']) ? $value['cisterna'] : 0;
                $chasis = isset($value['chasis']) ? $value['chasis'] : 0;
                $carga_pesada = isset($value['carga_pesada']) ? $value['carga_pesada'] : 0;
                $madrina = isset($value['madrina']) ? $value['madrina'] : 0;
                $mudanza = isset($value['mudanza']) ? $value['mudanza'] : 0;
                $utilitario = isset($value['utilitario']) ? $value['utilitario'] : 0;
                $especializado = isset($value['especializado']) ? $value['especializado'] : 0;

                $total_carroceria =
                    $caja_seca +
                    $refrigerado +
                    $plataforma +
                    $cisterna +
                    $chasis +
                    $carga_pesada +
                    $madrina +
                    $mudanza +
                    $utilitario +
                    $especializado;

                if ($total_carroceria == 100 && $total_operacion == 100) {
                    $status = true;
                } else {
                    $status = false;
                }
            }
        } else if (session()->type == 2) {

            $brandsModel = new BrandsModel();
            $brandsFleetsModel = new BrandsFleetsModel();


            $brandsFleets = $brandsFleetsModel -> select('Brands_Fleets.*, b.name, b.companies_id')
            -> join('Brands b','b.id = Brands_Fleets.brands_id','left')
            -> where('b.companies_id',session()->id)
            -> where('b.measure_year',date('Y'))
            -> where('b.deleted_at',null)
            -> findAll();

            // echo session() -> id;
            $brands = $brandsModel
            -> where('companies_id',session()->id)
            -> where('measure_year',date('Y'))
            -> where('deleted_at',null)
            -> findAll();


            $status = true;
            if(empty($brands)){
                $status = false;
            }

            // print2($brandsFleets);
            // exit();


            foreach ($brandsFleets as $b) {
                switch ($b['measure_type']) {
                    case '1':
                        if(empty($b['ton_km']) || empty($b['tot_km'])){
                            $status = false;
                            break 2;
                        }
                        break;
                    case '2':
                        if(empty($b['ton_km']) || empty($b['avg_payload'])){
                            $status = false;
                            break 2;
                        }
                        break;
                    case '3':
                        if(empty($b['tot_km']) || empty($b['avg_payload'])){
                            $status = false;
                            break 2;
                        }
                        break;
                    case '4':
                        if(empty($b['tot_km'])){
                            $status = false;
                            break 2;
                        }
                        break;
                    
                    default:
                        // code...
                        break;
                }
            }

        }

        return $status;
    }
    public static function paso4()
    {
        $status = true;

        $fleetsModel = new FleetsModel();

        $flotas = $fleetsModel
            ->where('companies_id', session()->id)->findAll();

        //Validamos paso 4

        foreach ($flotas as $key => $value) {
            // print2($value['id']);
            // print2($value['status']);
            // print2($value['name']);
            if ($value['status'] < 80) {
                $status = false;
                break;
            } 
        }

        // if($status)
        //     echo "SI";
        // else
        //     echo "NO";

        // exit();

        return $status;
    }

    public static function paso4U()
    {
        $status = true;

        $fleetsModel = new BrandsModel();

        $flotas = $fleetsModel
            ->where('companies_id', session()->id)
            ->where('deleted_at',null)
            ->where('measure_year',date('Y'))
            ->findAll();

        //Validamos paso 4

        foreach ($flotas as $key => $value) {
            // print2($value);
            if ($value['status'] < 90) {
                $status = false;
                break;
            } 
        }

        return $status;
    }
    public static function paso5()
    {
        $status = true;
        if (session() -> get('type') == 1) {
            $fleetsModel = new FleetsModel();
        }elseif (session() -> get('type') == 2){
            $fleetsModel = new BrandsModel();
        }
        //TODAS LAS FLOTAS DEL MEASURE YEAR ACTUAL EN 200
        $flotas = $fleetsModel
        ->where('companies_id', session()->id)
        ->where('measure_year', date('Y'))
        ->findAll();
        //Validamos paso 5

        if(empty($flotas)){
            $status = false;
        }

        foreach ($flotas as $key => $value) {
            if ($value['status'] < 100) {
                $status = false;
            }
        }

        return $status;
    }

    public static function paso6()
    {
        //NO SE PONE PALOMITA
        $company_model = new CompaniesModel();
        $fleets_model = new FleetsModel();

        $company = $company_model->where('id', session()->id)->first();

        $fleets = $fleets_model
            ->where('companies_id', session()->id)
            ->where('measure_year', date('Y'))
            ->findAll();

        $result = true;

        if ($company['rev_year'] != date('Y')) {
            $result = false;
        }

        foreach ($fleets as $f) {
            if ($f['status'] < 200) {
                $result = false;
            }
        }

        return $result;
    }
    
    public static function paso6U()
    {
        // echo "AAA";
        //NO SE PONE PALOMITA
        $company_model = new CompaniesModel();
        $fleets_model = new BrandsModel();

        $company = $company_model->where('id', session()->id)->first();

        $fleets = $fleets_model
            ->where('companies_id', session()->id)
            ->where('measure_year', date('Y'))
            ->findAll();

        $result = true;

        if ($company['rev_year'] != date('Y')) {
            $result = false;

        }

        foreach ($fleets as $f) {
            if ($f['status'] < 200) {

            // exit("DDD");
                $result = false;
            }
        }

        return $result;
    }
}
