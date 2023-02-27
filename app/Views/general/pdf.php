
<?php 
    include_once APPPATH.'/ThirdParty/j/j.func.php';
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SCE</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/adminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="/assets/adminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/adminLTE/css/adminlte.css">

    <link rel="icon" type="image/png" href="/assets/adminLTE/img/crud_logo.png" />

    <link href="/assets/j/j.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/general.css" rel="stylesheet" type="text/css" />




    <!-- jQuery -->
    <script src="/assets/adminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/assets/adminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        jQuery(document).ready(function($) {
            $.widget.bridge('uibutton', $.ui.button)
        });
    </script>
    <!-- Bootstrap 4 -->
    <script src="/assets/adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/j/j.js" charset="utf-8"></script>
    <script src="/assets/js/jquery-upload-file/js/jquery.uploadfile.js"></script>

    <style>
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px;
        }

        .tdTrans {
            border-top: solid 1px #ccc;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            color: white;
            text-align: center;
            line-height: 35px;
        }

        footer {
            /*position: fixed; */
            /*bottom: -60px; */
            /*left: 0px; */
            /*right: 0px;*/
            /*height: 50px;*/
            /*width: 100%;*/

            /** Extra personal styles **/
            /*color: white;*/
            /*text-align: center;*/
            /*line-height: 35px;*/
        }
    </style>


</head>

<body class="hold-transition sidebar-mini layout-fixed" style="font-family: Helvetica;font-size: .9em;">
    <header>
        <img src="<?= base_url(); ?>/assets/img/banner.png" alt="SCE" class="banner" width="100%">
        <hr/>
    </header>
    <div class="content" style="margin-top: 30px;">
        <hr/>
        <div style="margin-top: 20px;">
            <div style="margin-top: 30px;">
                
                <?= $html; ?>
                
            </div>
        </div>

    </div>
    <!-- <footer>
        <hr/>
        <div style="font-size:x-small;position:relative; width:100%; border:none 1px;background-color:rgba(0,0,0,0);" >
            <div style="position:relative;float:right;margin:-2px 0px 0px 0; border:none 1px;font-size:x-small">
                <table class="tablaSB" border="0" style ="margin:0px 0px 0px 0px;"cellspacing="0" cellpadding="0">
                    <tr>
                        <td style ="font-style:oblique; font-size:x-small;color:#333;text-align:right;">
                            
                        </td>
                        <td style="opacity:1">
                            <a target="new" href = "http://notland.mx" style = "color:#A0A0A0;text-decoration: none">
                                <img src="<?= base_url(); ?>/assets/img/PMR.png" alt="PMR" style="height: 30px;" >
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer> -->

</body>
</html>