<div class="navCompanies">
  <div class="container" id="navCont">
    <div class="collapse navbar-collapse" id="navbarMainCollapse">
      <ul class="nav navbar-nav navbar-left">
        <!--=====================================
        MENU INICIO
        ======================================-->
        <?php $active_menu = isset($active_menu)?$active_menu:null; ?>
        <li><a style="color: white;" href="/Empresas/empresa/inicio" class="<?= $active_menu == 'inicio' ? 'navbar-active' : '' ?>">Inicio</a></li>
        

        <?php if (isset($main_menu)) : ?>

          <!--=====================================
          FLOTAS | MENU EMPRESAS
          ======================================-->

          <?php if($main_menu == 'flotas') : ?>
            <li class="nav-item <?= $active_menu == 'informacionGeneral' ? 'navbar-active' : '' ?>">
              <a href="/Empresas/empresa/flotasInformacionGeneral?flota=<?= $_GET['flota'] ?>" class="preventLink nav-link" style="color: white;">Información General</a>
            </li>
            
            <!--=====================================
            COMBUSTIBLES SELECCIONADOS | MENU EMPRESAS
            ======================================-->
            <?php if (!empty($fleet['fuels'])) : ?> 
              <?php foreach ($fleet['fuels'] as $key => $value): ?>
                <li class="nav-item <?= isset($combustible_seleccionado) && $combustible_seleccionado['id'] == $value->fuels_id ? 'navbar-active' : '' ?>">
                  <a href="<?= base_url() ?>/Empresas/empresa/flotasCombustibleClases?flota=<?= $_GET['flota'] ?>&ff=<?= $value->id_encriptado ?>" class="preventLink nav-link" style="color: white;"><?= $value->name ?></a>
                </li>
              <?php endforeach ?>
            <?php endif ?>

          <?php endif ?>

          <!--=====================================
          BRAND | MENU EMPRESAS USUARIAS 
          ======================================-->
          <?php if($main_menu == 'brand') : ?>
            <li class="nav-item <?= $active_menu == 'agregar_transportistas' ? 'navbar-active' : '' ?>">
              <a href="/Empresas/empresa/brandsAgregarTransportistas?brand=<?= $_GET['brand'] ?>" class="nav-link preventLink" style="color: white;">Ingrese Transportistas</a>
            </li>
            <li class="nav-item <?= $active_menu == 'datos_de_actividad' ? 'navbar-active' : '' ?>">
              <a href="/Empresas/empresa/brandsDatosDeActividad?brand=<?= $_GET['brand'] ?>" class="nav-link preventLink" style="color: white;">Datos de Actividad</a>
            </li>
          <?php endif ?>

        <?php endif ?>

      </ul>
      <?php if (isset(session()->id)) : ?>
        <ul class="nav navbar-nav navbar-right">
          <li class="nav-item">
            <a href="/Empresas/login/logout" class="nav-link" style="color: white;">Cerrar Sesión</a>
          </li>
        </ul>
      <?php endif ?>
    </div>
  </div>
</div>