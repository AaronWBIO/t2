<script>
	$(document).ready(function() {
		$('#generateReport').click(function (e) {
			e.preventDefault();

			var year = $('#year-sel').val();
			load('#report_content','<?= base_url(); ?>/Empresas/Inquiries/report/'+year);

		});
	});
</script>

<div>
	<div class="row">
		<div class="col-md-4">
			<select name="year-sel" id="year-sel" class="form-control">
				<?php foreach ($years as $y){ ?>
					<option value="<?= $y['year']; ?>"><?= $y['year']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-4">
			<span class="btn btn-sm btn-primary" id="generateReport">Ver mis métricas</span>
		</div>
	</div>
</div>

<div id="report_content">
	
</div>