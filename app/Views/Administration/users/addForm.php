<?php  
	include_once APPPATH.'/ThirdParty/j/j.func.php';
?>

<script type="text/javascript">
	$(document).ready(function() {

		$('#env').click(function(event) {
			$('#formErrors').empty();
			var dat = $('#nEmp').serializeObject();
			dat['globalUsers'] = $('#globalUsers').is(':checked')?1:0;

			var rj = jsonF('<?= base_url(); ?>/Administration/users/add',dat);
			var r = $.parseJSON(rj);

			if(r.ok == 1){
				$('#popUp').modal('toggle');

				load('#usersList','<?= base_url(); ?>/Administration/users/list',{text: dat['username']});
				
			}else if(r.ok == 2){
				var html = `
					<div class="alert alert-danger" role="alert">
						${r.err}
					</div>
				`;
				$('#formErrors').append(html);
			}

		});

		$('#ID_EMPLEADO').blur(function(event) {
			var rj = jsonF('<?= base_url(); ?>/general/general/employee_id',{employee_id:$(this).val()});
			var r = $.parseJSON(rj);
			if(r.status == 1){
				$('#name').val(`${r.NOMBRE} ${r.APELLIDO_1} ${r.APELLIDO_2} `);
				$('#email').val(`${r.CORREO}`);

				$('#ID_C_U_R_P_ST').text(`${r.ID_C_U_R_P_ST}`);
				$('#ID_UNIDAD_ADMIN').text(`${r.ID_UNIDAD_ADMIN}`);
				$('#DESCRIPCION').text(`${r.DESCRIPCION}`);
				$('#ESTATUS').text(`${r.ESTATUS}`);
				$('#DESCRIP').text(`${r.DESCRIP}`);

			}else{
				alertar('ID EMPLEADO no encontrado');
				$('#name').val('');
				$('#email').val('');
				$('#ID_EMPLEADO').val('');

				$('#ID_C_U_R_P_ST').text('');
				$('#ID_UNIDAD_ADMIN').text('');
				$('#DESCRIPCION').text('');
				$('#ESTATUS').text('');
				$('#DESCRIP').text('');
			}
			
		});


	});
</script>


<div class="modal-header" >
	<div style="text-align: center;">
		<h4 class="modal-title">
			<?php echo 'Agregar usuario'; ?>
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
				<td>ID EMPLEADO<sup>*</sup></td>
				<td>
					<input type="text" value="" name="ID_EMPLEADO" id="ID_EMPLEADO" class="form-control oblig">
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Nombre<sup>*</sup></td>
				<td>
					<input type="text" value="" name="name" id="name" class="form-control oblig">
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Nombre de usuario<sup>*</sup></td>
				<td>
					<input type="text" value="" name="username" id="username" class="form-control oblig" >
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Correo electrónico<sup>*</sup></td>
				<td>
					<input type="text" value="" 
						name="email" id="email" class="form-control oblig">
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Contraseña<sup>*</sup></td>
				<td>
					<input type="password" value="" name="password" id="password" class="form-control oblig" >
				</td>
				<td></td>
			</tr>
			<tr>
				<td>CURP<sup>*</sup></td>
				<td>
					<span id="ID_C_U_R_P_ST"></span>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>ID UNIDAD ADMINISTRATIVA</td>
				<td>
					<span id="ID_UNIDAD_ADMIN"></span>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Descripción</td>
				<td>
					<span id="DESCRIPCION"></span>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Estatus</td>
				<td>
					<span id="ESTATUS"></span>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Descripción</td>
				<td>
					<span id="DESCRIP"></span>
				</td>
				<td></td>
			</tr>
		</table>
	</form>
	<span style="font-size: .7em;">* Campos obligatorios</span>
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
