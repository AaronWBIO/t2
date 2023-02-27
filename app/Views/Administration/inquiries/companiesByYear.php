<script>
	$(document).ready(function() {
		$('.checkyear').click(function (e) {
			e.preventDefault();
			var id = $(this).closest('td').attr('id');
			var year = id.split('_')[0];
			var companies_id = id.split('_')[1];
			// console.log(companies_id,year);

			$('#modalImg').width('95%');
			popUpImg('<?= base_url(); ?>/Administration/Inquiries/showResults',{companies_id:companies_id,year:year});

		});
	});
</script>

<?php if ($csv == 0){ ?>
	<div style="margin-top:20px;">
		<div style="text-align:right;">
			<a class="btn btn-sm btn-primary" target="_blank" 
				href="<?= base_url(); ?>/Administration/Inquiries/companiesByYear/1">
			Descargar CSV
			</a>
		</div>
		<table class="table">
			<thead>
				<tr style="vertical-align:top;">
					<th rowspan="2" width="65%">Razón social</th>
					<th colspan="<?= count($years); ?>" style="text-align:center;">Año que ha reportado a la SEMARNAT</th>
				</tr>
				<tr>
					<?php foreach ($years as $y => $yr){ ?>
						<th style="text-align:center;">
							<?= $y; ?>
						</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($companies as $c){ ?>
					<tr>
						<td><?= $c['cname']; ?></td>	
						<?php foreach ($years as $y => $yr){ ?>
							<td style="text-align:center;" id="<?= $y."_$c[cid]"; ?>">
								<?php if (!empty($c['years'][$y])){ ?>
									<i class="glyphicon glyphicon-ok manita checkyear"></i>
								<?php } ?>
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<form action="<?= base_url(); ?>/Administration/Inquiries/showResults" target="_blank" id="formInq">
			<input type="hidden" name="measure_year" id="formInq_measure_year"/>
			<input type="hidden" name="companies_id" id="formInq_companies_id"/>
		</form>
	</div>
<?php }else{
	header('Content-Type: text/html; charset=utf-8'); 
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=Empresas que han reportado.csv");


	$csv = '';
	// $csv = '"","año que ha reportado a SEMARNAT"'."\n";
	$csv .= '"Razón social"';
	foreach ($years as $y => $yr) {
		$csv .= ',"'.$y.'"';
	}
	$csv .= "\n";

	
	foreach ($companies as $c){
		$csv .= '"'.$c['cname'].'"';
		foreach ($years as $y => $yr){
			if (!empty($c['years'][$y])){
				$csv .= ',"X"';
			}else{
				$csv .= ',""';
			}
		}
		$csv .= "\n";
	}
	echo $csv;

} ?>