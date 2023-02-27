<script>
	$(document).ready(function() {

		$('#listDiv').on('click', '.viewCompany', function(event) {
			event.preventDefault();
			var companies_id = $(this).closest('tr').attr('id').split('_')[1];
			console.log(companies_id);
			popUp('<?= base_url(); ?>/Administration/companies/edtForm/' + companies_id);

		});

		$('#fleets_table').DataTable({
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
			},
			"paging": true,
			// dom: 'Bfrtip',
			// buttons: [
			//     // 'copyHtml5',
			//     // 'excelHtml5',
			//     'csvHtml5',
			//     // 'pdfHtml5'
			// ],

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

<div style="overflow-x:none;">

	<table class="table" id="fleets_table">
		<thead>
			<tr>
				<th>Empresa</th>
				<th>Flota</th>
				<th>Categoria</th>
				<th>Año de medición</th>
				<th>CO2GKM</th>
				<th>NOXGKM</th>
				<th>PM25GKM</th>
				<th>PM10GKM</th>
				<th>CNGKM</th>
				<th>CO2GTonKM</th>
				<th>NOXGTonKM</th>
				<th>PM25GTonKM</th>
				<th>PM10GTonKM</th>
				<th>CNGTonKM'</th>
			</tr>
		</thead>
		<tbody>

			<?php foreach ($fleets as $f) { ?>
				<tr>
					<td><?= $f['comname']; ?></td>
					<td><?= $f['name']; ?></td>
					<td><?= $f['cname']; ?></td>
					<td><?= $f['measure_year']; ?></td>
					<td><?= $f['CO2GKM']; ?></td>
					<td><?= $f['NOXGKM']; ?></td>
					<td><?= $f['PM25GKM']; ?></td>
					<td><?= $f['PM10GKM']; ?></td>
					<td><?= $f['CNGKM']; ?></td>
					<td><?= $f['CO2GTonKM']; ?></td>
					<td><?= $f['NOXGTonKM']; ?></td>
					<td><?= $f['PM25GTonKM']; ?></td>
					<td><?= $f['PM10GTonKM']; ?></td>
					<td><?= $f['CNGTonKM']; ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<div>

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active">
			<a href="#year-charts" aria-controls="year-charts" role="tab" data-toggle="tab">
				Años de medición
			</a>
		</li>
		<li role="presentation">
			<a href="#categories-charts" aria-controls="categories-charts" role="tab" data-toggle="tab">
				Categorías
			</a>
		</li>
		<li role="presentation">
			<a href="#combinado" aria-controls="combinado" role="tab" data-toggle="tab">
				Combinado
			</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="year-charts">
			<?php $data['fleetsYears'] = $fleetsYears; ?>
			<?= view('Administration/inquiries/chartsYears', $data); ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="categories-charts">
			<?php $data['fleetsCats'] = $fleetsCats; ?>
			<?= view('Administration/inquiries/chartsCats', $data); ?>

		</div>
		<div role="tabpanel" class="tab-pane" id="combinado">
			<?php $data['fleetsYearsCats'] = $fleetsYearsCats; ?>
			<?= view('Administration/inquiries/chartsCombinado', $data); ?>
		</div>
	</div>

</div>