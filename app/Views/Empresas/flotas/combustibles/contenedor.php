
<?= view('Empresas/componentes/heading_nombre_de_flota') ?>

<?php if (isset($administrator)) : ?>
    <!--=====================================
    ADMINISTRADOR
    ======================================-->
    <?= view('Administration/fleetValidations/submenu') ?>

    <script>
        $(document).ready(function() {

            var fleets_id = '<?= $fleet['id']; ?>';
            var companies_id = '<?= $fleet['companies_id']; ?>';

            $('#refuse').click(function(e) {
                e.preventDefault();

                var html = '';

                html += '<h4>Deja un comentario </h4>';
                html += '<textarea id="refuseComment" class="form-control"></textarea>';

                conf('<?= base_url(); ?>/general/general/confirmation',html,{},function(data){

                    var refuseComment = $('#refuseComment').val();
                    var rj = jsonF(
                        '<?= base_url(); ?>/Administration/FleetValidations/refuseFleet/' + companies_id + '/' + fleets_id,
                        {refuseComment:refuseComment}
                    );
                    console.log(rj);
                    var r = $.parseJSON(rj);

                    if (r.ok == 1) {
                        location.reload();
                    }
                });

            });


            $('#accept').click(function(e) {
                // console.log('aaa');
                e.preventDefault();

                html = '¿Estás seguro que deseas validar la información?'
                conf('<?= base_url(); ?>/general/general/confirmation',html,{},function(data){

                    var rj = jsonF('<?= base_url(); ?>/Administration/FleetValidations/acceptFleet/'+fleets_id);
                    var r = $.parseJSON(rj);
                    if (r.ok == 1) {
                        location.reload();
                    }

                })
            });


        });
    </script>
<?php endif ?>
<div>
    <ul class="nav nav-tabs">
        <?= view('Empresas/flotas/combustibles/menu') ?>
    </ul>
    <!-- =====================================
    INICIO: VALIDAR STATUS DE FLOTAS
    =====================================*/ -->
    <?php if (!isset($administrator)) : ?>
        <div class="tab-content <?= isset($fleet['status']) && $fleet['status'] >= 100 ? 'ptl-disabled' : '' ?>" id="nav-tabContent">
        <?php endif ?>

        <br><br>
        <!-- FORMULARIO -->
        <?= view('Empresas/flotas/combustibles/' . $formulario) ?>
        </div>
        <br>
        <br>
        <?php if (isset($administrator)) : ?>
            <!--=====================================
            ADMINISTRADOR
            ======================================-->
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-danger w-100 rechazar" id="refuse">Rechazar</a>
                    <a class="btn btn-primary w-100 rechazar button-submit" id="accept">Aceptar</a>
                </div>
            </div>
        <?php endif ?>
        <!-- =====================================
        FIN: VALIDAR STATUS DE FLOTAS
        =====================================*/ -->
</div>
</div>
