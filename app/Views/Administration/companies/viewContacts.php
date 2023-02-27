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

	});
</script>


<div class="modal-header" >
	<div style="text-align: center;">
		<h4 class="modal-title">
			<?php echo 'Contactos'; ?>
		</h4>
	</div>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close" 
		style="color:grey;top:0px;right:0px;position: absolute;">
	  <span aria-hidden="true">&times;</span>
	</button>

</div>
<div class="modal-body" id='pano' style='width:100%;border: none 1px;'>
	<table class="table">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Correo</th>
				<th>Cargo</th>
				<th>Teléfono</th>
				<th>Extensión</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($contacts as $c){ ?>
				<tr>
					<td><?= $c['nombre']; ?></td>
					<td><?= $c['email']; ?></td>
					<td><?= $c['position']; ?></td>
					<td><?= $c['phone']; ?></td>
					<td><?= $c['ext']; ?></td>
				</tr>

			<?php } ?>
		</tbody>	
	</table>
</div>
<div class="modal-footer">
	<div style="text-align: right;">
		<span id="cancel" data-dismiss="modal" class="btn btn-sm btn-danger">Cerrar</span>
	</div>
</div>
