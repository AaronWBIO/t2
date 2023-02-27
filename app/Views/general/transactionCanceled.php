<div style="margin-top: 30px;">
	<div style="text-align: center;">
		<h1><?= TR('transactionCanceledMsg') ?></h1>
	</div>

	<div style="margin-top: 20px;">
		<table border="0">
			<tr>
				<td colspan="2"><?= TR('origin'); ?></td>
			</tr>
			<tr>
				<td><?= TR('company'); ?></td>
				<td><?= $transaction['ocName']; ?></td>
			</tr>
			<tr>
				<td><?= TR('facility'); ?></td>
				<td><?= $transaction['ofName']; ?></td>
			</tr>
			<tr>
				<td><?= TR('account'); ?></td>
				<td><?= $transaction['oaAccountNo']; ?></td>
			</tr>
			<tr>
				<td colspan="2"><?= TR('destination'); ?></td>
			</tr>
			<tr>
				<td><?= TR('company'); ?></td>
				<td><?= $transaction['dcName']; ?></td>
			</tr>
			<tr>
				<td><?= TR('facility'); ?></td>
				<td><?= $transaction['dfName']; ?></td>
			</tr>
			<tr>
				<td><?= TR('account'); ?></td>
				<td><?= $transaction['daAccountNo']; ?></td>
			</tr>
		</table>
	</div>
	
</div>