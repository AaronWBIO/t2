<script>

    $('.button-submit').click(function(){
        
        var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/terminarEmpresa');
      
        rj = JSON.parse(rj);

        if (rj.ok == 1){
            window.location ="/Empresas/empresa/inicio";
        }

    })

</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Resultados</h4>
</div>
<div class="modal-body">

    <?php if ($lista) : ?>
        <div class="alert alert-danger" style="text-align: left !important;" role="alert">
            <?= $lista ?>
        </div>
    <?php else: ?>
        <div class="alert alert-success" style="text-align: left !important;" role="alert">
            ¡Resultado perfecto!
        </div>
    <?php endif ?>

</div>
<div class="modal-footer">
    <?php if ($lista) : ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Revisar valores</button>
    <?php endif ?>
    <button type="button" class="btn btn-primary button-submit">Continuar</button>
</div>