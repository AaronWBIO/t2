<script>
    edited = false;
    $(document).ready(function() {

        $('.preventLink').click(function (e) {
            e.preventDefault();

            var link = $(this).attr('href');
            
            if(edited){
                conf('<?= base_url(); ?>/general/general/confirmation',
                    'Estás a punto de dejar esta página y no haz guardado la información, ¿Estás seguro que deseas continuar?',
                    {},function(){
                        window.location.href = link;
                    });
            }else{
                window.location.href = link;
            }

        });

        $('input').keyup(function(event) {
            edited = true;
        });

    });
</script>

<!--=====================================
CLASES | CLASES
======================================-->
<li class="nav-item <?= $formulario == 'clases' ? 'active' : '' ?>">
    <?php if (isset($administrator)) : ?>
        <!--=====================================
        ADMINISTRADOR
        ======================================-->
        <a href="<?= base_url() ?>/Administration/FleetValidations/flotasCombustibleClases/<?= $company['id'] ?>/<?= $fleet['id'] ?>?ff=<?= $_GET['ff'] ?>" class="nav-link">Clases</a>
    <?php else : ?>
        <a href="<?= base_url() ?>/Empresas/empresa/flotasCombustibleClases?flota=<?= $_GET['flota'] ?>&ff=<?= $_GET['ff'] ?>" class="preventLink nav-link">Clases</a>
    <?php endif ?>
</li>
<!--=====================================
QUANTITY | AÑO MODELO DEL MOTOR Y CLASE
======================================-->
<li class="nav-item <?= $formulario == 'quantity' ? 'active' : '' ?>">
    <?php if (isset($administrator)) : ?>
        <!--=====================================
        ADMINISTRADOR
        ======================================-->
        <a href="<?= base_url() ?>/Administration/FleetValidations/flotasCombustibleQuantity/<?= $company['id'] ?>/<?= $fleet['id'] ?>?ff=<?= $_GET['ff'] ?>" class="nav-link">Año modelo del motor y clase</a>
    <?php else : ?>
        <a href="<?= base_url() ?>/Empresas/empresa/flotasCombustibleQuantity?flota=<?= $_GET['flota'] ?>&ff=<?= $_GET['ff'] ?>" class="preventLink nav-link">Año modelo del motor y clase</a>
    <?php endif ?>
</li>
<!--=====================================
TRAVELS | INFORMACIÓN DE ACTIVIDAD
======================================-->
<li class="nav-item <?= $formulario == 'travels' ? 'active' : '' ?>">
    <?php if (isset($administrator)) : ?>
        <!--=====================================
        ADMINISTRADOR
        ======================================-->
        <a href="<?= base_url() ?>/Administration/FleetValidations/flotasCombustiblesTravels/<?= $company['id'] ?>/<?= $fleet['id'] ?>?ff=<?= $_GET['ff'] ?>" class="nav-link">Información de actividad</a>
    <?php else : ?>
        <a href="<?= base_url() ?>/Empresas/empresa/flotasCombustiblesTravels?flota=<?= $_GET['flota'] ?>&ff=<?= $_GET['ff'] ?>" class="preventLink nav-link">Información de actividad</a>
    <?php endif ?>
</li>
<!--=====================================
REDUCTION |  REDUCCIÓN DE PM 
NOTA: SOLO SI ES DIESEL
======================================-->
<?php if ($combustible_seleccionado['id'] == 1) : ?>
    <li class="nav-item <?= $formulario == 'reduction' ? 'active' : '' ?>">
        <?php if (isset($administrator)) : ?>
            <!--=====================================
            ADMINISTRADOR
            ======================================-->
            <a href="<?= base_url() ?>/Administration/FleetValidations/flotasCombustiblesReduction/<?= $company['id'] ?>/<?= $fleet['id'] ?>?ff=<?= $_GET['ff'] ?>" class="nav-link">Reducción de PM</a>
        <?php else : ?>
            <a href="<?= base_url() ?>/Empresas/empresa/flotasCombustiblesReduction?flota=<?= $_GET['flota'] ?>&ff=<?= $_GET['ff'] ?>" class="preventLink nav-link">Reducción de PM</a>
        <?php endif ?>
    </li>
<?php endif ?>
<br>