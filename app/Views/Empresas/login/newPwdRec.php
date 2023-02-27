<script>
	$(document).ready(function() {
		
		$('#env').click(function(event) {
			$('#formErrors').empty();

			var dat = {};
			dat.pwd = $("#pwd").val();
			dat.password_confirm = $("#pwd2").val();

			console.log('aaa');
			console.log('<?= base_url(); ?>/Empresas/Login/chNewPassword/<?= $encryption; ?>/<?= $idhash; ?>');
			console.log('bbb');
			var rj = jsonF('<?= base_url(); ?>/Empresas/Login/chNewPassword/<?= $encryption; ?>/<?= $idhash; ?>',dat);
			// console.log(rj);
			var r = $.parseJSON(rj);

			if(r.ok == 1){
				$('#pwdForm').empty();
				html = 'La contraseña se cambió correctamente, ve a la página de '+
					'<a href="/" class="btn btn-sm btn-primary"> inicio </a>';
				$('#pwdForm').html(html);

			}else if(r.ok == 2){
				var html = `
					<div class="alert alert-danger" role="alert">
						${r.err}
					</div>
				`;
				$('#formErrors').append(html);
			}


		});
	});
</script>

<div class="container">
	<div class="row">
		<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper" id="pwdForm">
			<h2 style="margin-bottom: 20px;"><?= TR('newPassword'); ?></h2>
			<table class="table">
				<tr>
					<td><?php echo TR('password'); ?></td>
					<td><input type="password" name="pwd" id="pwd" class="form-control oblig"></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo TR('confirm_password'); ?></td>
					<td><input type="password" id="pwd2" name="password_confirm" class="form-control oblig"></td>
					<td valign="middle" style="font-size: large;vertical-align: middle;">
						<i id="pwdChk" style="display: none;" class="fa"></i>
					</td>
				</tr>
			</table>
			<div style="text-align: right;">
				<span id="env" class="btn btn-sm btn-primary"><?php echo TR('send'); ?></span>
			</div>
			<div class="row">
				<div class="col-12" id="formErrors"></div>
			</div>	
		</div>
	</div>
</div>
