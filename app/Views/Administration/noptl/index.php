<script>
	$(document).ready(function() {

		$("#flotas_id").change(function (e) {
			e.preventDefault();
			var fleet_id = $(this).val();
			if(fleet_id != ''){
				load('#fleetEmissions','<?= base_url(); ?>/Administration/NoPTL/fleetEmissions/'+fleet_id,{});
			}else{
				$('#fleetEmissions').empty();
			}
		});

		$('#addFleet').click(function (e) {
			e.preventDefault();
			popUp('<?= base_url(); ?>/Administration/NoPTL/addFleet');
		});

	});
</script>

<div class="row">
	<div class="col-md-6">
		<!-- Selecciona un tipo de flota<br/> -->
		<select name="flotas_id" id="flotas_id" class="form-control">
			<option value="">Selecciona una flota</option>
			<?php foreach ($fleets as $f){ ?>
				<option value="<?= $f['hash_id']; ?>"><?= $f['name']; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-6">
		<span class="btn btn-sm btn-primary" id="addFleet">Agregar flota</span>
		<a href="<?= base_url(); ?>/administration/NoPTL/dwlFleets" target="_blank" class="btn btn-primary btn-sm">
			Descargar CSV
		</a>					

	</div>
</div>

<div id="fleetEmissions"></div>