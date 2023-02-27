<div style="background-color: #255b4e; width: 100%;">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarMainCollapse">
            <ul class="nav navbar-nav navbar-left">
                <!--=====================================
                BRAND | MENU EMPRESAS USUARIAS 
            |   ======================================-->
                <?php if ($main_menu == 'brand') : ?>
                    <li class="nav-item <?= $active_menu == 'agregar_transportistas' ? 'navbar-active' : '' ?>">
                        <a href="<?= base_url() ?>/Administration/UsersValidations/brandsTransportistas/<?= $company['id'] ?>/<?= $company['brand']['id'] ?>" class="nav-link" style="color: white;">Ingrese Transportistas</a>
                    </li>
                    <li class="nav-item <?= $active_menu == 'datos_de_actividad' ? 'navbar-active' : '' ?>">
                        <a href="<?= base_url() ?>/Administration/UsersValidations/brandsDatosDeActividad/<?= $company['id'] ?>/<?= $company['brand']['id'] ?>" class="nav-link" style="color: white;">Datos de Actividad</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</div>