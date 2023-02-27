<script>
	$(document).ready(function() {

		$('#listDiv').on('click', '.validFleet', function(event) {
			event.preventDefault();
			var companies_id = $(this).closest('tr').attr('id').split('_')[1];
			var brands_id = $(this).closest('tr').attr('id').split('_')[2];

			window.location = `<?= base_url() ?>/Administration/UsersValidations/brandsTransportistas/${companies_id}/${brands_id}`;

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


<div id="listDiv">

	<table class="table" id="tableList">
		<thead>
			<tr>
				<th>Empresa</th>
				<th>Compañia</th>
				<th>Validar</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($fleets as $f) { ?>
				<tr id="fleet_<?= $f['cid']; ?>_<?= $f['id']; ?>">
					<td><?= $f['cname']; ?></td>
					<td><?= $f['name']; ?></td>
					<td>
						<span class="btn btn-sm btn-primary validFleet">Validar información</span>
					</td>
				</tr>
			<?php } ?>

		</tbody>
	</table>

</div>