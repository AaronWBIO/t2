<script>
	$(document).ready(function() {
		$('#companies-by-year').click(function (e) {
			e.preventDefault();
			load('#results','<?= base_url(); ?>/Administration/Inquiries/companiesByYear');
		});
		$('#class-metrics').click(function (e) {
			e.preventDefault();
			var measure_year = $('#year-sel').val();
			load('#results','<?= base_url(); ?>/Administration/Inquiries/metrics/html/class/'+measure_year);
		});
		$('#fuel-metrics').click(function (e) {
			e.preventDefault();
			var measure_year = $('#year-sel').val();
			load('#results','<?= base_url(); ?>/Administration/Inquiries/metrics/html/fuels/'+measure_year);
		});
		$('#cat-metrics').click(function (e) {
			e.preventDefault();
			var measure_year = $('#year-sel').val();
			load('#results','<?= base_url(); ?>/Administration/Inquiries/metrics/html/categories/'+measure_year);
		});
		$('#class-fuel-metrics').click(function (e) {
			e.preventDefault();
			var measure_year = $('#year-sel').val();
			load('#results','<?= base_url(); ?>/Administration/Inquiries/metrics/html/class_fuels/'+measure_year);
		});
		$('#completeDwd').click(function (e) {
			e.preventDefault();
			var measure_year = $('#year-sel').val();
			load('#results','<?= base_url(); ?>/Administration/Inquiries/metrics/html/all/'+measure_year);
		});
	});
</script>

<div>
	
	<div class="row">
		<div class="col-md-12">
			<span class="btn btn-sm btn-primary" id="companies-by-year">Empresas adheridas por año</span>
		</div>
	</div>
	<div class="row" style="margin-top:15px;">
		<div class="col-md-2">
			<select id="year-sel" class="form-control">
				<?php foreach ($fleetYears as $y){ ?>
					<option value="<?= $y['year']; ?>"><?= $y['year']; ?></option>
				<?php } ?>
				<?php if (empty($fleetYears)){ ?>
					<option value=""><?= date('Y'); ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-10">
			<span class="btn btn-sm btn-primary" id="class-metrics">Por clase</span>
			<span class="btn btn-sm btn-primary" id="fuel-metrics">Por combustible</span>
			<span class="btn btn-sm btn-primary" id="cat-metrics">Por categoría</span>
			<span class="btn btn-sm btn-primary" id="class-fuel-metrics">Por clase-combustible</span>
			<span class="btn btn-sm btn-primary" id="completeDwd">Toda la información</span>
		</div>
		<!-- <div class="col-md-4">
		</div> -->
	</div>


</div>

<div id="results" style="margin-top:20px;"></div>