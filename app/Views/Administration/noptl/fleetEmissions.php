<script>
	$(document).ready(function() {
		$("#saveEmissions").click(function (e) {
			e.preventDefault();
			var dat = $('#emissionsForm').serializeObject();
			// console.log(dat);

			var rj = jsonF('<?= base_url(); ?>/Administration/NoPTL/saveEmissions/<?= $hash_fleet_id; ?>',dat);
			console.log(rj);
			var r = $.parseJSON(rj);
			if(r.ok == 1){
				alertar('La información se guardó correctamente');
			}else{
				alertar(r.err);
			}

		});
	});
</script>
<h1>
	<?= $fleet['name']; ?>
</h1>

<form id="emissionsForm">
	<table class="table">
		<thead>
			<tr>
				<th>
					CO2GKM
				</th>
				<th>
					NOXGKM
				</th>
				<th>
					PM25GKM
				</th>
				<th>
					PM10GKM
				</th>
				<th>
					CNGKM
				</th>
				<th>
					CO2GTonKM
				</th>
				<th>
					NOXGTonKM
				</th>
				<th>
					PM25GTonKM
				</th>
				<th>
					PM10GTonKM
				</th>
				<th>
					CNGTonKM
				</th>	
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<input type="text" class="form-control" name="CO2GKM" value="<?= $cache['CO2GKM']; ?>" />
					
				</td>
				<td>
					<input type="text" class="form-control" name="NOXGKM" value="<?= $cache['NOXGKM']; ?>" />
					
				</td>
				<td>
					<input type="text" class="form-control" name="PM25GKM" value="<?= $cache['PM25GKM']; ?>" />
					
				</td>
				<td>
					<input type="text" class="form-control" name="PM10GKM" value="<?= $cache['PM10GKM']; ?>" />
					
				</td>
				<td>
					<input type="text" class="form-control" name="CNGKM" value="<?= $cache['CNGKM']; ?>" />
					
				</td>
				<td>
					<input type="text" class="form-control" name="CO2GTonKM" value="<?= $cache['CO2GTonKM']; ?>" />
					
				</td>
				<td>
					<input type="text" class="form-control" name="NOXGTonKM" value="<?= $cache['NOXGTonKM']; ?>" />
					
				</td>
				<td>
					<input type="text" class="form-control" name="PM25GTonKM" value="<?= $cache['PM25GTonKM']; ?>" />
					
				</td>
				<td>
					<input type="text" class="form-control" name="PM10GTonKM" value="<?= $cache['PM10GTonKM']; ?>" />
					
				</td>
				<td>
					<input type="text" class="form-control" name="CNGTonKM" value="<?= $cache['CNGTonKM']; ?>" />
				</td>
			</tr>
		</tbody>
	</table>

</form>

<div>
	<span class="btn btn-sm btn-primary" id="saveEmissions">Guardar</span>
</div>