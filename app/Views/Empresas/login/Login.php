
<div style="margin: 30px 0px;">
<!--   <center>
    <img src="<?= base_url(); ?>/assets/images/logo.jpg" alt="PTL"  style="height: 200px;">
  </center> -->
  <center>
  	<br/>
  	<?php if ($type == 'tr'){ ?>
  		<span class="subtituloLogin colorTransp"> Empresas transportistas</span>
  	<?php }else{ ?>
  		<span class="subtituloLogin colorTransp"> Empresas usuarias del transporte de carga</span>
  	<?php } ?>
  </center>
</div>
<hr/>

<center style="margin: 20px 0px 50px 0px;">
	<span class="subtituloLogin colorTransp2">Ingresa a la plataforma</span>
</center>
<form action="" method="POST">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="marco">
				
				<div class="row">
					<div class="col-md-4 col-md-offset-1">
					  Nombre de usuario<sup>*</sup>:
					</div>
					<div class="col-md-4 col-md-offset-1">
					  <input type="text" name="username" class="form-control">
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-4 col-md-offset-1">
					  Contraseña<sup>*</sup>:
					</div>
					<div class="col-md-4 col-md-offset-1">
					  <input type="password" name="password" class="form-control">
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-4 col-md-offset-1">
					  <span style="font-size: .7em;">* Campos obligatorios</span>
					</div>
					<div class="col-md-4 col-md-offset-1" style="text-align: right;">
					  <input type="submit" value="Enviar" class="btn btn-sm btn-primary">
					</div>
				</div>

				<div style="text-align:center;">
					<a href="<?= base_url(); ?>/Empresas/Login/forgotPwd">[¿Olvidaste tu contraseña?]</a>
				</div>
			</div>
		</div>
	</div>
	<?= csrf_field() ?>
</form>

<center style="margin-top: 30px;">
	<strong>¿Necesitas ayuda?</strong><br>
		
	Comunícate con el contacto de apoyo SEMARNAT a los teléfonos:<br/>(55) 56243300 Ext. 23556 o 23717<br/><br/>
	Escribe un correo a:<br/>
	<a href="mailto:transporte.limpio@semarnat.gob.mx">transporte.limpio@semarnat.gob.mx</a> 
</center>