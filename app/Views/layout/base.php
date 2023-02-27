<?php
header('Access-Control-Allow-Origin: ' . base_url());
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST');
header("X-Frame-Options: DENY");
header('X-Content-Type-Options: nosniff');
?>

<?php
// echo "AAA";
include_once APPPATH . '/ThirdParty/j/j.func.php';
$uri = service('uri');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />



    <title>PTL</title>

    <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
    <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>

    <!-- LIBRERIAS CSS -->
    <link href="<?= base_url(); ?>/assets/css/variables.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>/assets/css/general.css" rel="stylesheet" type="text/css" />

    <!-- LIBRERIAS JAVASCRIPT -->
    <script src="<?= base_url(); ?>/assets/js/jquery-3.6.0.js"></script>
    <?php
    if (strtolower($uri->getSegment(1)) == 'administration' || strtolower($uri->getSegment(1)) == 'empresas') {
        include_once APPPATH . '/ThirdParty/j/j.js.php';
    }
    ?>

    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- DataTables -->
    <script src="/assets/adminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/adminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/adminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <!-- UploadFiles -->
    <link href="/assets/js/jquery-upload-file/css/uploadfile.css " rel="stylesheet" type="text/css" />
    <script src="/assets/js/jquery.form.js"></script>
    <script src="/assets/js/jquery-upload-file/js/jquery.uploadfile.js"></script>

    <?php
    if (session()->type == 1 || session()->type == 2) {
        echo view('Empresas/componentes/funcionesGeneralesJs');
    }
    ?>

    <!-- AM Charts -->
    <!-- <script src="https://cdn.amcharts.com/lib/4/core.js"></script> -->
    <!-- <script src="https://cdn.amcharts.com/lib/4/charts.js"></script> -->
    <!-- <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script> -->

    <?php
    if (strtolower($uri->getSegment(1)) == 'empresas') {
        include_once APPPATH . '/ThirdParty/Empresas/main.php';
    }
    ?>
    <?php 
    $uri = service('uri');
    if (session()->get('id') && !empty($uri->getSegment(1))){ ?>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                banner_height = document.getElementById('banner').offsetHeight + 17;
                // console.log(banner_height);
                window.addEventListener('scroll', function() {
                    if (window.scrollY > banner_height) {
                        // console.log('aaa');
                        document.getElementById('navCont').classList.add('nav-fix');
                        // add padding top to show content behind navbar
                        navbar_height = document.getElementById('navCont').offsetHeight;
                        // document.body.style.paddingTop = navbar_height + 'px';
                    } else {
                        // console.log('bbb')
                        document.getElementById('navCont').classList.remove('nav-fix');
                        // remove padding top from body
                        // document.body.style.paddingTop = '0';
                    }
                });
            });
        </script>
    <?php } ?>

</head>

<body>
    <?php

    $uri = service('uri');

    $logged = session()->get('isLoggedIn');
    $loggedAdmin = session()->get('isLoggedInAdmin');

    if (strtolower($uri->getSegment(1)) == 'administration' || strtolower($uri->getSegment(1)) == 'empresas') {
        if (isset($logged)  && $logged == 1) {
            echo view_cell('\App\Libraries\Content::navBar', ['navbar' => 'layout/navCompanies']);
        } elseif (isset($loggedAdmin) && $loggedAdmin == 1) {
            echo view_cell('\App\Libraries\Content::navBar', ['navbar' => 'layout/navAdmin']);
        }
    }
    ?>
    <?php 
    $uri = service('uri');
    if (session()->get('id') && !empty($uri->getSegment(1))){ 
    ?>
        <div class="" id="banner"></div>
    <?php }else{ ?>
        <div class="banner" id="banner">
            <img src="<?= base_url(); ?>/assets/images/bannerMail.png" class="banner">
            <!-- <div class="bannerText">
                <h1 style="font-size: 1.9em;">
                    <span style="color: white;">
                        Plataforma Transporte Limpio
                    </span>
                </h1>
            </div> -->
            <!-- <img src="<?= base_url(); ?>/assets/images/layer1Banner.png" class="imgFondoBanner d-none d-md-block d-lg-block"> -->
        </div>
        <!-- <div style="background-color:#10312b; height: 25px;"></div>     -->
    <?php } ?>
    <div class="container mb-50">
        <?= view('Empresas/componentes/mensajes') ?>
        <?php if (isset($title)) { ?>
            <?= view_cell('\App\Libraries\Content::title', ['title' => @$title, 'fullpath' => @$fullpath]) ?>
        <?php } ?>
        <br />
        <?= view_cell('\App\Libraries\Content::content', ['content' => @$content, 'fullpath' => @$fullpath]) ?>
    </div>

    <div class="modal fade" id="popUpCuest" role="dialog" style="overflow-y: auto !important;" data-backdrop="static" data-keyboard="false">
        <div id="modalCuest" class="modal-dialog modal-xl">
            <div class="modal-content" style="border-radius: 0px;" id="popContCuest">
                Cargando...
            </div>
        </div>
    </div>
    <div class="modal fade" id="popUp" role="dialog" style="overflow-y: auto !important;" data-backdrop="static" data-keyboard="false">
        <div id="modal" class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 0px;" id="popCont">
                Cargando...
            </div>
        </div>
    </div>
    <div class="modal fade" id="popUpMapa" role="dialog" style="overflow-y: auto !important;" data-backdrop="static" data-keyboard="false">
        <div id="modalMapa" class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 0px;" id="popContMapa">
                Cargando...
            </div>
        </div>
    </div>
    <div class="modal fade" id="popUpImg" role="dialog" style="overflow-y: auto !important;" data-backdrop="static" data-keyboard="false">
        <div id="modalImg" class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 0px;" id="popContImg">
                Cargando...
            </div>
        </div>
    </div>
    <div class="modal fade" id="alertas" role="dialog" style="overflow-y: auto !important;">
        <div id="modalAlerta" class="modal-dialog">
            <div class="modal-content" style="border-radius: 0px;" id="alertasCont">
                Cargando...
            </div>
        </div>
    </div>
</body>

</html>