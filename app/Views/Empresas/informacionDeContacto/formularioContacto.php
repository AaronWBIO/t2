<?php
include_once APPPATH . '/ThirdParty/j/j.func.php';
?>

<script type="text/javascript">
	$(document).ready(function() {

		$('#curp').blur(function(event) {
			var rj = jsonF('<?= base_url(); ?>/general/general/curp',{curp:$(this).val()});
			var r = $.parseJSON(rj);
			if(r.status == 1){
				$('#name').val(`${r.Nombres} ${r.Apellido1} ${r.Apellido2} `);

			}else{
				alertar('CURP no encontrado');
				$('#name').val('');
				$('#curp').val('');
			}
			
		});

		$('#env').click(function(event) {

			$('#formErrors').empty();
			var dat = $('#nEmp').serializeObject();

			if ($(this).data('action') === 'eliminar') {
				var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/eliminarContacto', dat);

				return window.location = "<?= base_url() ?>/Empresas/Empresa/Contactos"
			}

			var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/guardarContacto', dat);
			console.log(rj);
			var r = $.parseJSON(rj);
			console.log(r);

			if (r.ok == 1) {

				window.location = "<?= base_url() ?>/Empresas/Empresa/Contactos"

			} else if (r.ok == 2) {
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


<div class="modal-header">
	<div style="text-align: center;">
		<h4 class="modal-title">
			<?php echo $accion . ' contacto'; ?>
		</h4>
	</div>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:grey;top:0px;right:0px;position: absolute;">
		<span aria-hidden="true">&times;</span>
	</button>

</div>
<div class="modal-body" id='pano' style='width:100%;border: none 1px;'>
	
	<div class="row">
		<div class="col-12" id="formErrors"></div>
	</div>

	<?= isset($eliminar) && $eliminar ? '<h1>¿Estás seguro de que deseas eliminar el contacto '.$contacto['nombre'] . '?</h1>' : '' ?>
	<!-- <?= isset($contacto['id']) ? $contacto['nombre'] . '</h1>' : '' ?> -->


	<form id="nEmp" class="<?= isset($eliminar) && $eliminar ? 'd-none' : '' ?>">
		<table class="table borderless" border="0">
			<tr>
				<td>CURP<sup>*</sup></td>
				<td colspan="3">
					<input type="text" value="<?= isset($contacto['curp']) ? $contacto['curp'] : '' ?>" name="curp" id="curp" class="form-control oblig">
				</td>
			</tr>
			<tr>
				<td>Nombre<sup>*</sup></td>
				<td colspan="3">
					<?= isset($contacto) ? '<input type="hidden" value="' . $contacto['id'] . '" name="id" id="id" class="form-control oblig">' : '' ?>
					<input type="text" value="<?= isset($contacto['nombre']) ? $contacto['nombre'] : '' ?>" name="nombre" id="name" class="form-control oblig">
				</td>
			</tr>
			<tr>
				<td>
					<span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="tipo_de_contacto"></span>
					Tipo de contacto<sup>*</sup>
				</td>
				<td colspan="3">
					<select name="type" id="type" class="form-control oblig">
						<option value="">- - - Selecciona un tipo de contacto - - -</option>
						<option <?= isset($contacto['type']) && $contacto['type'] == 1 ? 'selected' : ''  ?> value="1">Contacto de trabajo</option>
						<option <?= isset($contacto['type']) && $contacto['type'] == 2 ? 'selected' : ''  ?> value="2">Contacto ejecutivo</option>
						<option <?= isset($contacto['type']) && $contacto['type'] == 3 ? 'selected' : ''  ?> value="3">Contacto de sostenibilidad</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Cargo<sup>*</sup></td>
				<td colspan="3">
					<input type="text" value="<?= isset($contacto['position']) ? $contacto['position'] : '' ?>" name="position" id="position" class="form-control oblig">
				</td>
			</tr>
			<tr>
				<td>Correo electrónico<sup>*</sup></td>
				<td colspan="3">
					<input type="text" value="<?= isset($contacto['email']) ? $contacto['email'] : '' ?>" name="email" id="email" class="form-control oblig">
				</td>
			</tr>
			<tr>
				<td>Teléfono<sup>*</sup></td>
				<td>
					<input type="text" value="<?= isset($contacto['phone']) ? $contacto['phone'] : '' ?>" name="phone" id="phone" class="form-control oblig">
				</td>
				<td>Ext</td>
				<td>
					<input type="text" value="<?= isset($contacto['ext']) ? $contacto['ext'] : '' ?>" name="ext" id="ext" class="form-control oblig">
				</td>
			</tr>
			<tr>
				<td>Teléfono</td>
				<td>
					<input type="text" value="<?= isset($contacto['phone2']) ? $contacto['phone2'] : '' ?>" name="phone2" id="phone2" class="form-control oblig">
				</td>
				<td>Ext</td>
				<td>
					<input type="text" value="<?= isset($contacto['ext2']) ? $contacto['ext2'] : '' ?>" name="ext2" id="ext2" class="form-control oblig">
				</td>
			</tr>
		</table>
		<?= csrf_field() ?>
		<span style="font-size: .7em;">* Campos obligatorios</span>	
	</form>
</div>
<div class="modal-footer">
	<div style="text-align: right;">
		<span id="cancel" data-dismiss="modal" class="btn btn-sm btn-danger">Cancelar</span>
		<span id="env" class="btn btn-sm btn-primary" data-action='<?= isset($eliminar) && $eliminar ? 'eliminar' : '' ?>'>Guardar</span>
	</div>
</div>