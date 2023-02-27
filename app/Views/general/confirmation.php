<?php 

include_once APPPATH.'/ThirdParty/j/j.func.php';
?>

<div class="modal-header" style="text-align:center;">
	<div class="info-box">
		<span class="info-box-icon bg-warning"><i class="fa fa-ico fa-check-double"></i></span>

		<div class="info-box-content">
			<h3 class="info-box-text">
				<?php echo TR('confAction'); ?>
			</h3>
			<!-- <span class="info-box-number">13,648</span> -->
		</div>
		<!-- /.info-box-content -->
	</div>
</div>
<div class="modal-body">
	<?php echo $html; ?>
</div>

<div class="modal-footer">
	<a class="btn btn-sm btn-danger" data-dismiss="modal" id="cPop" ><?php echo TR('close'); ?></a>
	<a class="btn btn-sm btn-primary" data-dismiss="modal" id="envOkModal" ><?php echo TR('ok'); ?></a>
</div>
