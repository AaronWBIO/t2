<div>

	<hr>
	<div style="text-align:right;">
		<form action="<?= base_url(); ?>/Administration/Inquiries/metrics/csv/<?= $type; ?>/<?= $measure_year; ?>" target="_blank">
			<input type="submit" value="Descargar CSV" class="btn btn-sm btn-primary">
		</form>
	</div>
	Las emisiones están representadas en Toneladas al año
	<table class="table">
		<thead>
			<tr>
				<?php foreach ($columns as $c){ ?>
					<th><?= $c['0']; ?></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($results as $r){ ?>
				<tr>
					<?php foreach ($columns as $c){ ?>
						<td>
							<?php
								switch($c[2]){
									case 'text':
										echo $r[$c[1]];
										break;
									case 'int':
										echo number_format($r[$c[1]]/$c[3],0,'.',$c[4]);
										break;
									case 'float':
										echo number_format($r[$c[1]]/$c[3],2,'.',$c[4]);
										break;
								}
							?>
						</td>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>	
</div>
<div>
	*Para vehículos eléctricos las unidades son KW/h<br/>
	*Para vehículos que utilizan GLP y GNC las unidades son LEG<br/>
</div>