
<?php
use App\Libraries\EmpresaVerificarPasos;
use App\Models\Empresas\BrandsModel;

$validation = false;

$complete = EmpresaVerificarPasos::paso3();
$brandsModel = new BrandsModel();

$brandsC = $brandsModel -> where('companies_id',session()->id) -> where('measure_year',date('Y')) -> findAll();

$allInrange = true;
foreach($brandsC as $b){
	if($b['status'] >= 100 || $b['status'] < 90){
		$allInrange = false;
	}
}
$validation = $complete && $allInrange;

?>


<script>
	$(document).ready(function() {
		$('#sendValid').click(function (e) {
			e.preventDefault();

			var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/terminarEmpresaUsuaria');
			console.log(rj);
			var r = $.parseJSON(rj);

			if(r.ok == 1){
				alertar('La información ha sido enviada para su validación');
			}

		});
	});
</script>
<div style="margin-top: 20px;">

	<h3>Resumen de datos ingresados</h3>

	<table class="table">
		<thead>
			<tr style="background-color:#EEE;">
				<th>Empresa</th>
				<th>Nombre de la Flota</th>
				<th>Disponibilidad de datos</th>
				<th>Ton/Km</th>
				<th>Km Totales</th>
				<th>Carga útil promedio</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($brands as $key => $b){ ?>
				<tr>
					<td><?= $b['cname'] ?></td>
					<td><?= $b['fname'] ?></td>
					<td>
						<?php
							switch ($b['measure_type']) {
								case '1':
									echo "Ton/Km y Km Totales";
									break;
								case '2':
									echo "Ton/Km y Carga";
									break;
								case '3':
									echo "Km Totales y Carga";
									break;
								case '4':
									echo "Km Totales";
									break;
								
								default:
									// code...
									break;
							}
						?>
					</td>
					<td>
						<?php
							switch ($b['measure_type']) {
								case '1':
								case '2':
									echo $b['ton_km'];
									break;
								default:
									// code...
									break;
							}
						?>
					</td>
					<td>
						<?php
							switch ($b['measure_type']) {
								case '1':
								case '3':
								case '4':
									echo $b['tot_km'];
									break;
								
								default:
									// code...
									break;
							}
						?>
					</td>
					<td>
						<?php
							switch ($b['measure_type']) {
								case '2':
								case '3':
									echo $b['avg_payload'];
									break;								
								default:
									// code...
									break;
							}
						?>
					</td>

				</tr>
			<?php } ?>
		</tbody>
	</table>
	<div style="font-size: .8em;">
		<!-- * Para empresas o flotas totales, los valores promedio son ponderados con el total de kilómetros de los camiones.<br/>
		** km/L o en km/kWh -->
	</div>

	<table class="table">
		<thead>
			<tr style="background-color:#EEE;">
				<th>Empresa</th>
				<th>Nombre de la Flota</th>
				<th>CO2</th>
				<th>PM2.5</th>
				<th>PM10</th>
				<th>NOX</th>
				<th>CN</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				
			$sumCO2 = 0;
			$sumPM25 = 0;
			$sumPM10 = 0;
			$sumNOX = 0;
			$sumCN = 0;
			foreach ($brands as $key => $b){ 
				$sumCO2 += $b['CO2'];
				$sumPM25 += $b['PM25'];
				$sumPM10 += $b['PM10'];
				$sumNOX += $b['NOX'];
				$sumCN += $b['CN'];
			?>
				<tr>
					<td><?= $b['cname'] ?></td>
					<td><?= $b['fname'] ?></td>
					<td><?= $b['CO2'] ?></td>
					<td><?= $b['PM25'] ?></td>
					<td><?= $b['PM10'] ?></td>
					<td><?= $b['NOX'] ?></td>
					<td><?= $b['CN'] ?></td>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr style="background-color:#EEE;">
				<th></th>
				<th>Totales</th>
				<th><?= $sumCO2; ?></th>
				<th><?= $sumPM25; ?></th>
				<th><?= $sumPM10; ?></th>
				<th><?= $sumNOX; ?></th>
				<th><?= $sumCN; ?></th>
			</tr>
		</tfoot>
	</table>
</div>
<div>
	<div>
		<table>
			<thead>
				<tr>
					<th>Contaminantes evaluados</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						Dióxido de carbono: CO2 (Toneladas al año)
					</td>
				</tr>
				<tr>
					<td>
						Partículas menores a 2.5 micrométros: PM2.5 (Toneladas al año)
					</td>
				</tr>
				<tr>
					<td>
						Partículas menores a 10 micrómetros: PM10 (Toneladas al año)
					</td>
				</tr>
				<tr>
					<td>
						Óxidos de nitrógeno: NOx (Toneladas al año)
					</td>
				</tr>
				<tr>
					<td>
						Carbono negro: CN (Toneladas al año)
					</td>
				</tr>
			</tbody>
		</table>
	</div>	

</div>

<div style="text-align:right;">
	<?php if ($validation && !session()->get('isLoggedInAdmin') ){ ?>
		<span class="btn btn-primary" id="sendValid">Enviar datos a validación</span>
	<?php } ?>
</div>	



