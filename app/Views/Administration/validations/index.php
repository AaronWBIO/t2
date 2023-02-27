<script>
	jQuery(document).ready(function($) {
		$('#edtVV').click(function (e) {
			e.preventDefault();
			validations_id = $('#validations_id').val();
			
			load('#emissionFactorsContent','<?= base_url(); ?>/Administration/Validations/list/'+validations_id);
		});

	});
</script>

<div class="row">
	<div class="col-md-6" style="">
		<select class="form-control" id="validations_id">
			<?php foreach ($validations as $v){ ?>
				<option value="<?= $v['id']; ?>"><?= $v['name'] ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-6">
		<span class="btn btn-sm btn-primary" style="margin: 5px;" id="edtVV">Editar</span>
	</div>
</div>
<div id="emissionFactorsContent"></div>