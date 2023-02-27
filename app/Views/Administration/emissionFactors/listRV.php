<script>
	$(function() {
		$('#saveFE').click(function (e) {
			e.preventDefault();
			var dat = $('#feForm').serializeObject();
			// console.log(dat);
			var rj = jsonF('<?= base_url(); ?>/administration/emissionFactors/save',dat);
			var r = $.parseJSON(rj);
			if(r.ok == 1){
				alertar('La información se guardó correctamente');
			}else{
				alertar('Hubo un error al guardar la información');
			}

		});

		$('#uploadCSV').click(function (e) {
			e.preventDefault();
			popUp('<?= base_url(); ?>/administration/emissionFactors/addFromFile',{});
		});

	});

</script>


<div style="margin-top: 20px;">
	<div class="row">
		<div class="col-md-4">
			<table class="table">
				<tr>
					<th>Año de medición:</th>
					<td><?= $measure_year; ?></td>
				</tr>
				<tr>
					<th>Contaminante:</th>
					<td><?= $pollutant['name']; ?></td>
				</tr>
				<tr>
					<th>Combustible:</th>
					<td><?= $fuel['name']; ?></td>
				</tr>
				<tr>
					<th>Tipo:</th>
					<td>Rangos de velocidades</td>
				</tr>
				<tr>
					<th>Unidades:</th>
					<td><?= $pollutant['units']; ?></td>
				</tr>
			</table>
		</div>
		<div class="col-md-8">
			<span class="btn btn-sm btn-primary" id="saveFE">Guardar información</span>
			<span class="btn btn-sm btn-primary" id="uploadCSV">Cargar CSV</span>
			<a class="btn btn-sm btn-primary" href="<?= base_url(); ?>/assets/examples/velocidades.csv">Descargar ejemplo</a>
		</div>
	</div>

	<form id="feForm">
		<table class="table">
			<thead>
				<tr>
					<th><center>Clase-año</center></th>
					<th><center>Desaceleración</center></th>
					<th><center>0 - 40</center></th>
					<th><center>40 - 80</center></th>
					<th><center>80 +</center></th>
					<th><center>Autopista</center></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($vclass as $c){ ?>
					<?php 
					$i = 0;
					foreach ($fe[$c['id']] as $y => $f){ $i ++;
					?>
						<tr>
							<th><?= $c['name']; ?> - <?= $i == count($fe[$c['id']]) ? $y . " y anteriores": $y; ?></th>
							<td>
								<input type="text" class="form-control inpFE" value="<?= $f['4']['value']; ?>" 
									name="fe_id_<?= $f['4']['id']; ?>" id="desacel_<?= $y; ?>_<?= $c['code']; ?>" >
							</td>
							<td>
								<input type="text" class="form-control inpFE" value="<?= $f['1']['value']; ?>" 
									name="fe_id_<?= $f['1']['id']; ?>" id="40_<?= $y; ?>_<?= $c['code']; ?>" >
							</td>
							<td>
								<input type="text" class="form-control inpFE" value="<?= $f['2']['value']; ?>" 
									name="fe_id_<?= $f['2']['id']; ?>" id="4080_<?= $y; ?>_<?= $c['code']; ?>" >
							</td>
							<td>
								<input type="text" class="form-control inpFE" value="<?= $f['3']['value']; ?>" 
									name="fe_id_<?= $f['3']['id']; ?>" id="80_<?= $y; ?>_<?= $c['code']; ?>" >
							</td>
							<td>
								<input type="text" class="form-control inpFE" value="<?= $f['1']['value']; ?>" 
									name="fe_id_<?= $f['0']['id']; ?>" id="autopista_<?= $y; ?>_<?= $c['code']; ?>" >
							</td>
						</tr>
					<?php } ?>
				<?php } ?>

			</tbody>
		</table>
	</form>

</div>