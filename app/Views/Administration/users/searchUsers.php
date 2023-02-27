<script>
	$gmx(document).ready(function() {
		$('#search').click(function(event) {
			var text = $('#searchText').val();
			load('#usersList','<?= base_url(); ?>/Administration/users/list',{text: text})
			// $('#usersList').load('<?= base_url(); ?>/Administration/users/list',{text: text});
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
		<h5 class="m-0">Usuarios registrados</h5>
	</div>

	<div class="card-body">
		<div class="row justify-content-end">
			<div class="col-md-8" style="text-align: right;">
				<input type="text" id="searchText" class="form-control" placeholder="Search">
				<br>
				<button type="submit" id="search" class="btn btn-primary">
					Buscar
				</button>
			</div>
		</div>
		<div id="usersList"></div>
	</div>
</div>
