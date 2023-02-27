<script>
    let ContadorFormularios = <?= count($fleets) ?>;
    let Company = <?= json_encode($company) ?>;
    let Eliminados = [];
    let ActualTab = <?= isset($_GET['tab']) ? "'" . $_GET['tab'] . "'" : '"nav-tab-01"' ?>;

    $(document).ready(function() {

        //Pedir descripcion se agrega un valor a transporte especializado 
        $('.table-carroceria').on('change', '.transporte-especializado', function() {

            if (parseInt($(this).val()) > 0) {
                if ($(this).parent().find('.carrecoeria-description').length == 0) {
                    let formid = $(this).data('form');
                    $(this).parent().append(`<textarea name="${formid}[descripcion]" class="form-control carrecoeria-description"></textarea>`)
                }
            } else {
                $(this).parent().parent().find('textarea').remove();
            }

        })

        //Obtener tab actual
        $('.flotasTab').on('click', function() {
            ActualTab = $(this).attr('id');
        });

        //Nombre nueva flota
        $('.table-identificar-flotas').on('change', '.fleetName', function() {

            let formid = $(this).data('form');
            let valor = $(this).val();

            $('.fleetCompanyName-' + formid).each(function() {
                $(this).html(Company.name + ': ' + valor);
            })

            $('.fleetName-' + formid).each(function() {
                $(this).html(valor);
            })
        })

        //Eliminar flota
        $('.table-identificar-flotas').on('click', '.eliminarFlota', function() {
            let formName = $(this).data('form');
            let id = $(this).parent().parent().data('a');

            $('.' + formName).each(function() {
                $(this).remove();
            })

            if (id != undefined) {
                Eliminados.push(id);
            }
        })

        $('.table-carroceria').on('change', '.validar', 'tbody', function() {
            validar($(this));
        })

        $('.table-operacion').on('change', '.validar', 'tbody', function() {
            validar($(this));
        })

        //Guardar información        
        $('.button-submit').on('click', function() {

            emptyMensajes();

            let data = $('.form-descripcion-flotas').serializeObject();

            var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/guardarDescripcionFlotas', {
                eliminados: Eliminados
            });

            var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/guardarDescripcionFlotas', data);

            rj = JSON.parse(rj);

            if (rj.ok == 1) {
                window.location = `<?= base_url(); ?>/Empresas/empresa/descripcionFlotas?tab=${ActualTab}`;
            } else {
                mostrarMensaje(rj.errores, 'error');
            }
        });

        $('.agregarFlota').click(function() {
            let table_identificar_flotas_rows = '';
            let table_smartway_rows = '';

            table_identificar_flotas_rows += `
            
            <tr class="flota-data f-${ContadorFormularios}" data-form="${ContadorFormularios}">
                <td>
                    ${Company.name}
                </td>
                <td>
                    <input type="text" name="${ContadorFormularios}[name]" value="" class="form-control fleetName" data-form="${ContadorFormularios}">
                </td>
                <td>
                    <select name="${ContadorFormularios}[type]" class="form-control fleetType">
                        <option value="1">Privado</option>
                        <option value="2">Dedicado</option>
                        <option value="3">Para-Alquilar</option>
                    </select>
                </td>
                <td>
                    <div class="ptl-word-break fleetCompanyName-${ContadorFormularios}">
                        ${Company.name}: 
                    </div>                      
                </td>
                <td>
                    <a class="btn btn-danger eliminarFlota" data-form="f-${ContadorFormularios}">X</a>
                </td>
            </tr>
            `;

            //OPERACION
            let iter = 0;
            $('.fleet-operacion').find('tr').each(function() {
                var trow = $(this);
                if (iter === 0) {
                    if (trow.index() === 0) {
                        trow.append(
                            `                              
                                <th class="f-${ContadorFormularios}">
                                    <div class="ptl-word-break fleetName-${ContadorFormularios}">
                                            
                                    </div>                                      
                                </th>                            
                            `
                        );
                    }
                } else {

                    switch (iter) {
                        case 1:
                            input = `<input type="text" name="${ContadorFormularios}[carga_dedicada]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="operacion">`
                            break;
                        case 2:
                            input = `<input type="text" name="${ContadorFormularios}[carga_consolidada]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="operacion">`
                            break;
                        case 3:
                            input = `<input type="text" name="${ContadorFormularios}[acarreo]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="operacion">`
                            break;
                        case 4:
                            input = `<input type="text" name="${ContadorFormularios}[paqueteria]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="operacion">`
                            break;
                        case 5:
                            input = `<input type="text" name="${ContadorFormularios}[expedito]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="operacion">`
                            break;
                        case 6:
                            input = `<input type="text" name="${ContadorFormularios}[total_operacion]" value="" class="form-control total  fit-${ContadorFormularios}" data-form="${ContadorFormularios}" readonly>`
                            break;
                    }

                    trow.append(
                        `
                            <td class="f-${ContadorFormularios}">
                                ${input}
                            </td>
                        `
                    );
                }
                iter++;
            });

            //CARROCERIA
            iter = 0;
            $('.fleet-carroceria').find('tr').each(function() {
                var trow = $(this);
                if (iter === 0) {
                    if (trow.index() === 0) {
                        trow.append(
                            `   
                            <th class="f-${ContadorFormularios}">
                                <div class="ptl-word-break fleetName-${ContadorFormularios}">
                                
                                </div>   
                            </th>
                            `
                        );
                    }
                } else {
                    switch (iter) {
                        case 1:
                            input = `<input type="text" name="${ContadorFormularios}[caja_seca]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="carroceria">`
                            break;
                        case 2:
                            input = `<input type="text" name="${ContadorFormularios}[refrigerado]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="carroceria">`
                            break;
                        case 3:
                            input = `<input type="text" name="${ContadorFormularios}[plataforma]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="carroceria">`
                            break;
                        case 4:
                            input = `<input type="text" name="${ContadorFormularios}[cisterna]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="carroceria">`
                            break;
                        case 5:
                            input = `<input type="text" name="${ContadorFormularios}[chasis]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="carroceria">`
                            break;
                        case 6:
                            input = `<input type="text" name="${ContadorFormularios}[carga_pesada]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="carroceria">`
                            break;
                        case 7:
                            input = `<input type="text" name="${ContadorFormularios}[madrina]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="carroceria">`
                            break;
                        case 8:
                            input = `<input type="text" name="${ContadorFormularios}[mudanza]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="carroceria">`
                            break;
                        case 9:
                            input = `<input type="text" name="${ContadorFormularios}[utilitario]" value="" class="form-control validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="carroceria">`
                            break;
                        case 10:
                            input = `<input type="text" name="${ContadorFormularios}[especializado]" value="" class="form-control transporte-especializado validar fi-${ContadorFormularios}" data-form="${ContadorFormularios}" data-formname="carroceria">`
                            break;
                        case 11:
                            input = `<input type="text" name="${ContadorFormularios}[total_carroceria]" value="" class="form-control total fit-${ContadorFormularios}" data-form="${ContadorFormularios}" readonly>`
                            break;
                    }

                    trow.append(
                        `
                            <td class="f-${ContadorFormularios}">
                                ${input}
                            </td>
                        `
                    );
                }
                iter++;
            });

            table_smartway_rows += `
            
            <tr class="flota-data f-${ContadorFormularios}" data-form="${ContadorFormularios}">
                <td>
                    <div class="ptl-word-break fleetCompanyName-${ContadorFormularios}">
                        ${Company.name}: 
                    </div>                       
                </td>
                <td>
                    <input type="text" value="Por definir" class="form-control fleetName" disabled>
                </td>
            </tr>
            `;

            ContadorFormularios += 1;

            $('.table-identificar-flotas > tbody').append(table_identificar_flotas_rows);
            $('.table-smartway > tbody').append(table_smartway_rows);

        });

        //Boton siguiente y atras
        $('.navega-tab').on('click', function() {
            const tab = $(this).data('tab');
            $(`#${tab}`).trigger('click');
        });
    });

    /**
     * Funcion para validar totales sean igual a 100 
     * @author Luis Hernandez <luis07hernandez05@outlook.es> 
     * @created 10/10/2021
     */
    function validar(element) {

        const formid = element.data('form');
        const formname = element.data('formname');

        let suma = 0;

        $(`.table-${formname} .fi-${formid}`).each(function() {
            if ($(this).val().length != 0) {
                suma += parseInt($(this).val());
            }
        })

        if (suma > 100) {
            popUp('<?= base_url() ?>/Empresas/empresa/alerta', {
                mensaje: 'El total no puede ser mayor a 100.'
            });
            element.val(0);
            //recalculamos el total
            suma = 0;
            $(`.table-${formname} .fi-${formid}`).each(function() {
                if ($(this).val().length != 0) {
                    suma += parseInt($(this).val());
                }
            })
            $(`.table-${formname} .fit-${formid}`).val(suma > 0 ? suma : '0');
        } else {
            $(`.table-${formname} .fit-${formid}`).val(suma > 0 ? suma : '0');
        }
    }
</script>


<script>
    $(document).ready(function() {
        var edited = false;

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

        $('.form-descripcion-flotas').on('change', 'input', function(event) {
            event.preventDefault();
            edited = true;
            console.log('edited');
        });

    });
</script>

<form class="form-descripcion-flotas">
    <div>
        <ul class="nav nav-tabs">
            <li class="nav-item <?= !isset($_GET['tab']) ? 'active' : ($_GET['tab'] == 'nav-tab-01' ? "active" : '') ?>">
                <a class="nav-link flotasTab nav-tab-01" id="nav-tab-01" data-toggle="tab" href="#nav-01" role="tab" aria-controls="nav-01" aria-selected="true">Identificar flotas</a>
            </li>
            <li class="nav-item <?= isset($_GET['tab']) && $_GET['tab'] == 'nav-tab-03' ? "active" : '' ?>">
                <a class="nav-link flotasTab nav-tab-03" id="nav-tab-03" data-toggle="tab" href="#nav-03" role="tab" aria-controls="nav-03" aria-selected="true">Operación</a>
            </li>
            <li class="nav-item <?= isset($_GET['tab']) && $_GET['tab'] == 'nav-tab-04' ? "active" : '' ?>">
                <a class="nav-link flotasTab nav-tab-04" id="nav-tab-04" data-toggle="tab" href="#nav-04" role="tab" aria-controls="nav-04" aria-selected="true">Tipos de carrocería</a>
            </li>
            <li class="nav-item <?= isset($_GET['tab']) && $_GET['tab'] == 'nav-tab-05' ? "active" : '' ?>">
                <a class="nav-link flotasTab nav-tab-05" id="nav-tab-05" data-toggle="tab" href="#nav-05" role="tab" aria-controls="nav-05" aria-selected="true">Categoría Transporte limpio</a>
            </li>
            <br><br>
        </ul>


        <!-- <div class="ptl-my-2 ptl-marco-de-div-textos">
            <p>En el Programa Transporte Limpio se clasifican a las flotas en alguna de las 13&nbsp;categor&iacute;as definidas por el Programa. Estas categor&iacute;as aseguran que su flota ser&aacute; comparada con flotas similares.</p>
            <p>Si la &ldquo;Categor&iacute;a Transporte Limpio&rdquo; que se le asign&oacute; no es representativa para la descripci&oacute;n de su flota, por favor regrese a las pesta&ntilde;as "Operaci&oacute;n" y "Tipo&nbsp;de Carrocer&iacute;a" para hacer las correcciones.</p>
        </div> -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade <?= !isset($_GET['tab']) ? 'active in' : ($_GET['tab'] == 'nav-tab-01' ? "active in" : '') ?>" id="nav-01" role="tabpanel" aria-labelledby="nav-tab-01">
                <div class="overflow-x">

                    <div>
                        <p>En esta secci&oacute;n se identificar&aacute; la flota o las flotas de su empresa de acuerdo a la forma en que sus&nbsp;clientes los contratan.</p>
                        <p>Aseg&uacute;rese que en el campo &ldquo;Nombre de la flota&rdquo;, el cual se genera autom&aacute;ticamente, aparece el&nbsp;Nombre de la flota que su cliente identifica y contrata.</p>
                    </div>
                    <table class="table table-identificar-flotas">
                        <thead>
                            <tr>
                                <th>
                                    Empresa
                                </th>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="nombre_de_la_flota"></span>
                                    Nombre de la flota
                                </th>
                                <th>Tipo de flota</th>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="identificador_de_la_flota"></span>
                                    Identificador de la flota
                                    
                                </th>
                                <th>Remover</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fleets as $key => $value) : ?>
                                <tr class="flota-data f-<?= $key ?> ${ptl_disabled_fleet}" data-form="<?= $key ?>" data-a="<?= $value['id'] ?>">
                                    <td>
                                        <?= $company['name'] ?>
                                    </td>
                                    <td>
                                        <input type="hidden" name="<?= $key ?>[id]" value="<?= $value['id'] ?>" class="form-control">
                                        <input type="text" name="<?= $key ?>[name]" value="<?= $value['name'] ?>" class="form-control fleetName" data-form="<?= $key ?>">
                                    </td>
                                    <td>
                                        <select name="<?= $key ?>[type]" class="form-control fleetType">
                                            <option value="1" <?= $value['type'] == 1 ? 'selected' : '' ?>>Privado</option>
                                            <option value="2" <?= $value['type'] == 2 ? 'selected' : '' ?>>Dedicado</option>
                                            <option value="3" <?= $value['type'] == 3 ? 'selected' : '' ?>>Para-Alquilar</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="ptl-word-break fleetCompanyName-<?= $key ?>">
                                            <?= $company['name'] ?>: <?= $value['name'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger eliminarFlota" data-form="f-<?= $key ?>">X</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-md-6">
                    </div>
                    <div class="form-group col-md-6">
                        <div style="text-align:right;">
                            <?php if ($company['rev_year'] > date('Y') || $company['rev_year'] == null) : ?>
                                <a class="btn btn-primary agregarFlota">
                                    Agregar nueva flota
                                </a>
                            <?php endif ?>
                            <br>
                            <br>
                            <a href="/Empresas/Empresa/Inicio" class="btn btn-danger preventLink">Inicio</a>
                            <button type="button" class="btn btn-primary navega-tab" data-tab="nav-tab-03">Siguiente</button>
                            <br>
                            <br>
                            <a href="/Empresas/Empresa/Inicio" class="btn btn-danger">Cancelar</a>
                            <button type="button" class="btn btn-primary button-submit">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade <?= isset($_GET['tab']) && $_GET['tab'] == 'nav-tab-03' ? "active in" : '' ?>" id="nav-03" role="tabpanel" aria-labelledby="nav-tab-03">
                <div class="fleet-operacion">
                    <div>
                        <p>Indique en porcentaje (%) el tipo de operación de su flota o flotas definidas</p>
                    </div>
                    <table class="table table-operacion">
                        <thead>
                            <tr>
                                <th>
                                    Tipo de operación
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <th class="f-<?= $key ?>">
                                        <div class="ptl-word-break fleetName-<?= $key ?>">
                                            <?= $value['name'] ?>
                                        </div>
                                    </th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="carga_dedicada"></span>
                                    Carga dedicada
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[carga_dedicada]" value="<?= $value['carga_dedicada'] > 0 ? $value['carga_dedicada'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="operacion">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="carga_consolidada"></span>
                                    Carga consolidada
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[carga_consolidada]" value="<?= $value['carga_consolidada'] > 0 ? $value['carga_consolidada'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="operacion">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="acarreo"></span>
                                    Acarreo
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[acarreo]" value="<?= $value['acarreo'] > 0 ? $value['acarreo'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="operacion">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="paqueteria"></span>
                                    Paquetería
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[paqueteria]" value="<?= $value['paqueteria'] > 0 ? $value['paqueteria'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="operacion">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="expedito"></span>
                                    Expedito
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[expedito]" value="<?= $value['expedito'] > 0 ? $value['expedito'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="operacion">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>Total %</th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <?php
                                        $total = $value['carga_dedicada'] +
                                            $value['carga_consolidada'] +
                                            $value['acarreo'] +
                                            $value['paqueteria'] +
                                            $value['expedito'];
                                        ?>
                                        <input type="text" name="<?= $key ?>[total_operacion]" value="<?= $total ?>" class="form-control total fit-<?= $key ?>" readonly>
                                    </td>
                                <?php endforeach ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                    </div>
                    <div class="form-group col-md-6">
                        <div style="text-align:right">
                            <button type="button" class="btn btn-primary navega-tab" data-tab="nav-tab-01">Atras</button>
                            <a href="/Empresas/Empresa/Inicio" class="btn btn-danger preventLink">Inicio</a>
                            <button type="button" class="btn btn-primary navega-tab" data-tab="nav-tab-04">Siguiente</button>
                            <br>
                            <br>
                            <a href="/Empresas/Empresa/Inicio" class="btn btn-danger">Cancelar</a>
                            <button type="button" class="btn btn-primary button-submit">Guardar</button>
                        </div >
                    </div>
                </div>
            </div>

            <div class="tab-pane fade <?= isset($_GET['tab']) && $_GET['tab'] == 'nav-tab-04' ? "active in" : '' ?>" id="nav-04" role="tabpanel" aria-labelledby="nav-tab-04">
                <div class="fleet-carroceria">
                    <div>
                        <p>Indique en porcentaje (%) el tipo de carrocer&iacute;a de su flota o flotas definidas.</p>
                    </div>
                    <table class="table table-carroceria">
                        <thead>
                            <tr>
                                <th>
                                    Tipo de carrocería
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <th class="f-<?= $key ?>">
                                        <div class="ptl-word-break fleetName-<?= $key ?>">
                                            <?= $value['name'] ?>
                                        </div>
                                    </th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="caja_seca"></span>
                                    Caja seca
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[caja_seca]" value="<?= $value['caja_seca'] > 0 ? $value['caja_seca'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="carroceria">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="refrigerado"></span>
                                    Refrigerado
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[refrigerado]" value="<?= $value['refrigerado'] > 0 ? $value['refrigerado'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="carroceria">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="plataforma"></span>
                                    Plataforma
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[plataforma]" value="<?= $value['plataforma'] > 0 ? $value['plataforma'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="carroceria">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="camion_cisterna"></span>
                                    Camión cisterna
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[cisterna]" value="<?= $value['cisterna'] > 0 ? $value['cisterna'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="carroceria">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="chasis"></span>
                                    Chasis
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[chasis]" value="<?= $value['chasis'] > 0 ? $value['chasis'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="carroceria">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="carga_pesada"></span>
                                    Carga pesada / a granel
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[carga_pesada]" value="<?= $value['carga_pesada'] > 0 ? $value['carga_pesada'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="carroceria">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="transporte_de_vehiculos"></span>
                                    Transporte de vehículos (Madrina)
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[madrina]" value="<?= $value['madrina'] > 0 ? $value['madrina'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="carroceria">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="mudanza"></span>
                                    Mudanza
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[mudanza]" value="<?= $value['mudanza'] > 0 ? $value['mudanza'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="carroceria">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="utilitario"></span>
                                    Utilitario
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[utilitario]" value="<?= $value['utilitario'] > 0 ? $value['utilitario'] : '' ?>" class="form-control validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="carroceria">
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="transporte_especializado"></span>
                                    Transporte especializado
                                </th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <input type="text" name="<?= $key ?>[especializado]" value="<?= $value['especializado'] > 0 ? $value['especializado'] : '' ?>" class="form-control transporte-especializado validar fi-<?= $key ?>" data-form="<?= $key ?>" data-formname="carroceria">
                                        <?php if ($value['especializado'] > 0) :  ?>
                                            <textarea name="<?= $key ?>[descripcion]" class="form-control carrecoeria-description"><?= $value['descripcion'] ?></textarea>
                                        <?php endif ?>
                                    </td>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <th>Total %</th>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <td class="f-<?= $key ?>">
                                        <?php
                                        $total = $value['caja_seca'] +
                                            $value['refrigerado'] +
                                            $value['plataforma'] +
                                            $value['cisterna'] +
                                            $value['chasis'] +
                                            $value['carga_pesada'] +
                                            $value['madrina'] +
                                            $value['mudanza'] +
                                            $value['utilitario'] +
                                            $value['especializado'];
                                        ?>
                                        <input type="text" name="<?= $key ?>[total_carroceria]" value="<?= $total ?>" class="form-control total fit-<?= $key ?>" readonly>
                                    </td>
                                <?php endforeach ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-md-6">
                    </div>
                    <div class="form-group col-md-6">
                        <div style="text-align:right">
                            <button type="button" class="btn btn-primary navega-tab" data-tab="nav-tab-03">Atras</button>
                            <a href="/Empresas/Empresa/Inicio" class="btn btn-danger preventLink">Inicio</a>
                            <button type="button" class="btn btn-primary navega-tab" data-tab="nav-tab-05">Siguiente</button>
                            <br>
                            <br>
                            <a href="/Empresas/Empresa/Inicio" class="btn btn-danger">Cancelar</a>
                            <button type="button" class="btn btn-primary button-submit">Guardar</button>
                        </div >
                    </div>

                </div>
            </div>
            <div class="tab-pane fade <?= isset($_GET['tab']) && $_GET['tab'] == 'nav-tab-05' ? "active in" : '' ?>" id="nav-05" role="tabpanel" aria-labelledby="nav-tab-05">
                <div>
                    <p>
                        En el Programa Transporte Limpio se clasifican a las flotas en alguna de las categorías definidas por el Programa. Estas categorías aseguran que su flota será comparada con flotas similares.
                    </p>
                    <p>
                        Si la "Categoría Transporte Limpio" que se le asignó no es representativa para la descripción de su flota, por favor regrese a las pestañas "Operación" y/o "Tipo de Carrocería" para hacer las correcciones.
                    </p>
                    <p>
                        En el botón "Ver categorías de Transporte Limpio" se muestran las categorías definidas en el Programa Transporte Limpio.
                    </p>
                   <!--  <p>En el bot&oacute;n "Ver categor&iacute;as de Transporte Limpio" se muestran las Categor&iacute;as definidas en el Programa Transporte Limpio.</p>
                    <p data-sourcepos="1:1-2:457" dir="auto">Para ayudarle a obtener el m&aacute;ximo de su evaluaci&oacute;n, el Programa Transporte Limpio ha creado categor&iacute;as o l&iacute;neas base llamadas Categor&iacute;as del Programa Transporte Limpio. Las Categor&iacute;as del Programa Transporte Limpio asegurar&aacute;n que su flota es comparada con flotas similares a trav&eacute;s de Am&eacute;rica del Norte, que son similares y operan como la suya. De clic en el bot&oacute;n "Ver categorías de Transporte Limpio" para ver todas las Categor&iacute;as del Programa Transporte Limpio.</p>                    
                    <p data-sourcepos="6:1-6:127" dir="auto">Con base en la informaci&oacute;n proporcionada en las pesta&ntilde;as "Operaci&oacute;n" y "Tipo de Carrocer&iacute;a" su flota se clasific&oacute; como:&rdquo;</p>
                </div> -->
                <div class="overflow-x">
                    <table class="table table-smartway">
                            <thead>
                                <tr>
                                    <th>Identificador de la flota</th>
                                    <th>Categoría Transporte limpio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($fleets as $key => $value) : ?>
                                    <tr class="flota-data f-<?= $key ?> ${ptl_disabled_fleet}" data-form="<?= $key ?>">
                                        <td>
                                            <div class="ptl-word-break fleetCompanyName-<?= $key ?>">
                                                <?= $company['name'] ?>: <?= $value['name'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" value="<?= $value['categoria'] ?>" class="form-control fleetName" disabled>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                        </div>
                        <div class="form-group col-md-6">
                            <div style="text-align:right;">
                                <button type="button" class="btn btn-primary navega-tab" data-tab="nav-tab-04">Atras</button>
                                <a href="/Empresas/Empresa/Inicio" class="btn btn-danger preventLink">Inicio</a>
                                <br>
                                <br>
                                <a class="btn btn-primary ptl-tooltip" data-tipo="ver_categorias_transporte_limpio">Ver categorías de Transporte Limpio</a>

                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</form>