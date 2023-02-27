<script>
    let ClasesAgregadas = [];
    let ClasesEliminadas = [];
    let Clases = <?= json_encode($vClasses) ?>;
    const CombustibleSeleccionado = <?= json_encode($combustible_seleccionado) ?>;

    $(document).ready(function() {

        /*=====================================
        CLASES | CLASES
        =====================================*/

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

            emptyMensajes();

            guardarClases();
        })

        $('.clases-guardar-y-continuar').on('click', function() {

            emptyMensajes();

            guardarClases();

            $('#nav-tab-02').trigger('click');
        })

        /*=====================================
        QUANTITY | AÑO MODELO DEL MOTOR Y CLASE
        =====================================*/

        $('#nav-tab-02').click(function() {

            let fleets_fuels_vclass_quantity_data = <?= json_encode($fleets_fuels_vclass_quantity_data) ?>;

            let clases = [];
            let buildTable = `
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    `;

            for (clase of <?= json_encode($vClasses) ?>) {
                if (ClasesAgregadas.includes(clase.id)) {
                    clases.push(clase);

                    buildTable += `
                    <th>
                    <center>
                    ${clase.name}<br>
                    <img style="width:100px; height: 80px;" src="<?= base_url() ?>/assets/images/icons/${clase.icon}"><br>
                    </th>
                    </center>
                    `;

                }
            }

            buildTable += `
                </tr>
            </thead>
            <tbody>
            `;

            buildTable += `
                    <tr>
                        <th>
                            Años
                        </th>
                        <th>
                            Total de camiones
                        </th>
                `;

            for (clase of clases) {
                if (CombustibleSeleccionado.id == 1) {
                    buildTable += `
                            <th class="ptl-min-w">
                                <table class="ptl-w-100">
                                    <tr>
                                        <td width="33%">Quantity</td>
                                        <!--<td width="33%" class="">
                                            <center>
                                            Euro5
                                            <input type="checkbox" class="euro5-check form-checkbox" id="euro5-${clase.id}" data-id="${clase.id}">
                                            </center>
                                        </td>
                                        <td width="33%" class="">
                                            <center>
                                            Euro6
                                            <input type="checkbox" class="euro6-check form-checkbox" id="euro6-${clase.id}" data-id="${clase.id}">
                                            </center>
                                        </td>-->
                                    </tr>
                                </table>
                            </th>
                        `;
                } else {
                    buildTable += `
                            <th class="ptl-min-w">
                                <div class="col-md-12">
                                    <label>Quantity</label>
                                </div>
                            </th>
                        `;
                }
            }

            buildTable += `
                    </tr>
                `;

            var today = new Date();
            var year = today.getFullYear();

            for (var i = year; i >= 1988; i--) {

                buildTable += `
                    <tr>
                        <th>
                            ${i}
                        </th>
                        <th>
                            <input class="form-control total_camiones total-${i}" type="text" disabled>
                        </th>
                `;

                for (clase of clases) {

                    let item = fleets_fuels_vclass_quantity_data.find(element => (element.vclass_id == clase.id && element.year == i));

                    let value = item == undefined ? '' : (item == 0 ? '' : item.quantity);

                    buildTable += `
                            <th><div class="row">
                    `;

                    if (CombustibleSeleccionado.id == 1) {
                        let euro5 = item == undefined ? '' : (item == 0 ? '' : item.euro5);
                        let euro6 = item == undefined ? '' : (item == 0 ? '' : item.euro6);
                        buildTable += `

                            <table class="ptl-inputs-table">
                                <tr>
                                    <td width="33%">
                                        <input class="form-control quantity quantity-year-${i}" type="text" data-classid="${clase.id}" data-year="${i}" value="${value}">
                                    </td>                                    
                                    <td width="33%" class="euro5-${clase.id} d-none">
                                        <input class="form-control euro5" type="text" data-classid="${clase.id}" data-year="${i}" value="${euro5}">
                                    </td>                                    
                                    <td width="33%" class="euro6-${clase.id} d-none">
                                        <input class="form-control euro5" type="text" data-classid="${clase.id}" data-year="${i}" value="${euro6}">
                                    </td>                                    
                                </tr>
                            </table>

                            `;

                    } else {
                        buildTable += `
                        <div class="col-md-12">
                            <input class="form-control quantity quantity-year-${i}" type="text" data-classid="${clase.id}" data-year="${i}" value="${value}">
                        </div>
                        `;
                    }

                    buildTable += `
                    </div></th>
                    `;
                }

                buildTable += `
                    </tr>
                `;

            }

            buildTable += `
            </tbody>
            `;

            $('.table-clases').html(buildTable);
            $('.quantity').trigger('change');
        })

        $('.agregarClase').click(function() {
            if (!ClasesAgregadas.includes($('.agregarMasClases').val())) {
                ClasesAgregadas.push($('.agregarMasClases').val());

                let iter = 1;
                var table = $('.table-clases')
                let clase = Clases.find(element => element.id == $('.agregarMasClases').val());

                table.find('tr').each(function() {
                    var trow = $(this);
                    if (trow.index() === 0) {
                        if (iter == 1) {
                            trow.append(`
                            <th>
                            <center>
                                ${clase.name}<br>
                                <img style="width:100px; height: 80px;" src="<?= base_url() ?>/assets/images/icons/${clase.icon}"><br>
                                </th>
                            </center>
                            </th>
                            `);
                            iter += 1;
                        } else {
                            if (CombustibleSeleccionado.id == 1) {
                                trow.append(`
                                    <th class="ptl-min-w">
                                        <table class="ptl-w-100">
                                            <tr>
                                                <td width="33%">Quantity</td>
                                                <td width="33%" class="">
                                                    <center>
                                                    Euro5
                                                    <input type="checkbox" class="euro5-check form-checkbox" id="euro5-${clase.id}" data-id="${clase.id}">
                                                    </center>
                                                </td>
                                                <td width="33%" class="">
                                                    <center>
                                                    Euro6
                                                    <input type="checkbox" class="euro6-check form-checkbox" id="euro6-${clase.id}" data-id="${clase.id}">
                                                    </center>
                                                </td>
                                            </tr>
                                        </table>
                                    </th>
                                `)
                            } else {
                                trow.append(`
                                    <th class="ptl-min-w">
                                        <div class="col-md-12">
                                            <label>Quantity</label>
                                        </div>
                                    </th>
                                `);
                            }
                        }
                    } else {
                        let year = trow.find('.quantity').data('year');

                        let buildRow = `
                            <th><div class="row">
                        `;

                        if (CombustibleSeleccionado.id == 1) {

                            buildTable += `

                            <table class="ptl-inputs-table">
                                <tr>
                                    <td width="33%">
                                        <input class="form-control quantity quantity-year-${year}" type="text" data-classid="${clase.id}" data-year="${year}" value="${value}">
                                    </td>                                    
                                    <td width="33%" class="euro5-${clase.id} d-none">
                                        <input class="form-control euro5" type="text" data-classid="${clase.id}" data-year="${year}" value="${euro5}">
                                    </td>                                    
                                    <td width="33%" class="euro6-${clase.id} d-none">
                                        <input class="form-control euro5" type="text" data-classid="${clase.id}" data-year="${year}" value="${euro6}">
                                    </td>                                    
                                </tr>
                            </table>

                            `;

                        } else {
                            buildTable += `
                                <div class="col-md-12">
                                    <input class="form-control quantity quantity-year-${year}" type="text" data-classid="${clase.id}" data-year="${year}" value="${value}">
                                </div>
                            `;
                        }

                        buildRow += `
                        </div></th>
                        `;

                        trow.append(buildRow);
                    }
                });
            }

        });

        $('.table-clases-reduction').on('change', '.rquantity', function() {
            let suma = 0;

            $(this).parent().parent().find('.rquantity').each(function() {
                if ($(this).val().length != 0) {
                    suma += parseInt($(this).val());
                }
            });

            $(this).parent().parent().find('.rtotal_camiones').each(function() {
                $(this).val(suma > 0 ? suma : '0');
            });
        })

        $('#nav-tab-03').click(function() {

            emptyMensajes();

            let _clases = obtenerClasesSeleccionadas();
            ClasesAgregadas = _clases.clases_checked;
            ClasesEliminadas = _clases.clases_unchecked;

            let Fleets_Fuels_Vclass_Travel_data = JSON.parse(jsonF('<?= base_url(); ?>/Empresas/empresa/traerFleets_Fuels_Vclass_Travel_data', {
                ff: '<?= $_GET['ff'] ?>'
            }));

            let clases = [];
            let buildTable = `
            <thead>
                <tr>
                    <th></th>                    
                    `;

            for (clase of <?= json_encode($vClasses) ?>) {
                if (ClasesAgregadas.includes(clase.id)) {
                    clases.push(clase);

                    buildTable += `
                    <th>
                    <center>
                    ${clase.name}<br>
                    <img style="width:100px; height: 80px;" src="<?= base_url() ?>/assets/images/icons/${clase.icon}"><br>
                    </th>
                    </center>
                    `;

                }
            }

            buildTable += `
                </tr>
            </thead>
            <tbody>
            `;

            buildTable += `
                    <tr>
                        <th>
                            ${CombustibleSeleccionado.name}<br>
                        </th>                        
                `;

            for (clase of clases) {
                buildTable += `
                        <th>
                            ${clase.code}
                        </th>
                    `;
            }

            buildTable += `
                    </tr>
                `;

            var today = new Date();
            var year = today.getFullYear();
            var field_labels = [{
                    name: 'km_tot',
                    value: 'kilómetros recorridos totales',
                    placeholder: 'Km'
                },
                {
                    name: 'km_empty',
                    value: 'kilómetros recorridos vacios',
                    placeholder: 'Km'
                },
                {
                    name: 'lts_tot',
                    value: `${CombustibleSeleccionado.comment}`,
                    placeholder: 'Lts'
                },
            ];

            if (CombustibleSeleccionado.id == 7) {
                field_labels.push({
                    name: 'hybrid_type',
                    value: 'Especifique el tipo de combustible',
                    type: 'radio'
                });
            }

            field_labels.push(...[{
                    name: 'payload_avg',
                    value: 'Carga útil promedio (toneladas) únicamente el peso de la carga',
                    placeholder: '%'
                },
                {
                    name: 'load_volume',
                    value: 'Volumen de carga del camión (metros cúbicos)',
                    placeholder: 'm³'
                },
                {
                    name: 'avg_volume',
                    value: 'Promedio de volumen de carga empleado %',
                    placeholder: '%'
                },
                {
                    name: 'highway',
                    value: 'Autopista o carretera %',
                    placeholder: '%'
                },
                {
                    name: 'less_40',
                    value: 'Menos de 40 km/h %',
                    placeholder: '%'
                },
                {
                    name: '40_80',
                    value: '40 a 80 km/h %',
                    placeholder: '%'
                },
                {
                    name: 'over_80',
                    value: 'Más de 80 km/h %',
                    placeholder: '%'
                },
                {
                    name: 'ralenti_hours_large',
                    value: 'Horas en ralentí de duración larga al día por camión',
                    placeholder: 'Hrs.'
                },
                {
                    name: 'ralenti_hours_short',
                    value: 'Horas en ralentí de duración corta al día por camión',
                    placeholder: 'Hrs.'
                },
                {
                    name: 'ralenti_days',
                    value: 'Número promedio de días en carretera al año',
                    placeholder: '%'
                },
            ])

            let aux = 1;
            for (field of field_labels) {

                buildTable += `
                    <tr>
                        <th>
                            <label>${field.value}</label>
                        </th>                        
                `;

                for (clase of clases) {

                    let item = Fleets_Fuels_Vclass_Travel_data.find(element => (element.vclass_id == clase.id));

                    let value = item == undefined ? '' : (item[field.name] == 0 ? '' : item[field.name]);

                    buildTable += `
                            <td>
                    `;

                    if (field.name == 'hybrid_type') {
                        buildTable += `                            
                            <label class="radio-inline" id="fuel-diesel">
                                <input type="radio" name="${clase.id}#${field.name}" id="fuel-diesel" value="1" ${value == 1 ? 'checked' : ''}> Diesel
                            </label>
                            <label class="radio-inline" id="fuel-gasolina">
                                <input type="radio" name="${clase.id}#${field.name}" id="fuel-gasolina" value="2" ${value == 2 ? 'checked' : ''}> Gasolina
                            </label>
                        `;
                    } else {
                        buildTable += `
                                <input 
                                class="form-control tquantity" 
                                type="text"
                                name="${clase.id}#${field.name}"
                                placeholder="${field.placeholder}" 
                                data-classid="${clase.id}" 
                                data-year="${year}" 
                                value="${value}">
                        `;
                    }


                    if (aux == field_labels.length) {

                        buildTable += `
                        
                        <input 
                        type="hidden"
                        name="${clase.id}#vclass_id"
                        value="${clase.id}"> 

                        `;
                    }

                    buildTable += `
                            </td>
                    `;
                }

                buildTable += `
                    </tr>
                `;

                aux += 1;
            }

            buildTable += `
            </tbody>
            `;

            $('.table-clases-travels').html(buildTable);
            // $('.rquantity').trigger('change');
        })

        $('#nav-tab-04').click(function() {

            emptyMensajes();

            let _clases = obtenerClasesSeleccionadas();
            ClasesAgregadas = _clases.clases_checked;
            ClasesEliminadas = _clases.clases_unchecked;

            let fleets_fuels_vclass_reduction_data = JSON.parse(jsonF('<?= base_url(); ?>/Empresas/empresa/traerFleets_Fuels_Vclass_Reduction_data', {
                ff: '<?= $_GET['ff'] ?>'
            }));

            let clases = [];
            let buildTable = `
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    `;

            for (clase of <?= json_encode($vClasses) ?>) {
                if (ClasesAgregadas.includes(clase.id)) {
                    clases.push(clase);

                    buildTable += `
                    <th>
                    <center>
                    ${clase.name}<br>
                    <img style="width:100px; height: 80px;" src="<?= base_url() ?>/assets/images/icons/${clase.icon}"><br>
                    </th>
                    </center>
                    `;

                }
            }

            buildTable += `
                </tr>
            </thead>
            <tbody>
            `;

            buildTable += `
                    <tr>
                        <th>
                            Años
                        </th>
                        <th>
                            Total de camiones
                        </th>
                `;

            for (clase of clases) {
                buildTable += `
                        <th>
                            ${clase.code}
                        </th>
                    `;
            }

            buildTable += `
                    </tr>
                `;

            var today = new Date();
            var year = today.getFullYear();

            for (var i = year; i >= 1988; i--) {

                buildTable += `
                    <tr>
                        <th>
                            ${i}
                        </th>
                        <th>
                            <input class="form-control rtotal_camiones" type="text" disabled>
                        </th>
                `;

                for (clase of clases) {

                    let item = fleets_fuels_vclass_reduction_data.find(element => (element.vclass_id == clase.id && element.year == i));

                    let value = item == undefined ? '' : (item == 0 ? '' : item.quantity);

                    buildTable += `
                            <th>
                    `;
                    buildTable += `
                            <input class="form-control rquantity" type="text" data-classid="${clase.id}" data-year="${i}" value="${value}">
                    `;
                    buildTable += `
                            </th>
                    `;
                }

                buildTable += `
                    </tr>
                `;

            }

            buildTable += `
            </tbody>
            `;

            $('.table-clases-reduction').html(buildTable);
            $('.rquantity').trigger('change');
        })

        $('.continuar').click(function() {
            $('.selecciona-combustible').hide();
        });

        $('.table-clases').on('click', '.euro5-check', function() {
            const clase_id = $(this).data('id');

            if ($(this).is(':checked')) {
                $('.table-clases > tbody').find(`.euro5-${clase_id}`).each(function() {
                    $(this).removeClass('d-none');
                })
            } else {
                $('.table-clases').find('.euro5-' + clase_id).each(function() {
                    $(this).addClass('d-none');
                })
            }
        })

        $('.table-clases').on('click', '.euro6-check', function() {
            const clase_id = $(this).data('id');

            if ($(this).is(':checked')) {
                $('.table-clases > tbody').find(`.euro6-${clase_id}`).each(function() {
                    $(this).removeClass('d-none');
                })
            } else {
                $('.table-clases').find('.euro6-' + clase_id).each(function() {
                    $(this).addClass('d-none');
                })
            }
        })

        $('.clases-guardar-y-continuar-d').click(function() {
            $(this).hide();
            $('.elegirClases').hide();
            $('.agregarInformacionClases').removeClass('d-none');

            let containerAgregarInformacionClases = $('.agregarInformacionClases');
            let fleets_fuels_vclass_quantity_data = <?= json_encode($fleets_fuels_vclass_quantity_data) ?>;

            let clases = [];
            let buildTable = `
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    `;

            for (clase of <?= json_encode($vClasses) ?>) {
                if (clasesSeleccionadas.clases_checked.includes(clase.id)) {
                    clases.push(clase);

                    buildTable += `
                    <th>
                    <center>
                    ${clase.name}<br>
                    <img style="width:100px; height: 80px;" src="<?= base_url() ?>/assets/images/icons/${clase.icon}"><br>
                    </th>
                    </center>
                    `;

                }
            }

            buildTable += `
                </tr>
            </thead>
            <tbody>
            `;

            buildTable += `
                    <tr>
                        <th>
                            Años
                        </th>
                        <th>
                            Total de camiones
                        </th>
                `;

            for (clase of clases) {
                if (CombustibleSeleccionado.id == 1) {
                    buildTable += `
                            <th class="ptl-min-w">
                                <table class="ptl-w-100">
                                    <tr>
                                        <td width="33%">Quantity</td>
                                        <td width="33%" class="">
                                            <center>
                                            Euro5
                                            <input type="checkbox" class="euro5-check form-checkbox" id="euro5-${clase.id}" data-id="${clase.id}">
                                            </center>
                                        </td>
                                        <td width="33%" class="">
                                            <center>
                                            Euro6
                                            <input type="checkbox" class="euro6-check form-checkbox" id="euro6-${clase.id}" data-id="${clase.id}">
                                            </center>
                                        </td>
                                    </tr>
                                </table>
                            </th>
                        `;
                } else {
                    buildTable += `
                            <th class="ptl-min-w">
                                <div class="col-md-12">
                                    <label>Quantity</label>
                                </div>
                            </th>
                        `;
                }
            }

            buildTable += `
                    </tr>
                `;

            var today = new Date();
            var year = today.getFullYear();

            for (var i = year; i >= 1988; i--) {

                buildTable += `
                    <tr>
                        <th>
                            ${i}
                        </th>
                        <th>
                            <input class="form-control total_camiones total-${i}" type="text" disabled>
                        </th>
                `;

                for (clase of clases) {

                    let item = fleets_fuels_vclass_quantity_data.find(element => (element.vclass_id == clase.id && element.year == i));

                    let value = item == undefined ? '' : (item == 0 ? '' : item.quantity);

                    buildTable += `
                            <th><div class="row">
                    `;

                    <?php
                    if ($combustible_seleccionado['id'] == 1) {
                    ?>
                        let euro5 = item == undefined ? '' : (item == 0 ? '' : item.euro5);
                        let euro6 = item == undefined ? '' : (item == 0 ? '' : item.euro6);
                        buildTable += `

                            <table class="ptl-inputs-table">
                                <tr>
                                    <td width="33%">
                                        <input class="form-control quantity" type="text" data-classid="${clase.id}" data-year="${i}" value="${value}">
                                    </td>                                    
                                    <td width="33%" class="euro5-${clase.id} d-none">
                                        <input class="form-control euro5" type="text" data-classid="${clase.id}" data-year="${i}" value="${euro5}">
                                    </td>                                    
                                    <td width="33%" class="euro6-${clase.id} d-none">
                                        <input class="form-control euro5" type="text" data-classid="${clase.id}" data-year="${i}" value="${euro6}">
                                    </td>                                    
                                </tr>
                            </table>

                            `;
                    <?php
                    } else {
                    ?>
                        buildTable += `
                        <div class="col-md-12">
                            <input class="form-control quantity" type="text" data-classid="${clase.id}" data-year="${i}" value="${value}">
                        </div>
                        `;
                    <?php
                    }
                    ?>

                    buildTable += `
                    </div></th>
                    `;
                }

                buildTable += `
                    </tr>
                `;

            }

            buildTable += `
            </tbody>
            `;


            ClasesAgregadas = clasesSeleccionadas.clases_checked;
            ClasesEliminadas = clasesSeleccionadas.clases_unchecked;

            $('.table-clases').html(buildTable);
            $('.quantity').trigger('change');
        });

        $('.table-clases').on('change', '.quantity', function() {
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
        })

        $('.quantityGuardarYContinuar').click(function() {
            guardarQuantity();
            $('#nav-tab-03').trigger('click');
        });

        $('.guardarTravels').on('click', function(e) {
            e.preventDefault();
            guardarTravels();
        })

        $('.table-clases-travels').on('click', '.button-comment', function() {
            let data = JSON.parse(atob($(this).data('o')));

            popUp('<?= base_url() ?>/Empresas/empresa/travelClassFuelComentario', data);
        })

        // setInterval(() => {
        //     console.log(ClasesAgregadas);
        //     console.log(ClasesEliminadas);
        // }, 500);

    });

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
            agregadas: ClasesAgregadas,
            eliminadas: ClasesEliminadas,
        });

        rj = JSON.parse(rj);

        if (rj.ok == 1) {
            var html = `
					<div class="alert alert-success" role="alert">
                        ${rj.mensaje}
					</div>
				`;

            $('#mensaje').html(html);

            setTimeout(function() {
                $('#mensaje').empty();
            }, 3000);
        } else {
            var html = `
					<div class="alert alert-danger" role="alert">
                        ${rj.errores}
					</div>
				`;
            $('#mensaje').html(html);
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

    /**
     * Funcion para guardar la información cargada en tab: Año modelo del motor y clase 
     * @author Luis Hernandez <luis07hernandez05@outlook.es> 
     * @created 18/10/2021
     */
    function guardarQuantity() {

        emptyMensajes();

        const clasesSeleccionadas = obtenerClasesSeleccionadas();
        ClasesAgregadas.push(...clasesSeleccionadas.clases_checked)
        ClasesEliminadas.push(...clasesSeleccionadas.clases_unchecked)

        let data = [];
        let dataEuro5 = [];
        let dataEuro6 = [];

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

        var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/flotasGuardarInformacionCombustibles', {
            ff: '<?= $_GET['ff'] ?>',
            flota: '<?= $_GET['flota'] ?>',
            clases_checked: ClasesAgregadas,
            clases_unchecked: ClasesEliminadas,
            data: data
        });

        rj = JSON.parse(rj);

        if (rj.ok == 1) {
            var html = `
					<div class="alert alert-success" role="alert">
                        ${rj.mensaje}
					</div>
				`;

            $('#mensaje').html(html);

            setTimeout(function() {
                $('#mensaje').empty();
            }, 3000);

            if ('errores' in rj) {
                html = `
					<div class="alert alert-danger" role="alert">
                        <h3>Tú información se ha guardado, pero tienes estos errores.</h3>
                        ${rj.errores}
					</div>
				`;
                $('#mensaje-errores').html(html);
            }
        } else {
            var html = `
					<div class="alert alert-danger" role="alert">
                        ${rj.errores}
					</div>
				`;
            $('#mensaje').html(html);

            // setTimeout(function(){
            //     $('#mensaje').empty();
            // },3000);          
        }

    }

    /**
     * Funcion para guardar la información cargada en tab: Información de actividad 
     * @author Luis Hernandez <luis07hernandez05@outlook.es> 
     * @created 18/10/2021
     */
    function guardarTravels() {

        emptyMensajes();

        const data = $('#form-travels').serializeObject();

        var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/guardarflotasCombustiblesTravels', {
            ff: '<?= $_GET['ff'] ?>',
            flota: '<?= $_GET['flota'] ?>',
            clases_checked: ClasesAgregadas,
            clases_unchecked: ClasesEliminadas,
            data: data
        });

        rj = JSON.parse(rj);

        if (rj.ok == 1) {
            var html = `
					<div class="alert alert-success" role="alert">
                        ${rj.mensaje}
					</div>
				`;
            $('#mensaje').html(html);

            setTimeout(function() {
                $('#mensaje').empty();
            }, 3000);

            if ('errores' in rj) {
                html = `
					<div class="alert alert-danger" role="alert">
                        <h3>Tú información se ha guardado, pero tienes estos errores.</h3>
                        ${rj.errores}
					</div>
				`;
                $('#mensaje-errores').html(html);
            }

            for (item of rj.validacion) {
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

            $('#nav-tab-04').trigger('click');
        } else {
            var html = `
					<div class="alert alert-danger" role="alert">
                        ${rj.errores}
					</div>
				`;
            $('#mensaje').html(html);

            // setTimeout(function(){
            //     $('#mensaje').empty();
            // },3000);          
        }
    }

    /**
     * Funcion para guardar la información cargada en tab: Reducción de PM
     * @author Luis Hernandez <luis07hernandez05@outlook.es> 
     * @created 18/10/2021
     */
    function guardarReduction() {

        emptyMensajes();

        let data = [];

        $('.rquantity').each(function() {
            data.push({
                quantity: $(this).val(),
                year: $(this).data('year'),
                classid: $(this).data('classid')
            });
        })

        var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/guardarflotasCombustiblesReduction', {
            ff: '<?= $_GET['ff'] ?>',
            flota: '<?= $_GET['flota'] ?>',
            clases_checked: ClasesAgregadas,
            clases_unchecked: ClasesEliminadas,
            data: data
        });

        rj = JSON.parse(rj);

        if (rj.ok == 1) {
            var html = `
					<div class="alert alert-success" role="alert">
                        ${rj.mensaje}
					</div>
				`;
            $('#mensaje').html(html);

            setTimeout(function() {
                $('#mensaje').empty();
            }, 3000);

            if ('errores' in rj) {
                html = `
					<div class="alert alert-danger" role="alert">
                        <h3>Tú información se ha guardado, pero tienes estos errores.</h3>
                        ${rj.errores}
					</div>
				`;
                $('#mensaje-errores').html(html);
            }

        } else {
            var html = `
					<div class="alert alert-danger" role="alert">
                        ${rj.errores}
					</div>
				`;
            $('#mensaje').html(html);

            // setTimeout(function(){
            //     $('#mensaje').empty();
            // },3000);          
        }
    }

</script>
<?PHP
/*=====================================

=====================================*/
?>
<div id="mensaje"></div>
<div id="mensaje-errores"></div>

<div>
    <ul class="nav nav-tabs">
        <!--=====================================
        CLASES | CLASES
        ======================================-->
        <li class="nav-item active">
            <a class="nav-link" id="nav-tab-01" data-toggle="tab" href="#nav-01" role="tab" aria-controls="nav-01" aria-selected="true">Clases</a>
        </li>
        <!--=====================================
        QUANTITY | AÑO MODELO DEL MOTOR Y CLASE
        ======================================-->
        <li class="nav-item">
            <a class="nav-link" id="nav-tab-02" data-toggle="tab" href="#nav-02" role="tab" aria-controls="nav-02" aria-selected="true">Año modelo del motor y claseBBB</a>
        </li>
        <!--=====================================
        TRAVELS | INFORMACIÓN DE ACTIVIDAD
        ======================================-->
        <li class="nav-item">
            <a class="nav-link" id="nav-tab-03" data-toggle="tab" href="#nav-03" role="tab" aria-controls="nav-03" aria-selected="true">Información de actividad</a>
        </li>
        <!--=====================================
        REDUCTION |  REDUCCIÓN DE PM 
        NOTA: SOLO SI ES DIESEL
        ======================================-->
        <?php
        if ($combustible_seleccionado['id'] == 1) {
        ?>
            <li class="nav-item">
                <a class="nav-link" id="nav-tab-04" data-toggle="tab" href="#nav-04" role="tab" aria-controls="nav-04" aria-selected="true">Reducción de PM</a>
            </li>
        <?php
        }
        ?>
        <br>

        <!-- =====================================
        INICIO: VALIDAR STATUS DE FLOTAS
        =====================================*/ -->
        <div class="tab-content <?= isset($fleet['status']) && $fleet['status'] >= 100 ? 'ptl-disabled' : '' ?>" id="nav-tabContent">
            <!--=====================================
            CLASES | CLASES
            ======================================-->
            <div class="tab-pane active fade in" id="nav-01" role="tabpanel" aria-labelledby="nav-tab-01">
                <div class="elegirClases">
                    <ol>
                        <li class="li-none">
                            <div class="li-number">1</div>
                            <h5 class="d-inline">Selecciona la clase de camiones que vas a evaluar y da click en continuar</h5>
                        </li>
                    </ol>
                    <h2><?= $combustible_seleccionado['name'] ?></h2>
                    <label style="font-weight: lighter;">Nota: Las siluetas representan un ejemplo de los tipos de camiones para cada clase, más no incluye todos</label>
                    <div class="form-group">
                        <!-- ICONO AQUI -->
                        <label style="font-weight: lighter;">Peso bruto vehicular (toneladas)</label>
                    </div>
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
                                    <div class="col-md-3 ptl-card-container">
                                        <label for="c-<?= $value['id'] ?>" class="checkbox-card">
                                            <input type="checkbox" class="clases-clase-checkbox" value="<?= $value['id'] ?>" name="c-<?= $value['id'] ?>" id="c-<?= $value['id'] ?>" <?= in_array($value['id'], $_clases_seleccionadas_ids) ? 'checked' : '' ?> />
                                            <div class="ptl-card-content-wrapper">
                                                <div class="ptl-card">
                                                    <center>
                                                        <img class="ptl-card-img" src="<?= base_url() ?>/assets/images/icons/<?= $value['icon'] ?>" style="width: ">
                                                    </center>
                                                    <div class="ptl-card-body">
                                                        <?= $value['name'] ?>
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
                <div>
                    <button class="btn btn-primary clases-guardar">Guardar</button>
                    <a class="btn btn-warning clases-guardar-y-continuar">Guardar y continuar</a>
                </div>
            </div>
            <!--=====================================
            QUANTITY | AÑO MODELO DEL MOTOR Y CLASE
            ======================================-->
            <div class="tab-pane fade" id="nav-02" role="tabpanel" aria-labelledby="nav-tab-02">
                <div class="agregarInformacionClases">
                    <ol>
                        <li class="li-none">
                            <div class="li-number">1</div>
                            <h5 class="d-inline">Ingresa el número de camiones que tienes al 31 de diciembre del año que se reporta por clase y año modelo del motor.</h5>
                        </li>
                        <li class="li-none">
                            <div class="li-number">2</div>
                            <h5 class="d-inline">El total de cada clase se calcula automaticamente. &nbsp;</h5>
                        </li>
                    </ol>
                    <hr class="hr-separation">
                    </hr>
                    <h2><?= $combustible_seleccionado['name'] ?></h2>
                    <label style="font-weight: lighter;">Nota: Las siluetas representan un ejemplo de los tipos de camiones para cada clase, más no incluye todos</label>
                    <div class="form-group">
                        <!-- ICONO AQUI -->
                        <label style="font-weight: lighter;">Peso bruto vehicular (toneladas)</label>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-inline">
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
                            <button class="btn-primary col-md-12 quantityValidarInformacion">Validar infromación</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn-primary col-md-12 quantityGuardarYContinuar">Guardar y continuar</button>
                        </div>
                    </div>
                    <div role="region" aria-labelledby="caption" tabindex="0">
                        <table class="table table-bordered table-clases ptl-table-header-colum-as">
                        </table>
                    </div>
                </div>
            </div>
            <!--=====================================
            TRAVELS | INFORMACIÓN DE ACTIVIDAD
            ======================================-->
            <div class="tab-pane fade" id="nav-03" role="tabpanel" aria-labelledby="nav-tab-03">
                <form id="form-travels">
                    <div role="region" aria-labelledby="caption" tabindex="0">
                        <table class="table table-bordered table-clases-travels ptl-table-header-colum-as">
                        </table>
                    </div>
                </form>
                <div>
                    <button class="btn btn-primary reductionGuardar" onclick="guardarTravels()">Guardar, validar y continuar</button>
                </div>

            </div>
            <!--=====================================
            REDUCTION |  REDUCCIÓN DE PM 
            NOTA: SOLO SI ES DIESEL
            ======================================-->
            <?php
            if ($combustible_seleccionado['id'] == 1) {
            ?>
                <div class="tab-pane fade" id="nav-04" role="tabpanel" aria-labelledby="nav-tab-04">
                    <center>
                        <h5>Trampa de particula para PM por clase de camión</h5>
                    </center>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <button class="btn-primary col-md-12 reductionGuardar" onclick="guardarReduction()">Guardar</button>
                        </div>
                    </div>
                    <br>
                    <div class="overflow-x ptl-width-100">
                        <table class="table table-clases-reduction">
                        </table>
                    </div>
                    <div>
                        <button class="btn btn-primary reductionGuardar" onclick="guardarReduction()">Guardar</button>
                    </div>
                </div>
            <?php
            }
            ?>
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

    th {
        text-align: center !important;
    }

    .ptl-min-w {
        min-width: 400px !important;
    }
</style>