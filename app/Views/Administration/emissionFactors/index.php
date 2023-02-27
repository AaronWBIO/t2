<script>
	jQuery(document).ready(function($) {
		$('#edtFE').click(function (e) {
			e.preventDefault();
			measure_year = $('#measure_year').val();
			pollutants_code = $('#pollutants_code').val();
			fuels_code = $('#fuels_code').val();
			// console.log(measure_year);
			if(pollutants_code == 'CO2'){

				load('#emissionFactorsContent','<?= base_url(); ?>/administration/emissionFactors/list/'+
					measure_year+'/'+pollutants_code+'/'+fuels_code+'/0');
			}else{
				alertar('Este tipo de contaminante no cuenta con factores de emisión fijos')
			}
		});

		$('#edtFERC').click(function (e) {
			e.preventDefault();
			measure_year = $('#measure_year').val();
			pollutants_code = $('#pollutants_code').val();
			fuels_code = $('#fuels_code').val();
			// console.log(measure_year);
			if(pollutants_code != 'CO2'){
				load('#emissionFactorsContent','<?= base_url(); ?>/administration/emissionFactors/list/'+
					measure_year+'/'+pollutants_code+'/'+fuels_code+'/1');
			}else{
				alertar('Este tipo de contaminante no cuenta con factores de emisión en ralenti')
			}
		});

		$('#edtFERL').click(function (e) {
			e.preventDefault();
			measure_year = $('#measure_year').val();
			pollutants_code = $('#pollutants_code').val();
			fuels_code = $('#fuels_code').val();
			// console.log(measure_year);
			if(pollutants_code != 'CO2'){
				load('#emissionFactorsContent','<?= base_url(); ?>/administration/emissionFactors/list/'+
					measure_year+'/'+pollutants_code+'/'+fuels_code+'/2');
			}else{
				alertar('Este tipo de contaminante no cuenta con factores de emisión en ralenti')
			}

		});

		$('#edtFERV').click(function (e) {
			e.preventDefault();
			measure_year = $('#measure_year').val();
			pollutants_code = $('#pollutants_code').val();
			fuels_code = $('#fuels_code').val();
			// console.log(measure_year);
			
			// if(fuels_code == 'diesel' || fuels_code == 'gasolina'){
				if(pollutants_code != 'CO2'){
					load('#emissionFactorsContent','<?= base_url(); ?>/administration/emissionFactors/list/'+
						measure_year+'/'+pollutants_code+'/'+fuels_code+'/3');
				}else{
					alertar('Este tipo de contaminante no cuenta con factores de emisión por velocidad')
				}

				

			// }else{
			// 	alertar('Este tipo de combustible no cuenta con factores de emisión por velocidad');
			// }
		});
	});
</script>

<div class="row">
	<div class="col-md-2" style="">
		<select class="form-control" id="measure_year">
			<?php foreach ($years as $y){ ?>
				<option value="<?= $y; ?>"><?= $y; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-2" style="">
		<select class="form-control" id="pollutants_code">
			<?php foreach ($pollutants as $p){ ?>
				<option value="<?= $p['code']; ?>"><?= $p['name'] ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-2" style="">
		<select class="form-control" id="fuels_code">
			<?php foreach ($fuels as $f){ ?>
				<option value="<?= $f['code']; ?>"><?= $f['name'] ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-6">
		<span class="btn btn-sm btn-primary" style="margin: 5px;" id="edtFE">Factores de emisión</span>
		<span class="btn btn-sm btn-primary" style="margin: 5px;" id="edtFERC">Factores de emisión ralentí CD</span>
		<span class="btn btn-sm btn-primary" style="margin: 5px;" id="edtFERL">Factores de emisión ralentí LD</span>
		<span class="btn btn-sm btn-primary" style="margin: 5px;" id="edtFERV">Factores de emisión rangos de velocidad</span>
	</div>
</div>
<div id="emissionFactorsContent"></div>