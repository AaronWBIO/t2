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
			popUp('<?= base_url(); ?>/administration/emissionFactors/addFromFileRalenti',{});
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
					<td>
						
						<?php switch ($type) {
							case '0':
								echo "Normal";
								break;
							case '1':
								echo "Ralentí de corta duración";
								break;
							case '2':
								echo "Ralentí de larga duración";
								break;
							
							default:
								// code...
								break;
						} ?>	
					</td>
				</tr>
				<tr>
					<th>Unidades:</th>
					<td>
						<?= $type == 0 ? $pollutant['units'] : 'g/hr'; ?>		
					</td>
				</tr>
			</table>
		</div>
		<div class="col-md-8">
			<span class="btn btn-sm btn-primary" id="saveFE">Guardar información</span>
			<span class="btn btn-sm btn-primary" id="uploadCSV">Cargar CSV</span>
			<a class="btn btn-sm btn-primary" href="<?= base_url(); ?>/assets/examples/Ralenti.csv">Descargar ejemplo</a>
		</div>
	</div>

	<form id="feForm">
		<table class="table">
			<thead>
				<tr>
					<th style="vertical-align: middle;">Año</th>
					<?php foreach ($vclass as $c){ ?>
						<th>
							<center>
								<img src="<?= base_url(); ?>/assets/images/icons/<?= $c['icon']; ?>" width="100px;" alt=""><br/>
								<?= $c['name']; ?>
							</center>
						</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i = 0;
				foreach ($fe as $year => $f){ $i++;
				?>
					<tr>
						<td><?= $i == count($fe) ? $year . " y anteriores" : $year; ?></td>
						<?php foreach ($vclass as $c){ ?>
							<td>
								<input type="text" class="form-control inpFE" value="<?= $f[$c['id']]['value']; ?>" 
									name="fe_id_<?= $f[$c['id']]['id']; ?>" id="<?= $year; ?>_<?= $c['code']; ?>">
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</form>

</div>