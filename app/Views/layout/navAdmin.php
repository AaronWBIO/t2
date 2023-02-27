<?php

	$uri = service('uri');
	$elem = strtolower($uri->getSegment(2));


?>

<div style="background-color: #255b4e; width: 100%;"  >
	<div class="container" id="navCont">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarMainCollapse">
				<span class="sr-only"> Interruptor de Navegación</span><span class="icon-bar"></span>
				<span class="icon-bar"></span><span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="navbarMainCollapse" >
			<ul class="nav navbar-nav navbar-left">
				<li class="<?= $elem == 'dashboard' ? 'navbar-active' : ''; ?>" >
					<a class="navbar-link"  href="<?= base_url(); ?>/Administration/Dashboard" >
						Tablero
					</a>
				</li>
				<li class="<?= $elem == 'inquiries' ? 'navbar-active' : ''; ?>" >
					<a class="navbar-link"  href="<?= base_url(); ?>/Administration/Inquiries" >
						Consultas
					</a>
				</li>
				<li class="<?= $elem == 'companies' ? 'navbar-active' : ''; ?>" >
					<a class="navbar-link"  href="<?= base_url(); ?>/Administration/Companies" >
						Empresas
					</a>
				</li>
				<li class="dropdown 
				<?= 
				$elem == 'users' 
					|| $elem == 'emissionfactors' 
					|| $elem == 'validations' 
					|| $elem == 'noptl'
					? 'navbar-active' : ''; 
				?>
				" 
				>
				  <a href="#" style="color: white;" class="dropdown-toggle" 
				  	data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				  	Configuración <span class="caret"></span>
				  </a>
				  <ul class="dropdown-menu">
				    <li>
				    	<a href="<?= base_url(); ?>/Administration/Users">Usuarios internos</a>
				    </li>
				    <li>
				    	<a href="<?= base_url(); ?>/Administration/EmissionFactors">Factores de emisión</a>
				    </li>
				    <li>
				    	<a href="<?= base_url(); ?>/Administration/Validations">Datos de validación</a>
				    </li>
				    <li>
				    	<a href="<?= base_url(); ?>/Administration/NoPTL">No-PTL</a>
				    </li>
				    <!-- <li role="separator" class="divider"></li>
				    <li><a href="#">Separated link</a></li>
				    <li role="separator" class="divider"></li>
				    <li><a href="#">One more separated link</a></li> -->
				  </ul>
				</li>
				<li class="<?= $elem == 'fleetvalidations' ? 'navbar-active' : ''; ?>" >
					<a class="navbar-link"  href="<?= base_url(); ?>/Administration/FleetValidations" >
						Validación de flotas
					</a>
				</li>
				<li class="<?= $elem == 'usersvalidations' ? 'navbar-active' : ''; ?>" >
					<a class="navbar-link"  href="<?= base_url(); ?>/Administration/UsersValidations" >
						Validación de usuarios
					</a>
				</li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li >
					<a class="navbar-link"  href="<?= base_url(); ?>/Administration/login/logout" >
						Cerrar sesión
					</a>
				</li>
			</ul>

		</div>
	</div>
</div>
