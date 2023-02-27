<!--=====================================
CLASES | CLASES
======================================-->

<script>
    <?php if (!isset($administrator)) : ?>

        let ClasesAgregadas = [];
        let ClasesEliminadas = [];
        let Clases = <?= json_encode($vClasses) ?>;
        const CombustibleSeleccionado = <?= json_encode($combustible_seleccionado) ?>;

        $(document).ready(function() {

            cargarClasesAVariables();

            $('.clases-clase-checkbox').on('click', function() {
                const clase_id = $(this).val();

                if ($(this).is(':checked')) {

                    let indice = ClasesEliminadas.indexOf(clase_id);

                    if (indice > -1) {
                        ClasesEliminadas.splice(indice, 1);
                    }

                    ClasesAgregadas.push(clase_id);

                } else {

                    let indice = ClasesAgregadas.indexOf(clase_id);

                    if (indice > -1) {
                        ClasesAgregadas.splice(indice, 1);
                    }

                    ClasesEliminadas.push(clase_id);

                }
            })

            $('.clases-guardar').on('click', function() {
                if (guardarClases()) {
                    window.location = "<?= base_url() ?>/Empresas/empresa/flotasCombustibleClases?flota=<?= $_GET['flota'] ?>&ff=<?= $_GET['ff'] ?>";
                }
            })

            $('.clases-continuar').on('click', function() {
                window.location = "<?= base_url() ?>/Empresas/empresa/flotasCombustibleQuantity?flota=<?= $_GET['flota'] ?>&ff=<?= $_GET['ff'] ?>";
            })

        })

        /**
         * Funcion para cargar las clases seleccionadas y eliminadas a arreglos globales 
         * @author Luis Hernandez <luis07hernandez05@outlook.es>
         * @created 18/10/2021
         * @return Json
         */
        function guardarClases() {
            var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/guardarFlotasCombustibleClases', {
                ff: '<?= $_GET['ff'] ?>',
                flota: '<?= $_GET['flota'] ?>',
                clases_agregadas: ClasesAgregadas,
                clases_eliminadas: ClasesEliminadas,
            });

            rj = JSON.parse(rj);

            if (rj.ok == 1) {

                return true;

            } else {

                mostrarMensaje(rj.errores, 'error');

            }
        }

        /**
         * Funcion para cargar las clases seleccionadas y eliminadas a arreglos globales 
         * @author Luis Hernandez <luis07hernandez05@outlook.es>
         * @created 18/10/2021
         */
        function cargarClasesAVariables() {
            const clases = obtenerClasesSeleccionadas();
            ClasesAgregadas.push(...clases.clases_checked);
            ClasesEliminadas.push(...clases.clases_unchecked);
        }

        /**
         * Funcion para obtener las clases seleccionadas en la primera pantalla
         * @author Luis Hernandez <luis07hernandez05@outlook.es> 
         * @created 18/10/2021
         */
        function obtenerClasesSeleccionadas() {
            var arr_unchecked_values = $('input[type=checkbox]:not(:checked)').map(function() {
                return this.value
            }).get();
            var arr_checked_values = $('input[type=checkbox]:is(:checked)').map(function() {
                return this.value
            }).get();

            return {
                clases_checked: arr_checked_values,
                clases_unchecked: arr_unchecked_values
            }
        }

    <?php endif ?>
</script>

<div class="tab-pane active fade in" id="nav-01" role="tabpanel" aria-labelledby="nav-tab-01" style="margin-top: -50px;">
    <div class="elegirClases <?= isset($administrator) ? 'ptl-disabled-admin' : '' ?>">
        <?php if (!isset($administrator)) : ?>
            <ol>
                <li class="li-none">
                    <div class="li-number">1</div>
                    <h5 class="d-inline">
                        Inicie seleccionando las casillas apropiadas para cada una de las clases de cami&oacute;n que usted opera en esta flota, puede ser 2b, 3, 4, 5, 6, 7, 8a y/o 8b. Una vez seleccionadas, de clic en el bot&oacute;n GUARDAR y posteriormente aparecer&aacute; el bot&oacute;n CONTINUAR, de clic en este para ingresar el n&uacute;mero de veh&iacute;culos que tiene por clase y a&ntilde;o modelo del motor.
                    </h5>
                </li>
            </ol>
        <?php endif ?>
        <h2><?= $combustible_seleccionado['name'] ?></h2>
        <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="peso_bruto_vehicular"></span>
        <label style="font-weight: lighter;">
            Nota: Las siluetas representan un ejemplo de los tipos de camiones para cada clase, m&aacute;s no incluye todos. Favor de tomar en cuenta el Peso Bruto Vehicular (toneladas).
        </label>      
        <br> 
        <br>
        <form id="form-elegir-clases">
            <input type="hidden" name="clases" id="fec-clases" value="{}">
            <div class="row">
                <div class="col-md-12">
                    <?php

                    $_clases_seleccionadas = [];
                    $_clases_seleccionadas_ids = [];

                    if (isset($clases_seleccionadas)) {
                        foreach ($clases_seleccionadas as $key2 => $value2) {
                            $_clases_seleccionadas[$value2['id']] = $value2;
                            $_clases_seleccionadas_ids[] = $value2['id'];
                        }
                    }

                    foreach ($vClasses as $value) {
                    ?>
                        <div class="col-md-3 ptl-card-container" style="margin-top:20px;">
                            <label for="c-<?= $value['id'] ?>" class="checkbox-card">
                                <input type="checkbox" class="clases-clase-checkbox" value="<?= $value['id'] ?>" name="c-<?= $value['id'] ?>" id="c-<?= $value['id'] ?>" <?= in_array($value['id'], $_clases_seleccionadas_ids) ? 'checked' : '' ?> />
                                <div class="ptl-card-content-wrapper">
                                    <div class="ptl-card">
                                        <center >
                                            <img class="ptl-card-img" src="<?= base_url() ?>/assets/images/icons/<?= $value['icon'] ?>" style="width: ">
                                        </center>
                                        <div class="ptl-card-body">
                                            <?= $value['name'] ?>
                                            <br>
                                            <?= isset($value['weight']) ? $value['weight'] : '' ?>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!-- /.checkbox-card -->
                    <?php
                    }
                    ?>
                </div>
            </div>
            <br>
        </form>
    </div>

    <br>
    <div style="text-align:right;">
        <?php if (!isset($administrator)) : ?>
            <?php if (!empty($clases_seleccionadas)) : ?>
                <a class="btn btn-success clases-continuar">Continuar</a>
            <?php endif ?>
            <button class="btn btn-primary clases-guardar">Guardar</button>
        <?php endif ?>
    </div>
</div>

<style>
    label.checkbox-card input[type=checkbox] {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    label.checkbox-card input[type=checkbox]:checked+.ptl-card-content-wrapper {
        box-shadow: 0 2px 4px 0 rgba(219, 215, 215, 0.5), 0 0 0 2px var(--color-green);
        color: white;
        background-color: var(--color-green);
    }

    .ptl-card-container {
        display: flex;
        justify-content: center;
    }

    .ptl-card-content-wrapper {
        cursor: pointer;
        width: 100%;
        margin: 0;
        background-color: var(--color-grey);
        box-shadow: 0 2px 4px 0 rgba(219, 215, 215, 0.5), 0 0 0 2px var(--color-grey-t05);
    }

    .ptl-card {
        width: 100%;
    }

    .ptl-card-img {
        width: 200px;
    }

    .ptl-card-body {
        text-align: center;
    }
</style>