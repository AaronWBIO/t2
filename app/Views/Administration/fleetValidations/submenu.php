<div style="background-color: #255b4e; width: 100%;">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarMainCollapse">
            <ul class="nav navbar-nav navbar-left">
                <!--=====================================
                FLOTAS | MENU EMPRESAS
                ======================================-->

                <?php if ($main_menu == 'flotas') : ?>
                    <li class="nav-item <?= $active_menu == 'informacionGeneral' ? 'navbar-active' : '' ?>">
                        <a href="<?= base_url() ?>/Administration/FleetValidations/informacionGeneral/<?= $company['id'] ?>/<?= $fleet['id'] ?>" class="preventLink nav-link" style="color: white;">Información General</a>
                    </li>

                    <!--=====================================
                    COMBUSTIBLES SELECCIONADOS | MENU EMPRESAS
                    ======================================-->
                    <?php if (!empty($fleet['fuels'])) : ?>
                        <?php foreach ($fleet['fuels'] as $key => $value) : ?>
                            <li class="nav-item <?= isset($combustible_seleccionado) && $combustible_seleccionado['id'] == $value->fuels_id ? 'navbar-active' : '' ?>">
                                <a href="<?= base_url() ?>/Administration/FleetValidations/flotasCombustibleClases/<?= $company['id'] ?>/<?= $fleet['id'] ?>?ff=<?= $value->id ?>" class="preventLink nav-link" style="color: white;"><?= $value->name ?></a>
                            </li>
                        <?php endforeach ?>
                    <?php endif ?>
                <?php endif ?>
            </ul>
        </div>
    </div>
</div>