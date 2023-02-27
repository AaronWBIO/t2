<script>
	$(document).ready(function() {

		$('#listDiv').on('click', '.viewUser', function(event) {
			event.preventDefault();
			var users_id = $(this).closest('tr').attr('id').split('_')[1];
			console.log(users_id);
			popUp('<?= base_url(); ?>/Administration/users/edtForm/' + users_id);

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
				<th>ID EMPLEADO</th>
				<th>Nombre de usuario</th>
				<th>Nombre</th>
				<th>Correo electrónico</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $e) { ?>
				<tr id="trC_<?= $e['id']; ?>">
					<td><?= $e['ID_EMPLEADO']; ?></td>
					<td><?= $e['username']; ?></td>
					<td><?= $e['name']; ?></td>
					<td><?= $e['email']; ?></td>
					<td style="text-align: center;">
						<span class="btn btn-sm btn-default viewUser">
							Editar
						</span>
					</td>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th>ID EMPLEADO</th>
				<th>Nombre de usuario</th>
				<th>Nombre</th>
				<th>Correo electrónico</th>
				<th></th>
			</tr>
		</tfoot>
	</table>
</div>