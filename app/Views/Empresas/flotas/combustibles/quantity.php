<!--=====================================
REDUCTION |  REDUCCIÓN DE PM 
NOTA: SOLO SI ES DIESEL
======================================-->

<?php
$clases_seleccionadas_ids = [];
foreach ($clases_seleccionadas as $key => $value) {
    $clases_seleccionadas_ids[] = intval($value['id']);
}
?>

<script>
    let ClasesAgregadas = <?= json_encode($clases_seleccionadas_ids) ?>;
    let ClasesEliminadas = [];
    let Clases = <?= json_encode($vClasses) ?>;
    const CombustibleSeleccionado = <?= json_encode($combustible_seleccionado) ?>;

    $(document).ready(function() {

        <?php if (!isset($administrator)) : ?>
            /*=====================================
            MOSTRAR O OCULTAR EURO 5 O EURO 6
            NOTA: SOLO SI ES DIESEL
            =====================================*/
            $('.table-clases-quantity').on('click', '.euro5-check', function() {
                const clase_id = $(this).data('id');

                if ($(this).is(':checked')) {
                    $('.table-clases-quantity > tbody').find(`.euro5-${clase_id}`).each(function() {
                        $(this).removeClass('d-none');
                    })
                } else {
                    $('.table-clases-quantity').find('.euro5-' + clase_id).each(function() {
                        $(this).addClass('d-none');
                    })
                }
            })

            $('.table-clases-quantity').on('click', '.euro6-check', function() {
                const clase_id = $(this).data('id');

                if ($(this).is(':checked')) {
                    $('.table-clases-quantity > tbody').find(`.euro6-${clase_id}`).each(function() {
                        $(this).removeClass('d-none');
                    })
                } else {
                    $('.table-clases-quantity').find('.euro6-' + clase_id).each(function() {
                        $(this).addClass('d-none');
                    })
                }
            })

            /*=====================================
            ELIMINAR CLASE
            =====================================*/

            $('.table-clases-quantity').on('click', '.eliminar-clase', function() {
                const clase_id = $(this).data('id');

                let indice = ClasesAgregadas.indexOf(clase_id);

                if (indice > -1) {
                    ClasesAgregadas.splice(indice, 1);
                }

                ClasesEliminadas.push(clase_id);

                $('.table-clases-quantity').find(`.ptl-table-colum-clase-${clase_id}`).each(function() {
                    $(this).remove();
                })

            })

            /*=====================================
            GUARDAR
            =====================================*/
            $('.button-success').on('click', function() {
                if (guardarQuantity()) {
                    window.location = "<?= base_url() ?>/Empresas/empresa/flotasCombustibleQuantity?flota=<?= $_GET['flota'] ?>&ff=<?= $_GET['ff'] ?>";
                }
            });

            /*=====================================
            AGREGAR CLASE
            =====================================*/
            $('.agregarClase').click(function() {
                if (!ClasesAgregadas.includes(parseInt($('.agregarMasClases').val()))) {

                    let indice = ClasesEliminadas.indexOf($('.agregarMasClases').val());

                    if (indice > -1) {
                        ClasesEliminadas.splice(indice, 1);
                    }

                    ClasesAgregadas.push(parseInt($('.agregarMasClases').val()));

                    let iter = 1;
                    var table = $('.table-clases-quantity')
                    let clase = Clases.find(element => element.id == $('.agregarMasClases').val());

                    table.find('tr').each(function() {
                        var trow = $(this);
                        if (trow.index() === 0) {
                            if (iter == 1) {
                                trow.append(`
                            <th class="ptl-table-colum-clase-${clase.id}">
                            <center>
                                ${clase.name}<br>
                                <img style="width:100px; height: 80px;" src="<?= base_url() ?>/assets/images/icons/${clase.icon}"><br>
                                <a class="btn btn-danger btn-sm eliminar-clase" data-id="${clase.id}">X</a>
                            </center>
                            </th>
                            `);
                                iter += 1;
                            } else {
                                if (CombustibleSeleccionado.id == 1) {
                                    trow.append(`
                                    <td class="ptl-table-colum-clase-${clase.id}">
                                        <div class="ptl-da ptl-w-100">
                                            <div>Vehículos</div>
                                            <div class="">
                                                <center>
                                                    Euro5
                                                    <input type="checkbox" class="euro5-check form-checkbox" id="euro5-${clase.id}" data-id="${clase.id}">
                                                </center>
                                            </div>
                                            <div class="">
                                                <center>
                                                    Euro6
                                                    <input type="checkbox" class="euro6-check form-checkbox" id="euro6-${clase.id}" data-id="${clase.id}">
                                                </center>
                                            </div>                                            
                                        </div>
                                    </td>
                                `)
                                } else {
                                    trow.append(`
                                    <td class="ptl-table-colum-clase-${clase.id}">
                                        <div class="col-md-12">
                                            <label>Vehículos</label>
                                        </div>
                                    </td>
                                `);
                                }
                            }
                        } else {
                            let year = trow.find('.quantity').data('year');

                            let buildRow = `
                                <td class="ptl-table-colum-clase-${clase.id}">
                            `;

                            if (year == undefined) {

                                if (CombustibleSeleccionado.id == 1) {

                                    buildRow += `
                                        
                                        <div class="ptl-da ptl-w-100">
                                            <div>
                                                <input class="form-control total-col-quantity" type="text" data-classid="${clase.id}" value="0" disabled>
                                            </div>
                                            <div class="euro5-${clase.id} d-none">
                                                <input class="form-control total-col-euro5" type="text" data-classid="${clase.id}" value="0" disabled>
                                            </div>
                                            <div class="euro6-${clase.id} d-none">
                                                <input class="form-control total-col-euro6" type="text" data-classid="${clase.id}" value="0" disabled>
                                            </div>
                                        </div>

                                        `;

                                } else {
                                    buildRow += `
                                        <div class="col-md-12">
                                            <div>
                                                <input class="form-control total-col-quantity" type="text" data-classid="${clase.id}" value="0" disabled>
                                            </div>
                                        </div>
                                        `;
                                }

                            } else {
                                if (CombustibleSeleccionado.id == 1) {

                                    buildRow += `

                                        <div class="ptl-da ptl-w-100">
                                        <div >
                                            <input class="form-control quantity quantity-year-${year} quantity-col-${clase.id}" type="text" data-classid="${clase.id}" data-year="${year}">
                                        </div>                                    
                                        <div class="euro5-${clase.id} d-none">
                                            <input class="form-control euro5 euro5-col-${clase.id}" type="text" data-classid="${clase.id}" data-year="${year}">
                                        </div>                                    
                                        <div class="euro6-${clase.id} d-none">
                                            <input class="form-control euro6 euro6-col-${clase.id}" type="text" data-classid="${clase.id}" data-year="${year}">
                                        </div>                                                                    
                                        </div>

                                        `;

                                } else {
                                    buildRow += `
                                        <div class="col-md-12">
                                            <input class="form-control quantity quantity-year-${year} quantity-col-${clase.id}" type="text" data-classid="${clase.id}" data-year="${year}">
                                        </div>
                                        `;
                                }
                            }

                            buildRow += `
                                </td>
                            `;

                            trow.append(buildRow);
                        }
                    });
                }

            });

        <?php endif ?>

        /*=====================================
        CALCULAR TOTAL
        =====================================*/
        $('.table-clases-quantity').on('change', '.quantity', function() {
            let suma = 0;

            let year = $(this).data('year');

            $(document).find(`.quantity-year-${year}`).each(function() {
                if ($(this).val().length != 0) {
                    suma += parseInt($(this).val());
                }
            });

            $(document).find(`.total-${year}`).each(function() {
                $(this).val(suma > 0 ? suma : '0');
            });

            // Total columnas

            suma = 0;

            const classid = $(this).data('classid');

            $(document).find(`.quantity-col-${classid}`).each(function() {
                if ($(this).val().length != 0) {
                    suma += parseInt($(this).val());
                }
            });

            $(`.ptl-table-colum-clase-${classid}`).find('.total-col-quantity').val(suma > 0 ? suma : '0');

        })

        $('.table-clases-quantity').on('change', '.euro5', function() {
            // Total columnas

            suma = 0;

            const classid = $(this).data('classid');

            $(document).find(`.euro5-col-${classid}`).each(function() {
                if ($(this).val().length != 0) {
                    suma += parseInt($(this).val());
                }
            });

            $(`.ptl-table-colum-clase-${classid}`).find('.total-col-euro5').val(suma > 0 ? suma : '0');

        })

        $('.table-clases-quantity').on('change', '.euro6', function() {
            // Total columnas

            suma = 0;

            const classid = $(this).data('classid');

            $(document).find(`.euro6-col-${classid}`).each(function() {
                if ($(this).val().length != 0) {
                    suma += parseInt($(this).val());
                }
            });

            $(`.ptl-table-colum-clase-${classid}`).find('.total-col-euro6').val(suma > 0 ? suma : '0');

        })

        $('.quantity').trigger('change');
        $('.euro5').trigger('change');
        $('.euro6').trigger('change');
    })

    <?php if (!isset($administrator)) : ?>

        /**
         * Funcion para guardar la información cargada en tab: Reducción de PM
         * @author Luis Hernandez <luis07hernandez05@outlook.es> 
         * @created 18/10/2021
         */
        function guardarQuantity() {

            emptyMensajes();

            let data = [];

            $('.quantity').each(function() {
                data.push({
                    quantity: $(this).val(),
                    year: $(this).data('year'),
                    classid: $(this).data('classid')
                });
            })

            $('.euro5').each(function() {
                data.push({
                    euro5: $(this).val(),
                    year: $(this).data('year'),
                    classid: $(this).data('classid')
                });
            })

            $('.euro6').each(function() {
                data.push({
                    euro6: $(this).val(),
                    year: $(this).data('year'),
                    classid: $(this).data('classid')
                });
            })

            /*=====================================
            OBTENEMOS CLASES QUE TIENEN EURO5 o EURO6 ACTIVADOS
            =====================================*/

            let euros5 = [];

            $('.euro5-check').each(function() {
                let obj = null;
                if ($(this).is(':checked')) {
                    obj = {
                        euro5: 1,
                        vclass_id: $(this).data('id')
                    }
                } else {
                    obj = {
                        euro5: 0,
                        vclass_id: $(this).data('id')
                    }
                }
                euros5.push(obj);
            })

            let euros6 = [];

            $('.euro6-check').each(function() {
                let obj = null;
                if ($(this).is(':checked')) {
                    obj = {
                        euro6: 1,
                        vclass_id: $(this).data('id')
                    }
                } else {
                    obj = {
                        euro6: 0,
                        vclass_id: $(this).data('id')
                    }
                }
                euros6.push(obj);
            })

            var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/guardarFlotasCombustibleQuantity', {
                ff: '<?= $_GET['ff'] ?>',
                flota: '<?= $_GET['flota'] ?>',
                data: data,
                euros5: euros5,
                euros6: euros6,
                clases_eliminadas: ClasesEliminadas,
                clases_agregadas: ClasesAgregadas,
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
    <?php if (!isset($administrator)) : ?>
        <ol>
            <li class="li-none">
                <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="ubicando_los_camiones_de_sus_flotas"></span>
                <div class="li-number">1</div>
                <h5 class="d-inline">
                    Ingrese, por clase y a&ntilde;o modelo,&nbsp;el n&uacute;mero de unidades que&nbsp;tiene al 31 de diciembre del a&ntilde;o&nbsp;que est&aacute; reportando.
                </h5>
            </li>
            <li class="li-none">
                <div class="li-number">2</div>
                <h5 class="d-inline">
                    El total de cada clase se calcula&nbsp;autom&aacute;ticamente.
                </h5>
            </li>
        </ol>
    <?php endif ?>
    <hr class="hr-separation">
    </hr>
    <h2><?= $combustible_seleccionado['name'] ?></h2>
    <?php if (!isset($administrator)) : ?>
        <!-- <div class="row"> -->
        <!-- AGREGAR MAS CLASES -->
        <!-- <div class="col-md-4 form-inline">
                <select class="form-control agregarMasClases">
                    <?php
                    foreach ($vClasses as $value) {
                    ?>
                        <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <button class="btn btn-success agregarClase">Agregar</button>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <button class="btn-primary col-md-12 button-success">Guardar</button>
            </div>
        </div> -->
    <?php endif ?>
    <div role="region" aria-labelledby="caption" tabindex="0" style="margin-top:-20px;">
        <table class="table table-clases-quantity ptl-table-header-colum-as">
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
                <tr>
                    <th>
                        Total
                    </th>
                    <td>
                    </td>
                    <?php foreach ($vClasses as $key => $t) : ?>
                        <?php foreach ($clases_seleccionadas as $k => $clase) : ?>
                            <?php if ($clase['id'] == $t['id']) : ?>
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
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endforeach ?>

                </tr>

            </thead>
            <tbody>
                <tr>
                    <th>
                        A&ntilde;o-modelo
                    </th>
                    <td>
                        Total de camiones
                    </td>
                    <?php foreach ($clases_seleccionadas as $key => $clase) : ?>
                        <?php if ($combustible_seleccionado['id'] == 1) : ?>
                            <td class="ptl-min-w ptl-table-colum-clase-<?= $clase['id'] ?> <?= isset($administrator) ? 'ptl-disabled-admin' : '' ?>">
                                <div class="ptl-da ptl-w-100">
                                    <div>Vehículos</div>
                                    <!-- <div class="">
                                        <center>
                                            Euro5
                                            <input type="checkbox" value="1" class="euro5-check form-checkbox" id="euro5-<?= $clase['id'] ?>" data-id="<?= $clase['id'] ?>" <?= $clase['euro5'] == 1 ? 'checked' : '' ?>>
                                        </center>
                                    </div>
                                    <div class="">
                                        <center>
                                            Euro6
                                            <input type="checkbox" value="1" class="euro6-check form-checkbox" id="euro6-<?= $clase['id'] ?>" data-id="<?= $clase['id'] ?>" <?= $clase['euro6'] == 1 ? 'checked' : '' ?>>
                                        </center>
                                    </div> -->
                                </div>
                            </td>
                        <?php else : ?>
                            <td class="ptl-table-colum-clase-<?= $clase['id'] ?>">
                                <label>Vehículos</label>
                            </td>
                        <?php endif ?>
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

                <?php for ($i = $year; $i >= $last_year; $i--) : ?>
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
                        <?php foreach ($vClasses as $key => $t) : ?>
                            <?php foreach ($clases_seleccionadas as $k => $clase) : ?>
                                <?php if ($clase['id'] == $t['id']) : ?>
                                    <?php
                                    // Obtenemos los valores de fila a pintar
                                    $item = null;
                                    foreach ($fleets_fuels_vclass_quantity_data as $k => $v) {
                                        if ($clase['id'] == $v['vclass_id'] && $v['year'] == $i) {
                                            $item = $v;
                                        }
                                    }

                                    $item_value = !isset($item['quantity']) ? '' : ($item['quantity'] == 0 ? '' : $item['quantity']);

                                    if ($combustible_seleccionado['id'] == 1) {

                                        $euro5 = !isset($item) ? '' : ($item['euro5'] == 0 ? '' : $item['euro5']);
                                        $euro6 = !isset($item) ? '' : ($item['euro6'] == 0 ? '' : $item['euro6']);
                                    ?>
                                        <td class="ptl-table-colum-clase-<?= $clase['id'] ?> <?= isset($administrator) ? 'ptl-disabled-admin' : '' ?>">
                                            <div class="ptl-da ptl-w-100">
                                                <div>
                                                    
                                                    <input class="form-control quantity quantity-year-<?= $i ?> quantity-col-<?= $clase['id'] ?>" type="text" data-classid="<?= $clase['id'] ?>" data-year="<?= $i ?>" value="<?= $item_value ?>" placeholder="Cantidad">
                                                </div>
                                                <?php if ($i >= 2019) : ?>
                                                    <div class="<?= $clase['euro5'] == 0 ? 'd-none' : '' ?> euro5-<?= $clase['id'] ?>">
                                                        <input class="form-control euro5 euro5-col-<?= $clase['id'] ?>" type="text" data-classid="<?= $clase['id'] ?>" data-year="<?= $i ?>" value="<?= $euro5 ?>" placeholder="Euro5">
                                                    </div>
                                                    <div class="<?= $clase['euro6'] == 0 ? 'd-none' : '' ?> euro6-<?= $clase['id'] ?>">
                                                        <input class="form-control euro6 euro6-col-<?= $clase['id'] ?>" type="text" data-classid="<?= $clase['id'] ?>" data-year="<?= $i ?>" value="<?= $euro6 ?>" placeholder="Euro6">
                                                    </div>
                                                <?php endif ?>
                                            </div>
                                        </td>
                                    <?php
                                    } else {
                                    ?>
                                        <td class="ptl-table-colum-clase-<?= $clase['id'] ?> <?= isset($administrator) ? 'ptl-disabled-admin' : '' ?>">
                                            <input class="form-control quantity quantity-year-<?= $i ?> quantity-col-<?= $clase['id'] ?>" type="text" data-classid="<?= $clase['id'] ?>" data-year="<?= $i ?>" value="<?= $item_value ?>">
                                        </td>
                                    <?php
                                    }
                                    ?>


                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endforeach ?>

                    </tr>
                <?php endfor ?>
                <!-- TOTAL DE CLASE POR COLUMNA -->
            </tbody>
        </table>
    </div>
    <br>
    <br>
    <div style="text-align:right;">
        <?php if (!isset($administrator)) : ?>
            <?php if (!empty($fleets_fuels_vclass_quantity_data)) : ?>
                <a href="<?= base_url() ?>/Empresas/empresa/flotasCombustiblesTravels?flota=<?= $_GET['flota'] ?>&ff=<?= $_GET['ff'] ?>" class="btn btn-success">Continuar</a>
            <?php endif ?>
            <button class="btn btn-primary button-success">Guardar</button>
        <?php endif ?>
    </div>
</div>