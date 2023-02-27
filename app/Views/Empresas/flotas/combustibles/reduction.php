<!--=====================================
REDUCTION |  REDUCCIÓN DE PM 
NOTA: SOLO SI ES DIESEL
======================================-->

<script>
    let ClasesAgregadas = [];
    let ClasesEliminadas = [];
    let Clases = <?= json_encode($vClasses) ?>;
    const CombustibleSeleccionado = <?= json_encode($combustible_seleccionado) ?>;

    $(document).ready(function() {

        <?php if (!isset($administrator)) : ?>

            /*=====================================
            GUARDAR INFORMACION
            =====================================*/

            $('.button-submit').on('click', function() {
                if (guardarReduction()) {
                    window.location = "<?= base_url() ?>/Empresas/empresa/flotasCombustiblesReduction?flota=<?= $_GET['flota'] ?>&ff=<?= $_GET['ff'] ?>";
                }
            });

            /*=====================================
            ELIMINAR CLASE
            =====================================*/

            $('.table-clases-reduction').on('click', '.eliminar-clase', function() {
                const clase_id = $(this).data('id');

                ClasesEliminadas.push(clase_id);

                $('.table-clases-reduction').find(`.ptl-table-colum-clase-${clase_id}`).each(function() {
                    $(this).remove();
                })

            })

            var quantities = <?= atj($quantities); ?>;
            // console.log(quantities);

        <?php endif ?>

        /*=====================================
        CALCULAR TOTAL
        =====================================*/

        $('.table-clases-reduction').on('change', '.quantity', function() {
            let suma = 0;

            let year = $(this).data('year');
            var class_id = $(this).data('classid');

            $(document).find(`.quantity-year-${year}`).each(function() {
                // console.log($(this).val());
                if ($(this).val().length != 0) {
                    suma += parseInt($(this).val());
                }
            });

            $(document).find(`.total-${year}`).each(function() {
                $(this).val(suma > 0 ? suma : '0');
            });
            // console.log(suma);
            // var year = $(this).attr('data-year');
            

            suma = 0;

            const classid = $(this).data('classid');

            $(document).find(`.quantity-col-${classid}`).each(function() {
                if ($(this).val().length != 0) {
                    suma += parseInt($(this).val());
                }
            });
            // console.log(suma);
            $(`.ptl-table-colum-clase-${classid}`).find('.total-col-quantity').val(suma > 0 ? suma : '0');

        })

        <?php if (!isset($administrator)) : ?>
        $('.table-clases-reduction').on('change', '.quantity', function() {
            let suma = 0;

            let year = $(this).data('year');
            var class_id = $(this).data('classid');

            var num_v = quantities[class_id][year];

            if(parseInt(num_v) < parseInt($(this).val())){
                alertar('El número de vehículos registrado es menor al número de vehículos con trampa de partículas. El total de cualquier año modelo no puede superar los totales especificados en la pestaña Año modelo del motor y Clase.')
                $(this).val('');
                $(this).trigger('change');
                return;
            }

        })
        <?php endif ?>


        /*=====================================
        EJECUTANDO EVENTO CHANGE PARA CALCULAR TOTALES
        =====================================*/

        $('.quantity').trigger('change');
        // sums();

        // $('.table-clases-reduction').on('change', '.quantity', function() {
        //     console.log('aaa');
        //     let suma = 0;

        //     let year = $(this).data('year');

        //     $(document).find(`.quantity-year-${year}`).each(function() {
        //         if ($(this).val().length != 0) {
        //             suma += parseInt($(this).val());
        //         }
        //     });

        //     $(document).find(`.total-${year}`).each(function() {
        //         $(this).val(suma > 0 ? suma : '0');
        //     });

        //     // Total columnas
        //     console.log(suma);

        //     suma = 0;

        //     const classid = $(this).data('classid');

        //     $(document).find(`.quantity-col-${classid}`).each(function() {
        //         if ($(this).val().length != 0) {
        //             suma += parseInt($(this).val());
        //         }
        //     });
        //     console.log(suma);
        //     $(`.ptl-table-colum-clase-${classid}`).find('.total-col-quantity').val(suma > 0 ? suma : '0');

        // })


    });



    <?php if (!isset($administrator)) : ?>

        /**
         * Funcion para guardar la información cargada en tab: Reducción de PM
         * @author Luis Hernandez <luis07hernandez05@outlook.es> 
         * @created 18/10/2021
         */
        function guardarReduction() {

            emptyMensajes();

            let data = [];

            $('.quantity').each(function() {
                data.push({
                    quantity: $(this).val(),
                    year: $(this).data('year'),
                    classid: $(this).data('classid')
                });
            })

            var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/guardarflotasCombustiblesReduction', {
                ff: '<?= $_GET['ff'] ?>',
                flota: '<?= $_GET['flota'] ?>',
                data: data,
                clases_eliminadas: ClasesEliminadas,
            });

            rj = JSON.parse(rj);

            if (rj.ok == 1) {

                return true;

            } else {

            }
        }

    <?php endif ?>
</script>

<div class="tab-pane active fade in" id="nav-01" role="tabpanel" aria-labelledby="nav-tab-01" style="margin-top:-50px;">
    <center>
        <h5>
            <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="trampa_de_particulas"></span>
            Trampa de partículas por clase de camión
        </h5>
    </center>
    <div role="region" aria-labelledby="caption" tabindex="0">
        <table class="table table-clases-reduction ptl-table-header-colum-as">
            <thead>
                <tr>
                    <th width='100px'></th>
                    <th width='100px'></th>
                    <?php foreach ($vClasses as $key => $clase) : ?>
                        <?php foreach ($clases_seleccionadas as $k => $v) : ?>
                            <?php if ($clase['id'] == $v['id']) : ?>
                                <th class="ptl-table-colum-clase-<?= $clase['id'] ?>">
                                    <center>
                                        <?= $clase['name'] ?><br>
                                        <?= isset($clase['weight']) ? $clase['weight'] : '' ?><br>
                                        <!-- <img style="width:100px; height: 80px;" src="<?= base_url() ?>/assets/images/icons/<?= $clase['icon'] ?>"><br> -->
                                        <?php if (!isset($administrator)) : ?>
                                            <!-- <a class="btn btn-danger btn-sm eliminar-clase" data-id="<?= $clase['id'] ?>">X</a> -->
                                        <?php endif ?>
                                    </center>
                                </th>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>
                        Total
                    </th>
                    <td>
                    </td>
                    <?php foreach ($clases_seleccionadas as $key => $clase) : ?>
                        <?php if ($combustible_seleccionado['id'] == 1) : ?>
                            <td class="ptl-table-colum-clase-<?= $clase['id'] ?> <?= isset($administrator) ? 'ptl-disabled-admin' : '' ?>">
                                <div class="ptl-da ptl-w-100">
                                    <div>
                                        <input class="form-control total-col-quantity" type="text" data-classid="<?= $clase['id'] ?>" disabled>
                                    </div>
                                    <div class="<?= $clase['euro5'] == 0 ? 'd-none' : '' ?> euro5-<?= $clase['id'] ?>">
                                        <input class="form-control total-col-euro5" type="text" data-classid="<?= $clase['id'] ?>" disabled>
                                    </div>
                                    <div class="<?= $clase['euro6'] == 0 ? 'd-none' : '' ?> euro6-<?= $clase['id'] ?>">
                                        <input class="form-control total-col-euro6" type="text" data-classid="<?= $clase['id'] ?>" disabled>
                                    </div>
                                </div>
                            </td>
                        <?php else : ?>
                            <td class="ptl-table-colum-clase-<?= $clase['id'] ?> <?= isset($administrator) ? 'ptl-disabled-admin' : '' ?>">
                                <input class="form-control total-col-quantity" type="text" data-classid="<?= $clase['id'] ?>" disabled>
                            </td>
                        <?php endif ?>
                    <?php endforeach ?>
                </tr>

                <tr>
                    <th>
                        A&ntilde;o-modelo
                    </th>
                    <td>
                        Total de camiones
                    </td>
                    <?php foreach ($clases_seleccionadas as $key => $clase) : ?>
                        <td class="ptl-table-colum-clase-<?= $clase['id'] ?>">
                            <!-- <?= $clase['code'] ?> -->
                        </td>
                    <?php endforeach ?>
                </tr>
                <?php
                /*=====================================
                CARGAMOS DATOS
                =====================================*/
                $year = date('Y')+1;
                $num_years = 32;
                $last_year = $year-$num_years;

                ?>

                <?php 
                for ($i = $year; $i >= $last_year; $i--) : 
                    if ($i < $year - 10) {
                        continue;
                    }
                ?>
                    <tr>
                        <th>
                            <?php if ($i-($year-$num_years) == 0){ ?>
                            <label><?= $i ?> y anteriores</label>
                                
                            <?php }else{ ?>
                            <label><?= $i ?></label>
                            <?php } ?>

                        </th>
                        <td>
                            <input class="form-control total-<?= $i ?>" type="text" disabled>
                        </td>
                        <?php foreach ($clases_seleccionadas as $key => $clase) : ?>
                            <?php
                            //Obtenemos los valores de la fila a pintar
                            $item = null;
                            foreach ($Fleets_Fuels_Vclass_Reduction_data as $k => $v) {
                                if ($clase['id'] == $v['vclass_id'] && $v['year'] == $i) {
                                    $item = $v;
                                }
                            }

                            $item_value = !isset($item['quantity']) ? '' : ($item['quantity'] == 0 ? '' : $item['quantity']);
                            ?>
                            <td class="ptl-table-colum-clase-<?= $clase['id'] ?> <?= isset($administrator) ? 'ptl-disabled-admin' : '' ?>">
                                <input class="form-control quantity quantity-year-<?= $i ?> quantity-col-<?= $clase['id'] ?>" type="text" data-classid="<?= $clase['id'] ?>" data-year="<?= $i ?>" value="<?= $item_value ?>">
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endfor ?>
                <!-- TOTAL DE CLASE POR COLUMNA -->
            </tbody>
        </table>
    </div>
    <br>
    <br>
    <div class="" style="text-align:right;">
        <?php if (!isset($administrator)) : ?>
            <?php if (!empty($Fleets_Fuels_Vclass_Reduction_data)) : ?>
                <?php
                $_fuel = false;
                foreach ($fleet['fuels'] as $key => $value) {
                    if ($value->fuels_id == $combustible_seleccionado['id']) {
                        $_fuel = isset($fleet['fuels'][$key+1]) ? $fleet['fuels'][$key+1] : false;
                    }
                }                        
                ?>
                <?php if ($_fuel) : ?>
                    <a href="<?= base_url() ?>/Empresas/empresa/flotasCombustibleClases?flota=<?= $_GET['flota'] ?>&ff=<?= $_fuel->id_encriptado ?>" class="btn btn-success travels-continuar">Continuar</a>
                <?php else : ?>
                    <a href="<?= base_url() ?>/Empresas/empresa/inicio" class="btn btn-success travels-continuar">Inicio</a>
                <?php endif ?>
            <?php endif ?>
            <button class="btn btn-primary button-submit">Guardar</button>
        <?php endif ?>
    </div>
    <br>
    <?php if (isset($_fuel) && $_fuel) : ?>
        <p>De clic en el botón Continuar para capturar información del siguiente combustible.</p>
    <?php else : ?>
        <p>De clic en el botón Inicio para capturar información de la siguiente flota.</p>
    <?php endif ?>  
</div>