<script>
	$(document).ready(function() {
		$('#year-sel').change(function (e) {
			e.preventDefault();
			var year = $(this).val();
			if(year != ''){
				if(!$('#y_'+year).length){
					var elem = `
						<li class="list-group-item yearli" id="y_${year}" style='position:relative;'>
							${year}
							<span style="position:absolute; right:10px;" class="delElem">
								<i class="glyphicon glyphicon-trash manita"></i>
							</span>
						</li>
					`;
					$('#years_selected').append(elem);
				}
			}
		});

		$('#categories-sel').change(function (e) {
			e.preventDefault();
			var categories_id = $(this).val();
			var categories_name = $( "#categories-sel option:selected" ).text();
			if(categories_id != ''){
				if(!$('#cat_'+categories_id).length){
					var elem = `
						<li class="list-group-item catli" id="cat_${categories_id}" style='position:relative;'>
							${categories_name}
							<span style="position:absolute; right:10px;" class="delElem">
								<i class="glyphicon glyphicon-trash manita"></i>
							</span>
						</li>
					`;
					$('#categories_selected').append(elem);
				}
			}
		});

		$('#years_selected, #categories_selected').on('click', '.delElem', function(event) {
			event.preventDefault();
			$(this).closest('li').remove();
		});

		$('#sendAnalysis').click(function (e) {
			e.preventDefault();
			var years = [];
			var categories = [];

			$.each($('.yearli'), function(index, val) {
				years.push(this.id.split('_')[1]);
			});
			$.each($('.catli'), function(index, val) {
				categories.push(this.id.split('_')[1]);
			});

			var data = {};
			data['years'] = years;
			data['categories'] = categories;

			load('#results','<?= base_url(); ?>/Administration/Inquiries/results',data);
		});
	});
</script>
<div>
	<div class="row">
		<div class="col-md-4">
			<div>Selecciona años para analizar</div>
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
			<div>Selecciona categorias para analizar</div>
			<select name="categories-sel" id="categories-sel" class="form-control">
				<option value="">Selecciona una categoría</option>
				<?php foreach ($categories as $c){ ?>
					<option value="<?= $c['id']; ?>" >
						<?= $c['name']; ?>
					</option>
				<?php } ?>
			</select>
			<br>
			<div>
				<ul class="list-group" id="categories_selected"></ul>
			</div>
		</div>
		<div class="col-md-4">
			<br/>
			<span class="btn btn-sm btn-primary" id="sendAnalysis">Analizar</span>
		</div>
	</div>
</div>

<div id="results">
	

</div>



