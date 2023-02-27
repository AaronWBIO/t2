<?php  
	include_once APPPATH.'/ThirdParty/j/j.func.php';
?>

<script type="text/javascript">
	$(document).ready(function() {


		$('#env').click(function(event) {
			$('#formErrors').empty();
			var dat = $('#nEmp').serializeObject();

			var rj = jsonF('<?= base_url(); ?>/Administration/NoPTL/add',dat);
			// console.log(rj);
			var r = $.parseJSON(rj);
			// console.log(r);

			if(r.ok == 1){
				$('#popUp').modal('toggle');
				var o = new Option(dat.name,r.nId);

				$("#flotas_id").append(o).val(r.nId).trigger('change');

				// load('#companiesList','<?= base_url(); ?>/Administration/companies/list',{text: dat['rfc']});
				
			}else if(r.ok == 2){
				var html = `
					<div class="alert alert-danger" role="alert">
						${r.err}
					</div>
				`;
				$('#formErrors').append(html);
			}

		});


	});
</script>


<div class="modal-header" >
	<div style="text-align: center;">
		<h4 class="modal-title">
			<?php echo 'Agregar flota'; ?>
		</h4>
	</div>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close" 
		style="color:grey;top:0px;right:0px;position: absolute;">
	  <span aria-hidden="true">&times;</span>
	</button>

</div>
<div class="modal-body" id='pano' style='width:100%;border: none 1px;'>
	<br/>
	<form id="nEmp">
		<table class="table borderless" border="0">
			<tr>
				<td>Nombre</td>
				<td>
					<input type="text" value="" name="name" id="name" class="form-control oblig">
				</td>
				<td></td>
			</tr>
		</table>
		<?= csrf_field() ?>		
	</form>
	<div class="row">
		<div class="col-12" id="formErrors"></div>
	</div>

</div>
<div class="modal-footer">
	<div style="text-align: right;">
		<span id="cancel" data-dismiss="modal" class="btn btn-sm btn-danger">Cancelar</span>
		<span id="env" class="btn btn-sm btn-primary">Enviar</span>
	</div>
</div>
