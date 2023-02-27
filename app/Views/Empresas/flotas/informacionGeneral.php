<script>
    $(document).ready(function() {
        //Al cargar la pagina ejecutamos funcion trigger para ejecutar evento change. Y calcular la suma.
        $('#mexico').trigger('change');

        <?php if (!isset($administrator)) : ?>

            //Guardar 
            $('.button-submit').click(function(e) {
                e.preventDefault();

                emptyMensajes();

                var data = $('#form-fleets').serializeObject();

                if (!('fuels[]' in data)) {
                    alertar("Debe seleccionar al menos un combustible.");
                    return;
                }

                data.usa = data.usa.replace(/\s/g, "") == "" ? '0' : data.usa;
                data.canada = data.canada.replace(/\s/g, "") == "" ? '0' : data.canada;
                data.mexico = data.mexico.replace(/\s/g, "") == "" ? '0' : data.mexico;

                var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/guardarFlotasInformacionGeneral?flota=<?= $_GET['flota'] ?>', data);

                rj = JSON.parse(rj);

                if (rj.ok == 1) {
                    window.location.reload();
                } else {
                    mostrarMensaje(rj.errores, 'error');
                }

            });

        <?php endif ?>
    })

    /**
     * Funcion para calcular porcentaje de Operaciones
     * @author Luis Hernandez <luis07hernandez05@outlook.es> 
     * @created 18/10/2021
     */
    function sumarPorcentajesDeOperaciones() {
        const valores = $('.operationPercentage');
        let suma = 0;
        valores.each(function(index) {
            if ($(this).val().length != 0) {
                suma += parseInt($(this).val());
            }
        });
        $('#total').val(suma);
    }
</script>
<script>
    $(document).ready(function() {
        var edited = false;

        $('.preventLink').click(function (e) {
            e.preventDefault();
            console.log('rrr');
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

        $('input').change(function(event) {
            edited = true;
        });

    });
</script>

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

                conf('<?= base_url(); ?>/general/general/confirmation', html, {}, function(data) {

                    var refuseComment = $('#refuseComment').val();
                    var rj = jsonF(
                        '<?= base_url(); ?>/Administration/FleetValidations/refuseFleet/' + companies_id + '/' + fleets_id, {
                            refuseComment: refuseComment
                        }
                    );
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

                    var rj = jsonF('<?= base_url(); ?>/Administration/FleetValidations/acceptFleet/' + fleets_id);
                    var r = $.parseJSON(rj);
                    if (r.ok == 1) {
                        location.reload();
                    }

                })
            });

        });
    </script>

<?php endif ?>

<?= view('Empresas/componentes/heading_nombre_de_flota') ?>

<div class="ptl-my-2">
    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="que_hacer_informacion_general" id="ayuda"></span>
    Ayuda
</div>

<!--=====================================
INICIO: VALIDAR STATUS DE FLOTAS
======================================-->
<?php if (!isset($administrator)) : ?>
    <div class="<?= isset($fleet['status']) && $fleet['status'] >= 100 ? 'ptl-disabled' : '' ?>">
    <?php else : ?>
        <!--=====================================
        ADMINISTRADOR
        ======================================-->
        <div class="ptl-disabled-admin">
        <?php endif ?>


        <form id="form-fleets">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-12">
                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="porcentaje_de_operaciones"></span>
                    <label>Indique el procentaje aproximado de operaciones en México, los EE.UU y Canadá<sup>*</sup></label><br>
                    <div class="form-group col-md-3">
                        <label for="vCodigoPostal">México</label>
                        <input type="text" value="<?= isset($fleet['mexico']) ? esc($fleet['mexico']) : '' ?>" class="form-control operationPercentage" id="mexico" name="mexico" placeholder="0" onchange="sumarPorcentajesDeOperaciones()">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="vCodigoPostal">EE.UU.</label>
                        <input type="text" value="<?= isset($fleet['usa']) ? esc($fleet['usa']) : '' ?>" class="form-control operationPercentage" id="usa" name="usa" placeholder="0" onchange="sumarPorcentajesDeOperaciones()">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="vCodigoPostal">Canadá</label>
                        <input type="text" value="<?= isset($fleet['canada']) ? esc($fleet['canada']) : '' ?>" class="form-control operationPercentage" id="canada" name="canada" placeholder="0" onchange="sumarPorcentajesDeOperaciones()">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="vCodigoPostal">Total</label>
                        <input type="text" class="form-control" id="total" name="total" placeholder="0" disabled>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="tipos_de_combustible"></span>
                    <label>Tipos de combustible en esta flota (indique todos los que apliquen)<sup>*</sup></label><br>
                    <?php

                    if (isset($fleet['fuels'])) {
                        $fleet_fuels = $fleet['fuels'];
                    } else {
                        $fleet_fuels = [];
                    }

                    foreach ($fuels as $key => $value) {
                        foreach ($fleet_fuels as $key2 => $value2) {
                            $status = intval($value['id']) == intval($value2->fuels_id) ? 'checked' : null;
                            if ($status == 'checked') {
                                $value['checked'] = $status;
                                continue;
                            }
                        }
                    ?>
                        <div class="form-check col-md-3">
                            <input type="checkbox" value="<?= esc($value['id']) ?>" class="form-check-input" name="fuels[]" <?= isset($value['checked']) ? $value['checked'] : '' ?>>
                            <label class="form-check-label" for="inlineCheckbox1"><?= $value['name'] ?></label>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="recorrido_corto_vs_largo"></span>
                    <label>Porcentaje de recorrido corto vs recorrido largo</label><br>
                    <div class="form-group col-md-6">
                        <label for="short">% Recorrido corto <sup>*</sup></label>
                        <input type="text" value="<?= isset($fleet['short']) ? esc($fleet['short']) : '' ?>" class="form-control" id="short" name="short" placeholder="0">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="short">% Recorrido largo <sup>*</sup></label>
                        <input type="text" value="<?= isset($fleet['large']) ? esc($fleet['large']) : '' ?>" class="form-control" id="large" name="large" placeholder="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="cedio_intermediario"></span>
                    <label>¿Cedió a un intermediario una parte del volumen total transportado por su empresa?<sup>*</sup></label><br>
                    <div class="form-group col-md-6">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="intermediary" id="intermediary-true" value="1" <?= isset($fleet['intermediary']) && $fleet['intermediary'] == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="intermediary-true">Sí</label>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="intermediary" id="intermediary-false" value="0" <?= isset($fleet['intermediary']) && $fleet['intermediary'] == 0 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="intermediary-false">No</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>¿Qué procentaje de la carga total que transportó el año pasado fue a través de un intermediario? % <sup>*</sup></label><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group col-md-12">
                        <input type="text" value="<?= isset($fleet['intermediaryPercent']) ? esc($fleet['intermediaryPercent']) : '' ?>" class="form-control" id="intermediaryPercent" name="intermediaryPercent" placeholder="0">
                    </div>
                </div>
            </div>
            <span style="">* Campos obligatorios</span>
            <div id="mensaje-errores"></div>
            <?php if (!isset($administrator)) : ?>
                <div class="row">
                    <div class="col-md-12" style="text-align: right;">
                        <a href="/Empresas/empresa/inicio" class="btn btn-danger w-100 preventLink">Cancelar</a>
                        <button type="submit" class="btn btn-primary w-100 button-submit">Guardar</button>
                        <?php if (isset($fleet['intermediary']) && !empty($fleet['fuels'])) : ?>
                            <br><br>
                            <a href="<?= base_url() ?>/Empresas/empresa/flotasCombustibleClases?flota=<?= $_GET['flota'] ?>&ff=<?= $fleet['fuels'][0]->id_encriptado ?>" class="btn btn-success w-100 preventLink">Continuar</a>
                        <?php endif ?>
                    </div>
                </div>
            <?php endif ?>
        </form>
        </div>
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