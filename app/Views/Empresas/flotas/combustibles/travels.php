<!--=====================================
TRAVELS | INFORMACIÓN DE ACTIVIDAD
======================================-->

<script>
    /*=====================================
    ADMINISTRADOR
    =====================================*/
    <?php if (isset($administrator)) : ?>

        $(document).ready(function() {

            let validacion = <?= json_encode($validacion) ?>

            /*=====================================
            PINTAMOS LOS INPUTS CON RESPUESTA DE VALIDACION > 1. Y AGREGAMOS BOTÓN PARA COMENTARIO
            =====================================*/

            for (item of validacion) {
                if (item.status != 0) {
                    let style = item.status == 1 ? 'ptl-bg-yellow' : (item.status == 2 ? 'ptl-bg-red' : (item.status == 3 ? 'ptl-bg-red1' : ''));

                    let input = $(`input[name="${item.name}"]`);
                    input.addClass(style);
                    let inputHTML = input.prop('outerHTML');
                    let th = input.parent();
                    let comment = '';

                    if (th.find('.button-comment').length == 0) {
                        comment = `                    
                            <a class="btn btn-primary btn-sm button-comment" data-o="${btoa(JSON.stringify(item))}">
                                <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                            </a>
                        `;
                        th.append(comment)
                    }
                }
            }

            /*=====================================
            BOTÓN VER COMENTARIO
            =====================================*/
            $('.table-clases-travels').on('click', '.button-comment', function() {
                let data = JSON.parse(atob($(this).data('o')));

                popUp('<?= base_url() ?>/Administration/FleetValidations/travelClassFuelComentario', data);
            })

        })

    <?php endif ?>

    /*=====================================
    EMPRESAS
    =====================================*/
    <?php if (!isset($administrator)) : ?>

        let ClasesAgregadas = [];
        let ClasesEliminadas = [];
        let Clases = <?= json_encode($vClasses) ?>;
        const CombustibleSeleccionado = <?= json_encode($combustible_seleccionado) ?>;

        $(document).ready(function() {

            /*=====================================
            BOTÓN GUARDAR Y VALIDAR
            =====================================*/

            $('.travels-guardar-y-validar').on('click', function() {
                guardarTravels();
            });

            /*=====================================
            BOTÓN PARA DEJAR COMENTARIO
            =====================================*/

            $('.table-clases-travels').on('click', '.button-comment', function() {
                let data = JSON.parse(atob($(this).data('o')));

                popUp('<?= base_url() ?>/Empresas/empresa/travelClassFuelComentario', data);
            })

            /*=====================================
            EJECUTAR EVENTO AL DAR CLIC EN BOTÓN CONTINUAR
            =====================================*/

            $('.travels-continuar').on('click', function() {
                window.location = "<?= base_url() ?>/Empresas/empresa/flotasCombustiblesReduction?flota=<?= $_GET['flota'] ?>&ff=<?= $_GET['ff'] ?>";
            });

            /*=====================================
            ELIMINAR CLASE
            =====================================*/

            $('.table-clases-travels').on('click', '.eliminar-clase', function() {
                const clase_id = $(this).data('id');

                ClasesEliminadas.push(clase_id);

                $('.table-clases-travels').find(`.ptl-table-colum-clase-${clase_id}`).each(function() {
                    $(this).remove();
                })

            })

        })

        /**
         * Funcion para guardar informacion   
         * 
         * @author Luis Hernandez <luis07hernandez05@outlook.es> 
         * @created 10/10/2021
         */
        function guardarTravels() {

            emptyMensajes();
            const data = $('#form-travels').serializeObject();

            var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/guardarflotasCombustiblesTravels', {
                ff: '<?= $_GET['ff'] ?>',
                flota: '<?= $_GET['flota'] ?>',
                data: data,
                clases_eliminadas: ClasesEliminadas,
            });

            rj = JSON.parse(rj);

            if (rj.ok == 1) {

                edited = false;
                // console.log('aa');
                /*=====================================
                MOSTRAMOS MENSAJE DE ERRORES
                =====================================*/
                if ('errores' in rj) {
                    mostrarMensaje(`
                <h3>Tú información se ha guardado, pero tienes estos errores.</h3>
                <p>Hay advertencias y posibles errores en algunos de los datos ingresados para esta flota porque los datos se encuentran fuera del rango de respuesta de la mayoría de los socios. Esto podría ser debido a un error de captura de datos (al teclear) o porque sus operaciones son únicas. Los datos resaltados deben ser corregidos o explicarse haciendo clic sobre el ícono de comentario y proporcionando una explicación en el espacio del cuadro emergente.</p><br>
                ${rj.errores}
                `, 'error');
                }

                /*=====================================
                MOSTRAMOS MENSAJE DE SUCCESS
                =====================================*/
                mostrarMensaje(rj.mensaje, 'success');

                /*=====================================
                PINTAMOS LOS INPUTS CON RESPUESTA DE VALIDACION > 1. Y AGREGAMOS BOTÓN PARA COMENTARIO
                =====================================*/
                if ('validacion' in rj) {
                    console.log(rj['validacion']);
                    for (item of rj.validacion) {
                        if (item.status != 0) {
                            let style = 'ptl-bg-yellow';

                            // console.log(item.name);

                            let input = $(`input[name="${item.name}"]`);
                            input.addClass(style);
                            let inputHTML = input.prop('outerHTML');
                            let th = input.parent();
                            let comment = '';

                            if (th.find('.button-comment').length == 0) {
                                comment = `     
                            <p>
                                El valor que ingresaste está fuera de rango. Deja un comentario para este dato.
                            </p>               
                            <a class="btn btn-primary btn-sm button-comment" data-o="${btoa(JSON.stringify(item))}">
                                <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                            </a>
                        `;
                                th.append(comment)
                            }
                        }else{
                            let style = 'ptl-bg-yellow';
                            let input = $(`input[name="${item.name}"]`);
                            input.removeClass(style);
                            $(input).closest('td').find('p').remove();
                            $(input).closest('td').find('a').remove();
                        }
                    }
                }

            } else {
                mostrarMensaje(rj.errores, 'error');
            }
        }
    <?php endif ?>

    /*=====================================
    GENERAL
    =====================================*/
    $(document).ready(function() {

        $('.tipo_de_carretera').on('change', function() {
            const classid = $(this).data('classid');

            let total_field = $(`.tipo_de_carretera-${classid}.tipo_de_carretera-total`);

            let tipo_de_carretera_fields = $(`.tipo_de_carretera-${classid}`);

            let total = 0;

            tipo_de_carretera_fields.each(function() {
                if (!$(this).hasClass('tipo_de_carretera-total')) {
                    total += parseInt($(this).val() == '' ? 0 : $(this).val());
                }
            })

            if (total > 100) {
                alertar('El porcentaje total de los tipos de carretera no debe ser mayor a 100')
                $(this).val(0);
                total = 0;
                tipo_de_carretera_fields.each(function() {
                    if (!$(this).hasClass('tipo_de_carretera-total')) {
                        total += parseInt($(this).val() == '' ? 0 : $(this).val());
                    }
                })
                total_field.val(total);
                return;
            }

            if (isNaN(total)) {
                total_field.val(0);
            } else {
                total_field.val(total);
            }
        })

        $('.eficiencia').on('change', function() {
            const classid = $(this).data('classid');

            let eficiencia_field_total = $(`.eficiencia-total-${classid}`);

            let total = 0;

            <?php if ($combustible_seleccionado['id'] == 1) : ?>

                let km_tot = $(`.km_tot-${classid}`).val() == '' ? 0 : $(`.km_tot-${classid}`).val();
                km_tot = parseFloat(km_tot);

                let lts_tot = $(`.lts_tot-${classid}`).val() == '' ? 0 : $(`.lts_tot-${classid}`).val();
                lts_tot = parseFloat(lts_tot);

                let lts_bio = $(`.lts_bio-${classid}`).val() == '' ? 0 : $(`.lts_bio-${classid}`).val();
                lts_bio = parseFloat(lts_bio);

                total = km_tot / (lts_tot);

            <?php else : ?>
                let km_tot = $(`.km_tot-${classid}`).val() == '' ? 0 : $(`.km_tot-${classid}`).val();
                km_tot = parseFloat(km_tot);

                let lts_tot = $(`.lts_tot-${classid}`).val() == '' ? 0 : $(`.lts_tot-${classid}`).val();
                lts_tot = parseFloat(lts_tot);

                total = km_tot / lts_tot;
            <?php endif ?>

            if (isNaN(total) || !isFinite(total) ) {
                eficiencia_field_total.val('-');
            } else {
                eficiencia_field_total.val(total.toFixed(2));
            }
        })

        $('.tipo_de_carretera').trigger('change');
        $('.eficiencia').trigger('change');

    });
</script>

<div class="tab-pane active fade in" id="nav-01" role="tabpanel" aria-labelledby="nav-tab-01" style="margin-top:-30px;">
    <h2><?= $combustible_seleccionado['name'] ?></h2>
    <form id="form-travels">
        <div role="region" aria-labelledby="caption" tabindex="0">
            <table class="table table-clases-travels ptl-table-header-colum-as">
                <thead>
                    <tr>
                        <th width='200px'></th>
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
                            <?= $combustible_seleccionado['name'] ?><br>
                        </th>
                        <?php foreach ($vClasses as $key => $v) { ?>
                            <?php foreach ($clases_seleccionadas as $key => $clase) { ?>
                                <?php if ($clase['id'] == $v['id']) { ?>
                                    <td class="ptl-table-colum-clase-<?= $clase['id'] ?>">
                                        <!-- <?= $clase['code'] ?> -->
                                    </td>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </tr>
                    <?php
                    /*=====================================
                    CARGAMOS DATOS
                    =====================================*/
                    $year = date('Y');

                    $field_labels = [
                        [
                            'name' => 'km_tot',
                            'tooltip' => 'km_tot',
                            'value' => 'kilómetros recorridos totales',
                            'placeholder' => 'Km',
                            'clases' => 'eficiencia km_tot',
                            'clase_identificadora' => 'km_tot',
                            'bg-color' => "rgba(37,91,78,.3)",
                        ],
                        [
                            'name' => 'km_empty',
                            'tooltip' => 'km_empty',
                            'value' => 'kilómetros recorridos en vacío',
                            'placeholder' => 'Km',
                            'bg-color' => "rgba(37,91,78,.3)",
                        ],
                    ];

                    if ($combustible_seleccionado['id'] == 5) {
                        $field_labels[] = [
                            'name' => 'lts_tot',
                            'tooltip' => 'lts_tot_gnc',
                            'value' => $combustible_seleccionado['comment'],
                            'placeholder' => 'Lts',
                            'clases' => 'eficiencia lts_tot',
                            'clase_identificadora' => 'lts_tot',
                            'bg-color' => "rgba(37,91,78,.3)",
                        ];

                    }
                    elseif($combustible_seleccionado['id'] == 3){
                        $field_labels[] = [
                            'name' => 'lts_tot',
                            'tooltip' => 'lts_tot_glp',
                            'value' => $combustible_seleccionado['comment'],
                            'placeholder' => 'Lts',
                            'clases' => 'eficiencia lts_tot',
                            'clase_identificadora' => 'lts_tot',
                            'bg-color' => "rgba(37,91,78,.3)",
                        ];

                    }
                    else{                    
                        $field_labels[] = [
                            'name' => 'lts_tot',
                            'tooltip' => 'lts_tot',
                            'value' => $combustible_seleccionado['comment'],
                            'placeholder' => 'Lts',
                            'clases' => 'eficiencia lts_tot',
                            'clase_identificadora' => 'lts_tot',
                            'bg-color' => "rgba(37,91,78,.3)",
                        ];
                    }


                    if ($combustible_seleccionado['id'] == 1) {
                        // $field_labels[] = [
                        //     'name' => 'lts_bio',
                        //     'tooltip' => 'lts_bio',
                        //     'value' => 'Litros de Biodiésel (B100 Equivalentes)',
                        //     'placeholder' => 'Lts',
                        //     'clases' => 'eficiencia lts_bio',
                        //     'clase_identificadora' => 'lts_bio',
                        // ];
                    }

                    $field_labels[] = [
                        'name' => '',
                        'value' => 'Rendimiento (Km/L)',
                        'placeholder' => '',
                        'clases' => 'eficiencia-total',
                        'clase_identificadora' => 'eficiencia-total',
                        'bg-color' => "rgba(37,91,78,.3)",
                    ];

                    if ($combustible_seleccionado['id'] == 7) {
                        $field_labels[] = [
                            'name' => 'hybrid_type',
                            'tooltip' => 'hybrid_type',
                            'value' => 'Especifique el tipo de combustible',
                            'type' => 'radio',
                            'bg-color' => "rgba(.2,.2,.2,.1)",
                        ];
                    }

                    array_push(
                        $field_labels,
                        [
                            'name' => 'payload_avg',
                            'tooltip' => 'payload_avg',
                            'value' => 'Carga útil promedio (toneladas)',
                            'placeholder' => 'Ton',
                            'bg-color' => "rgba(.2,.2,.2,.1)",
                        ],
                        [
                            'name' => 'highway',
                            'tooltip' => 'highway',
                            'value' => 'Porcentaje de manejo en autopista o carretera',
                            'placeholder' => '%',
                            'clase_identificadora' => 'tipo_de_carretera',
                            'clases' => 'tipo_de_carretera',
                            'bg-color' => "rgba(22,137,60,.3)",
                        ],
                        [
                            'name' => 'less_40',
                            'tooltip' => 'less_40',
                            'value' => 'Porcentaje de manejo urbano (menos de 40 km/h)',
                            'placeholder' => '%',
                            'clase_identificadora' => 'tipo_de_carretera',
                            'clases' => 'tipo_de_carretera',
                            'bg-color' => "rgba(22,137,60,.3)",
                        ],
                        [
                            'name' => '40_80',
                            'tooltip' => '40_80',
                            'value' => 'Porcentaje de manejo urbano (40 a 80 km/h)',
                            'placeholder' => '%',
                            'clase_identificadora' => 'tipo_de_carretera',
                            'clases' => 'tipo_de_carretera',
                            'bg-color' => "rgba(22,137,60,.3)",
                        ],
                        [
                            'name' => 'over_80',
                            'tooltip' => 'over_80',
                            'value' => 'Porcentaje de manejo urbano (más de 80 km/h)',
                            'placeholder' => '%',
                            'clase_identificadora' => 'tipo_de_carretera',
                            'clases' => 'tipo_de_carretera',
                            'bg-color' => "rgba(22,137,60,.3)",
                        ],
                        [
                            'name' => '',
                            'tooltip' => 'total_categorias_de_velocidad',
                            'value' => 'Total',
                            'placeholder' => '0',
                            'clase_identificadora' => 'tipo_de_carretera',
                            'clases' => 'tipo_de_carretera-total',
                            'bg-color' => "rgba(22,137,60,.3)",
                        ],
                        [
                            'name' => 'ralenti_hours_large',
                            'tooltip' => 'ralenti_hours_large',
                            'value' => 'Horas en ralentí de duración larga al día por camión',
                            'placeholder' => 'Hrs.',
                            'bg-color' => "rgba(16,49,43,.3)",
                        ],
                        [
                            'name' => 'ralenti_hours_short',
                            'tooltip' => 'ralenti_hours_short',
                            'value' => 'Horas en ralentí de duración corta al día por camión',
                            'placeholder' => 'Hrs.',
                            'bg-color' => "rgba(16,49,43,.3)",
                        ],
                        [
                            'name' => 'ralenti_days',
                            'tooltip' => 'ralenti_days',
                            'value' => 'Número promedio de días en carretera al año',
                            'placeholder' => '',
                            'bg-color' => "rgba(16,49,43,.3)",
                        ],
                    );

                    $aux = 1;
                    ?>
                    <?php foreach ($field_labels as $key => $field) : ?>
                        <tr>
                            <th style="font-size:.8em; background-color: <?= $field['bg-color']; ?>;">
                                <?php if (isset($field['tooltip'])) : ?>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="<?= $field['tooltip'] ?>"></span>
                                <?php endif ?>
                                <label><?= $field['value'] ?></label>
                            </th>
                            <?php foreach ($vClasses as $key => $vc) { ?>
                                <?php foreach ($clases_seleccionadas as $key => $clase) { ?>
                                    <?php if ($clase['id'] == $vc['id']) { ?>
                                        <?php
                                        // Obtenemos los valores de la fila a pintar
                                        $item = null;
                                        foreach ($Fleets_Fuels_Vclass_Travel_data as $k => $v) {
                                            if ($clase['id'] == $v['vclass_id']) {
                                                $item = $v;
                                            }
                                        }
                                        $item_value = !isset($item[$field['name']]) ? '' : ($item[$field['name']] == 0 ? '0' : $item[$field['name']]);
                                        // if( isset($item[$field['name']]) && $item[$field['name']] == 0  ){
                                        //     echo "-- ".$field['name']."<br/>";
                                        // }
                                        ?>
                                        <td class="ptl-table-colum-clase-<?= $clase['id'] ?>" style="background-color: <?= $field['bg-color']; ?>;">
                                            <?php if ($field['name'] == 'hybrid_type') : ?>
                                                <label class="radio-inline" id="fuel-diesel">
                                                    <input class="<?= isset($administrator) ? 'ptl-disabled-admin' : '' ?>" type="radio" name="<?= $clase['id'] ?>#<?= $field['name'] ?>" id="fuel-diesel" value="1" <?= $item_value == 1 ? 'checked' : '' ?>> Diesel
                                                </label>
                                                <label class="radio-inline" id="fuel-gasolina">
                                                    <input class="<?= isset($administrator) ? 'ptl-disabled-admin' : '' ?>" type="radio" name="<?= $clase['id'] ?>#<?= $field['name'] ?>" id="fuel-gasolina" value="2" <?= $item_value == 1 ? 'checked' : '' ?>> Gasolina
                                                </label>
                                            <?php else : ?>
                                                <input class="form-control tquantity <?= isset($administrator) ? 'ptl-disabled-admin' : '' ?> <?= isset($field['clase_identificadora']) ? $field['clase_identificadora'] . '-' . $clase['id'] : '' ?> <?= isset($field['clases']) ? $field['clases'] : '' ?>" type="text" name="<?= $clase['id'] ?>#<?= $field['name'] ?>" placeholder="<?= $field['placeholder'] ?>" data-classid="<?= $clase['id'] ?>" data-year="<?= $year ?>" value="<?= $item_value ?>" <?= empty($field['name']) ? 'disabled' : '' ?>>

                                            <?php endif ?>
                                            <?php if ($aux == count($field_labels)) : ?>
                                                <input type="hidden" name="<?= $clase['id'] ?>#vclass_id" value="<?= $clase['id'] ?>">
                                            <?php endif ?>
                                        </td>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>

                            <?php foreach ($clases_seleccionadas as $key => $clase) : ?>

                            <?php endforeach ?>
                        </tr>
                        <?php $aux++; ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </form>
    <div class="" style="text-align:right;">
        <?php if (!isset($administrator)) : ?>
            <?php if ($combustible_seleccionado['id'] == 1) : ?>
                <?php if (!empty($Fleets_Fuels_Vclass_Travel_data)) : ?>
                    <a href="<?= base_url() ?>/Empresas/empresa/flotasCombustiblesReduction?flota=<?= $_GET['flota'] ?>&ff=<?= $_GET['ff'] ?>" class="btn btn-success travels-continuar">Continuar</a>
                <?php endif ?>
            <?php else : ?>
                <?php
                $_fuel = false;
                foreach ($fleet['fuels'] as $key => $value) {
                    if ($value->fuels_id == $combustible_seleccionado['id']) {
                        $_fuel = isset($fleet['fuels'][$key + 1]) ? $fleet['fuels'][$key + 1] : false;
                    }
                }
                ?>
                <?php if ($_fuel) : ?>
                    <a href="<?= base_url() ?>/Empresas/empresa/flotasCombustibleClases?flota=<?= $_GET['flota'] ?>&ff=<?= $_fuel->id_encriptado ?>" class="btn btn-success travels-continuar">Continuar</a>
                <?php else : ?>
                    <a href="<?= base_url() ?>/Empresas/empresa/inicio" class="btn btn-success travels-continuar">Inicio</a>
                <?php endif ?>
            <?php endif ?>
            <button class="btn btn-primary travels-guardar-y-validar">Guardar y validar</button>
        <?php endif ?>
    </div>
    <?php if ($combustible_seleccionado['id'] != 1) : ?>
        <br>
        <?php if ($_fuel) : ?>
            <p>De clic en el botón Continuar para capturar información del siguiente combustible.</p>
        <?php else : ?>
            <p>De clic en el botón Inicio para capturar información de la siguiente flota.</p>
        <?php endif ?>
    <?php endif ?>
</div>