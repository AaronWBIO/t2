<?php

	use App\Libraries\GeneralLibrary;
	$general = new GeneralLibrary();
	// $aa = $general->csrfToken(true);
	// echo $aa;
?>
<script>
	$gmx(document).ready(function() {
		var view = 'companies';


		$('#addCompany').click(function(event) {
			popUp('<?= base_url(); ?>/Administration/companies/addForm',{});
			setTimeout(function(){ 
				token =  $.parseJSON(jsonFG('<?= base_url(); ?>/general/general/csrfToken/json')); 
			}, 1000);

		});


		// console.log('aaa',data);

	});
</script>

<div class="row">
	<div class="col-md-12" style="">
		<div class="card card-primary card-outline">
			<div class="card-body">
				<div style="text-align: right;margin:10px 0px;">
					<span class="btn btn-primary btn-sm corpHide" id="addCompany">
						<i class="glyphicon glyphicon-plus"></i>
						Agregar empresa
					</span>
					<a href="<?= base_url(); ?>/administration/Companies/dwlCopanies" target="_blank" class="btn btn-primary btn-sm">
						Descargar CSV
					</a>					
				</div>
			</div>
		</div>
		<div id="searchContent">
			<?= view_cell('\App\Libraries\Companies::search') ?>
		</div>
	</div>
</div>