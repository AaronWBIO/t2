
<div style="margin-top:30px;">
	<h2>
		Reporte del año <?= $measure_year; ?>
	</h2>

	<h3>Flotas</h3>

	<table class="table">
		<thead>
			<tr>
				<th>Flota</th>
				<td>CO2GKM</td>
				<td>NOXGKM</td>
				<td>PM25GKM</td>
				<td>PM10GKM</td>
				<td>CNGKM</td>
				<td>CO2GTonKM</td>
				<td>NOXGTonKM</td>
				<td>PM25GTonKM</td>
				<td>PM10GTonKM</td>
				<td>CNGTonKM</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($info['fleets'] as $f){ ?>
				<tr>
					<th><?= "$f[cname] : $f[name]"; ?></th>
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
		<tfoot>
			<tr>
				<th>Totales:</th>
				<th><?= $info['inds']['CO2GKM']; ?></th>
				<th><?= $info['inds']['NOXGKM']; ?></th>
				<th><?= $info['inds']['PM25GKM']; ?></th>
				<th><?= $info['inds']['PM10GKM']; ?></th>
				<th><?= $info['inds']['CNGKM']; ?></th>
				<th><?= $info['inds']['CO2GTonKM']; ?></th>
				<th><?= $info['inds']['NOXGTonKM']; ?></th>
				<th><?= $info['inds']['PM25GTonKM']; ?></th>
				<th><?= $info['inds']['PM10GTonKM']; ?></th>
				<th><?= $info['inds']['CNGTonKM']; ?></th>
			</tr>
		</tfoot>
	</table>
</div>