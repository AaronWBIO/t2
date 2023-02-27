<?php  
	include_once APPPATH.'/ThirdParty/j/j.func.php';
?>

<script type="text/javascript">
	$(document).ready(function() {


		$('.button-cerrar-comentario').on('click',function(){

        });

		$('.button-submit-comentario').on('click',function(){
            
            $('.mensaje-comentario').empty();

            let data = <?= json_encode($data) ?>;
            
            data.comment = $('textarea').val();

            var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/guardarTravelClassFuelComentario', data);

            rj = JSON.parse(rj);

            if (rj.ok == 1){
                
                var html = `
					<div class="alert alert-success" role="alert">
                        ${rj.success}
					</div>
				`;
                $('.mensaje-comentario').html(html);                

                $('.comentario-acciones').html(`
                    <button type="button" class="btn btn-sm btn-primary button-cerrar-comentario" data-dismiss="modal" aria-label="Close">Cerrar</button>                    
                `);
            }
        });
		
	});
</script>

<div class="modal-header" >
	<div style="text-align: center;">
		<h4 class="modal-title">
			Comentario
		</h4>
	</div>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close" 
		style="color:grey;top:0px;right:0px;position: absolute;">
	  <span aria-hidden="true">&times;</span>
	</button>

</div>
<div class="modal-body" id="pano" style="width:100%;border: none 1px;">   
    <div class="mensaje-comentario"></div> 
	<form class="form-comentario">
		<table class="table borderless" border="0">
			<tr>
				<td>Comentario</td>
				<td colspan="3">
					<textarea class="ptl-w-100"><?= isset($data['comment']) ? $data['comment'] : '' ?></textarea>
				</td>				
			</tr>														
		</table>		
	</form>
	<div class="row">
		<div class="col-12" id="formErrors"></div>
	</div>

</div>
<div class="modal-footer">
	<div style="text-align: right;" class="comentario-acciones">
	<?php if (isset($administrator)) : ?>
		<span id="cancel" data-dismiss="modal" class="btn btn-sm btn-danger">Cerrar</span>
	<?php else : ?>
		<span id="cancel" data-dismiss="modal" class="btn btn-sm btn-danger">Cancelar</span>
		<span id="env" class="btn btn-sm btn-primary button-submit-comentario">Enviar</span>
	<?php endif ?>
	</div>
</div>
