<?php
ob_start(); 
include 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="../dist/gambar/favico.ico"/>
    <title>ATAZ Barbershop</title>

    <!-- Bootstrap Core CSS -->
    <link href="../dist/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Datepicker CSS -->
    <link href="../dist/datepicker/bootstrap-datepicker.css" rel="stylesheet">


    <!-- MetisMenu CSS -->
    <link href="../dist/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../dist/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../dist/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- select CSS -->
    <link href="../dist/chosen/chosen.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../dist/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">



</head>

<body>

    <div id="wrapper">
        <?php
        include "menu.php"
        ?>
        <div id="page-wrapper">
        <!-- script untuk membuat menu dinamis dan merubah url menjadi clean url
             contoh dasar ada di menu.rar(silahkan pelajari).
        -->
                            <?php ob_start(); 
                                $pages_dir = '../pages';
                                if (!empty($_GET['cp'])) {
                                    $pages = scandir($pages_dir, 0);
                                    unset($pages[0], $pages[1]);
                                    $p = $_GET['cp'];
                                    if (in_array($p. '.php', $pages)) {
                                        include($pages_dir.'/'.$p.'.php');
                                    } else {
                                        echo 'Page not Found !';
                                    }
                                } else {
                                    include ($pages_dir.'/homeadmin.php');
                                }
                            ob_flush(); ?>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery  -->
    <script src="../dist/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../dist/bootstrap/js/bootstrap.min.js"></script>

    <!-- Datepicker JavaScript -->
    <script src="../dist/datepicker/bootstrap-datepicker.js"></script>
    <script src="../dist/datepicker/bootstrap-datepicker.id.min.js"></script> 

     <!-- chosen select -->
    <script src="../dist/chosen/chosen.jquery.min.js" type="text/javascript"></script> 

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../dist/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../dist/DataTables/jquery.dataTables.min.js"></script>
    <script src="../dist/datatables-plugins/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Custom JavaScript -->
    <script src="../dist/tampilan.js"></script>
    <!-- Custom JavaScript tampilan upload -->
    <script src="../dist/bootstrap-file-input/bootstrap-file-input.min.js"></script>
</body>
</html>
