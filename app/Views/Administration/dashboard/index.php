<?php 

// print2($empresasTrTot);
// print2($empresasTrRep);
// print2($empresasUsTot);
// print2($empresasUsRep);
// print2($fleetsRep);
// print2($CO210);
// print2($PM1010);
// print2($PM2510);
// print2($NOX10);
// print2($CN10);
// print2($fleetYears);
// print2($measure_year);
// exit();

?>

<script>
	$(document).ready(function() {
		$('#reloadData').click(function (e) {
			e.preventDefault();
			var year = $('#year-sel').val();
			var url = '<?= base_url(); ?>/administration/dashboard/index/'+year;
			console.log(url);
			$('#yearForm').attr({'action':url}).submit();
		});
	});
</script>

<form action="" id="yearForm" method="post">
	<div class="row">
		<div class="col-md-3">
			Selecciona un año
		</div>
		<div class="col-md-3">
			<select name="year" class="form-control" id="year-sel" >
				<?php foreach ($fleetYears as $y){ ?>
					<option value="<?= $y['measure_year']; ?>" <?= $measure_year == $y['measure_year']?'selected':''; ?> >
						<?= $y['measure_year']; ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-3">
			<span class="btn btn-primary" id="reloadData">Actualizar</span>
		</div>
	</div>
	<?= csrf_field() ?>
</form>
<hr>
<h2>Empresas transportistas</h2>
<div class="row">
	<div class="col-md-3">
		<center>
			<h5>Registradas</h5>
			<h2>
				<?= $empresasTrTot['cuenta']; ?>
			</h2>
		</center>
	</div>

	<div class="col-md-3">
		<center>
			<h5>Enviaron datos</h5>
			<h2>
				<?= empty($empresasTrRep['cuenta']) ? 0 : $empresasTrRep['cuenta']; ?>
			</h2>
		</center>
	</div>
	<div class="col-md-3">
		<center>
			<h5>Con información validada</h5>
			<h2>
				<?= empty($empresasTrValid['cuenta']) ? 0 : $empresasTrValid['cuenta']; ?>
			</h2>
		</center>
	</div>
	<div class="col-md-3">
		<center>
			<h5>Número de vehículos reportados</h5>
			<h2>
				<?= empty($tot_v['cuenta']) ? 0 : $tot_v['cuenta']; ?>
			</h2>
		</center>
	</div>
</div>
<h3>Emisiones Totales (Toneladas al año)</h3>
<div class="row">
	<div class="col-md-2">
		<center>
			<h5>CO2</h5>
			<h2>
				<?= empty($emisiones['CO2']) ? 0 : number_format($emisiones['CO2']/1000000,2); ?>
			</h2>
		</center>
	</div>
	<div class="col-md-2">
		<center>
			<h5>PM2.5</h5>
			<h2>
				<?= empty($emisiones['PM25']) ? 0 : number_format($emisiones['PM25']/1000000,2); ?>
			</h2>
		</center>
	</div>
	<div class="col-md-2">
		<center>
			<h5>PM10</h5>
			<h2>
				<?= empty($emisiones['PM10']) ? 0 : number_format($emisiones['PM10']/1000000,2); ?>
			</h2>
		</center>
	</div>
	<div class="col-md-2">
		<center>
			<h5>NOx</h5>
			<h2>
				<?= empty($emisiones['NOX']) ? 0 : number_format($emisiones['NOX']/1000000,2); ?>
			</h2>
		</center>
	</div>
	<div class="col-md-2">
		<center>
			<h5>CN</h5>
			<h2>
				<?= empty($emisiones['CN']) ? 0 : number_format($emisiones['CN']/1000000,2); ?>
			</h2>
		</center>
	</div>
</div>

<hr>
<h2>Empresas usuarias de transporte de carga</h2>
<div class="row">
	<div class="col-md-3">
		<center>
			<h5>Registradas</h5>
			<h2>
				<?= $empresasUsRep['cuenta']; ?>
			</h2>
		</center>
	</div>

	<div class="col-md-3">
		<center>
			<h5>Enviaron datos</h5>
			<h2>
				<?= $empresasUsRep['cuenta']; ?>
			</h2>
		</center>
	</div>
	<div class="col-md-3">
		<center>
			<h5>Con información validada</h5>
			<h2>
				<?= $empresasUsValid['cuenta']; ?>
			</h2>
		</center>
	</div>
</div>
<h3>Emisiones Totales (Toneladas al año)</h3>
<div class="row">
	<div class="col-md-2">
		<center>
			<h5>CO2</h5>
			<h2>
				<?= empty($emisionesU['CO2']) ? 0 : number_format($emisionesU['CO2']/1000000,2); ?>
			</h2>
		</center>
	</div>
	<div class="col-md-2">
		<center>
			<h5>PM2.5</h5>
			<h2>
				<?= empty($emisionesU['PM25']) ? 0 : number_format($emisionesU['PM25']/1000000,2); ?>
			</h2>
		</center>
	</div>
	<div class="col-md-2">
		<center>
			<h5>PM10</h5>
			<h2>
				<?= empty($emisionesU['PM10']) ? 0 : number_format($emisionesU['PM10']/1000000,2); ?>
			</h2>
		</center>
	</div>
	<div class="col-md-2">
		<center>
			<h5>NOx</h5>
			<h2>
				<?= empty($emisionesU['NOX']) ? 0 : number_format($emisionesU['NOX']/1000000,2); ?>
			</h2>
		</center>
	</div>
	<div class="col-md-2">
		<center>
			<h5>CN</h5>
			<h2>
				<?= empty($emisionesU['CN']) ? 0 : number_format($emisionesU['CN']/1000000,2); ?>
			</h2>
		</center>
	</div>
</div>

<hr>
