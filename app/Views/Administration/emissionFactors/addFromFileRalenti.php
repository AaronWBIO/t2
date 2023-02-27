<?php  
	include_once APPPATH.'/ThirdParty/j/j.func.php';

	// print2($companies);
?>

<script type="text/javascript">
	var file = '';
	$(document).ready(function() {
		token =  $.parseJSON(jsonFG('<?= base_url(); ?>/general/general/csrfToken/json'));
		var data = {};
		data['prefijo'] = '';
		data[token['csrfName']] = token['csrfHash'];
		subArch(
			$('#uploadFile'),
			'<?= base_url(); ?>/Administration/emissionFactors/uploadFiles',
			data,
			'csv',
			true,
			function(e){
				// console.log(e);
				$('#formErrors').empty();

				var errors = e.errors;
				// console.log(errors);

				if(errors.length > 0){

					var ul = $('<ul>');

					$('<div>').attr({class:'alert alert-danger'}).append(ul).appendTo('#formErrors');
					

				}else{
					$('#uplContent').remove();
					$('#btnRun').show();
					file = e.file;
					// console.log('poner botón de continuar');
				}


			},
			false,
			'Selecciona un archivo',
			"<span style='margin-bottom:20px;'> &nbsp; Arrastra y suelta un archivo</span>",
			extErrorStr = "No se puede cargar. Sólo se aceptan las siguientes extensiones:"
		);

		$('#btnRun').click(function(event) {
			if(file != ''){
				var rj = jsonFA(
					'<?= base_url(); ?>/Administration/EmissionFactors/runFromFileRalenti/'+file,
					{},
					function(rj,data){
						var r = $.parseJSON(rj);
						$('.inpFE').val('');
						for(var i in r){
							$('#'+i).val(r[i]);
						}

					}

				);

				// console.log(rj);

			}
		});


	});
</script>


<div class="modal-header" >
	<div style="text-align: center;">
		<h4 class="modal-title">
			Agregar desde CSV
		</h4>
	</div>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>

</div>
<div class="modal-body" id='pano' style='width:100%;border: none 1px;'>
	<br/>
	<div id="uplContent">
		<!-- <div style="margin-bottom: 10px;">
			<a href="/assets/examples/companiesExample.csv" target="_blank" download>
				<i class="fa fa-ico fa-download"></i>
				Ejemplo
			</a>
		</div> -->
		<div id="uploadFile"></div>
	</div>
	<div class="row">
		<div class="col-12" id="formErrors"></div>
	</div>
	<div id="divBtnRun">
		<span class="btn btn-primary" id="btnRun" data-dismiss="modal" style="display: none;">
			Agregar factores de emisión desde el archivo
		</span>
	</div>
</div>
<div class="modal-footer">
	<div style="text-align: right;">
		<span id="cancel" data-dismiss="modal" class="btn btn-sm btn-primary"><?php echo TR('close'); ?></span>
	</div>
</div>
