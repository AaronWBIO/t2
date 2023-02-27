<div style="margin-top: 20px;">
	
	<br/><br/><br/><br/><br/>

	<h1><?= $title; ?></h1>
	<h3>Resumen de datos ingresados</h3>
	<table cellspacing="0" cellpadding="1" border="1" style="font-size:8px;">
		<thead>
			<tr style="background-color:#CCCCCC; font-weight: bold; text-align: center;">
				<th>Nombre de la Flota</th>
				<th>Tipo de Combustible</th>
				<th>Clase</th>
				<th>Número de camiones</th>
				<th>Año-modelo promedio</th>
				<th>Combustible (Litros o kWhr)</th>
				<th>La eficiencia de los vehículos**</th>
				<th>Kilómetros Totales Recorridos al Año</th>
				<th>Kilómetros Totales en Vacío al Año</th>
				<th>Promedio de Carga útil (toneladas/ camión)*</th>
				<th>Promedio de Horas en Ralentí (por camión al año)</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$fleets_id = -1;
			$change = false;
			$sum = array();
			$num = 0;
			$fleet_km = array();
			$fleet_payload = array();

			$acums = array();
			$acums['km_tot'] = 0;
			$acums['km_empty'] = 0;
			$acums['v_total'] = 0;
			$acums['km_tot_fleet'] = array();
			$acums['payload_avg_fleet'] = array();

			$countFleets = 0;
			
			foreach ($fleets as $k => $f){ 
				if($k == 0){
					$fname = "$f[com_name] - $f[name]";
				}

				if($f['fleets_id'] != $fleets_id){

					$countFleets ++;
					// echo "fleet $f[fleets_id] <br/>";
					$fnameAnt = $fname;
					$fname = "$f[com_name] - $f[name]";
					$fleets_id = $f['fleets_id'];
					$sumAnt = $sum;
					$numAnt = $num;

					$sum['v_total'] = 0;
					$sum['sum_years'] = 0;
					$sum['lts_tot'] = 0;
					$sum['eficiencia'] = 0;
					$sum['km_tot'] = 0;
					$sum['km_empty'] = 0;
					$sum['payload_avg'] = 0;
					$sum['ralenti_hours'] = 0;
					$sum['avg_year'] = 0;

					$num = 0;
					
					if($k != 0){
						$change = true;
					}
					// echo "fleet_km<br/>";
					// print2($fleet_km);
					// echo "fleet_payload<br/>";
					// print2($fleet_payload);

					$fleet_km_ant = $fleet_km;
					$fleet_payload_ant = $fleet_payload;

					$fleet_km = array();
					$fleet_payload = array();
				}
				$sum['v_total'] += $f['v_total'];
				$sum['sum_years'] += $f['avg_year']*$f['v_total'];
				$sum['lts_tot'] += $f['lts_tot'];
				$sum['eficiencia'] += $f['lts_tot'] != 0 ? $f['km_tot']/$f['lts_tot'] : 0;
				$sum['km_tot'] += $f['km_tot'];
				$sum['km_empty'] += $f['km_empty'];
				$sum['payload_avg'] += $f['payload_avg'];
				$sum['ralenti_hours'] += $f['ralenti_days']*($f['ralenti_hours_large']+$f['ralenti_hours_short']);

				$fleet_km[] = $f['km_tot'];
				$fleet_payload[] = $f['payload_avg'];

				$num ++;

			?>
				<?php 
				if ($change){ 
					$change = false;

					$payload_avg_calc = 0;
					foreach ($fleet_km_ant as $k => $km_tot) {
						$payload_avg = $fleet_payload_ant[$k];
						// echo "($km_tot / $sumAnt[km_tot]) * $payload_avg <br/>";
						$payload_avg_calc += $sumAnt['km_tot'] != 0 ? ($km_tot/$sumAnt['km_tot'])*$payload_avg : 0;
					}

					$acums['km_tot'] += $sumAnt['km_tot'];
					$acums['km_empty'] += $sumAnt['km_empty'];
					$acums['v_total'] += $sumAnt['v_total'];
					$acums['km_tot_fleet'][] = $sumAnt['km_tot'];
					$acums['payload_avg_fleet'][] = $payload_avg_calc;

					$avg_year = $sumAnt['v_total'] != 0 ? $sumAnt['sum_years']/$sumAnt['v_total'] : 0;

				?>
					<tr>
						<th><?= "$fnameAnt" ?></th>
						<th style="text-align: center;"><?= "Todo" ?></th>
						<th style="text-align: center;"><?= "Todo" ?></th>
						<th style="text-align: center;"><?= number_format($sumAnt['v_total'],0); ?></th>
						<th style="text-align: center;"><?= number_format($avg_year,0); ?></th>
						<th style="text-align: center;"><?= number_format($sumAnt['avg_year'],0); ?></th>
						<th style="text-align: center;"><?= number_format($sumAnt['lts_tot'],0); ?></th>
						<td style="text-align: center;"><?= number_format($sumAnt['lts_tot'] != 0 ? $sumAnt['km_tot']/$sumAnt['lts_tot'] : 0,2); ?></td>

						<!-- <th style="text-align: center;">NA</th> -->
						<th style="text-align: center;"><?= number_format($sumAnt['km_tot'],0); ?></th>
						<th style="text-align: center;"><?= number_format($sumAnt['km_empty'],0); ?></th>
						<th style="text-align: center;"><?= number_format($payload_avg_calc,2); ?></th>
						<th style="text-align: center;">
							NA
						</th>

					</tr>
				<?php } ?>

				<tr>
					<td><?= "$f[name]" ?></td>
					<td style="text-align: center;"><?= $f['fuel_name']; ?></td>
					<td style="text-align: center;"><?= $f['vclass_name']; ?></td>
					<td style="text-align: center;"><?= number_format($f['v_total'],0); ?></td>
					<td style="text-align: center;"><?= number_format($f['avg_year'],0); ?></td>
					<td style="text-align: center;"><?= number_format($f['lts_tot'],0); ?></td>
					<td style="text-align: center;"><?= number_format($f['lts_tot'] != 0 ? $f['km_tot']/$f['lts_tot'] : 0,2); ?></td>
					<td style="text-align: center;"><?= number_format($f['km_tot'],0); ?></td>
					<td style="text-align: center;"><?= number_format($f['km_empty'],0); ?></td>
					<td style="text-align: center;"><?= number_format($f['payload_avg'],2); ?></td>
					<td style="text-align: center;">
						<?= number_format($f['ralenti_days']*($f['ralenti_hours_large']+$f['ralenti_hours_short']),0); ?>
					</td>
				</tr>

			<?php } ?>
			<?php 
			if (!empty($fleets) ){ 
				$payload_avg_calc = 0;
				foreach ($fleet_km as $k => $km_tot) {
					$payload_avg = $fleet_payload[$k];
					// echo "($km_tot / $sum[km_tot]) * $payload_avg <br/>";
					$payload_avg_calc += $sum['km_tot'] != 0 ? ($km_tot/$sum['km_tot'])*$payload_avg : 0;
				}

				$acums['km_tot'] += $sum['km_tot'];
				$acums['km_empty'] += $sum['km_empty'];
				$acums['v_total'] += $sum['v_total'];
				$acums['km_tot_fleet'][] = $sum['km_tot'];
				$acums['payload_avg_fleet'][] = $payload_avg_calc;

				$avg_year = $sum['v_total'] != 0 ? $sum['sum_years']/$sum['v_total'] : 0;
			?>
				<tr>
					<th><?= "$f[com_name] - $f[name]" ?></th>
					<th style="text-align: center;"><?= "Todo" ?></th>
					<th style="text-align: center;"><?= "Todo" ?></th>
					<th style="text-align: center;"><?= number_format($sum['v_total']); ?></th>
					<th style="text-align: center;"><?= number_format($avg_year,0); ?></th>
					<th style="text-align: center;"><?= number_format($sum['lts_tot'],0); ?></th>
					<td style="text-align: center;"><?= number_format($sum['lts_tot'] != 0 ? $sum['km_tot']/$sum['lts_tot'] : 0,2); ?></td>

					<!-- <th style="text-align: center;">NA</th> -->
					<th style="text-align: center;"><?= number_format($sum['km_tot']); ?></th>
					<th style="text-align: center;"><?= number_format($sum['km_empty']); ?></th>
					<th style="text-align: center;"><?= number_format($payload_avg_calc); ?></th>
					<th style="text-align: center;">
						NA
					</th>
				</tr>
			<?php } ?>

			<?php 
			if (!empty($fleets)){ 
				$payload_avg_calc = 0;
				foreach ($acums['km_tot_fleet'] as $k => $km_tot) {
					$payload_avg = $acums['payload_avg_fleet'][$k];
					// echo "($km_tot / $sum[km_tot]) * $payload_avg <br/>";
					$payload_avg_calc += $acums['km_tot'] != 0 ? ($km_tot/$acums['km_tot'])*$payload_avg : 0;
				}


			?>
<!-- 				<tr>
					<th><?= "Totales" ?></th>
					<th style="text-align: center;"><?= "Todo" ?></th>
					<th style="text-align: center;"><?= "Todo" ?></th>
					<th style="text-align: center;"><?= number_format($acums['v_total'],0); ?></th>
					<th style="text-align: center;">NA</th>
					<th style="text-align: center;">NA</th>
					<th style="text-align: center;"><?= number_format($acums['km_tot'],0); ?></th>
					<th style="text-align: center;"><?= number_format($acums['km_empty'],0); ?></th>
					<th style="text-align: center;"><?= number_format($payload_avg_calc,2); ?></th>
					<th style="text-align: center;">
						NA
					</th>
				</tr>
 -->			<?php } ?>
		</tbody>
	</table>
	<div style="font-size: .8em;">
		* Para empresas o flotas totales, los valores promedio son ponderados con el total de kilómetros de los camiones.<br/>
		** km/L o en km/kWh
	</div>

	<div style="margin-top:10px;">
		<h3>Resumen de emisiones por flota </h3>
		<table cellspacing="0" cellpadding="1" border="1" style="font-size:8px;">
			<thead>
				<tr style="background-color: #CCCCCC; font-weight: bold; text-align: center;">
					<th rowspan="2">Nombre de la flota</th>
					<th colspan="5" style="border-left: none 1px;">Toneladas totales</th>
					<th colspan="5" style="border-left: none 1px;">Gramos por kilómetro</th>
					<th colspan="5" style="border-left: none 1px;">Gramos por tonelada - kilómetro</th>
				</tr>
				<tr style="background-color: #CCCCCC; font-weight: bold; text-align: center;">
					<th style="border-left: none 1px;">CO<sub>2</sub></th>
					<th>PM<sub>2.5</sub></th>
					<th>PM<sub>10</sub></th>
					<th>NOx</th>
					<th>CN</th>

					<th style="border-left: none 1px;">CO<sub>2</sub></th>
					<th>PM<sub>2.5</sub></th>
					<th>PM<sub>10</sub></th>
					<th>NOx</th>
					<th>CN</th>

					<th style="border-left: none 1px;">CO<sub>2</sub></th>
					<th>PM<sub>2.5</sub></th>
					<th>PM<sub>10</sub></th>
					<th>NOx</th>
					<th>CN</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$sum_company = array();
				$sum_company['CO2'] = 0;
				$sum_company['PM25'] = 0;
				$sum_company['PM10'] = 0;
				$sum_company['NOX'] = 0;
				$sum_company['CN'] = 0;
				$sum_company['CO2GKM'] = 0;
				$sum_company['PM25GKM'] = 0;
				$sum_company['PM10GKM'] = 0;
				$sum_company['NOXGKM'] = 0;
				$sum_company['CNGKM'] = 0;
				$sum_company['CO2GTonKM'] = 0;
				$sum_company['PM25GTonKM'] = 0;
				$sum_company['PM10GTonKM'] = 0;
				$sum_company['NOXGTonKM'] = 0;
				$sum_company['CNGTonKM'] = 0;
				$cname = '';
				foreach ($fleetscache as $f){
					$sum_company['CO2'] += $f['CO2'];
					$sum_company['PM25'] += $f['PM25'];
					$sum_company['PM10'] += $f['PM10'];
					$sum_company['NOX'] += $f['NOX'];
					$sum_company['CN'] += $f['CN'];
					$sum_company['CO2GKM'] += $f['CO2GKM'];
					$sum_company['PM25GKM'] += $f['PM25GKM'];
					$sum_company['PM10GKM'] += $f['PM10GKM'];
					$sum_company['NOXGKM'] += $f['NOXGKM'];
					$sum_company['CNGKM'] += $f['CNGKM'];
					$sum_company['CO2GTonKM'] += $f['CO2GTonKM'];
					$sum_company['PM25GTonKM'] += $f['PM25GTonKM'];
					$sum_company['PM10GTonKM'] += $f['PM10GTonKM'];
					$sum_company['NOXGTonKM'] += $f['NOXGTonKM'];
					$sum_company['CNGTonKM'] += $f['CNGTonKM'];
					$cname = "$f[cname]";
				?>
					<tr>
						<td><?= "$f[fname]"; ?></td>

						<td style="border-left: none 1px;"><?= number_format($f['CO2']/1000000,2); ?></td>
						<td><?= number_format($f['PM25']/1000000,2); ?></td>
						<td><?= number_format($f['PM10']/1000000,2); ?></td>
						<td><?= number_format($f['NOX']/1000000,2); ?></td>
						<td><?= number_format($f['CN']/1000000,2); ?></td>

						<td style="border-left: none 1px;"><?= number_format($f['CO2GKM'],2); ?></td>
						<td><?= number_format($f['PM25GKM'],2); ?></td>
						<td><?= number_format($f['PM10GKM'],2); ?></td>
						<td><?= number_format($f['NOXGKM'],2); ?></td>
						<td><?= number_format($f['CNGKM'],2); ?></td>

						<td style="border-left: none 1px;"><?= number_format($f['CO2GTonKM'],2); ?></td>
						<td><?= number_format($f['PM25GTonKM'],2); ?></td>
						<td><?= number_format($f['PM10GTonKM'],2); ?></td>
						<td><?= number_format($f['NOXGTonKM'],2); ?></td>
						<td><?= number_format($f['CNGTonKM'],2); ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div style="margin-top:10px;">
		<h3>Emisiones totales de la empresa</h3>
		<table cellspacing="0" cellpadding="1" border="1" style="font-size:8px;">
			<thead>
				<tr style="background-color: #CCCCCC; font-weight: bold; text-align: center;">
					<th rowspan="2">Nombre de la flota</th>
					<th colspan="5" style="border-left: none 1px;">Toneladas totales</th>
					<th colspan="5" style="border-left: none 1px;">Gramos por kilómetro</th>
					<th colspan="5" style="border-left: none 1px;">Gramos por tonelada - kilómetro</th>
				</tr>
				<tr style="background-color: #CCCCCC; font-weight: bold; text-align: center;">
					<th style="border-left: none 1px;">CO<sub>2</sub></th>
					<th>PM<sub>2.5</sub></th>
					<th>PM<sub>10</sub></th>
					<th>NOx</th>
					<th>CN</th>

					<th style="border-left: none 1px;">CO<sub>2</sub></th>
					<th>PM<sub>2.5</sub></th>
					<th>PM<sub>10</sub></th>
					<th>NOx</th>
					<th>CN</th>

					<th style="border-left: none 1px;">CO<sub>2</sub></th>
					<th>PM<sub>2.5</sub></th>
					<th>PM<sub>10</sub></th>
					<th>NOx</th>
					<th>CN</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= "$cname"; ?></td>

					<td style="border-left: none 1px;"><?= number_format($sum_company['CO2']/1000000,2); ?></td>
					<td><?= number_format($sum_company['PM25']/1000000,2); ?></td>
					<td><?= number_format($sum_company['PM10']/1000000,2); ?></td>
					<td><?= number_format($sum_company['NOX']/1000000,2); ?></td>
					<td><?= number_format($sum_company['CN']/1000000,2); ?></td>

					<td style="border-left: none 1px;"><?= number_format($sum_company['CO2GKM'],2); ?></td>
					<td><?= number_format($sum_company['PM25GKM'],2); ?></td>
					<td><?= number_format($sum_company['PM10GKM'],2); ?></td>
					<td><?= number_format($sum_company['NOXGKM'],2); ?></td>
					<td><?= number_format($sum_company['CNGKM'],2); ?></td>

					<td style="border-left: none 1px;"><?= number_format($sum_company['CO2GTonKM'],2); ?></td>
					<td><?= number_format($sum_company['PM25GTonKM'],2); ?></td>
					<td><?= number_format($sum_company['PM10GTonKM'],2); ?></td>
					<td><?= number_format($sum_company['NOXGTonKM'],2); ?></td>
					<td><?= number_format($sum_company['CNGTonKM'],2); ?></td>
				</tr>

			</tbody>

		</table>
	</div>
	<div>
		<table style="font-size:8px;">
			<thead>
				<tr>
					<th>Contaminantes evaluados</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						Dióxido de carbono: CO2
					</td>
				</tr>
				<tr>
					<td>
						Partículas menores a 2.5 micrométros: PM2.5
					</td>
				</tr>
				<tr>
					<td>
						Partículas menores a 10 micrómetros: PM10
					</td>
				</tr>
				<tr>
					<td>
						Óxidos de nitrógeno: NOx
					</td>
				</tr>
				<tr>
					<td>
						Carbono negro: CN
					</td>
				</tr>
			</tbody>
		</table>
	</div>	
</div>


