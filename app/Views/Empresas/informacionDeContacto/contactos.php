<script>
    $(document).ready(function() {

        setInterval(() => {
            $('#mensaje').empty();
        }, 3000);

        //Inicializar datatable de contactos | Empresas
        $('#contactosDatatable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },
            // responsive: true,
            data: <?= isset($contactos) ? $contactos : '' ?>,
            columns: [{
                    data: 'nombre',
                    title: 'Nombre'
                },
                {
                    data: 'curp',
                    title: 'CURP'
                },
                {
                    data: 'position',
                    title: 'Cargo',
                },
                {
                    data: 'email',
                    title: 'Correo Electrónico',
                },
                {
                    data: 'phone',
                    title: 'Teléfono',
                },
                {
                    data: 'ext',
                    title: 'Ext',
                },
                {
                    data: 'phone2',
                    title: 'Teléfono 2',
                },
                {
                    data: 'ext2',
                    title: 'Ext 2',
                },
                {
                    render: function(data, type, row) {

                        const buttons = `
                        <button class="btn btn-warning editar" data-id="${row.id}">Editar</button>                            
                        <button class="btn btn-danger eliminar" data-id="${row.id}">Eliminar</button>                            
                        `;

                        return buttons;
                    },
                    title: 'Acciones',
                }
            ]
        })

        //Abrir modal para crear contacto
        $('#nuevoContacto').on('click', function() {
            popUp('<?= base_url() ?>/Empresas/empresa/formularioContacto');
        });

        $('#contactosDatatable').on('click', '.editar', function() {
            popUp('<?= base_url() ?>/Empresas/empresa/formularioContacto', {
                id: $(this).data('id'),
                accion: 'editar'
            });
        });

        $('#contactosDatatable').on('click', '.eliminar', function() {
            popUp('<?= base_url() ?>/Empresas/empresa/formularioContacto', {
                id: $(this).data('id'),
                accion: 'eliminar'
            });
        });

    });
</script>

<p>Favor de incluir la informaci&oacute;n de las personas encargadas del&nbsp;Programa Transporte Limpio dentro de su empresa. Le pedimos incluir al menos 2 contactos.&nbsp;</p>
<p>Si quiere editar la informaci&oacute;n o eliminar alguno de los contactos, deslice la barra de&nbsp;desplazamiento a la derecha.</p>

<button class="btn btn-primary" id="nuevoContacto">Nuevo Contacto + </button>
<br>
<br>
<div style="overflow-x: auto;">
    <table class="table" id="contactosDatatable" style="font-size: inherit;"></table>
    <br>
</div>

<p class="ptl-my-2">Para continuar con el llenado de la plataforma, de clic en&nbsp;el bot&oacute;n Inicio que se encuentra en la parte superior.</p>