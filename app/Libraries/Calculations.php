<?php 

namespace App\Libraries;

use App\Models\Administration\EmissionFactorsModel;
use App\Models\Administration\PollutantsModel;
use App\Models\Administration\VclassModel;
use App\Models\Administration\FuelsModel;
use App\Models\Empresas\CompaniesModel;
use App\Models\Administration\FleetsModel;
use App\Models\Administration\FleetsFuelsModel;
use App\Models\Administration\FleetsFuelsVclassTravels;
use App\Models\Administration\FleetsFuelsVclassQuantity;
use App\Models\Administration\FleetFuelsVclassReduction;
use App\Models\Administration\DriveVelocitiesModel;
use App\Models\Administration\CacheModel;
use App\Models\Administration\CacheVclassModel;

use App\Models\Administration\BrandsModel;
use App\Models\Administration\BrandsFleetsModel;
use App\Models\Administration\CacheUsersModel;

use App\Libraries\Email;

class Calculations {

	public function evaluate($companies_id,$measure_year,$updateStatus = false){
		$fleetsModel = new FleetsModel();
		$fuelsModel = new FuelsModel();
		$fleetsFuelModel = new FleetsFuelsModel();
		$travelsModel = new FleetsFuelsVclassTravels();
		$quantityModel = new FleetsFuelsVclassQuantity();
		$reductionsModel = new FleetFuelsVclassReduction();
		$pollutantsModel = new PollutantsModel();

		$fleets = $fleetsModel 
		-> where('companies_id',$companies_id) 
		-> where('measure_year',$measure_year)
		-> findAll();


		foreach ($fleets as $k => $fleet) {

			$fleetsFuelsDB = $fleetsFuelModel 
			-> select('Fleets_Fuels.*,f.code as fcode')
			-> join('Fuels f','f.id = Fleets_Fuels.fuels_id','left')
			-> where('Fleets_Fuels.fleets_id',$fleet['id'])
			->findAll();

			// echo "FUEEEELS<br/>";
			// print2($fleetsFuelsDB);

			$fleets[$k]['fuelsDB'] = $fleetsFuelsDB;

			foreach ($fleetsFuelsDB as $ff) {

				if($ff['active'] != 1){
					continue;
				}

				$travelsDB = $travelsModel
				-> select('Fleets_Fuels_Vclass_Travels.*, c.code as ccode, Fuels.code as htcode')
				-> join('Vclass c','c.id = Fleets_Fuels_Vclass_Travels.vclass_id','left')
				-> join('Fuels','Fuels.id = Fleets_Fuels_Vclass_Travels.hybrid_type','left')
				-> join('Fleets_Fuels_Vclass ffv','ffv.vclass_id = c.id AND ffv.Fleets_Fuels_id = Fleets_Fuels_Vclass_Travels.fleets_fuels_id','left')
				-> where('ffv.id !=',null)
				-> where('Fleets_Fuels_Vclass_Travels.fleets_fuels_id',$ff['id'])
				-> findAll();

				
				// print2($travelsDB);
				$travels = array();
				foreach ($travelsDB as $t) {
					$travels[$t['ccode']] = $t;
				}

				$fleets[$k]['fuels'][$ff['fcode']]['travels'] = $travels;

				$quantities = $quantityModel 
				-> select('Fleet_Fuels_Vclass_Quantity.*,c.code as ccode')
				-> join('Vclass c','c.id = Fleet_Fuels_Vclass_Quantity.vclass_id','left')
				-> join('Fleets_Fuels_Vclass ffv','ffv.vclass_id = c.id AND ffv.Fleets_Fuels_id = Fleet_Fuels_Vclass_Quantity.fleets_fuels_id','left')
				-> where('ffv.id !=',null)

				-> where('Fleet_Fuels_Vclass_Quantity.fleets_fuels_id',$ff['id'])
				-> findAll();

				$reductions = $reductionsModel 
				-> select('Fleet_Fuels_Vclass_Reduction.*,c.code as ccode')
				-> join('Vclass c','c.id = Fleet_Fuels_Vclass_Reduction.vclass_id','left')
				-> where('fleets_fuels_id',$ff['id'])
				-> findAll();

				foreach ($quantities as $q) {
					$fleets[$k]['fuels'][$ff['fcode']]['quantity'][$q['ccode']][$q['year']]['quantity'] = $q['quantity'];
					$fleets[$k]['fuels'][$ff['fcode']]['quantity'][$q['ccode']][$q['year']]['euro5'] = $q['euro5'];
					$fleets[$k]['fuels'][$ff['fcode']]['quantity'][$q['ccode']][$q['year']]['euro6'] = $q['euro6'];
				}

				foreach ($reductions as $r) {
					$fleets[$k]['fuels'][$ff['fcode']]['reductions'][$r['ccode']][$r['year']]["type_$r[type]"]['quantity'] = $r['quantity'];
					// $fleets[$k]['fuels'][$ff['fcode']]['reductions'][$r['ccode']][$r['year']]['quantity'] = $r['quantity'];
				}
			}
			
		}

		// print2($fleets);

		foreach ($fleets as $fleet) {
			$this -> emissionCalculator($fleet,$measure_year,$updateStatus);
		}
	}

	public function emissionCalculator($fleet,$measure_year, $updateStatus = true){

		$errorMessage = 'No es posible generar el cálculo por falta de factores de emisión, ponte en contacto con el equipo de la SEMARNAT';

		$pollutantsModel = new PollutantsModel();
		$vclassModel = new VclassModel();
		$fuelsModel = new FuelsModel();
		$emissionFactorsModel = new EmissionFactorsModel();
		$driveVelocitiesModel = new DriveVelocitiesModel();
		$cacheModel = new CacheModel();
		$cacheVclassModel = new CacheVclassModel();
		$fleetsModel = new FleetsModel();
		$companiesModel = new CompaniesModel();

		$email = new Email();

		$dvDB = $driveVelocitiesModel 
		-> select('Drive_Velocities.*, c.code as ccode, f.code as fcode')
		-> join("Fuels f", 'f.id = Drive_Velocities.fuels_id','left')
		-> join("Vclass c", 'c.id = Drive_Velocities.vclass_id','left')
		-> findAll();

		$dv = array();
		foreach ($dvDB as $v) {
			$dv[$v['fcode']][$v['ccode']] = $v;
		}

		$pollutants = $pollutantsModel -> findAll();
		$vclass = $vclassModel -> findAll();
		$fuels = $fuelsModel -> findAll();
		$efDB = $emissionFactorsModel -> getAllEF($measure_year);

		$ef = array();
		$ef['normal'] = array();
		$ef['ralentiC'] = array();
		$ef['ralentiL'] = array();
		$ef['velocity'] = array();

		foreach ($efDB as $f) {
			switch ($f['ralenti']) {
				case '0':
					$ef['normal'][$f['pcode']][$f['fcode']][$f['ccode']][$f['year']] = $f['value'];
					break;
				case '1':
					$ef['ralentiC'][$f['pcode']][$f['fcode']][$f['ccode']][$f['year']] = $f['value'];
					break;
				case '2':
					$ef['ralentiL'][$f['pcode']][$f['fcode']][$f['ccode']][$f['year']] = $f['value'];
					break;
				case '3':
					$ef['velocity'][$f['pcode']][$f['fcode']][$f['ccode']][$f['year']][$f['range']] = $f['value'];
					break;
				
				default:
					// code...
					break;
			}
		}

		// print2($ef['velocity']);

		// $M = Kilómetros manejados por Camión Clase C por año
		// $M['clase']['año']

		$M = array();

		if(empty($ef['velocity'])){
			return $M;
		}

		foreach ($fuels as $f) {
			$M[$f['code']] = array();
			foreach ($vclass as $c) {
				$M[$f['code']][$c['code']]['km_total'] = 0;
				$M[$f['code']][$c['code']]['v_total'] = 0;
				$M[$f['code']][$c['code']]['lts_total'] = 0;
				$M[$f['code']][$c['code']]['v_total_euro5'] = 0;
				$M[$f['code']][$c['code']]['v_total_euro6'] = 0;
				$M[$f['code']][$c['code']]['v_total_reductions'] = array();
				$M[$f['code']][$c['code']]['truck_years'] = array();
				$M[$f['code']][$c['code']]['data_years'] = array();
				$M[$f['code']][$c['code']]['velocities'] = array();
				$M[$f['code']][$c['code']]['km_years'] = array();
				$M[$f['code']][$c['code']]['general_emissions'] = array();
				$M[$f['code']][$c['code']]['percent_years'] = array();
				$M[$f['code']][$c['code']]['sum_years'] = 0;
			}
		}

		$fleet['fuels'] = isset($fleet['fuels']) ? $fleet['fuels'] : array();
		//emisionesTot
		
		foreach ($fleet['fuels'] as $f => $t) {
			foreach ($t['travels'] as $c => $ti) {// Travel information
				if($f == 'diesel' || $f == 'gasolina'){
					// print2($dv);
					// print2($f);
					// echo "AAA<br/>";
					// print2($c);
					// echo "AAA<br/>";
					$dvc = $dv[$f][$c];
				}else{
					// print2($dv);
					$dvc = $dv['diesel'][$c];
				}
				// echo "DVC<br/>";
				// print2($dvc);
				// echo "TI<br/>";
				// print2($ti);
				$M[$f][$c]['velocities']['highway'] = $ti['highway'];
				$M[$f][$c]['velocities']['range_1'] = $ti['less_40']*($dvc['range_1']+$dvc['range_2']+$dvc['range_3'])/100;
				$M[$f][$c]['velocities']['range_2'] = $ti['40_80']*($dvc['range_1']+$dvc['range_2']+$dvc['range_3'])/100;
				$M[$f][$c]['velocities']['range_3'] = $ti['over_80']*($dvc['range_1']+$dvc['range_2']+$dvc['range_3'])/100;
				$M[$f][$c]['velocities']['deceleration'] = 100
					-$M[$f][$c]['velocities']['range_1']
					-$M[$f][$c]['velocities']['range_2']
					-$M[$f][$c]['velocities']['range_3']
					-$M[$f][$c]['velocities']['highway'];

				$M[$f][$c]['km_total'] += $ti['km_tot'];
				// echo "RRR $f $c <br/>";
				$M[$f][$c]['ti'] = $ti;
				$M[$f][$c]['lts_total'] += $ti['lts_tot'];

				// echo "Velocities<br/>";
				// print2($M[$f][$c]['velocities']);
			}

			if(!isset($t['quantity'])){
				continue;
			}
			// print2($t['quantity']);
			foreach ($t['quantity'] as $c => $qs) {
				foreach ($qs as $y => $q) {
					if($q['quantity'] == 0){
						continue;
					}
					$M[$f][$c]['v_total'] += $q['quantity'];
					$M[$f][$c]['v_total_euro5'] += $q['euro5'];
					$M[$f][$c]['v_total_euro6'] += $q['euro6'];
					$M[$f][$c]['truck_years'][$y] = $q['quantity'];
					$M[$f][$c]['data_years'][$y]['truck_years'] = $q['quantity'];
					$M[$f][$c]['sum_years'] += $y*$q['quantity'];
					// echo "$y * $q[quantity] <br/>";
				}
			}
			if($f == 'diesel'){
				$t['reductions'] = isset($t['reductions']) ? $t['reductions'] : array();
				foreach ($t['reductions'] as $c => $qs) {
					foreach ($qs as $y => $q) {
						foreach ($q as $tt => $qv) {
							if(!isset($M[$f][$c]['v_total_reductions'][$tt])){
								$M[$f][$c]['v_total_reductions'][$tt] = 0;
							}
							$M[$f][$c]['v_total_reductions'][$tt] += $qv['quantity'];
						}
					}
				}
			}

		}
		// echo "<hr/>";
		foreach ($M as $f => $cs) {
			foreach ($cs as $c => $data) {
				foreach ($data['truck_years'] as $y => $v) {
					$M[$f][$c]['percent_years'][$y] = $M[$f][$c]['v_total'] != 0 ? $v/$M[$f][$c]['v_total'] : 0;
					$M[$f][$c]['km_years'][$y] = $M[$f][$c]['km_total']*$M[$f][$c]['percent_years'][$y];

					$M[$f][$c]['data_years'][$y]['percent_years'] = $M[$f][$c]['percent_years'][$y];
					$M[$f][$c]['data_years'][$y]['km_years'] = $M[$f][$c]['km_years'][$y];
					$M[$f][$c]['data_years'][$y]['km_velocities']['highway'] = 
						isset($M[$f][$c]['velocities']['highway']) ? 
							$M[$f][$c]['km_years'][$y]*($M[$f][$c]['velocities']['highway'] /100) : 0;
					$M[$f][$c]['data_years'][$y]['km_velocities']['range_1'] = 
						isset($M[$f][$c]['velocities']['range_1']) ? 
							$M[$f][$c]['km_years'][$y]*($M[$f][$c]['velocities']['range_1'] /100) : 0;
					$M[$f][$c]['data_years'][$y]['km_velocities']['range_2'] = 
						isset($M[$f][$c]['velocities']['range_2']) ? 
							$M[$f][$c]['km_years'][$y]*($M[$f][$c]['velocities']['range_2'] /100) : 0;
					$M[$f][$c]['data_years'][$y]['km_velocities']['range_3'] = 
						isset($M[$f][$c]['velocities']['range_3']) ? 
							$M[$f][$c]['km_years'][$y]*($M[$f][$c]['velocities']['range_3'] /100) : 0;
					$M[$f][$c]['data_years'][$y]['km_velocities']['deceleration'] = 
						isset($M[$f][$c]['velocities']['deceleration']) ? 
							$M[$f][$c]['km_years'][$y]*($M[$f][$c]['velocities']['deceleration'] /100) : 0;
				}
			}
		}

		///// Desaceleraciones

		// print2($ef['velocity']);


		$em = array();
		foreach ($pollutants as $p) {
			$em[$p['code']] = 0;
			

			switch ($p['code']) {
				case 'PM25':
				case 'PM10':
					foreach ($M as $f => $cs) {
						foreach ($cs as $c => $v) {
							$e['reductions'] = 0;
							$dat = $M[$f][$c];

							if($dat['km_total'] == 0){
								continue;
							}

							$reductions = $dat['v_total_reductions'];
							// print2($c);
							// print2($reductions);
							// print2($reductions);
							$e['reductions'] += isset($reductions['type_1']) ? 0.21*$reductions['type_1']/$dat['v_total'] :0;
							$e['reductions'] += isset($reductions['type_2']) ? 0.05*$reductions['type_2']/$dat['v_total'] :0;
							$e['reductions'] += isset($reductions['type_3']) ? 0.9*$reductions['type_3']/$dat['v_total'] :0;
							
							$e['reductionTot'] = 1-$e['reductions'];
							// print2($e['reductionTot']);
							$M[$f][$c]['general_reductions'][$p['code']] = $e['reductionTot'];
						}
					}
				case 'NOX':
				case 'CN':
					$e['ralenti'] = 0;
					foreach ($M as $f => $cs) {
						foreach ($cs as $c => $v) {
							$e['velocity'] = 0;
							$dat = $M[$f][$c];

							if($dat['km_total'] == 0){
								continue;
							}

							if($f == 'gasolina'){
								if (!isset($ef['velocity'][$p['code']][$f])) {
									exit($errorMessage);
								}
								$efc = $ef['velocity'][$p['code']][$f][$c];
							}if($f == 'hibrido'){
								if (!isset($ef['velocity'][$p['code']][$M[$f][$c]['ti']['htcode']])) {
									exit($errorMessage);
								}
								$efc = $ef['velocity'][$p['code']][$M[$f][$c]['ti']['htcode']][$c];
							}else{
								if( !isset($ef['velocity'][$p['code']]['diesel'][$c]) ){
									exit($errorMessage);
								}
								$efc = $ef['velocity'][$p['code']]['diesel'][$c];
							}




							foreach ($M[$f][$c]['data_years'] as $y => $dy) {
								$M[$f][$c]['data_years'][$y]['emissions'][$p['code']] = 0;
								
								$datY = $M[$f][$c]['data_years'][$y];
								// echo "EFC $p[code] $f $c $y <br/>";
								// print2($efc[$y]);
								// echo "velocities <br/>";
								// print2($M[$f][$c]['velocities']);
								// echo "daty <br/>";
								// print2($datY);
								// echo "dat <br/>";
								// print2($dat);

								// echo "<br/>EVEL $p[code] - $f - $c - $fleet[id] -$y - $datY[km_years]<br/>";
								// print2($efc[$y]);
								// print2($M[$f][$c]['velocities']);

								if (isset($efc[$y])) {
									// code...
									$e['velocity'] = ($datY['km_years'] * 
										(
											($M[$f][$c]['velocities']['highway'] * $efc[$y][0]/100) + 
											($M[$f][$c]['velocities']['range_1'] * $efc[$y][1]/100) + 
											($M[$f][$c]['velocities']['range_2'] * $efc[$y][2]/100) + 
											($M[$f][$c]['velocities']['range_3'] * $efc[$y][3]/100) + 
											($M[$f][$c]['velocities']['deceleration'] * $efc[$y][4]/100)
										)
									);
								}

								// echo "evelocity = $e[velocity] ";

								if($f == 'diesel'){
									if( !isset( $ef['velocity'][$p['code']]['biodiesel'][$c] ) ){
										exit($errorMessage);
									}

									$efcb = $ef['velocity'][$p['code']]['biodiesel'][$c];

									if (isset($efcb[$y])) {
										// code...
										$e['velocity'] += ($datY['km_years'] * 
											(
												($M[$f][$c]['velocities']['highway'] * $efcb[$y][0]/100) + 
												($M[$f][$c]['velocities']['range_1'] * $efcb[$y][1]/100) + 
												($M[$f][$c]['velocities']['range_2'] * $efcb[$y][2]/100) + 
												($M[$f][$c]['velocities']['range_3'] * $efcb[$y][3]/100) + 
												($M[$f][$c]['velocities']['deceleration'] * $efcb[$y][4]/100)
											)
										);
									}

								}


								$M[$f][$c]['data_years'][$y]['velocities_emissions'][$p['code']] = $e['velocity'];
								if(!isset($M[$f][$c]['general_emissions'][$p['code']])){
									$M[$f][$c]['general_emissions'][$p['code']] = 0;
								}

								$M[$f][$c]['general_emissions'][$p['code']] += $e['velocity'];
								// print2([$f,$c,$p['code']]);
								// print2($e['velocity']);
								if($dat['km_total'] == 0){
									continue;
								}

								// print2([$f,$c,$ef['ralentiC'][$p['code']]]);

								// print2($efrc = $ef['ralentiC'][$p['code']][$f]);
								// echo "--- - - -- -- \n";
								// print2($c);
								// print2($f);
								// print2($p['code']);
								// print2($fleet['id']);
								if( !isset( $ef['ralentiC'][$p['code']][$f][$c] ) ){
									exit($errorMessage);
								}

								if( !isset( $ef['ralentiL'][$p['code']][$f][$c] ) ){
									exit($errorMessage);
								}

								$efrc = $ef['ralentiC'][$p['code']][$f][$c];
								$efrl = $ef['ralentiL'][$p['code']][$f][$c];

								// print2([
								// 	$efrc, 
								// 	$efrl, 
								// ]);
								// print2($efrl);

								if(isset($efrc[$y])){
									$e['ralenti'] += (
										$efrc[$y] * 
										($dat['ti']['ralenti_hours_short'] * $dat['ti']['ralenti_days']) * 
										$datY['truck_years']
									);
								}
								if(isset($efrl[$y])){

								 $e['ralenti'] += (
									$efrl[$y] * 
									($dat['ti']['ralenti_hours_large'] * $dat['ti']['ralenti_days']) * 
									$datY['truck_years']
								);
								}
								
								// echo "<br/>$y - - - ".$efrl[$y] .
								// "* (".$dat['ti']['ralenti_hours_large']." * ".$dat['ti']['ralenti_days'].") * ".$datY['truck_years']."";

							}
							



							// echo "<br/>".$efrl[$y] ."*".
							// 	$dat['ti']['ralenti_hours_large'] ."*". $dat['ti']['ralenti_days'] ." *" .
							// 	$datY['truck_years'];

							// echo "<br/>".$efrc[$y] ."*".
							// 	$dat['ti']['ralenti_hours_short'] ."* ".$dat['ti']['ralenti_days']." * ".
							// 	$datY['truck_years'];


							// echo "<br/>EFCR, EFLR";
							// print2([$efrc[$y],$efrl[$y]]);
							// print2("RALENTI");
							// print2($e['ralenti']);

							if(!isset($M[$f][$c]['general_emissions'][$p['code']])){
								$M[$f][$c]['general_emissions'][$p['code']] = 0;
							}

							$M[$f][$c]['general_emissions'][$p['code']] += $e['ralenti'];
							if($p['code'] == 'PM25' || $p['code'] == 'PM10'){
								$M[$f][$c]['general_emissions'][$p['code']] = $M[$f][$c]['general_emissions'][$p['code']] * $M[$f][$c]['general_reductions'][$p['code']];
							}

							// print2($M[$f][$c]['general_emissions'][$p['code']]);

						}
					}
					break;
				case 'CO2':
					foreach ($M as $f => $cs) {

						if( !isset(  $ef['normal']['CO2'] ) || !isset(  $ef['normal']['CO2'][$f] ) ){
							exit($errorMessage);
						}
						if(!isset(  $ef['normal']['CO2']['biodiesel'] ) ){
							exit($errorMessage);
						}

						$fesd = $ef['normal']['CO2'][$f][''][''];
						$fesb = $ef['normal']['CO2']['biodiesel'][''][''];
						foreach ($cs as $c => $v) {
							$dat = $M[$f][$c];
							if($dat['km_total'] == 0){
								continue;
							}

							$ti = $M[$f][$c]['ti'];

							$M[$f][$c]['general_emissions'][$p['code']] = $ti['lts_tot'] * $fesd + $ti['lts_bio'] * $fesb;

						}
					}
					break;
				
				default:
					// code...
					break;
			}
		}

		

		$inds = $this->generateIndicators($fleet,$M);
		$indsClass = $this->generateIndicatorsVclass($fleet,$M);

		$M['indicators'] = $inds;


		$json = atj($M);
		$newData = [
			'json' => $json,
			'fleets_id' => $fleet['id'],
			'CO2GKM' => empty($inds) ? 0 : $inds['CO2GKM'],
			'NOXGKM' => empty($inds) ? 0 : $inds['NOXGKM'],
			'PM25GKM' => empty($inds) ? 0 : $inds['PM25GKM'],
			'PM10GKM' => empty($inds) ? 0 : $inds['PM10GKM'],
			'CNGKM' => empty($inds) ? 0 : $inds['CNGKM'],
			'CO2' => empty($inds) ? 0 : $inds['CO2'],
			'NOX' => empty($inds) ? 0 : $inds['NOX'],
			'PM25' => empty($inds) ? 0 : $inds['PM25'],
			'PM10' => empty($inds) ? 0 : $inds['PM10'],
			'CN' => empty($inds) ? 0 : $inds['CN'],
			'CO2GTonKM' => empty($inds) ? 0 : $inds['CO2GTonKM'],
			'NOXGTonKM' => empty($inds) ? 0 : $inds['NOXGTonKM'],
			'PM25GTonKM' => empty($inds) ? 0 : $inds['PM25GTonKM'],
			'PM10GTonKM' => empty($inds) ? 0 : $inds['PM10GTonKM'],
			'CNGTonKM' => empty($inds) ? 0 : $inds['CNGTonKM'],
			'avg_year' => empty($inds) ? 0 : $inds['avg_year'],
			'km_tot' => empty($inds) ? 0 : $inds['km_tot'],
			'lts_tot' => empty($inds) ? 0 : $inds['lts_tot'],
		];

		// print2($newData);

		if($fleet['status']<100){
			$cacheVclassModel -> where('fleets_id',$fleet['id']) -> delete();
			$cacheModel -> where('fleets_id',$fleet['id']) -> delete();
			foreach ($indsClass as $f => $iic) {
				// print2($iic);
				foreach ($iic as $c => $ic) {
					$newDataClass = [
						'json' => atj($ic),
						'fleets_id' => $fleet['id'],
						'CO2GKM' => empty($ic) ? 0 : $ic['CO2GKM'],
						'NOXGKM' => empty($ic) ? 0 : $ic['NOXGKM'],
						'PM25GKM' => empty($ic) ? 0 : $ic['PM25GKM'],
						'PM10GKM' => empty($ic) ? 0 : $ic['PM10GKM'],
						'CNGKM' => empty($ic) ? 0 : $ic['CNGKM'],
						'CO2' => empty($ic) ? 0 : $ic['CO2'],
						'NOX' => empty($ic) ? 0 : $ic['NOX'],
						'PM25' => empty($ic) ? 0 : $ic['PM25'],
						'PM10' => empty($ic) ? 0 : $ic['PM10'],
						'CN' => empty($ic) ? 0 : $ic['CN'],
						'CO2GTonKM' => empty($ic) ? 0 : $ic['CO2GTonKM'],
						'NOXGTonKM' => empty($ic) ? 0 : $ic['NOXGTonKM'],
						'PM25GTonKM' => empty($ic) ? 0 : $ic['PM25GTonKM'],
						'PM10GTonKM' => empty($ic) ? 0 : $ic['PM10GTonKM'],
						'CNGTonKM' => empty($ic) ? 0 : $ic['CNGTonKM'],
						'vclass_code' => $c,
						'fuels_code' => $f,
						'v_total' => $ic['v_total'],
						'km_tot' => $ic['km_tot'],
						'km_empty' => $ic['km_empty'],
						'payload_avg' => $ic['payload_avg'],
						'avg_year' => $ic['avg_year'],
						'lts_tot' => $ic['lts_tot'],
					];
					// print2($newDataClass);
					$cacheVclassModel -> insert($newDataClass);
				}
			}

			$cacheModel -> insert($newData);
			if($updateStatus){
				$fleetsModel -> update($fleet['id'],['status' => 100]);
			}
		}


		if($updateStatus){
			$companiesModel -> update($fleet['companies_id'],['rev_year' => $measure_year]);
		}

		
		// print2($M);
		return $M;
	}

	public function generateIndicators($fleet,$M){
		// print2($fleet);
		$companiesModel = new CompaniesModel();
		$company = $companiesModel -> where('id',$fleet['companies_id']) -> first();

		$metrics = array();

		$metrics['nombreTransportista'] = $company['name'];
		
		$vTot = 0;
		$cargaProm = 0;
		$volProm = 0;
		$kmTot = 0;
		$sum_years = 0;
		$lts_tot = 0;
		foreach ($fleet['fuels'] as $f => $trs) {
			foreach ($trs['travels'] as $c => $t) {
				// print2($t);
				$vTot += $M[$f][$c]['v_total'];
				// $cargaProm += $M[$f][$c]['v_total']*$t['payload_avg'];
				$volProm += $M[$f][$c]['v_total']*$t['avg_volume'];
				$kmTot += $t['km_tot'];
				$lts_tot += $t['lts_tot'];
				$sum_years += $M[$f][$c]['sum_years'];
				// print2([$fleet['id'],$fleet['name'],$f,$c,$M[$f][$c]['v_total'],$M[$f][$c]['sum_years']]);

				
			}
		}

		foreach ($fleet['fuels'] as $f => $trs) {
			foreach ($trs['travels'] as $c => $t) {
				$cargaProm += $kmTot != 0 ? ($t['km_tot']/$kmTot)*$t['payload_avg'] : 0 ;
			}
		}


		$avg_year = $vTot != 0 ? $sum_years/$vTot : 0;
		// print2($vTot);
		// print2($sum_years);
		// print2($avg_year);


		$metrics['cargaUtilPromedio'] = $vTot != 0 ? $cargaProm/$vTot : 0 ;
		$metrics['volumenPromedio'] = $vTot != 0 ? $volProm/$vTot : 0 ;

		$emisionesTot = array();

		foreach ($M as $f => $cs) {
			foreach ($cs as $c => $v) {
				$emissions = $v['general_emissions'];
				// print2($f);
				// print2($c);
				// print2($emissions);
				foreach ($emissions as $ff => $e) {
					if(!isset($emisionesTot[$ff])){
						$emisionesTot[$ff] = 0;
					}
					$emisionesTot[$ff] += $e;
				}
			}
		}

		$millasTot = $kmTot*0.621371;
		if(empty($emisionesTot)){
			$metrics['CO2'] = 0;
			$metrics['CO2GKM'] = 0;
			$metrics['CO2GMile'] = 0;
			$metrics['NOX'] = 0;
			$metrics['NOXGKM'] = 0;
			$metrics['NOXGMile'] = 0;
			$metrics['PM25'] = 0;
			$metrics['PM25GKM'] = 0;
			$metrics['PM25GMile'] = 0;
			$metrics['PM10'] = 0;
			$metrics['PM10GKM'] = 0;
			$metrics['PM10GMile'] = 0;
			$metrics['CN'] = 0;
			$metrics['CNGKM'] = 0;
			$metrics['CNGMile'] = 0;
			$metrics['CO2GTonKM'] = 0;
			$metrics['CO2GTonMile'] = 0;
			$metrics['NOXGTonKM'] = 0;
			$metrics['NOXGTonMile'] = 0;
			$metrics['PM25GTonKM'] = 0;
			$metrics['PM25GTonMile'] = 0;
			$metrics['PM10GTonKM'] = 0;
			$metrics['PM10GTonMile'] = 0;
			$metrics['CNGTonKM'] = 0;
			$metrics['CNGTonMile'] = 0;
			$metrics['avg_year'] = 0;
			$metrics['km_tot'] = 0;
			$metrics['lts_tot'] = 0;

			return $metrics;
		}

		$metrics['CO2'] = $emisionesTot['CO2'];
		$metrics['CO2GKM'] = $kmTot != 0 ? $emisionesTot['CO2']/$kmTot : 0;
		$metrics['CO2GMile'] = $millasTot != 0 ? $emisionesTot['CO2']/$millasTot : 0;
		
		$metrics['NOX'] = $emisionesTot['NOX'];
		$metrics['NOXGKM'] = $kmTot != 0 ? $emisionesTot['NOX']/$kmTot : 0;
		$metrics['NOXGMile'] = $millasTot != 0 ? $emisionesTot['NOX']/$millasTot : 0;
		
		$metrics['PM25'] = $emisionesTot['PM25'];
		$metrics['PM25GKM'] = $kmTot != 0 ? $emisionesTot['PM25']/$kmTot : 0;
		$metrics['PM25GMile'] = $millasTot != 0 ? $emisionesTot['PM25']/$millasTot : 0;
		
		$metrics['PM10'] = $emisionesTot['PM10'];
		$metrics['PM10GKM'] = $kmTot != 0 ? $emisionesTot['PM10']/$kmTot : 0;
		$metrics['PM10GMile'] = $millasTot != 0 ? $emisionesTot['PM10']/$millasTot : 0;
		
		$metrics['CN'] = $emisionesTot['CN'];
		$metrics['CNGKM'] = $kmTot != 0 ? $emisionesTot['CN']/$kmTot : 0;
		$metrics['CNGMile'] = $millasTot != 0 ? $emisionesTot['CN']/$millasTot : 0;

		$metrics['CO2GTonKM'] = $kmTot != 0 && $cargaProm != 0 ? $emisionesTot['CO2']/$kmTot/$cargaProm : 0;
		// print2($emisionesTot);
		// print2($kmTot);
		// print2($cargaProm);

		$metrics['CO2GTonMile'] = $millasTot != 0 && $cargaProm != 0 ? $emisionesTot['CO2']/$millasTot/$cargaProm : 0;
		
		$metrics['NOXGTonKM'] = $kmTot != 0 && $cargaProm != 0 ? $emisionesTot['NOX']/$kmTot/$cargaProm : 0;
		$metrics['NOXGTonMile'] = $millasTot != 0 && $cargaProm != 0 ? $emisionesTot['NOX']/$millasTot/$cargaProm : 0;
		
		$metrics['PM25GTonKM'] = $kmTot != 0 && $cargaProm != 0 ? $emisionesTot['PM25']/$kmTot/$cargaProm : 0;
		$metrics['PM25GTonMile'] = $millasTot != 0 && $cargaProm != 0 ? $emisionesTot['PM25']/$millasTot/$cargaProm : 0;
		
		$metrics['PM10GTonKM'] = $kmTot != 0 && $cargaProm != 0 ? $emisionesTot['PM10']/$kmTot/$cargaProm : 0;
		$metrics['PM10GTonMile'] = $millasTot != 0 && $cargaProm != 0 ? $emisionesTot['PM10']/$millasTot/$cargaProm : 0;
		
		$metrics['CNGTonKM'] = $kmTot != 0 && $cargaProm != 0 ? $emisionesTot['CN']/$kmTot/$cargaProm : 0;
		$metrics['CNGTonMile'] = $millasTot != 0 && $cargaProm != 0 ? $emisionesTot['CN']/$millasTot/$cargaProm : 0;

		$metrics['avg_year'] = $avg_year;
		$metrics['km_tot'] = $kmTot;
		$metrics['lts_tot'] = $lts_tot;
		// print2($metrics);
		return $metrics;
	}

	public function generateIndicatorsVclass($fleet,$M){
		// print2($M);
		$companiesModel = new CompaniesModel();
		$company = $companiesModel -> where('id',$fleet['companies_id']) -> first();

		$metrics = array();

		// $metrics['nombreTransportista'] = $company['name'];
		$emisionesTot = array();
		
		$vTot = array();
		$cargaProm = array();
		$volProm = array();
		$kmTot = array();
		foreach ($fleet['fuels'] as $f => $trs) {
			foreach ($trs['travels'] as $c => $t) {
				// print2($t);
				if(!isset($kmTot[$c])){
					$kmTot[$f][$c] = 0;
					$vTot[$f][$c] = 0;
					$cargaProm[$f][$c] = 0;
					$volProm[$f][$c] = 0;
					
				}
				$vTot[$f][$c] += $M[$f][$c]['v_total'];
				$cargaProm[$f][$c] += $M[$f][$c]['v_total']*$t['payload_avg'];
				$volProm[$f][$c] += $M[$f][$c]['v_total']*$t['avg_volume'];
				$kmTot[$f][$c] += $M[$f][$c]['ti']['km_tot'];
				// print2();
				$emissions[$f][$c] = $M[$f][$c]['general_emissions'];
				foreach ($emissions[$f][$c] as $ff => $e) {
					if(!isset($emisionesTot[$f][$c][$ff])){
						$emisionesTot[$f][$c][$ff] = 0;
					}
					// echo "AAAA---<br/>";
					// print2([$c,$ff,$e]);
					$emisionesTot[$f][$c][$ff] += $e;
				}
			}
		}

		// print2($emisionesTot);
		foreach ($emisionesTot as $f => $et) {
			// code...
			foreach ($et as $c => $e) {
				// print2([$c,$e]);
				$millasTot = $kmTot[$f][$c]*0.621371;

				$metrics[$f][$c]['CO2GKM'] = 
					$kmTot[$f][$c] != 0 ? $et[$c]['CO2']/$kmTot[$f][$c] : 0;

				$metrics[$f][$c]['CO2'] = $et[$c]['CO2'];

				$metrics[$f][$c]['CO2GMile'] = 
					$millasTot != 0 ? $et[$c]['CO2']/$millasTot : 0;
				
				$metrics[$f][$c]['NOXGKM'] = 
					$kmTot[$f][$c] != 0 ? $et[$c]['NOX']/$kmTot[$f][$c] : 0;

				$metrics[$f][$c]['NOX'] = $et[$c]['NOX'];

				$metrics[$f][$c]['NOXGMile'] = 
					$millasTot != 0 ? $et[$c]['NOX']/$millasTot : 0;

				$metrics[$f][$c]['PM25GKM'] = 
					$kmTot[$f][$c] != 0 ? $et[$c]['PM25']/$kmTot[$f][$c] : 0;

				$metrics[$f][$c]['PM25'] = $et[$c]['PM25'];

				$metrics[$f][$c]['PM25GMile'] = 
					$millasTot != 0 ? $et[$c]['PM25']/$millasTot : 0;
				
				$metrics[$f][$c]['PM10GKM'] = 
					$kmTot[$f][$c] != 0 ? $et[$c]['PM10']/$kmTot[$f][$c] : 0;

				$metrics[$f][$c]['PM10'] = $et[$c]['PM10'];

				$metrics[$f][$c]['PM10GMile'] = 
					$millasTot != 0 ? $et[$c]['PM10']/$millasTot : 0;
				
				$metrics[$f][$c]['CNGKM'] = 
					$kmTot[$f][$c] != 0 ? $et[$c]['CN']/$kmTot[$f][$c] : 0;

				$metrics[$f][$c]['CN'] = $et[$c]['CN'];

				$metrics[$f][$c]['CNGMile'] = 
					$millasTot != 0 ? $et[$c]['CN']/$millasTot : 0;

				$metrics[$f][$c]['CO2GTonKM'] = 
					$kmTot[$f][$c] != 0 && $cargaProm[$f][$c] != 0 ? $et[$c]['CO2']/$kmTot[$f][$c]/$cargaProm[$f][$c] : 0;

				$metrics[$f][$c]['CO2GTonMile'] = 
					$millasTot != 0 && $cargaProm[$f][$c] != 0 ? $et[$c]['CO2']/$millasTot/$cargaProm[$f][$c] : 0;
				
				$metrics[$f][$c]['NOXGTonKM'] = 
					$kmTot[$f][$c] != 0 && $cargaProm[$f][$c] != 0 ? $et[$c]['NOX']/$kmTot[$f][$c]/$cargaProm[$f][$c] : 0;

				$metrics[$f][$c]['NOXGTonMile'] = 
					$millasTot != 0 && $cargaProm[$f][$c] != 0 ? $et[$c]['NOX']/$millasTot/$cargaProm[$f][$c] : 0;
				
				$metrics[$f][$c]['PM25GTonKM'] = 
					$kmTot[$f][$c] != 0 && $cargaProm[$f][$c] != 0 ? $et[$c]['PM25']/$kmTot[$f][$c]/$cargaProm[$f][$c] : 0;

				$metrics[$f][$c]['PM25GTonMile'] = 
					$millasTot != 0 && $cargaProm[$f][$c] != 0 ? $et[$c]['PM25']/$millasTot/$cargaProm[$f][$c] : 0;
				
				$metrics[$f][$c]['PM10GTonKM'] = 
					$kmTot[$f][$c] != 0 && $cargaProm[$f][$c] != 0 ? $et[$c]['PM10']/$kmTot[$f][$c]/$cargaProm[$f][$c] : 0;

				$metrics[$f][$c]['PM10GTonMile'] = 
					$millasTot != 0 && $cargaProm[$f][$c] != 0 ? $et[$c]['PM10']/$millasTot/$cargaProm[$f][$c] : 0;
				
				$metrics[$f][$c]['CNGTonKM'] = 
					$kmTot[$f][$c] != 0 && $cargaProm[$f][$c] != 0 ? $et[$c]['CN']/$kmTot[$f][$c]/$cargaProm[$f][$c] : 0;

				$metrics[$f][$c]['CNGTonMile'] = 
					$millasTot != 0 && $cargaProm[$f][$c] != 0 ? $et[$c]['CN']/$millasTot/$cargaProm[$f][$c] : 0;

				$metrics[$f][$c]['avg_year'] = $M[$f][$c]['v_total'] != 0 ? $M[$f][$c]['sum_years']/$M[$f][$c]['v_total'] : 0;

				$metrics[$f][$c]['v_total'] = $M[$f][$c]['v_total'];
				$metrics[$f][$c]['km_tot'] = $M[$f][$c]['ti']['km_tot'];
				$metrics[$f][$c]['km_empty'] = $M[$f][$c]['ti']['km_empty'];
				$metrics[$f][$c]['payload_avg'] = $M[$f][$c]['ti']['payload_avg'];
				$metrics[$f][$c]['lts_tot'] = $M[$f][$c]['ti']['lts_tot'];

				// print2($M[$f][$c]);

			}
		}

		// print2($metrics);
		return $metrics;
	}

	public function usersEvaluate($companies_id,$measure_year,$updateStatus = false){

		$brandsModel = new BrandsModel(); 
		$companiesModel = new CompaniesModel(); 

		$brands = $brandsModel 
		-> where('companies_id',$companies_id) 
		-> where('measure_year',$measure_year) 
		-> findAll();

		$brandEmissions = array();
		foreach ($brands as $b) {
			$brandEmissions[$b['id']] = $this -> evaluateBrand($b,$measure_year,$updateStatus);
		}

		$newData = ['rev_year' => $measure_year];

		if($updateStatus){
			$companiesModel -> update($companies_id,$newData);
		}


		return '{"ok":"1"}';
	}

	public function evaluateBrand($brand,$measure_year,$updateStatus = true){
		$brandsFleetsModel = new BrandsFleetsModel();
		$brandsModel = new BrandsModel();
		$cacheUsersModel = new CacheUsersModel();

		$brandsFleets = $brandsFleetsModel 
		-> select('Brands_Fleets.*,f.name as fname, c.name as coname')
		-> join('Fleets f','f.id = Brands_Fleets.fleets_id','left')
		-> join('Companies c','c.id = f.companies_id','left')
		-> where('brands_id',$brand['id']) 
		-> findAll();

		$brandFleetEmissions = array();

		$co2 = 0;
		$pm10 = 0;
		$pm25 = 0;
		$nox = 0;
		$cn = 0;


		foreach ($brandsFleets as $bf) {
			$brandFleetEmissions[$bf['id']]['data'] = $bf; 
			$emissions = $this -> evaluateBrandFleet($bf,$measure_year);
			// $brandFleetEmissions[$bf['id']]['emissions'] = $emissions;
			// $co2 += $emissions['CO2'];
			// $nox += $emissions['NOX'];
			// $pm25 += $emissions['PM25'];
			// $pm10 += $emissions['PM10'];
			// $cn += $emissions['CN'];

			$cacheUsersModel -> where('brand_fleets_id',$bf['id']) -> delete();
			// print2($emissions);
			$newData = [
				'brands_id' => $brand['id'],
				'brand_fleets_id' => $bf['id'],
				'CO2' => $emissions['CO2'],
				'NOX' => $emissions['NOX'],
				'PM25' => $emissions['PM25'],
				'PM10' => $emissions['PM10'],
				'CN' => $emissions['CN'],

				'GKMCO2' => $emissions['GKMCO2'],
				'GKMNOX' => $emissions['GKMNOX'],
				'GKMPM25' => $emissions['GKMPM25'],
				'GKMPM10' => $emissions['GKMPM10'],
				'GKMCN' => $emissions['GKMCN'],

				'GTONKMCO2' => $emissions['GTONKMCO2'],
				'GTONKMNOX' => $emissions['GTONKMNOX'],
				'GTONKMPM25' => $emissions['GTONKMPM25'],
				'GTONKMPM10' => $emissions['GTONKMPM10'],
				'GTONKMCN' => $emissions['GTONKMCN'],


				'json' => atj($brandFleetEmissions)
			];

			// print2($newData);
			if ($brand['status'] < 100) {
				$cacheUsersModel -> where('brands_id',$brand['id']) -> delete();
				$cacheUsersModel -> insert($newData);
			}



		}

		// $newData = [
		// 	'brands_id' => $brand['id'],
		// 	'CO2' => $co2,
		// 	'NOX' => $nox,
		// 	'PM25' => $pm10,
		// 	'PM10' => $pm25,
		// 	'CN' => $cn,
		// 	'json' => atj($brandFleetEmissions)
		// ];

		// $cacheUsersModel -> insert($newData);

		$newDataBrand = ['status' => 100];
		if($updateStatus){
			$brandsModel -> update($brand['id'],$newDataBrand);
		}

		return $brandFleetEmissions;
	}

	public function evaluateBrandFleet($brandFleet,$measure_year){
		$cacheModel = new CacheModel();
		$fleetsModel = new FleetsModel();

		$cache = $cacheModel -> where('fleets_id',$brandFleet['fleets_id']) -> first();
		$fleet = $fleetsModel 
		-> select('Fleets.*, c.code as ccode, co.name as coname')
		-> join('Categories c','c.id = Fleets.categories_id','left')
		-> join('Companies co','co.id = Fleets.companies_id','left')
		-> where('Fleets.id',$brandFleet['fleets_id']) 
		-> first();

		$A=0;
		$B=0;
		$C=0;

		switch ($brandFleet['measure_type']) {
			case '1':
				$A = $brandFleet['ton_km'];
				$B = $brandFleet['tot_km'];
				$C = $B != 0 ? $A/$B : 0;

				// $emisions = $this -> case1($brandFleet,$fleet['ccode'],$cache);
				break;
			case '2':
				$A = $brandFleet['ton_km'];
				$C = $brandFleet['avg_payload'];
				$B = $C != 0 ? $A/$C : 0; 

				// $emisions['CO2'] = $brandFleet['ton_km'] * $cache['CO2GTonKM'];
				// $emisions['NOX'] = $brandFleet['ton_km'] * $cache['NOXGTonKM'];
				// $emisions['PM25'] = $brandFleet['ton_km'] * $cache['PM25GTonKM'];
				// $emisions['PM10'] = $brandFleet['ton_km'] * $cache['PM10GTonKM'];
				// $emisions['CN'] = $brandFleet['ton_km'] * $cache['CNGTonKM'];
				break;
			case '3':
				$B = $brandFleet['tot_km'];
				$C = $brandFleet['avg_payload'];
				$A = $C * $B;

				// $emisions = $this -> case3($brandFleet,$fleet['ccode'],$cache);
				break;
			case '4':
				// $A=$brandFleet[''];
				// $B=$brandFleet[''];
				// $C=$brandFleet[''];

				// $emisions['CO2'] = $brandFleet['tot_km'] * $cache['CO2GKM'];
				// $emisions['NOX'] = $brandFleet['tot_km'] * $cache['NOXGKM'];
				// $emisions['PM25'] = $brandFleet['tot_km'] * $cache['PM25GKM'];
				// $emisions['PM10'] = $brandFleet['tot_km'] * $cache['PM10GKM'];
				// $emisions['CN'] = $brandFleet['tot_km'] * $cache['CNGKM'];
				break;
			
			default:
				// if($brandFleet['ton_km'] != 0){
				// 	$emisions['CO2'] = $brandFleet['ton_km'] * $cache['CO2GTonKM'];
				// 	$emisions['NOX'] = $brandFleet['ton_km'] * $cache['NOXGTonKM'];
				// 	$emisions['PM25'] = $brandFleet['ton_km'] * $cache['PM25GTonKM'];
				// 	$emisions['PM10'] = $brandFleet['ton_km'] * $cache['PM10GTonKM'];
				// 	$emisions['CN'] = $brandFleet['ton_km'] * $cache['CNGTonKM'];

				// }elseif($brandFleet['tot_km'] != 0){
				// 	$emisions['CO2'] = $brandFleet['tot_km'] * $cache['CO2GKM'];
				// 	$emisions['NOX'] = $brandFleet['tot_km'] * $cache['NOXGKM'];
				// 	$emisions['PM25'] = $brandFleet['tot_km'] * $cache['PM25GKM'];
				// 	$emisions['PM10'] = $brandFleet['tot_km'] * $cache['PM10GKM'];
				// 	$emisions['CN'] = $brandFleet['tot_km'] * $cache['CNGKM'];

				// }else{
				// 	$emisions['CO2'] = 0;
				// 	$emisions['NOX'] = 0;
				// 	$emisions['PM25'] = 0;
				// 	$emisions['PM10'] = 0;
				// 	$emisions['CN'] = 0;
				// }
				break;
		}

		// print2([$A,$B,$C]);

		$emissions['CO2'] =  $A * $cache['CO2GTonKM']/1000000;
		$emissions['NOX'] =  $A * $cache['NOXGTonKM']/1000000;
		$emissions['PM25'] =  $A * $cache['PM25GTonKM']/1000000;
		$emissions['PM10'] =  $A * $cache['PM10GTonKM']/1000000;
		$emissions['CN'] =  $A * $cache['CNGTonKM']/1000000;

		$emissions['GKMCO2'] = $B != 0 ? $emissions['CO2']/$B * 1000000 : 0;
		$emissions['GKMNOX'] = $B != 0 ? $emissions['NOX']/$B * 1000000 : 0;
		$emissions['GKMPM25'] = $B != 0 ? $emissions['PM25']/$B * 1000000 : 0;
		$emissions['GKMPM10'] = $B != 0 ? $emissions['PM10']/$B * 1000000 : 0;
		$emissions['GKMCN'] = $B != 0 ? $emissions['CN']/$B * 1000000 : 0;

		$emissions['GTONKMCO2'] = $A != 0 ? $emissions['CO2']/$A*1000000 : 0;
		$emissions['GTONKMNOX'] = $A != 0 ? $emissions['NOX']/$A*1000000 : 0;
		$emissions['GTONKMPM25'] = $A != 0 ? $emissions['PM25']/$A*1000000 : 0;
		$emissions['GTONKMPM10'] = $A != 0 ? $emissions['PM10']/$A*1000000 : 0;
		$emissions['GTONKMCN'] = $A != 0 ? $emissions['CN']/$A*1000000 : 0;

		// echo '$cache[CO2GTonKM] = '.$cache['CO2GTonKM']."<br/>";
		// echo '$cache[NOXGTonKM] = '.$cache['NOXGTonKM']."<br/>";
		// echo '$cache[PM25GTonKM] = '.$cache['PM25GTonKM']."<br/>";
		// echo '$cache[PM10GTonKM] = '.$cache['PM10GTonKM']."<br/>";
		// echo '$cache[CNGTonKM] = '.$cache['CNGTonKM']."<br/>";
		
		// print2($emissions);

		return $emissions;
	}

	private function case3($brandFleet,$category_code,$cache){

		$emisions = array();
		switch ($category_code) {
			case 'refrigerado':
			case 'mixto':
			case 'TL-CajaSeca':
				$emisions['CO2'] = $brandFleet['tot_km']*$brandFleet['avg_payload'] * $cache['CO2GTonKM'];
				$emisions['NOX'] = $brandFleet['tot_km']*$brandFleet['avg_payload'] * $cache['NOXGTonKM'];
				$emisions['PM25'] = $brandFleet['tot_km']*$brandFleet['avg_payload'] * $cache['PM25GTonKM'];
				$emisions['PM10'] = $brandFleet['tot_km']*$brandFleet['avg_payload'] * $cache['PM10GTonKM'];
				$emisions['CN'] = $brandFleet['tot_km']*$brandFleet['avg_payload'] * $cache['CNGTonKM'];

				break;

			case 'acarreo':
			case 'LTL-CajaSeca':
			case 'plataforma':
			case 'cisterna':
			case 'pesada':
			case 'madrina':
			case 'mudanza':
			case 'utilitario':
			case 'especializado':
			case 'paqueteria':
			case 'expedito':
				$emisions['CO2'] = $brandFleet['tot_km'] * $cache['CO2GKM'];
				$emisions['NOX'] = $brandFleet['tot_km'] * $cache['NOXGKM'];
				$emisions['PM25'] = $brandFleet['tot_km'] * $cache['PM25GKM'];
				$emisions['PM10'] = $brandFleet['tot_km'] * $cache['PM10GKM'];
				$emisions['CN'] = $brandFleet['tot_km'] * $cache['CNGKM'];
				break;
			
			default:
				$emisions['CO2'] = $brandFleet['tot_km'] * $cache['CO2GKM'];
				$emisions['NOX'] = $brandFleet['tot_km'] * $cache['NOXGKM'];
				$emisions['PM25'] = $brandFleet['tot_km'] * $cache['PM25GKM'];
				$emisions['PM10'] = $brandFleet['tot_km'] * $cache['PM10GKM'];
				$emisions['CN'] = $brandFleet['tot_km'] * $cache['CNGKM'];
				break;
		}

		return $emisions;
	}

	private function case1($brandFleet,$category_code,$cache){

		$emisions = array();
		switch ($category_code) {
			case 'refrigerado':
			case 'mixto':
			case 'TL-CajaSeca':
				$emisions['CO2'] = $brandFleet['ton_km'] * $cache['CO2GTonKM'];
				$emisions['NOX'] = $brandFleet['ton_km'] * $cache['NOXGTonKM'];
				$emisions['PM25'] = $brandFleet['ton_km'] * $cache['PM25GTonKM'];
				$emisions['PM10'] = $brandFleet['ton_km'] * $cache['PM10GTonKM'];
				$emisions['CN'] = $brandFleet['ton_km'] * $cache['CNGTonKM'];
				break;

			case 'acarreo':
			case 'LTL-CajaSeca':
			case 'plataforma':
			case 'cisterna':
			case 'pesada':
			case 'madrina':
			case 'mudanza':
			case 'utilitario':
			case 'especializado':
			case 'paqueteria':
			case 'expedito':
				$emisions['CO2'] = $brandFleet['tot_km'] != 0 ? $brandFleet['ton_km']/$brandFleet['tot_km'] * $cache['CO2GKM'] : 0;
				$emisions['NOX'] = $brandFleet['tot_km'] != 0 ? $brandFleet['ton_km']/$brandFleet['tot_km'] * $cache['NOXGKM'] : 0;
				$emisions['PM25'] = $brandFleet['tot_km'] != 0 ? $brandFleet['ton_km']/$brandFleet['tot_km'] * $cache['PM25GKM'] : 0;
				$emisions['PM10'] = $brandFleet['tot_km'] != 0 ? $brandFleet['ton_km']/$brandFleet['tot_km'] * $cache['PM10GKM'] : 0;
				$emisions['CN'] = $brandFleet['tot_km'] != 0 ? $brandFleet['ton_km']/$brandFleet['tot_km'] * $cache['CNGKM'] : 0;
				break;
			
			default:
				$emisions['CO2'] = $brandFleet['ton_km'] * $cache['CO2GTonKM'];
				$emisions['NOX'] = $brandFleet['ton_km'] * $cache['NOXGTonKM'];
				$emisions['PM25'] = $brandFleet['ton_km'] * $cache['PM25GTonKM'];
				$emisions['PM10'] = $brandFleet['ton_km'] * $cache['PM10GTonKM'];
				$emisions['CN'] = $brandFleet['ton_km'] * $cache['CNGTonKM'];
				break;
		}

		return $emisions;
	}

}


?>