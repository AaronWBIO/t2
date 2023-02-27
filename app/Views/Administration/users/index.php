<?php

	use App\Libraries\GeneralLibrary;
	$general = new GeneralLibrary();
	// $aa = $general->csrfToken(true);
	// echo $aa;
?>
<script>
	$gmx(document).ready(function() {

		$('#addCompany').click(function(event) {
			popUp('<?= base_url(); ?>/Administration/users/addForm',{});

		});

	});
</script>

<div class="row">
	<div class="col-md-12" style="">
		<div class="card card-primary card-outline">
			<div class="card-body">
				<div style="text-align: right;margin:10px 0px;">
					<span class="btn btn-primary btn-sm corpHide" id="addCompany">
						<i class="glyphicon glyphicon-plus"></i>
						Agregar usuario
					</span>
					
				</div>
			</div>
		</div>
		<div id="searchContent">
			<?= view_cell('\App\Libraries\Users::search') ?>
		</div>
	</div>
</div>