<script>
	$(function() {
		$('#saveFE').click(function (e) {
			e.preventDefault();
			var dat = $('#feForm').serializeObject();
			var rj = jsonF('<?= base_url(); ?>/Administration/Validations/save',dat);
			var r = $.parseJSON(rj);
			if(r.ok == 1){
				alertar('La información se guardó correctamente');
			}else{
				alertar('Hubo un error al guardar la información');
			}

		});
		
		$('#uploadCSV').click(function (e) {
			e.preventDefault();
			popUp('<?= base_url(); ?>/administration/validations/addFromFile',{});
		});

		$('#exampleCSV').click(function (e) {
			e.preventDefault();
			$('#exampleCSVform').submit();
		});
	});

</script>

<h3>
	<?= $validation['name']; ?>
</h3>	
<div style="margin-top: 20px;">
	<div class="row">
		<div class="col-md-4">
		</div>
		<div class="col-md-8">
			<span class="btn btn-sm btn-primary" id="saveFE">Guardar información</span>
			<span class="btn btn-sm btn-primary" id="uploadCSV">Cargar CSV</span>
			<span class="btn btn-sm btn-primary" id="exampleCSV">Ejemplo CSV</span>
			<form action="<?= base_url(); ?>/Administration/Validations/exampleCSV" target="_blank" id="exampleCSVform"></form>
		</div>
	</div>

	<form id="feForm">
		<table class="table">
			<thead>
				<tr>
					<th style="vertical-align: middle;">Clase - Categoría</th>
					<th style="vertical-align: middle;">Mínimo absoluto</th>
					<th style="vertical-align: middle;">Rojo bajo</th>
					<th style="vertical-align: middle;">Amarillo bajo</th>
					<th style="vertical-align: middle;">Amarillo alto</th>
					<th style="vertical-align: middle;">Rojo Alto</th>
					<th style="vertical-align: middle;">Máximo absoluto</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($vclass as $vc){ ?>
					<?php foreach ($categories as $c){ ?>
						<tr>
							<th><?= "$vc[name] -<br/> $c[name]"; ?></th>
							<td>
								<input type="text" class="form-control inpVV" 
									value="<?= $validationsValues[$vc['code']][$c['code']]['min'] ?>" 
									name="vv_id_<?= $validationsValues[$vc['code']][$c['code']]['id'] ?>[min]" 
									id="<?= $vc['code']; ?>_<?= $c['code']; ?>_min" 
									\>

							</td>
							<td>
								<input type="text" class="form-control inpVV" 
									value="<?= $validationsValues[$vc['code']][$c['code']]['red_low'] ?>" 
									name="vv_id_<?= $validationsValues[$vc['code']][$c['code']]['id'] ?>[red_low]" 
									id="<?= $vc['code']; ?>_<?= $c['code']; ?>_rl" 
									\>

							</td>
							<td>
								<input type="text" class="form-control inpVV" 
									value="<?= $validationsValues[$vc['code']][$c['code']]['yellow_low'] ?>" 
									name="vv_id_<?= $validationsValues[$vc['code']][$c['code']]['id'] ?>[yellow_low]" 
									id="<?= $vc['code']; ?>_<?= $c['code']; ?>_yl" 
									\>

							</td>
							<td>
								<input type="text" class="form-control inpVV" 
									value="<?= $validationsValues[$vc['code']][$c['code']]['yellow_high'] ?>" 
									name="vv_id_<?= $validationsValues[$vc['code']][$c['code']]['id'] ?>[yellow_high]" 
									id="<?= $vc['code']; ?>_<?= $c['code']; ?>_lh" 
									\>

							</td>
							<td>
								<input type="text" class="form-control inpVV" 
									value="<?= $validationsValues[$vc['code']][$c['code']]['red_high'] ?>" 
									name="vv_id_<?= $validationsValues[$vc['code']][$c['code']]['id'] ?>[red_high]" 
									id="<?= $vc['code']; ?>_<?= $c['code']; ?>_rh" 
									\>

							</td>
							<td>
								<input type="text" class="form-control inpVV" 
									value="<?= $validationsValues[$vc['code']][$c['code']]['max'] ?>" 
									name="vv_id_<?= $validationsValues[$vc['code']][$c['code']]['id'] ?>[max]" 
									id="<?= $vc['code']; ?>_<?= $c['code']; ?>_max" 
									\>

							</td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</form>

</div>