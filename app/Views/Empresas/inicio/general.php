<!--=====================================
INICIO
======================================-->

<script>
  $(document).ready(function() {

    /*=====================================
    GENERAL
    =====================================*/



    /*=====================================
    EMPRESAS
    =====================================*/

    //VER MIS METRICAS
    $('.ver-mis-metricas').click(function() {

      // var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/terminarEmpresa');

      // var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/showResults');
      // console.log(rj);

    })

    //ENVIAR INFORMACIÓN A VALIDACIÓN    
    $('.enviar-validacion-empresas').click(function() {

      var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/validarEmpresa');

      rj = JSON.parse(rj);

      if (rj.ok == 1) {
        popUp('<?= base_url() ?>/Empresas/empresa/resultadoValidacionEmpresa', rj.result);
      } else {
        mostrarMensaje('Ha ocurrido un error.', 'error');
      }

    })

    //TABLA DE FLOTAS    
    $('#fleetsDatatable').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
      },
      // responsive: true,
      data: <?= isset($flotas_de_company) ? $flotas_de_company : '[]' ?>,
      columns: [{
          title: 'Nombre de la flota',
          render: function(data, type, row) {

            let status = 'La información está Incompleta';

            switch (parseInt(row.status)) {
              case 200:
                status = 'Información validada';
                break;
              case 100:
                status = 'Información en validación';
                break;
              case 90:
                status = 'La información está completa sin alertas de validación';
                break;
              case 80:
                status = 'La información está completa con alertas de validación';
                break;
              case 70:
                status = 'La información está Incompleta';
                break;
              default:
                status = 'La información está Incompleta';
                break;
            }

            return `${row.companyName}: ${row.name} (${status})`;
          },
        },
        {
          render: function(data, type, row) {

            const buttons = `
                          <a class="btn btn-warning detalles" href="/Empresas/empresa/flotasInformacionGeneral?flota=${row.id_encrypt}">Capturar</a>                                                    
                        `;

            return buttons;
          },
          title: '',
        }
      ],
      searching: false,
      paging: false,
      "language": {
        "search": 'Buscar: ',
        "info": '<span style="font-size:.8em;">Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros</span>',
        "infoEmpty": 'Mostrando 0 a 0 de 0 filas',
        "paginate": {
          "first": "Primero",
          "last": "'Último'",
          "next": "Siguiente",
          "previous": "Anterior"
        },
      },

    })

    /*=====================================
    EMPRESAS USUARIAS
    =====================================*/
    $('.enviar-empresas-usuarias').click(function() {
      var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/terminarEmpresaUsuaria');

      rj = JSON.parse(rj);

      if (rj.ok == 1) {
        window.location = "<?= base_url(); ?>/Empresas/empresa/inicio";
      }
    })


    //TABLA DE BRANDS        
    $('#brandsDatatable').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
      },
      // responsive: true,
      data: <?= isset($brands) ? $brands : '[]' ?>,
      columns: [{
          title: 'Nombre',
          render: function(data, type, row) {

            let status = 'La información está Incompleta';

            switch (parseInt(row.status)) {
              case 200:
                status = 'Información validada';
                break;
              case 100:
                status = 'Información en validación';
                break;
              case 90:
                status = 'La información está completa';
                break;              
              case 70:
                status = 'La información está Incompleta';
                break;
              default:
                status = 'La información está Incompleta';
                break;
            }

            return `${row.name} (${status})`;
          },
        },
        {
          render: function(data, type, row) {

            const buttons = `
                          <a class="btn btn-warning detalles" href="/Empresas/empresa/brandsAgregarTransportistas?brand=${row.id_encrypt}">Capturar</a>                                                    
                        `;

            return buttons;
          },
          title: 'Acciones',
        }
      ]
    })

  })
</script>

<?php

use App\Libraries\EmpresaVerificarPasos;

$paso1 = EmpresaVerificarPasos::paso1();
$paso2 = EmpresaVerificarPasos::paso2();
$paso3 = EmpresaVerificarPasos::paso3();
$paso4 = EmpresaVerificarPasos::paso4();
$paso4U = EmpresaVerificarPasos::paso4U();
$paso4 = EmpresaVerificarPasos::paso4();
$paso5 = EmpresaVerificarPasos::paso5();
$paso6 = EmpresaVerificarPasos::paso6();
$paso6U = EmpresaVerificarPasos::paso6U();

?>

<div class="ptl-my-2">
  <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="ayuda_general_inicio" id="ayuda"></span>
  Ayuda
</div>

<h4>Por favor, complete los siguientes pasos. Para obtener más información seleccione el botón ayuda.</h4>
<!-- <br> -->

<!-- PASO 1 -->
<div class="form-group">
  <div class="li-number">1</div>
  <label for="vNombre">Verifique el nombre de la empresa</label>

  <!-- Paso 1 Completado -->
  <span class="glyphicon glyphicon-ok ptl-green-text paso1"></span><br>
  <label style="font-weight: lighter;">
    <p>(Este es el nombre con el que se registr&oacute; su empresa en el Programa&nbsp;Transporte&nbsp; Limpio. En caso de un cambio o correcci&oacute;n, contactar al equipo del Programa Transporte Limpio)</p>
  </label>
  <input type="text" value="<?= isset($company['name']) ? esc($company['name']) : '' ?>" class="form-control input-nombre" disabled>
</div>

<!-- PASO 2 -->
<div class="form-group">
  <div class="li-number">2</div>
  <a href="/Empresas/Empresa/InformacionDeSocios" class="btn btn-primary">
    Información de la empresa y contactos
  </a>

  <!-- Paso 2 Completado -->
  <?php if ($paso1 && $paso2) : ?>
    <span class="glyphicon glyphicon-ok ptl-green-text paso2"></span>
  <?php endif ?>
</div>

<!-- PASO 3 -->
<div class="form-group">
  <?php if (isset($company['type']) && intval($company['type']) == 1) : ?>

    <!-- EMPRESA TIPO 1 -->

    <div class="li-number">3</div>

    <!-- VALIDAMOS SI HABILITAMOS PASO 3  -->

    <?php if ($paso1 && $paso2) : ?>
      <a href="/Empresas/Empresa/descripcionFlotas" class="btn btn-primary">
        Descripción de la flota(s)
      </a>
    <?php else : ?>
      <a class="btn btn-primary ptl-disabled">
        Descripción de la flota(s)
      </a>
    <?php endif ?>

    <!-- Paso 3 Completado -->
    <?php if ($paso1 && $paso2 && $paso3) : ?>
      <span class="glyphicon glyphicon-ok ptl-green-text paso3"></span>
    <?php endif ?>

  <?php elseif (isset($company['type']) && intval($company['type']) == 2) : ?>

    <!-- EMPRESA TIPO 2 (EMPRESAS USUARIAS) -->

    <div class="li-number">3</div>

    <!-- VALIDAMOS SI HABILITAMOS PASO 3  -->

    <?php if ($paso1 && $paso2) : ?>
      <a href="/Empresas/Empresa/agregarBrands" class="btn btn-primary">
        Unidades de negocio
      </a>
    <?php else : ?>
      <a class="btn btn-primary ptl-disabled">
        Unidades de negocios
      </a>
    <?php endif ?>

    <!-- Paso 3 Completado -->
    <?php if ($paso1 && $paso2 && $paso3) : ?>
      <span class="glyphicon glyphicon-ok ptl-green-text paso3"></span>
    <?php endif ?>

  <?php endif ?>

</div>

<!-- PASO 4 -->
<div class="row">
  <div class="col-md-12">

    <div class="li-number">4</div>
    <strong>Captura de datos:</strong> (De clic en el botón Capturar para comenzar a agregar información)

    <?php if ($company['type'] == 1){ ?>
      <?php if ($paso1 && $paso2 && $paso3 && $paso4) { ?>
        <span class="glyphicon glyphicon-ok ptl-green-text paso4"></span>
      <?php } ?>
      <table class="table flotas-datatable" id="fleetsDatatable"></table>
    <?php } ?>

    <?php if ($company['type'] == 2){ ?>
      <?php if ($paso1 && $paso2 && $paso3 && $paso4U) : ?>
        <span class="glyphicon glyphicon-ok ptl-green-text paso4"></span>
      <?php endif ?>
      <table class="table brands-datatable" id="brandsDatatable"></table>

    <?php } ?>

  </div>
</div>
<br>

<!--  -->

<div class="form-group">
  <div align="center">
    <?php if (isset($company['type']) && $company['type'] == 1) : ?>
      <!-- <button class="btn btn-primary btn-lg enviar-validacion-empresas" type="button">ENVIAR INFORMACIÓN A VALIDACIÓN</button> -->
    <?php else : ?>

    <?php endif ?>
  </div>
</div>

<!-- PASO 5 -->
<div class="row">
  <div class="col-md-12">
    <div class="li-number">5</div>

    <!-- VALIDAMOS SI HABILITAMOS PASO 5  -->

    <?php if (session() -> get('type') == 1){ ?>
      <?php if ($paso1 && $paso2 && $paso3 && $paso4 ) { ?>
        <a href="<?= base_url(); ?>/Empresas/empresa/showResults" class="btn btn-primary">Informe de desempeño preliminar</a>
      <?php }else{ ?>
        <a class="btn btn-primary ptl-disabled">Informe de desempeño preliminar</a>
      <?php } ?>
      <?php if ($paso1 && $paso2 && $paso3 && $paso4 && $paso5 ) : ?>
        <span class="glyphicon glyphicon-ok ptl-green-text paso5"></span>
      <?php endif ?>
    <?php } ?>

    <?php if (session() -> get('type') == 2){ ?>
      <?php if ($paso1 && $paso2 && $paso3 && $paso4U ) { ?>
        <a href="<?= base_url(); ?>/Empresas/empresa/showResultsU" class="btn btn-primary">Informe de desempeño preliminar</a>
      <?php }else{ ?>
        <a class="btn btn-primary ptl-disabled">Informe de desempeño preliminar</a>
      <?php } ?>
      <?php if ($paso1 && $paso2 && $paso3 && $paso4U && $paso5 ) : ?>
        <span class="glyphicon glyphicon-ok ptl-green-text paso5"></span>
      <?php endif ?>
    <?php } ?>


  </div>
</div>

<!-- PASO 6 -->
<div class="row">
  <div class="col-md-12">
    <div class="li-number">6</div>

    <!-- VALIDAMOS SI HABILITAMOS PASO 6  -->
    <?php if (session() -> get('type') == 2){ ?>
      <?php if ($paso6U ) { ?>
        <a href="<?= base_url(); ?>/Empresas/empresa/downloadReport" class="btn btn-primary" target="_blank">
          Informe de desempeño validado
        </a>
        <span class="glyphicon glyphicon-ok ptl-green-text paso6"></span>

        <!-- <button class="btn btn-primary ver-mis-metricas" type="button">Informe de desempeño validado</button> -->

      <?php }else{ ?>
        <a class="btn btn-primary ptl-disabled">Informe de desempeño validado</a>

      <?php } ?>

    <?php } ?>
    <?php if (session() -> get('type') == 1){ ?>
      <?php if ($paso6) { ?>
        <a href="<?= base_url(); ?>/Empresas/empresa/downloadReport" class="btn btn-primary" target="_blank">
          Informe de desempeño validado
        </a>
        <span class="glyphicon glyphicon-ok ptl-green-text paso6"></span>

      <?php }else{ ?>
        <a class="btn btn-primary ptl-disabled">Informe de desempeño validado</a>

      <?php } ?>

    <?php } ?>


  </div>
</div>