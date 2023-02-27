<script>
    let FleetsAgregadas = [];
    let FleetsEliminadas = [];
    let Fleets = <?= isset($fleets) ? json_encode($fleets) : '[]' ?>;
    let no_sw_Fleets = <?= isset($no_sw_fleets) ? json_encode($no_sw_fleets) : '[]' ?>;

    $(document).ready(function() {

        $('#no-ptl-btn').click(function (e) {
            e.preventDefault();
            $('.nav-tab-02').trigger('click');
        });

        <?php if (!isset($administrator)) : ?>
            /*=====================================
            GENERAL
            =====================================*/

            //Guardar información        
            $('.button-submit').on('click', function() {

                $('#mensaje').empty();

                var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/brandsGuardarTransportistas', {
                    agregadas: FleetsAgregadas,
                    eliminadas: FleetsEliminadas,
                });

                rj = JSON.parse(rj);

                if (rj.ok == 1) {
                    $('#mensaje').html(`<div class="alert alert-success" role="alert">${rj.mensaje}</div>`)

                    window.location.href = "#mensaje"

                    setTimeout(() => {
                        $('#mensaje').empty();
                    }, 3000);

                } else {
                    $('#mensaje').html(`<div class="alert alert-danger" role="alert">Ha ocurrido un error.</div>`)
                }
            });

        <?php endif ?>

        /*=====================================
        Compañias Smartway
        =====================================*/

        loadFleets();

        <?php if (!isset($administrator)) : ?>
            //Seleccionar flota
            $('#table-fleetsDatatable').on('click', '.agregarFlota', function() {
                const fleetId = $(this).data('id');
                const fleet = Fleets.find(element => element.id == fleetId);

                let html = `
            
                <tr class="f-${fleet.id}" data-id="${fleet.id}">
                    <td>${fleet.company_name}: ${fleet.name}</td>
                    <td>${fleet.direccion}</td>
                    <td>${fleet.categoria}</td>
                    <td><button class="btn btn-danger eliminarFlota" data-id="${fleet.id}">X</button></td>
                </tr>
            
                `;

                if ($(`.f-${fleet.id}`).length == 0) {
                    $('#table-fleetsAgregadas > tbody').append(html);

                    let indice = FleetsEliminadas.findIndex(element => element.fleets_id == fleetId);
                    if (indice > -1) {
                        FleetsAgregadas.push(FleetsAgregadas[indice]);
                        FleetsEliminadas.splice(indice, 1);
                    }

                    FleetsAgregadas.push({
                        id: null,
                        fleets_id: fleet.id,
                        brands_id: <?= $company['brand']['id'] ?>
                    });
                }

            })

            //Eliminar flota
            $('#table-fleetsAgregadas').on('click', '.eliminarFlota', function() {
                let fleetId = $(this).data('id');

                $(this).parent().parent().remove();

                let indice = FleetsAgregadas.findIndex(element => element.fleets_id == fleetId);

                if (indice > -1) {
                    FleetsEliminadas.push(FleetsAgregadas[indice]);
                    FleetsAgregadas.splice(indice, 1);
                }
            });

            //load fleets datatable
            $('#table-fleetsDatatable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                // responsive: true,
                data: Fleets,
                columns: [
                    // {
                    //     render: function(data, type, row) {

                    //         const buttons = `
                    //           <a class="btn btn-warning agregarFlota" data-id="${row.id}">+</a>                                                    
                    //         `;

                    //         return buttons;
                    //     },
                    //     title: 'Acciones',
                    // },
                    {
                        title: 'Empresa transportista',
                        render: function(data, type, row) {
                            const html = `<span class="agregarFlota manita" data-id="${row.id}">${row.company_name}: ${row.name}</span>`;
                            return html;
                        }
                    },
                    // {
                    //     data: 'direccion',
                    //     title: 'Dirección'
                    // },
                    {
                        data: 'categoria',
                        title: 'Categoría'
                    },
                ]
            })
        <?php endif ?>


        /*=====================================
        Compañias No-Smartway
        =====================================*/
        loadNo_Sw_Fleets();

        <?php if (!isset($administrator)) : ?>
            //load no smartway fleets datatable
            $('#table-no_sw_fleetsDatatable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                // responsive: true,
                data: no_sw_Fleets,
                columns: [
                    // {
                    //     render: function(data, type, row) {

                    //         const buttons = `
                    //           <a class="btn btn-warning agregarFlota" data-id="${row.id}">+</a>                                                    
                    //         `;

                    //         return buttons;
                    //     },
                    //     title: 'Acciones',
                    // },
                    {
                        title: 'Nombre',
                        render: function(data, type, row) {
                            const html = `<span class="manita agregarFlota" data-id="${row.id}">${row.company_name}: ${row.name}</span>`;
                            return html;
                        }
                    },
                ]
            })

            //Seleccionar flota
            $('#table-no_sw_fleetsDatatable').on('click', '.agregarFlota', function() {
                const fleetId = $(this).data('id');
                const fleet = no_sw_Fleets.find(element => element.id == fleetId);

                let html = `
            
                <tr class="no-sw-f-${fleet.id}" data-id="${fleet.id}">
                    <td>${fleet.company_name}: ${fleet.name}</td>
                    <td><button class="btn btn-danger eliminarFlota" data-id="${fleet.id}">X</button></td>
                </tr>
            
                `;

                if ($(`.no-sw-f-${fleet.id}`).length == 0) {
                    $('#table-no_sw_fleetsAgregadas > tbody').append(html);

                    let indice = FleetsEliminadas.findIndex(element => element.fleets_id == fleetId);
                    if (indice > -1) {
                        FleetsAgregadas.push(FleetsAgregadas[indice]);
                        FleetsEliminadas.splice(indice, 1);
                    }

                    FleetsAgregadas.push({
                        id: null,
                        fleets_id: fleet.id,
                        brands_id: <?= $company['brand']['id'] ?>
                    });
                }

            })

            //Eliminar flota
            $('#table-no_sw_fleetsAgregadas').on('click', '.eliminarFlota', function() {
                let fleetId = $(this).data('id');

                $(this).parent().parent().remove();

                let indice = FleetsAgregadas.findIndex(element => element.fleets_id == fleetId);

                if (indice > -1) {
                    FleetsEliminadas.push(FleetsAgregadas[indice]);
                    FleetsAgregadas.splice(indice, 1);
                }
            });
        <?php endif ?>

    });

    function loadFleets() {
        let fleets = <?= json_encode($company['brand']['fleets']) ?>;

        let html = '';

        for (fleet of fleets) {

            html += `
        
            <tr class="f-${fleet.id}" data-id="${fleet.id}">
                <td>${fleet.company_name}: ${fleet.name}</td>
                <td>${fleet.direccion}</td>
                <td>${fleet.categoria}</td>
                <?php if (!isset($administrator)) : ?>
                    <td><button class="btn btn-danger eliminarFlota" data-id="${fleet.id}">X</button></td>
                <?php endif ?>
            </tr>

            `;

            FleetsAgregadas.push({
                id: fleet.brands_fleets_id,
                fleets_id: fleet.id,
                brands_id: <?= $company['brand']['id'] ?>
            });
        }

        $('#table-fleetsAgregadas > tbody').append(html);
    }

    function loadNo_Sw_Fleets() {
        let no_sw_fleets = <?= json_encode($company['brand']['no_sw_fleets']) ?>;

        let html = '';

        for (fleet of no_sw_fleets) {

            html += `
        
            <tr class="no-sw-f-${fleet.id}" data-id="${fleet.id}">
                <td>${fleet.company_name}: ${fleet.name}</td>
                
                <?php if (!isset($administrator)) : ?>
                    <td><button class="btn btn-danger eliminarFlota" data-id="${fleet.id}">X</button></td>
                <?php endif ?>        
            </tr>

            `;

            FleetsAgregadas.push({
                id: fleet.brands_fleets_id,
                fleets_id: fleet.id,
                brands_id: <?= $company['brand']['id'] ?>
            });
        }

        $('#table-no_sw_fleetsAgregadas > tbody').append(html);
    }
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
            <a class="nav-link nav-tab-01" id="nav-tab-01" data-toggle="tab" href="#nav-01" role="tab" aria-controls="nav-01" aria-selected="true">Selección de Transportistas Transporte Limpio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link nav-tab-02" id="nav-tab-02" data-toggle="tab" href="#nav-02" role="tab" aria-controls="nav-01" aria-selected="true">Selección de Transportistas No-Transporte Limpio</a>
        </li>
    </ul>
    <br/>



    <div class="tab-content <?= $company['brand']['status'] >= 100 ? 'ptl-disabled' :'' ?>" id="nav-tabContent">
        <div class="tab-pane active fade in" id="nav-01" role="tabpanel" aria-labelledby="nav-tab-01">
            <div style="text-align:justify;">
                <p>En esta sección debe de ingresar el nombre de las empresas de transporte que contrata para mover sus cargas.</p>

                <p>Puede ser que algunas de las empresas que contrata estén participando en el Programa Transporte Limpio; en ese caso, le sugerimos dar clic en los nombres de las empresas transportistas que aparecen a continuación y, que usted está seguro que contrata para mover sus cargas. Puede usar el buscador para encontrar de manera más sencilla a sus proveedores de transporte. </p>

                <p>Una vez que de clic en el nombre de su proveedor, aparecerá dicho nombre en la sección “Mis proveedores de transporte” que se muestra más abajo. Para eliminar alguna empresa de transporte solo debe dar clic en el botón “X” que ésta  a la derecha de cada empresa transportista.</p>

                <p>Es importante que incluya a TODOS sus proveedores de transporte; por ello, si no aparece en el listado el nombre de alguno de sus proveedores de transporte, significa que no está participando en el Programa Transporte Limpio; en ese caso, le pedimos dar clic en el botón “Transportistas no-PTL”, para que pueda capturar a las empresas transportistas que no están en el listado.</p>
            </div>

            <?php if (!isset($administrator)) : ?>
                <div class="row">
                    <div class="col-md-9">
                        <table class="table" id="table-fleetsDatatable"></table>
                    </div>
                    <div class="col-md-3" style="padding-top:90px;">
                        <span class="btn btn-primary" id="no-ptl-btn">Transportistas<br/>NO-PTL</span>
                    </div>
                </div>
                <br><br>
            <?php endif ?>
            <h2>Mis proveedores de transporte</h2>
            <table class="table" id="table-fleetsAgregadas">
                <thead>
                    <tr>
                        <th wordwrap>Transportistas Transporte Limpio</th>
                        <th wordwrap>Direccion</th>
                        <th wordwrap>Categoria</th>
                        <?php if (!isset($administrator)) : ?>
                            <th>Remover</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="nav-02" role="tabpanel" aria-labelledby="nav-tab-02">
            <div style="text-align:justify;">
                <p>En esta sección debe de ingresar el número total de las empresas transportistas no-PTL (que significan empresas que no participan en el Programa Transporte Limpio), y, que contrata para mover sus cargas.</p>

                <p>Para ello, debe de seleccionar a los transportistas no-PTL por el tipo de categoría que clasifica el Programa Transporte Limpio a las empresas transportistas. En caso de que no esté seguro  de la categoría a la que pertenece la empresa transportista no-PTL que contrata, puede seleccionar la categoría no-PTL/Carga general. </p>

                <p>Para hacer la selección de sus transportistas no-PTL debe dar clic en el botón “Seleccione el tipo de Transportista no-PTL por categoría”, posteriormente se desplegarán las categorías y debe seleccionar la categoría que corresponda a las empresas transportistas que contrata. Una vez seleccionada debe de dar clic en el botón “Agregar”; puede agregar diversas categorías, de acuerdo a la información que tenga de sus transportistas.</p>

                <p>Cuando agrega a un Transportista no-PTL por categoría, este debe de aparecer en la sección “Mis proveedores de transporte no-PTL”, en esa sección debe de indicar el número de empresas transportistas que contrata y que pertenecen a esa categoría. </p>

                <p>Puede remover algunas de las categorías dando clic en botón “X” que ésta  a la derecha de cada empresa Transportista no-PTL.</p>

            </div>

            <div class="form-inline">
                <div class="form-group">
                    <label for="no_ptl">Número Total de transportistas No-Transporte Limpio para esta empresa: </label>
                    <input type="text" class="form-control" id="no_sw_no_ptl" <?= isset($administrator) ? 'disabled' : '' ?>>
                </div>
            </div>
            <?php if (!isset($administrator)) : ?>
                <br><br>
                <table class="table" id="table-no_sw_fleetsDatatable" style="width:100% !important;"></table>
            <?php endif ?>
            <br><br>
            <table class="table" id="table-no_sw_fleetsAgregadas">
                <thead>
                    <tr>
                        <th wordwrap>Transportistas No Transporte Limpio</th>
                        <?php if (!isset($administrator)) : ?>
                            <th>Remover</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="row" >
            <div class="col-md-12">
                <?php if (!isset($administrator)) : ?>
                    <div style="text-align: right;">
                        
                            <a href="/Empresas/Empresa/Inicio" class="btn btn-danger">Cancelar</a>
                            <button type="button" class="btn btn-primary button-submit">Guardar</button>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?php if (isset($administrator)) : ?>
    <!--=====================================
    ADMINISTRADOR
    ======================================-->
    <?= view('Administration/usersValidations/buttons') ?>
<?php endif ?>