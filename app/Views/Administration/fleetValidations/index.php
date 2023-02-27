<script>
	$(document).ready(function() {

		$('#listDiv').on('click', '.validFleet', function(event) {
			event.preventDefault();
			var fleets_id = $(this).closest('tr').attr('id').split('_')[2];
			var companies_id = $(this).closest('tr').attr('id').split('_')[1];

			window.location = `<?= base_url() ?>/Administration/FleetValidations/informacionGeneral/${companies_id}/${fleets_id}`;

		});

		$('#listDiv').on('click', '.viewValids', function(event) {
			event.preventDefault();
			var fleets_id = $(this).closest('tr').attr('id').split('_')[2];
			var companies_id = $(this).closest('tr').attr('id').split('_')[1];
			// var json = $(this).attr('json');


			var json = jsonF('<?= base_url() ?>/Administration/FleetValidations/getValidValues/'+fleets_id);
			// console.log(json);

			var valids = $.parseJSON(json);

			console.log(valids);
			html = `
				<table class="table">
				<thead>
					<tr>
						<th>Combustible</th>
						<th>Clase</th>
						<th>Campo</th>
						<th>Valor</th>
					</tr>
				</thead>
			`;
			for (var fuel in valids) {
				for (var vclass in valids[fuel]) {
					for (var field in valids[fuel][vclass]) {
						if (valids[fuel][vclass][field] != 0) {
							html += `
								<tr>
									<td>${fuel}</td>
									<td>${vclass}</td>
									<td>${fieldname(field)}</td>
									<td>${valids[fuel][vclass][field]}</td>
								</tr>

							`
						} 
						// else if (valids[fuel][vclass][field] == 2) {
						// 	html += `
						// 		<tr>
						// 			<td>${fuel}</td>
						// 			<td>${vclass}</td>
						// 			<td>${fieldname(field)}</td>
						// 			<td>Rojo</td>
						// 		</tr>

						// 	`
						// } 
						// else if (valids[fuel][vclass][field] == 3) {
						// 	html += `
						// 		<tr>
						// 			<td>${fuel}</td>
						// 			<td>${vclass}</td>
						// 			<td>${fieldname(field)}</td>
						// 			<td>Fuera de rango</td>
						// 		</tr>

						// 	`
						// }
					}
				}
			}
			html += '</table>';
			alertar(html);
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

	function fieldname(field) {
		switch (field) {
			case 'km/l':
				return 'kilómetros por litro';
			case 'km_empty':
				return 'kilómetros en vacío';
			case 'km_tot':
				return 'kilómetros Totales';
			case 'load_volume':
				return 'kilómetros volumen promedio';
			case 'payload_avg':
				return 'Carga util promedio';
			case 'ralenti':
				return 'Ralentí';
			case 'ralenti_days':
				return 'Número promedio de días en carretera al año';
			case 'ralenti_hours_large':
				return 'Horras en ralentí de duración larga'; 
			case 'ralenti_hours_short':
				return 'Horras en ralentí de duración corta'; 

		}
	}
</script>


<div id="listDiv">

	<table class="table" id="tableList">
		<thead>
			<tr>
				<th>Empresa</th>
				<th>Flota</th>
				<th>Alertas de validación</th>
				<th>Validar</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($fleets as $f) { ?>
				<tr id="fleet_<?= $f['cid']; ?>_<?= $f['id']; ?>">
					<td><?= $f['cname']; ?></td>
					<td><?= $f['name']; ?></td>
					<td>
						<?php
						$a = 0;
						$aa = array();
						$b = 0;
						$ba = array();
						$c = 0;
						$ca = array();
						$tot = 0;
						$valids = json_decode($f['json'], true);
						foreach ($valids as $fuel => $clases) {
							foreach ($clases as $clase => $val) {
								foreach ($val as $field => $value) {
									if ($value == 1) {
										$a++;
										$aa[$fuel][$clase][$field] = $value;
									} elseif ($value == 2) {
										$b++;
										$ba[$fuel][$clase][$field] = $value;
									} elseif ($value == 3) {
										// print2($value);
										$c++;
										$ca[$fuel][$clase][$field] = $value;
									}
								}

								$tot = $a + $b + $c;
							}
						}
						?>
						<?php if ($tot != 0) { ?>
							<span class="manita viewValids" json='<?= $f['json']; ?>'> <?= $tot; ?></span>
						<?php } else { ?>
							<span class=""> <?= $tot; ?></span>
						<?php } ?>

					</td>
					<td>
						<span class="btn btn-sm btn-primary validFleet">Validar información</span>
					</td>
				</tr>
			<?php } ?>

		</tbody>
	</table>

</div>