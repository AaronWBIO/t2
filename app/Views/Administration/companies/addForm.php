<?php  
	include_once APPPATH.'/ThirdParty/j/j.func.php';
?>

<script type="text/javascript">
	$(document).ready(function() {

		$('#env').click(function(event) {
			$('#formErrors').empty();
			var dat = $('#nEmp').serializeObject();
			dat['globalUsers'] = $('#globalUsers').is(':checked')?1:0;

			var rj = jsonF('<?= base_url(); ?>/Administration/companies/add',dat);
			// console.log(rj);
			var r = $.parseJSON(rj);
			// console.log(r);

			if(r.ok == 1){
				$('#popUp').modal('toggle');

				load('#companiesList','<?= base_url(); ?>/Administration/companies/list',{text: dat['rfc']});
				
			}else if(r.ok == 2){
				var html = `
					<div class="alert alert-danger" role="alert">
						${r.err}
					</div>
				`;
				$('#formErrors').append(html);
			}

		});

		$('#estado').change(function(event) {
			var estados_id = $(this).val();
			rj = jsonFG('<?= base_url(); ?>/general/general/getMunicipios/'+estados_id);
			var r = $.parseJSON(rj);
			optsSel(r,$('#municipio'),false,'- - - Selecciona un municipio - - -',false)
		});

		soloNumeros($('#phone'));
		soloNumeros($('#zipCode'));

		$('#pwdGen').click(function (e) {
			e.preventDefault();
			var rj = jsonF('<?= base_url(); ?>/Administration/Companies/pwdGenerator')
			var r = $.parseJSON(rj);
			$('#password').val(r.pwd);
		});

	});
</script>


<div class="modal-header" >
	<div style="text-align: center;">
		<h4 class="modal-title">
			<?php echo 'Agregar empresa'; ?>
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
				<td>Nombre<sup>*</sup></td>
				<td>
					<input type="text" value="" name="name" id="name" class="form-control oblig">
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Tipo<sup>*</sup></td>
				<td>
					<select name="type" id="type" class="form-control">
						<option value="">- - - Selecciona un tipo de empresa - - -</option>
						<option value="1">Transportista</option>
						<option value="2">Usuaria de transporte de carga</option>
					</select>
				</td>
				<td></td>
			</tr>

			<tr>
				<td>RFC<sup>*</sup></td>
				<td>
					<input type="text" value="" name="rfc" id="rfc" class="form-control oblig" >
				</td>
				<td></td>
			</tr>
			<!-- <tr>
				<td>Nombre de usuario</td>
				<td>
					<input type="text" value="" name="username" id="username" class="form-control oblig" >
				</td>
				<td></td>
			</tr> -->
			<tr>
				<td>Contraseña<sup>*</sup></td>
				<td>
					<input type="text" value="" name="password" id="password" class="form-control oblig" >
				</td>
				<td>
					<div style="padding-top:7px;">
						
						<span class="btb btn-sm btn-primary" id="pwdGen" >Generar</span>
					</div>
				</td>
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
				<td>Dirección web</td>
				<td>
					<input type="text" value="" 
						name="website" id="website" class="form-control oblig">
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Dirección</td>
				<td>
					<input type="text" value="" 
						name="direccion" id="direccion" class="form-control oblig">
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Estado</td>
				<td>
					<select name="estado" id="estado" class="form-control">
						<option value="">- - - Selecciona un estado - - -</option>
						<?php foreach ($estados as $e){ ?>
							<option value="<?= $e['id']; ?>"><?= $e['nombre']; ?></option>
						<?php } ?>
					</select>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Municipio</td>
				<td>
					<select name="municipio" id="municipio" class="form-control">
						<option value="">- - - Selecciona un municipio - - -</option>
					</select>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Código Postal</td>
				<td>
					<input type="text" value="" 
						name="cp" id="cp" class="form-control oblig">
				</td>
				<td></td>
			</tr>
			<!-- <tr>
				<td>Teléfono</td>
				<td>
					<input type="text" value="" 
						name="phone" id="phone" class="form-control oblig">
				</td>
				<td></td>
			</tr> -->
		</table>
		<?= csrf_field() ?>		
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
