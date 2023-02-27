<script>
	$(document).ready(function() {

		$('#listDiv').on('click', '.viewCompany', function(event) {
			event.preventDefault();
			var companies_id = $(this).closest('tr').attr('id').split('_')[1];
			console.log(companies_id);
			popUp('<?= base_url(); ?>/Administration/companies/edtForm/' + companies_id);

		});
		
		$('#listDiv').on('click', '.viewContacts', function(event) {
			event.preventDefault();
			var companies_id = $(this).closest('tr').attr('id').split('_')[1];
			console.log(companies_id);
			popUp('<?= base_url(); ?>/Administration/companies/viewContacts/' + companies_id);

		});

		$('#tableList').DataTable({
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
			},
			"paging": true,
			"lengthChange": false,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			// "responsive": true,
			"scrollX": true,
			"language": {
				"search": 'Buscar: ',
				"info": 'Mostrando _START_ a _END_ de _TOTAL_ filas',
				"infoEmpty": 'Mostrando 0 a 0 de 0 filas',
				"paginate": {
					"first": "Primero",
					"last": "'Último'",
					"next": "Siguiente",
					"previous": "Anterior"
				},
			},
		});


	});
</script>

<div style="margin-top: 15px;overflow-x: auto;" id="listDiv">
	<table class="table" id="tableList">
		<thead>
			<tr>
				<!-- <th>ID</th> -->
				<th>Nombre</th>
				<th>RFC</th>
				<th>Tipo</th>
				<th>Estado</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $e) { ?>
				<tr id="trC_<?= $e['id']; ?>">
					<!-- <td><?= $e['id']; ?></td> -->
					<td><?= $e['name']; ?></td>
					<td><?= $e['rfc']; ?></td>
					<td>
						<?php
						switch ($e['type']) {
							case '1':
								echo 'Transportista';
								break;
							case '2':
								echo 'Usuaria de transporte de carga';
								break;

							default:
								# code...
								break;
						}
						?>
					</td>
					<td><?= $e['estadoNombre']; ?></td>
					<td style="text-align: center;">
						<span class="btn btn-sm btn-default viewCompany">
							Editar
						</span>
					</td>
					<td style="text-align: center;">
						<span class="btn btn-sm btn-default viewContacts">
							Ver contactos
						</span>
					</td>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th>Nombre</th>
				<th>Nombre de usuario</th>
				<th>Tipo</th>
				<th>Estado</th>
				<th></th>
				<th></th>
			</tr>
		</tfoot>
	</table>
</div>