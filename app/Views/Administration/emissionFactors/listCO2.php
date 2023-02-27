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
					<td><?= $type == 0?'Normal':'Ralentí'; ?></td>
				</tr>
				<tr>
					<th>Unidades:</th>
					<td>
						<?php if ($fuel['code'] == 'electrico'){ ?>
							g/KWhr
						<?php }else{ ?>
							<?= $pollutant['units']; ?>
						<?php } ?>
					</td>
				</tr>
			</table>
		</div>
		<div class="col-md-8">
			<span class="btn btn-sm btn-primary" id="saveFE">Guardar información</span>
		</div>
	</div>

	<form id="feForm">
		<table class="table">
			<tbody>
				<tr>
					<td>Factor de emisión</td>
					<td>
						<input type="text" class="form-control" value="<?= $fe['value']; ?>" 
							name="fe_id_<?= $fe['id']; ?>" >
					</td>
				</tr>
			</tbody>
		</table>
	</form>

</div>