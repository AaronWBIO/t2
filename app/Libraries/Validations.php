<?php 

namespace App\Libraries;
use App\Models\Empresas\FleetsModel;
use App\Models\Empresas\Fleets_Fuels_Vclass;
use App\Models\Administration\CompaniesModel;
use App\Models\Administration\CategoriesModel;
use App\Models\Administration\ValidationsModel;
use App\Models\Administration\ValidationsValuesModel;
use App\Models\Administration\FleetsFuelsVclassQuantity;
use App\Models\Administration\FleetsFuelsVclassTravels;
use App\Models\Administration\FleetsFuelsModel;


class Validations {


	public function category($fleets_id, $fleet = null){
		
		$fleetModel = new FleetsModel();
		$categoriesModel = new CategoriesModel();

		$categories = $categoriesModel -> getCodes();

		if(empty($fleet)){
			$fleet = $fleetModel -> where('id',$fleets_id) -> first();
		}
		// print2($fleet);

		if($fleet['paqueteria'] >= 75){
			return $categories['paqueteria'];
		}
		elseif($fleet['mudanza'] >= 75){
			return $categories['mudanza'];
		}
		elseif($fleet['carga_pesada'] >= 75){
			return $categories['pesada'];
		}
		elseif($fleet['refrigerado'] >= 75){
			return $categories['refrigerado'];
		}
		elseif($fleet['cisterna'] >= 75){
			return $categories['cisterna'];
		}
		elseif($fleet['madrina'] >= 75){
			return $categories['madrina'];
		}
		elseif($fleet['plataforma'] >= 75){
			return $categories['plataforma'];
		}
		elseif($fleet['utilitario'] + $fleet['especializado'] >= 75){
			return $categories['especializado'];
		}

		elseif($fleet['caja_seca'] >= 75 || $fleet['chasis'] >= 75 || $fleet['caja_seca'] + $fleet['chasis'] >= 75){
			if($fleet['carga_dedicada'] >= 75){
				return $categories['TL-CajaSeca'];
			}
			elseif($fleet['carga_consolidada'] >= 75){
				return $categories['LTL-CajaSeca'];
			}
			elseif($fleet['paqueteria'] >= 75){
				return $categories['paqueteria'];
			}
			elseif($fleet['expedito'] >= 75){
				return $categories['expedito'];
			}
			elseif($fleet['acarreo'] >= 75){
				return $categories['acarreo'];
			}
			else{
				return $categories['mixto'];
			}
		}
		else{
			return $categories['mixto'];
		}

		return $categories['mixto'];



		//////////

		// if($fleet['acarreo'] >= 75){
		// 	return $categories['acarreo'];
		// }
		// elseif($fleet['refrigerado'] >= 75){
		// 	return $categories['refrigerado'];
		// }
		// elseif($fleet['caja_seca'] + $fleet['chasis'] >= 75){
		// 	if($fleet['carga_dedicada'] >= 75){
		// 		return $categories['TL-CajaSeca'];
		// 	}
		// 	if($fleet['carga_consolidada'] >= 75){
		// 		return $categories['LTL-CajaSeca'];
		// 	}else{
		// 		return $categories['mixto'];
		// 	}
		// }
		// elseif($fleet['plataforma'] >= 75){
		// 	return $categories['plataforma'];
		// }
		// elseif($fleet['cisterna'] >= 75){
		// 	return $categories['cisterna'];
		// }
		// elseif($fleet['carga_pesada'] >= 75){
		// 	return $categories['pesada'];
		// }
		// elseif($fleet['madrina'] >= 75){
		// 	return $categories['madrina'];
		// }
		// elseif($fleet['mudanza'] >= 75){
		// 	return $categories['mudanza'];
		// }
		// elseif($fleet['utilitario'] >= 75){
		// 	return $categories['utilitario'];
		// }
		// elseif($fleet['especializado'] >= 75){
		// 	return $categories['especializado'];
		// }
		// elseif($fleet['paqueteria'] >= 75){
		// 	return $categories['paqueteria'];
		// }
		// elseif($fleet['expedito'] >= 75){
		// 	return $categories['expedito'];
		// }
		// else{
		// 	return $categories['mixto'];
		// }

		// return $categories['mixto'];
	}

	public function validation($fleets_id,$field,$vclass_id,$value,$fuels_id,$fleet=null){

		$fleetsModel = new FleetsModel();
		if(empty($fleet)){
			$fleet = $fleetsModel -> where('id',$fleets_id) -> first();
		}
		$category = $this -> category($fleets_id,$fleet);

		switch ($field) {
			case 'km_tot':
				return $this -> kmTot($fleet,$category,$vclass_id,$value,$fuels_id);
				break;
			case 'km/l':
				return $this -> kmL($fleet,$category,$vclass_id,$value,$fuels_id);
				break;
			case 'km_empty':
				return $this -> kmEmpty($fleet,$category,$vclass_id,$value,$fuels_id);
				break;
			// case 'load_volume':
			// 	return $this -> kmVol($fleet,$category,$vclass_id,$value,$fuels_id);
			// 	break;
			case 'ralenti_days':
				return $this -> ralenti_days($fleet,$category,$vclass_id,$value,$fuels_id);
				break;
			case 'ralenti_hours_large':
				return $this -> ralenti_hours_large($fleet,$category,$vclass_id,$value,$fuels_id);
				break;
			case 'ralenti_hours_short':
				return $this -> ralenti_hours_short($fleet,$category,$vclass_id,$value,$fuels_id);
				break;
			case 'payload_avg':
				return $this -> payloadAvg($fleet,$category,$vclass_id,$value,$fuels_id);
				break;
			
			default:
				// code...
				break;
		}
	}

	public function fleetEval($fleets_id, $fleet = null){

		$fleetsModel = new FleetsModel();
		$fleetsFuelsVclass = new Fleets_Fuels_Vclass();
		$fleetsFuelsModel = new FleetsFuelsModel();
		$fleetsFuelsVclassTravels = new FleetsFuelsVclassTravels();
		$validationsModel = new ValidationsModel();

		$validations = $validationsModel -> findAll();

		$fuels = $fleetsFuelsModel 
		-> select('f.*, Fleets_Fuels.id as ffid, Fleets_Fuels.active')
		-> join('Fuels f','f.id = Fleets_Fuels.fuels_id','left')
		-> where('Fleets_Fuels.fleets_id',$fleets_id)
		-> where('Fleets_Fuels.active',1)
		-> findAll();
		// print2($fuels);

		if(empty($fleet)){
			$fleet = $fleetsModel -> where('id',$fleets_id) -> first();
		}
		// print2($fleet);
		$fleetVals = array();
		foreach ($fuels as $f) {
			
			$vclass = $fleetsFuelsVclass 
			-> select('Fleets_Fuels_Vclass.*,vc.code as vccode, vc.name as vcname')
			-> join('Vclass vc','vc.id = Fleets_Fuels_Vclass.vclass_id','left')
			-> where('Fleets_Fuels_id',$f['ffid']) 
			-> findAll();

			// print2($vclass);

			// print2($travels);
			foreach ($vclass as $vc) {
				$travels = $fleetsFuelsVclassTravels 
				-> where('fleets_fuels_id',$f['ffid']) 
				-> where('vclass_id',$vc['vclass_id'])
				-> first();

				// print2($travels);
				if(empty($travels)){
					continue;
				}

				foreach ($validations as $v) {
					switch ($v['field']) {
						case 'km_tot':
							$value = $travels['km_tot'];
							// echo $v['field']." = $value <br/>";
							break;
						case 'km/l':
							$value = $travels['lts_tot'] != 0 ? $travels['km_tot']/$travels['lts_tot'] : 0;
							// echo $v['field']." = $value <br/>";
							break;
						case 'km_empty':
							$value = $travels['km_empty'];
							// echo $v['field']." = $value <br/>";
							break;
						// case 'load_volume':
						// 	$value = $travels['load_volume'];
						// 	// echo $v['field']." = $value <br/>";
						// 	break;
						case 'ralenti_days':
							$value = $travels['ralenti_days'];
							// echo $v['field']." = $value <br/>";
							break;
						case 'ralenti_hours_large':
							$value = $travels['ralenti_hours_large'];
							// echo $v['field']." = $value <br/>";
							break;
						case 'ralenti_hours_short':
							$value = $travels['ralenti_hours_short'];
							// echo $v['field']." = $value <br/>";
							break;
						case 'payload_avg':
							$value = $travels['payload_avg'];
							// echo $v['field']." = $value <br/>";
							break;
						
						default:
							// code...
							break;
					}

					$fleetVals[$f['name']][$vc['vcname']][$v['field']] = $this -> validation($fleet['id'],$v['field'],$vc['vclass_id'],$value,$f['id'],$fleet);
				}
			}
		}


		$status = $fleet['status'] < 100 ? $status = $this -> fleet_status($fleets_id, $fleetVals, $fleet) : $status = $fleet['status'];

		// print2($status);

		$json = atj($fleetVals);

		$fleetsModel -> update($fleets_id,['json'=>$json,'status' => $status]);

		return $fleetVals;
	}

	public function companyEvaluate($companies_id, $measure_year = null){

		$fleetsModel = new  FleetsModel();
		$measure_year = empty($measure_year) ? date('Y') : $measure_year;

		$fleets = $fleetsModel -> where('companies_id',$companies_id) -> where('measure_year',$measure_year) -> findAll();

		$evals = array();
		foreach ($fleets as $f) {
			// print2($f);
			$evals[$f['name']] = $this -> fleetEval($f['id'], $f);
		}

		// print2($evals);
		return $evals;
	}

	private function kmTot($fleet,$category,$vclass_id,$value,$fuels_id){

		$validationsValuesModel = new ValidationsValuesModel();
		$fleetsFuelsVclassQuantity = new FleetsFuelsVclassQuantity();

		$trucks = $fleetsFuelsVclassQuantity
		-> select('SUM(Fleet_Fuels_Vclass_Quantity.quantity) as sum')
		-> join('Fleets_Fuels ff', 'ff.id = fleets_fuels_id','left')
		-> where('ff.fuels_id',$fuels_id)
		-> where('ff.fleets_id',$fleet['id'])
		-> where('Fleet_Fuels_Vclass_Quantity.vclass_id',$vclass_id)
		-> first()['sum'];

		$avg = $trucks != 0 ? $value / $trucks : 0;

		$ranges = $validationsValuesModel 
		-> select('Validations_Values.*')
		-> join('Validations v','v.id = Validations_Values.validations_id','left')
		-> where('Validations_Values.vclass_id',$vclass_id)
		-> where('categories_id',$category['id'])
		-> where('v.field','km_tot')
		-> first();

		return $trucks != 0 ? $this -> evaluate($ranges,$avg) : 0;
		
	}

	private function kmL($fleet,$category,$vclass_id,$value,$fuels_id){

		$validationsValuesModel = new ValidationsValuesModel();
		$ranges = $validationsValuesModel 
		-> select('Validations_Values.*')
		-> join('Validations v','v.id = Validations_Values.validations_id','left')
		-> where('Validations_Values.vclass_id',$vclass_id)
		-> where('categories_id',$category['id'])
		-> where('v.field','km/l')
		-> first();

		return $this -> evaluate($ranges,$value);
	}

	private function kmEmpty($fleet,$category,$vclass_id,$value,$fuels_id){
		$validationsValuesModel = new ValidationsValuesModel();
		$ranges = $validationsValuesModel 
		-> select('Validations_Values.*')
		-> join('Validations v','v.id = Validations_Values.validations_id','left')
		-> where('Validations_Values.vclass_id',$vclass_id)
		-> where('categories_id',$category['id'])
		-> where('v.field','km_empty')
		-> first();

		return $this -> evaluate($ranges,$value);
	}

	private function kmVol($fleet,$category,$vclass_id,$value,$fuels_id){
		$validationsValuesModel = new ValidationsValuesModel();
		$ranges = $validationsValuesModel 
		-> select('Validations_Values.*')
		-> join('Validations v','v.id = Validations_Values.validations_id','left')
		-> where('Validations_Values.vclass_id',$vclass_id)
		-> where('categories_id',$category['id'])
		-> where('v.field','load_volume')
		-> first();

		return 0;
	}

	private function ralenti_days($fleet,$category,$vclass_id,$value,$fuels_id){
		$validationsValuesModel = new ValidationsValuesModel();
		$ranges = $validationsValuesModel 
		-> select('Validations_Values.*')
		-> join('Validations v','v.id = Validations_Values.validations_id','left')
		-> where('Validations_Values.vclass_id',$vclass_id)
		-> where('categories_id',$category['id'])
		-> where('v.field','ralenti_days')
		-> first();

		return $this -> evaluate($ranges,$value);
	}

	private function ralenti_hours_large($fleet,$category,$vclass_id,$value,$fuels_id){
		$validationsValuesModel = new ValidationsValuesModel();
		$ranges = $validationsValuesModel 
		-> select('Validations_Values.*')
		-> join('Validations v','v.id = Validations_Values.validations_id','left')
		-> where('Validations_Values.vclass_id',$vclass_id)
		-> where('categories_id',$category['id'])
		-> where('v.field','ralenti_hours_large')
		-> first();
		
		return $this -> evaluate($ranges,$value);
	}

	private function ralenti_hours_short($fleet,$category,$vclass_id,$value,$fuels_id){
		$validationsValuesModel = new ValidationsValuesModel();
		$ranges = $validationsValuesModel 
		-> select('Validations_Values.*')
		-> join('Validations v','v.id = Validations_Values.validations_id','left')
		-> where('Validations_Values.vclass_id',$vclass_id)
		-> where('categories_id',$category['id'])
		-> where('v.field','ralenti_hours_short')
		-> first();
		
		// print2($ranges);
		// print2($value);
		return $this -> evaluate($ranges,$value);
	}

	private function payloadAvg($fleet,$category,$vclass_id,$value,$fuels_id){
		$validationsValuesModel = new ValidationsValuesModel();
		$ranges = $validationsValuesModel 
		-> select('Validations_Values.*')
		-> join('Validations v','v.id = Validations_Values.validations_id','left')
		-> where('Validations_Values.vclass_id',$vclass_id)
		-> where('categories_id',$category['id'])
		-> where('v.field','payload_avg')
		-> first();


		return $this -> evaluate($ranges,$value);
	}

	private function evaluate($ranges,$value){

		if(
			$ranges['min'] == null && 
			$ranges['red_low'] == null && 
			$ranges['yellow_low'] == null && 
			$ranges['yellow_high'] == null && 
			$ranges['red_high'] == null && 
			$ranges['max'] == null
		){
			return 0;
		}

		if($value < $ranges['min']){
			return 3;
		}
		elseif($value >= $ranges['min'] && $value < $ranges['red_low']){
			return 2;
		}
		elseif($value >= $ranges['red_low'] && $value < $ranges['yellow_low']){
			return 1;
		}
		elseif($value >= $ranges['yellow_low'] && $value <= $ranges['yellow_high']){
			return 0;
		}
		elseif($value > $ranges['yellow_high'] && $value <= $ranges['red_high']){
			return 1;
		}
		elseif($value > $ranges['red_high'] && $value <= $ranges['max']){
			return 2;
		}
		elseif($value > $ranges['max']){
			return 3;
		}
		return 0;
	}
	
	public function fleet_status($fleets_id, $fleetVals, $fleet = null){

		$fleetsFuelsModel = new FleetsFuelsModel();
		$fleetsFuelsVclassTravels = new FleetsFuelsVclassTravels();
		$fleetsFuelsVclassQuantity = new FleetsFuelsVclassQuantity();

		$incomplete = false;
		$incomplete_data = array();

		$errors = false;
		$errors_data = array();

		if(empty($fleet)){
			$fleet = $fleetsModel -> where('id',$fleets_id) -> first();
		}

		$tipo_de_carga = $fleet['carga_dedicada']+
			$fleet['carga_consolidada']+
			$fleet['acarreo']+
			$fleet['paqueteria']+
			$fleet['expedito'];

		if($tipo_de_carga < 100){
			$incomplete = true;

			$incomplete_data[] = 'Tipo de carga';
		}

		$tipo_de_carroceria = $fleet['caja_seca']+
			$fleet['refrigerado']+
			$fleet['plataforma']+
			$fleet['cisterna']+
			$fleet['chasis']+
			$fleet['carga_pesada']+
			$fleet['madrina']+
			$fleet['mudanza']+
			$fleet['utilitario']+
			$fleet['especializado'];

		if($tipo_de_carroceria < 100){
			$incomplete = true;
			$incomplete_data[] = 'Tipo de carrocería';

		}
		$operacion = $fleet['usa']+
			$fleet['canada']+
			$fleet['mexico'];

		if($operacion < 100){
			$incomplete = true;
			$incomplete_data[] = 'Datos de operación';
		}

		$recorrido = $fleet['short']+
			$fleet['large'];

		if($recorrido < 100){
			$incomplete = true;
			$incomplete_data[] = 'Datos de recorrido';
		}

		if($fleet['intermediary'] == null){
			$incomplete = true;
			$incomplete_data[] = 'Intermediario';
		}

		if($fleet['intermediaryPercent'] == null && $fleet['intermediaryPercent'] > 0){
			$incomplete = true;
			$incomplete_data[] = 'Porcentaje intermediario';
		}


		$fleetsFuels = $fleetsFuelsModel 
		-> select('Fleets_Fuels.*, f.code as fcode')
		-> join('Fuels f','f.id = Fleets_Fuels.fuels_id','left')
		-> where('fleets_id', $fleets_id) 
		-> where('active', 1) 
		-> findAll();

		if(empty($fleetsFuels)){
			$incomplete = true;
			$incomplete_data[] = 'No hay información de combustibles';
		}


		foreach ($fleetsFuels as $ff) {

			$travels = $fleetsFuelsVclassTravels -> where('fleets_fuels_id', $ff['id']) -> findAll();
			$incomplete_data['fuels'][$ff['fcode']]['fcode'] = $ff['fcode'];

			if(empty($travels)){
				$incomplete = true;
			}
			foreach ($travels as $t) {
				if($t['km_tot'] == null){
					$incomplete = true;
					$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'km_tot';
				}
				// if($t['km_pay'] == null){
				// 	$incomplete = true;
				// 	$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'km_pay';
				// }


				if($t['km_empty'] == null){
					$incomplete = true;
					$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'km_empty';
				}

				if($t['lts_tot'] == null){
					$incomplete = true;
					$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'lts_tot';
				}

				// if($ff['fcode'] == 'diesel' && $t['lts_bio'] == null){
				// 	$incomplete = true;
				// 	$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'lts_bio';
				// }

				if($t['payload_avg'] == null){
					$incomplete = true;
					$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'payload_avg';
				}

				// if($t['load_type'] == null){
				// 	$incomplete = true;
				// 	$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'load_type';
				// }

				// if($t['highway'] == null){
				// 	$incomplete = true;
				// 	$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'highway';
				// }
				// if($t['less_40'] == null){
				// 	$incomplete = true;
				// 	$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'less_40';
				// }
				// if($t['40_80'] == null){
				// 	$incomplete = true;
				// 	$incomplete_data['fuels'][$ff['fcode']]['field'][] = '40_80';
				// }
				// if($t['over_80'] == null){
				// 	$incomplete = true;
				// 	$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'over_80';
				// }

				if($t['highway'] + $t['less_40'] + $t['40_80'] + $t['over_80'] < 100){
					$incomplete = true;
					$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'sum';
				}


				if($t['ralenti_hours_large'] == null){
					$incomplete = true;
					$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'ralenti_hours_large';
				}
				if($t['ralenti_hours_short'] == null){
					$incomplete = true;
					$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'ralenti_hours_short';
				}
				if($t['ralenti_days'] == null){
					$incomplete = true;
					$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'ralenti_days';
				}
				if($ff['fcode'] == 'hibrido' && $t['hybrid_type'] == null){
					$incomplete = true;
					$incomplete_data['fuels'][$ff['fcode']]['field'][] = 'hybrid_type';
				}
			}

			$quantities = $fleetsFuelsVclassQuantity 
			-> select('SUM(quantity) as v_tot, Fleet_Fuels_Vclass_Quantity.vclass_id')
			-> join('Fleets_Fuels_Vclass ffv',
				'ffv.vclass_id = Fleet_Fuels_Vclass_Quantity.vclass_id AND 
					ffv.Fleets_Fuels_id = Fleet_Fuels_Vclass_Quantity.fleets_fuels_id',
				'left')
			-> where('Fleet_Fuels_Vclass_Quantity.fleets_fuels_id', $ff['id'])
			-> where('ffv.id !=', null)
			-> groupBy('Fleet_Fuels_Vclass_Quantity.vclass_id')
			-> findAll();


			// print2($quantities);
			foreach($quantities as $q){
				if($q['v_tot'] == 0){
					$incomplete = true;
					$incomplete_data['quantities'][] = 'v_tot';
				}
			}

		}

		// if($incomplete){
		// 	echo "La flota $fleets_id está incompleta <br/>";
		// 	print2($incomplete_data);
		// }else{
		// 	echo "La flota $fleets_id está COMPLETA <br/>";
		// }

		// print2($fleetVals);

		foreach ($fleetVals as $ff => $vClasses) {
			foreach ($vClasses as $c => $errs) {
				foreach ($errs as $field => $v) {
					if( $v > 0){
						$errors = true;
					}
				}
			}
		}


		if($incomplete){
			$status = 70;
		}elseif(!$incomplete && $errors){
			$status = 80;
		}elseif(!$incomplete){
			$status = 90;
		}
		// print2($incomplete_data);
		// print2($status);

		return $status;
	}




}


?>