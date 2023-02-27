<?php 
	include_once APPPATH.'/ThirdParty/j/j.func.php';

	$name = empty($name)?'alert':$name;
	$icon = empty($icon)?'fa-exclamation':$icon;


?>

<div class="modal-header" >
	<div style="text-align: center;">
		<h4 class="modal-title">
			Alerta
		</h4>
	</div>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close" 
		style="color:grey;top:0px;right:0px;position: absolute;">
	  <span aria-hidden="true">&times;</span>
	</button>

</div>

<div class="modal-body">
	<?php echo $_POST['html']; ?>
</div>

<div class="modal-footer">
	<a class="btn btn-primary" data-dismiss="modal" id="envOkModal">Cerrar</a>
</div>
