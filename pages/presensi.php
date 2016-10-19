<?php
date_default_timezone_set('Asia/Jakarta');
include 'koneksi.php';
include 'cek.php';
include 'form.php';
include '../dist/DateToIndo.php';
include '../dist/JmlHari.php';
include '../dist/NamaHari.php';
$now = date('Y-m-d H:i:s');
    // menampilkan jumlah hari pada bulan dan tahun saat ini
    $bulanini= jumlah_hari();
    // menampilkan jumlah hari pada bulan pebruari tahun ini
    $febbulaniini= jumlah_hari(2);
    // menampilkan jumlah hari pada bulan pebruari tahun 2000
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Presensi Ataz</title>
     <style type="text/css">
          .modal-dialog2 {
            width: 100%;
            margin: 30px auto;
          }
          .modal-dialog {
            width: 300px;
            margin: 30px auto;
          }
     </style>
    <script type="text/javascript">
        function CekLamaLogin(NamaLayer, JamDatang) {
            var enableCache = false;
            //document.body.style.cursor='crosshair';

          var oXMLHTTP;
          try{ 
            oXMLHTTP=new XMLHttpRequest();  
          }catch (e){  
            try{
              oXMLHTTP=new ActiveXObject("Msxml2.XMLHTTP");    
            }catch (e){    
              try{
                oXMLHTTP=new ActiveXObject("Microsoft.XMLHTTP");      
              }catch (e){
                    alert("Your browser does not support AJAX!");
                      return false;      
              }    
            }  
          }  

            var sURL = "presensidurasi.php?Datang=" + JamDatang;
            oXMLHTTP.open( "POST", sURL, false );
            oXMLHTTP.send(null);
            var menit = oXMLHTTP.responseText;
            document.getElementById(NamaLayer).innerHTML=menit;
        }
    </script>
    <script type="text/javascript">
        function buatjam(){
            var date = new Date();
            var j = date.getHours();
            var m = date.getMinutes();
            var s = date.getSeconds();
            j = cek(j);
            m = cek(m);
            s = cek(s);
            document.getElementById("jam").innerHTML = j+":"+m+":"+s;
            setTimeout("buatjam()",500);
        }
        function cek(x){
            if(x < 10){
                x = "0"+x;
            }
            return x;
        }
    </script>

    <script src="../dist/jquery/jquery.min.js"></script>

    <script type="text/javascript">
        $(window).load(function(){
        $("#tglprint").datepicker({
            autoclose: 1,
            format: "MM yyyy",
            startDate: '-1m',
            viewMode: "months", 
            minViewMode: "months"
        });
         });
    </script>

    <script type="text/javascript">
        $(window).load(function(){
        $("#tgledit").datepicker({
            autoclose: 1,
            format: "MM yyyy",
            startDate: '-1m',
            viewMode: "months", 
            minViewMode: "months"
        });
         });
    </script>

<script type="text/javascript">
    $(window).load(function(){
        $("#color_me").change(function(){
            var color = $("option:selected", this).attr("class");
            $("#color_me").attr("class", color);
        });
    });
</script>

<style type="text/css">
    .satu {
        background-color: #BDFF7D;
    }
    .dua {
        background-color: #FFFF66;
    }
    .tiga {
        background-color: #FF0000;
    }
    .empat {
        background-color: #FF9900;
    }
</style>

</head>
<body>
    <div class="row">
        <!-- Button Menu -->
        <?php
            if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
            <div class="col-lg-5">
                <h3> 
                    <a href="#pilihbulan" id="0" class="btn btn-warning col-lg-5" data-toggle="modal" data-target="#pilihbulan">
                        <strong> <span class="glyphicon glyphicon-plus"></span> Input Jadwal </strong>
                    </a>
                    <a href="#jadwaledit" id="0" class="col-md-5 col-md-offset-2 btn btn-warning" data-toggle="modal" data-target="#jadwaledit">
                        <span class="fa fa-pencil"></span> <b>Edit Jadwal</b>
                    </a>
                </h3> 
            </div>
            <div class="col-lg-7">
            <div class="col-lg-4 col-md-offset-8">
                <h3> 
                    <a href="#pilihjadwal" id="0" class="btn btn-warning " data-toggle="modal" data-target="#pilihjadwal">
                        <strong> <span class="fa  fa-spinner"></span> Lihat Jadwal Kerja </strong>
                    </a>
                </h3>   
            </div>

            </div>
            <?php
            }else{?>
            <div class="col-lg-5" >
                <h3 class="col-lg-12 ">Awali Kerja Dengan Doa </h3>
            </div>
            <div class="col-lg-7">
            <div class="col-lg-4 col-md-offset-8">
                <h3> 
                    <a href="#pilihjadwal" id="0" class="btn btn-warning " data-toggle="modal" data-target="#pilihjadwal">
                        <strong> <span class="fa  fa-spinner"></span> Lihat Jadwal Kerja </strong>
                    </a>
                </h3>   
            </div>
            </div>
            <?php
            }
        ?>
        <!-- Button Menu End -->

        <!-- Modal Pertama Input (input jadwal) -->
        <div class="modal fade" id="pilihbulan" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog">
            <form class="form-horizontal" role="form" action="jadwalinput" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" onclick="" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">PILIH BULAN</h4>
                    </div>
                    <div class="modal-body">
                          <div class="controls">
                            <input type="text" name="jadwalinput" class="form-control input-sm" id="tglprint" placeholder="Bulan" required="required">
                          </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Pilih Bulan</button>
                    </div>
                </div> <!-- /.modal-content -->
            </form>
          </div>
        </div>
        <!-- Modal Pertama Input End -->

        <!-- Modal Pertama Edit (jadwal Edit) -->
        <div class="modal fade" id="jadwaledit" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog">
            <form class="form-horizontal" role="form" action="jadwaledit" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" onclick="" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">PILIH BULAN</h4>
                    </div>
                    <div class="modal-body">
                        <div class="controls">
                            <input type="text" name="editbulan" class="form-control input-sm" id="tgledit" placeholder="Bulan" required="required">
                          </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Pilih Bulan</button>
                    </div>
                </div> <!-- /.modal-content -->
            </form>
          </div>
        </div>
        <!-- Modal Pertama Edit End -->

        <!-- Modal Lihat jadwal -->
        <?php 
            date_default_timezone_set('Asia/Jakarta');
            $datejadwal  = date("Y-m-d");
            $bulan =date('m', strtotime(str_replace(' ','-', $datejadwal)));
            $wulan =date('F', strtotime(str_replace(' ','-', $datejadwal)));
            $tahun =date('Y', strtotime(str_replace(' ','-', $datejadwal)));
            $jum_tgl=jumlah_hari($bulan, $tahun);
        ?>
        <div class="modal fade" id="pilihjadwal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog2">
            <form class="form-horizontal" role="form" action="" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" onclick="" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Jadwal Kerja Bulan <?php echo "".(WulanIndo($bulan))." ".$tahun.""; ?></h4>
                    </div>
                    <div class="modal-body">
                        <table width="100%" bordercolor="#111111" style="border-style:solid; border-width:1; border-collapse: collapse; padding-left:4; padding-right:4; padding-top:1; padding-bottom:1" >
                                <tr style="border:1px solid #000000;border-collapse:collapse;">
                                    <td colspan="2" style="padding-right:25px; border:1px solid #CCC;border-collapse:collapse;" align="center">
                                        <strong><i class="fa fa-user"></i> Crew</strong>
                                    </td>
                                    <?php
                                    for ($x = 1; $x <= $jum_tgl; $x++) {
                                        $warna = "background:#CACACA; color:#000000;";
                                        if($x % 2 == 0){
                                        $warna = "";
                                        }
                                        $tanggal=''.$tahun.'-'.$bulan.'-'.$x.'';
                                        $tanggaltampil = (haritiga($tanggal,'-'));
                                        ?>
                                    <th style="text-align: center;border-right: thin solid black;<?php echo $warna ;?>"><b><?php echo $x; ?><br><?php echo $tanggaltampil; ?></b></th>
                                    <?php
                                    }
                                    ?>
                                </tr>

                                <?php
                                    $no = '0';
                                    $result = mysql_query("SELECT nama FROM jadwal where bulan='$bulan' and tahun='$tahun' group by nama");
                                    while($row=mysql_fetch_array($result))
                                    {
                                    $no++;
                                    $nama = $row['nama'];
                                    $jenengawal1 = ucwords($row['nama']);
                                    $jenengawal =str_word_count($jenengawal1, 1);
                                    
                                        $warna = "background:#292933; color:#ffffff;";
                                        if($no % 2 == 0){
                                        $warna = "background:#ECECEC; color:#000000;";
                                        }?>
                                        <tr style="border:1px solid #000000;border-collapse:collapse;">
                                            <th align="center" style="padding-right : 16px; padding-left:5px;"><?php echo $no;?></th>
                                            <th align="left" style="padding-left:5px;border-right: thin solid black;"> <?php echo $jenengawal[0]; ?></th>
                                            <?php
                                                for ($x = 1; $x <= $jum_tgl; $x++) {

                                                    $shift1=mysql_query("SELECT * FROM jadwal where nama='$nama' and day(tgl)='$x' and bulan='$bulan' and tahun='$tahun'");
                                                    $data=mysql_fetch_array($shift1);
                                                    $count=mysql_num_rows($shift1);
                                                    $shifttampil=$data['shift'];
                                                    if ($count > 1) {
                                                        echo "<td align='center' style='border-right: thin solid black; text-align:center;'><b>1+3</b></td>";
                                                    }elseif ($count < 1) {
                                                        echo "<td align='center' style='background:#FFA2D0; border-right: thin solid black;'></td>";
                                                    }else{
                                                        echo "<td style='border-right: thin solid black;text-align:center;'><b>$shifttampil</b></td>";
                                                    }
                                                 }
                                            ?>
                                        </tr>
                                    <?php 
                                    }
                                    mysql_free_result($result);
                                ?>
                        </table>
                        <br>
                        <table border="1">
                            <tr>
                                    <th align="center" style="padding-right : 16px; padding-left:5px;">#</th>
                                    <th align="center" style=" text-align:center; padding-right:20px; padding-left:20px;">Crew</th>
                                    <th align="center" style="padding-right : 16px; padding-left:5px;">Jumlah Shift</th>
                            </tr>
                            <?php
                                    $no = '0';
                                    $result = mysql_query("SELECT nama,count(nama) as jumlah_shift FROM jadwal where bulan='$bulan' and tahun='$tahun' group by nama");
                                    while($row=mysql_fetch_array($result))
                                    {
                                    $no++;
                                    $nama = $row['nama'];
                                    $jenengawal=str_word_count($nama, 1);?>
                                    <tr>
                                            <th align="center" style="padding-right : 16px; padding-left:5px;"><?php echo $no;?></th>
                                            <th align="left" style="padding-left:5px;"> <?php echo $jenengawal[0]; ?></th>
                                            <td align="center"><strong><?php echo $row['jumlah_shift']; ?></strong></td>
                                    </tr>
                                    <?php 
                                    }
                                    mysql_free_result($result);?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="" class="col-md-2 col-md-offset-5 btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div> <!-- /.modal-content -->
            </form>
          </div>
        </div>
        <!-- Modal Lihat jadwal End -->
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Ataz Presensi
                </div>
                <div class="panel-body">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Presensi Datang</a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body" >
                                    <form class="form-horizontal" role="form" action="prosesabsen.php" method="post">
                                        <?php
                                        $datang = new \form\PresensiDatang;
                                        $datang -> datang();
                                        ?>
                                        <input type="hidden" name="proses" value="datang">
                                    </form>
                                </div><!-- panel body jasa end -->
                            </div>
                        </div><!-- panel jasa end -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Presensi Pulang</a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body" >
                                    <form class="form-horizontal" role="form" action="prosesabsen.php" method="post">
                                        <?php
                                        $pulang = new \form\PresensiPulang;
                                        $pulang -> pulang();
                                        ?>
                                        <input type="hidden" name="proses" value="pulang">
                                    </form>
                                </div><!-- panel body barang end -->
                            </div>
                        </div><!-- panel barang end -->
                    </div><!-- panel Group end -->
                </div>
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 (nested) -->
        <div class="col-lg-7">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Crew yang Sedang Bertugas 
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <td align="center"><strong>Shift</strong></td>
                                    <td align="center"><strong>Jam Datang</strong></td>
                                    <td align="center"><strong>Durasi</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = '0';
                            $result = mysql_query("SELECT * FROM absensi where sudahpulang='0'");
                            while($row=mysql_fetch_array($result))
                            {
                            $no++;
                            $datang = $row['datang'];
                            $jam = date("H:i", strtotime("$datang"));
                            ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $row['user'];?></td>
                                    <td align="center"><?php echo $row['shift']; ?></td>
                                    <td align="center"><?php echo $jam;?></td>
                                    <td align="center">
                                      <script type="text/javascript">setInterval("CekLamaLogin('<?php echo $no; ?>', '<?php echo $datang;?>')",1000);</script>
                                      <div id="<?php echo $no; ?>" align="center">Time</div>
                                    </td>
                                </tr>
                            <?php 
                            }
                            mysql_free_result($result);
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 (nested) -->
    </div>

</body>
</html>