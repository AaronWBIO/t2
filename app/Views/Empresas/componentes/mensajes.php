<?php
$mensajeExito = session()->getFlashdata('success');
$mensajeError = session()->getFlashdata('errores');
?>

<div id="mensaje-success">
    <?php if ($mensajeExito) : ?>
        <div class="alert alert-success alert-dismissible mt-25" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= $mensajeExito ?>
        </div>
    <?php endif ?>
</div>
<div id="mensaje-error">
    <?php if ($mensajeError) : ?>
        <div class="alert alert-danger alert-dismissible mt-25" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= $mensajeError ?>
        </div>
    <?php endif ?>
</div>
<div id="mensaje"></div>