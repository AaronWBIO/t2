<script>
	$(document).ready(function() {
		// $('#year-sel').change(function (e) {
		// 	e.preventDefault();
		// 	var year = $(this).val();
		// 	if(year != ''){
		// 		if(!$('#y_'+year).length){
		// 			var elem = `
		// 				<li class="list-group-item yearli" id="y_${year}" style='position:relative;'>
		// 					${year}
		// 					<span style="position:absolute; right:10px;" class="delElem">
		// 						<i class="glyphicon glyphicon-trash manita"></i>
		// 					</span>
		// 				</li>
		// 			`;
		// 			$('#years_selected').append(elem);
		// 		}
		// 	}
		// });

		// $('#categories-sel').change(function (e) {
		// 	e.preventDefault();
		// 	var categories_id = $(this).val();
		// 	var categories_name = $( "#categories-sel option:selected" ).text();
		// 	if(categories_id != ''){
		// 		if(!$('#cat_'+categories_id).length){
		// 			var elem = `
		// 				<li class="list-group-item catli" id="cat_${categories_id}" style='position:relative;'>
		// 					${categories_name}
		// 					<span style="position:absolute; right:10px;" class="delElem">
		// 						<i class="glyphicon glyphicon-trash manita"></i>
		// 					</span>
		// 				</li>
		// 			`;
		// 			$('#categories_selected').append(elem);
		// 		}
		// 	}
		// });

		// $('#years_selected, #categories_selected').on('click', '.delElem', function(event) {
		// 	event.preventDefault();
		// 	$(this).closest('li').remove();
		// });

		$('#sendAnalysis').click(function (e) {
			e.preventDefault();
			var measure_year = $('#year-sel').val();
			$('#measure_year').val(measure_year);
			// console.log(measure_year);
			// var categories = [];
			if(measure_year != ''){
				$('#formResults').submit();
			}

			// $.each($('.yearli'), function(index, val) {
			// 	years.push(this.id.split('_')[1]);
			// });
			// $.each($('.catli'), function(index, val) {
			// 	categories.push(this.id.split('_')[1]);
			// });

			// var data = {};
			// data['years'] = years;
			// data['categories'] = categories;

			// load('#results','<?= base_url(); ?>/Empresas/Inquiries/results',data);
		});

	});
</script>
<div>
	<div class="row">
		<div class="col-md-4">
			<div>Selecciona año para analizar</div>
			<select name="year-sel" id="year-sel" class="form-control">
				<option value="">Selecciona un año</option>
				<?php foreach ($fleetYears as $y){ ?>
					<option value="<?= $y['measure_year']; ?>" >
						<?= $y['measure_year']; ?>
					</option>
				<?php } ?>
			</select>
			<br>
			<div>
				<ul class="list-group" id="years_selected"></ul>
			</div>
		</div>
		<div class="col-md-4">
			<br/>
			<span class="btn btn-sm btn-primary" id="sendAnalysis">Analizar</span>
		</div>
	</div>
</div>
<?php if (session()->get('type') == 1){ ?>
	<form action="<?= base_url();?>/Empresas/empresa/showResults" id="formResults" method="post">
		<input type="hidden" id="measure_year" name="measure_year">
		<?= csrf_field() ?>
	</form>
<?php }elseif (session()->get('type') == 2){ ?>
	<form action="<?= base_url();?>/Empresas/empresa/showResultsU" id="formResults" method="post">
		<input type="hidden" id="measure_year" name="measure_year">
		<?= csrf_field() ?>
	</form>
<?php } ?>


