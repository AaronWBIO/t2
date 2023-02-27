<script src="/assets/adminLTE/plugins/jquery/jquery.min.js"></script>

<script>

	$(document).ready(function() {
		$("#sendLink").click(function(event) {
			var username = $('#username').val();
			var email = $('#email').val();
			if(email != '' && username != ''){
				$('#form-container').remove();
				$('#message-container').show();
				// console.log({email:email,username:username});
				var rj = jsonF('<?= base_url(); ?>/Administration/Login/emailRec',{email:email,username:username});
				// console.log(rj);
				var r = $.parseJSON(rj);

				if(r.ok == 1){
					$('#form').text('Se ha enviado un correo electrónico con las instrucciones para cambiar tu contraseña, la liga adjunta tiene una validez de 30 minutos.');
				}else{
					$('#msg').text('Correo electrónico no registrado en el sistema');
				}
			}
		});
	});
</script>

<div id="form">
	<table class="table">
		<tr>
			<td width="30%">Nombre de usuario</td>
			<td>
				<input type="text" class="form-control" placeholder="Nombre de usuario" id="username" name="username">
			</td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align: right;">
				<span class="btn btn-sm btn-primary" id="sendLink">Enviar</span>
			</td>
		</tr>
	</table>
</div>
<div id="infoRec" style="display: none;">
	La información ha sido recibida, recibirás un correo con las instrucciones para cambiar la contraseña.
</div>