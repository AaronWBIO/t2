<script>
    $(document).ready(function() {
        
        <?php if (!isset($administrator)) : ?>
            //Guardar información        
            $('.button-submit').on('click', function() {

                $('#mensaje').empty();

                const data = $('#form-datosDeActividad').serializeObject();

                var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/brandsGuardarDatosDeActividad', data);

                rj = JSON.parse(rj);
                // console.log(rj); return;
                if (rj.ok == 1) {
                    $('#mensaje').html(`<div class="alert alert-success" role="alert">${rj.mensaje}</div>`)

                    window.location.href = "#mensaje"

                    setTimeout(() => {
                        $('#mensaje').empty();
                    }, 3000);

                } 
                else if(rj.ok == 2){
                    $('#mensaje').html(`<div class="alert alert-danger" role="alert">La información está incompleta, favor de verificarla.</div>`)
                }
                else {
                    $('#mensaje').html(`<div class="alert alert-danger" role="alert">Ha ocurrido un error.</div>`)
                }
            });
        <?php endif ?>

        loadTable();

        $('.table-datosDeActividad').on('change', '.disponibilidadDeDatos', function() {
            let fleetId = $(this).data('id');
            // $('.dataField').val('');

            switch (parseInt($(this).val())) {
                case 1:
                    $(`.carga-promedio-${fleetId}`).attr('disabled', true).val('');
                    $(`.tm-km-${fleetId}`).attr('disabled', false);
                    $(`.km-tot-${fleetId}`).attr('disabled', false);
                    break;
                case 2:
                    $(`.carga-promedio-${fleetId}`).attr('disabled', false);
                    $(`.tm-km-${fleetId}`).attr('disabled', false);
                    $(`.km-tot-${fleetId}`).attr('disabled', true).val('');
                    break;
                case 3:
                    $(`.carga-promedio-${fleetId}`).attr('disabled', false);
                    $(`.tm-km-${fleetId}`).attr('disabled', true).val('');
                    $(`.km-tot-${fleetId}`).attr('disabled', false);
                    break;
                // case 4:
                //     $(`.carga-promedio-${fleetId}`).attr('disabled', true);
                //     $(`.tm-km-${fleetId}`).attr('disabled', true);
                //     $(`.km-tot-${fleetId}`).attr('disabled', false);
                //     break;
            }
        });

        $('.disponibilidadDeDatos').trigger('change');
    })

    function loadTable() {

        let fleets = <?= json_encode($company['brand']['fleets']) ?>;
        
        <?php if (isset($administrator)): ?>
            fleets.push(...<?= json_encode($company['brand']['no_sw_fleets']) ?>)
        <?php endif ?>

        let html = '';

        for (fleet of fleets) {
            html += `
            
                <tr class="f-${fleet.id}" data-id="${fleet.id}">
                    <td>   
                        ${fleet.company_name}: ${fleet.name}
                        <input name="${fleet.brands_fleets_id}#id" value="${fleet.brands_fleets_id}" type="hidden">
                    </td>                    
                    <td>${fleet.categoria}</td>
                    <!-- <td>
                        <input name="${fleet.brands_fleets_id}#carrier" value="1" type="checkbox" class="form-check-input" ${fleet.carrier == 1 ? 'checked' : ''}>
                    </td> -->
                    <td>
                        <select class="form-control disponibilidadDeDatos" data-id="${fleet.id}" name="${fleet.brands_fleets_id}#measure_type">
                            <option value="1" ${fleet.measure_type == 1 ? 'selected' : ''}>a - Ton-Km y Km Totales</option>
                            <option value="2" ${fleet.measure_type == 2 ? 'selected' : ''}>b - Ton-Km y Carga Prom</option>                            
                            <option value="3" ${fleet.measure_type == 3 ? 'selected' : ''}>c - Km Totales y Carga Prom</option>                            
                            <!-- <option value="4" ${fleet.measure_type == 4 ? 'selected' : ''}>d - Km Total solamente</option> -->
                        </select>
                    </td>
                    <td><input name="${fleet.brands_fleets_id}#ton_km" value="${fleet.ton_km != 0 && fleet.ton_km ? fleet.ton_km : ''}" type="text" class="form-control tm-km-${fleet.id} dataField"></td>
                    <td><input name="${fleet.brands_fleets_id}#tot_km" value="${fleet.tot_km != 0 && fleet.tot_km ? fleet.tot_km : ''}" type="text" class="form-control km-tot-${fleet.id} dataField"></td>
                    <td><input name="${fleet.brands_fleets_id}#avg_payload" value="${fleet.avg_payload != 0 && fleet.avg_payload ? fleet.avg_payload : ''}" type="text" class="form-control carga-promedio-${fleet.id} dataField" disabled></td>                    
                </tr>
            
            `;
        }

        $('.table-datosDeActividad > tbody').append(html);

    }
</script>

<script>
    $(document).ready(function() {
        var edited = false;

        $('.preventLink').click(function(e) {
            e.preventDefault();

            var link = $(this).attr('href');

            if (edited) {
                conf('<?= base_url(); ?>/general/general/confirmation',
                    'Estás a punto de dejar esta página y no haz guardado la información, ¿Estás seguro que deseas continuar?', {},
                    function() {
                        window.location.href = link;
                    });
            } else {
                window.location.href = link;
            }

        });

        $('.table-datosDeActividad').on('change', 'input', function(event) {
            event.preventDefault();
            edited = true;
            console.log('edited');
        });
        $('.table-datosDeActividad').on('change', 'select', function(event) {
            event.preventDefault();
            edited = true;
            console.log('edited');
        });

    });
</script>


<div id="mensaje">
</div>

<?php if (isset($administrator)) : ?>
    <!--=====================================
    ADMINISTRADOR
    ======================================-->
    <?= view('Administration/usersValidations/submenu') ?>


<?php endif ?>

<div>
    <ul class="nav nav-tabs">
        <li class="nav-item active">
            <a class="nav-link nav-tab-01" id="nav-tab-01" data-toggle="tab" href="#nav-01" role="tab" aria-controls="nav-01" aria-selected="true">Datos de Actividad</a>
        </li>
    </ul>

    <div class="tab-content <?= $company['brand']['status'] >= 100 ? 'ptl-disabled' :'' ?>" id="nav-tabContent">
        <div class="tab-pane active fade in" id="nav-01" role="tabpanel" aria-labelledby="nav-tab-01">
            <form id="form-datosDeActividad">
                <div class="overflow-x">
                    <table class="table table-datosDeActividad ptl-w-100 <?= isset($administrator) ? 'ptl-disabled-admin' : '' ?>">
                        <thead>
                            <tr>
                                <th>Transportistas</th>
                                <th>Categoría</th>
                                <!-- <th>
                                    Transportista
                                </th> -->
                                <th>
                                    <!-- <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="disponibilidad_de_datos" id="ayuda"></span> -->
                                    Disponibilidad de datos
                                </th>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="ton_km" id="ayuda"></span>
                                    Ton-Km
                                </th>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="km_tot_usr" id="ayuda"></span>
                                    Km Totales
                                </th>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="carga_util" id="ayuda"></span>
                                    Carga útil promedio
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <div class="row">
            <?php if (!isset($administrator)) : ?>
                <div class="form-group col-md-6">
                    <a href="/Empresas/Empresa/Inicio" class="btn btn-danger preventLink">Cancelar</a>
                    <button type="button" class="btn btn-primary button-submit">Guardar</button>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?php if (isset($administrator)) : ?>
    <!--=====================================
    ADMINISTRADOR
    ======================================-->
    <?= view('Administration/usersValidations/buttons') ?>
<?php endif ?>