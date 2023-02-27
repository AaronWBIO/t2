<script>
	$gmx(document).ready(function() {
		$('#search').click(function(event) {
			var text = $('#searchText').val();
			load('#companiesList','<?= base_url(); ?>/Administration/companies/list',{text: text})
			// $('#companiesList').load('<?= base_url(); ?>/Administration/companies/list',{text: text});
		});

		$('#searchText').keyup(function(event) {
			if(event.which == 13) {
			    $('#search').trigger('click');
			}
		});
	});
</script>
<div class="card card-primary card-outline">
	<div class="card-header">
		<h5 class="m-0">Empresas registradas</h5>
	</div>

	<div class="card-body">
		<div class="row justify-content-end">
			<div class="col-md-8" style="text-align: right;">
				<input type="text" id="searchText" class="form-control" placeholder="Buscar">
				<br>
			</div>
			<div class="col-md-4" style="text-align: right;">
				<br>
				<br>
				<br>
				<button type="submit" id="search" class="btn btn-primary">
					Buscar
				</button>

			</div>
		</div>
		<div id="companiesList"></div>
	</div>
</div>
