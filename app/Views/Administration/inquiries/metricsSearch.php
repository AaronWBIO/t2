<script>
	$(document).ready(function() {
		$('#yearSel').change(function (e) {
			e.preventDefault();
			var value = $(this).val();
			if(value != ''){
				if(!$('#y_'+value).length){
					var elem = `
						<li class="list-group-item yearli" id="y_${value}" style='position:relative;'>
							${value}
							<span style="position:absolute; right:10px;" class="delElem">
								<i class="glyphicon glyphicon-trash manita"></i>
							</span>
						</li>
					`;
					$('#years_selected').append(elem);
				}
			}
		});

		$('#fuelsSel').change(function (e) {
			e.preventDefault();
			var value = $(this).val();
			if(value != ''){
				if(!$('#f_'+value).length){
					var elem = `
						<li class="list-group-item fuelli" id="f_${value}" style='position:relative;'>
							${value}
							<span style="position:absolute; right:10px;" class="delElem">
								<i class="glyphicon glyphicon-trash manita"></i>
							</span>
						</li>
					`;
					$('#fuels_selected').append(elem);
				}
			}
		});

		$('#vclassSel').change(function (e) {
			e.preventDefault();
			var value = $(this).val();
			if(value != ''){
				if(!$('#c_'+value).length){
					var elem = `
						<li class="list-group-item yearli" id="c_${value}" style='position:relative;'>
							${value}
							<span style="position:absolute; right:10px;" class="delElem">
								<i class="glyphicon glyphicon-trash manita"></i>
							</span>
						</li>
					`;
					$('#vclass_selected').append(elem);
				}
			}
		});

		$('#pollutantSel').change(function (e) {
			e.preventDefault();
			var value = $(this).val();
			if(value != ''){
				if(!$('#p_'+value).length){
					var elem = `
						<li class="list-group-item yearli" id="p_${value}" style='position:relative;'>
							${value}
							<span style="position:absolute; right:10px;" class="delElem">
								<i class="glyphicon glyphicon-trash manita"></i>
							</span>
						</li>
					`;
					$('#pollutants_selected').append(elem);
				}
			}
		});

		$('#years_selected, #fuels_selected, #pollutants_selected, #vclass_selected').on('click', '.delElem', function(event) {
			event.preventDefault();
			$(this).closest('li').remove();
		});

		$("#agregation").change(function (e) {
			var value = $(this).val();

			switch(value){
				case "company":
					$('#fuelsSel').prop('disabled',true);
					break;
				default:
					break;
			}

		});


	});
</script>

<div>
	<div class="row">
		<div class="col-md-4">
			Agregación
			<select id="agregation" class="form-control">
				<option value="">Agregación</option>
				<option value="company">Empresa</option>
				<option value="fleet">Flota</option>
				<option value="fleetFuel">Flota-combustible</option>
				<option value="vclass">Clase</option>
				<option value="vclassFuel">Clase-combustible</option>
			</select>
		</div>
	</div>
	<div class="row" style="margin-top: 10px;">
		<div class="col-md-2">
			<div>Año de datos</div>
			<select id="yearSel" class="form-control">
				<option value="" >Año</option>
				<?php foreach ($years as $y){ ?>
					<option value="<?= $y['year']; ?>"><?= $y['year']; ?></option>
				<?php } ?>
			</select>
			<div style="margin-top:15px;">
				<ul class="list-group" id="years_selected"></ul>
			</div>
		</div>
		<div class="col-md-2">
			<div>Combustible</div>
			<select id="fuelsSel" class="form-control">
				<option value="" >Combustible</option>
				<?php foreach ($fuels as $e){ ?>
					<?php if ($e['code'] == 'biodiesel'){ continue; }?>
					<option value="<?= $e['code']; ?>"><?= $e['name']; ?></option>
				<?php } ?>
			</select>
			<div style="margin-top:15px;">
				<ul class="list-group" id="fuels_selected"></ul>
			</div>
		</div>
		<div class="col-md-2">
			<div>Clase de camión</div>
			<select id="vclassSel" class="form-control">
				<option value="" >Clase</option>
				<?php foreach ($vclass as $e){ ?>
					<option value="<?= $e['code']; ?>"><?= $e['name']; ?></option>
				<?php } ?>
			</select>
			<div style="margin-top:15px;">
				<ul class="list-group" id="vclass_selected"></ul>
			</div>

		</div>
		<!-- <div class="col-md-2">
			<div>Contaminantes</div>
			<select id="pollutantSel" class="form-control">
				<option value="" >Contaminante</option>
				<?php foreach ($pollutants as $e){ ?>
					<option value="<?= $e['code']; ?>"><?= $e['name']; ?></option>
				<?php } ?>
			</select>
			<div style="margin-top:15px;">
				<ul class="list-group" id="pollutants_selected"></ul>
			</div>

		</div> -->
	</div>
</div>
<hr/>
<!-- <div>
	<div class="row">
		<div class="col-md-3">
			<div class="inqTitle">
				Información del socio y Herramienta
			</div>
			<div class="inq_div_label">
				<input type="checkbox" id="companyName" class=" c_checker">
				<label for="companyName" class="inq_label">Nombre de la empresa</label>
			</div>
			<div class="inq_div_label">
				<input type="checkbox" id="workContact" class=" c_checker">
				<label for="workContact" class="inq_label">Contacto de trabajo</label>
			</div>
			<div class="inq_div_label">
				<input type="checkbox" id="executiveContact" class=" c_checker">
				<label for="executiveContact" class="inq_label">Contacto ejecutivo</label>
			</div>
			<div class="inq_div_label">
				<input type="checkbox" id="companyPhone" class=" c_checker">
				<label for="companyPhone" class="inq_label">Teléfono</label>
			</div>
			<div class="inq_div_label">
				<input type="checkbox" id="companyWebsite" class=" c_checker">
				<label for="companyWebsite" class="inq_label">Sitio web</label>
			</div>
		</div>
	</div>
</div> -->