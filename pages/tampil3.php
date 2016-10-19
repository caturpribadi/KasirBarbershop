<?php
date_default_timezone_set('Asia/Jakarta');
include 'koneksi.php';
include 'cek.php';
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
    <style type="text/css">
        .divBox {
            width: 15px;
            height: 15px;
            background: #ddd;

            position: relative;
            -webkit-box-shadow: 0px 1px 3px rgba(0,0,0,0.5);
            -moz-box-shadow: 0px 1px 3px rgba(0,0,0,0.5);
            box-shadow: 0px 1px 3px rgba(0,0,0,0.5);
        }

        .divBox label {
            display: block;
            width: 15px;
            height: 15px;
            -webkit-transition: all .5s ease;
            -moz-transition: all .5s ease;
            -o-transition: all .5s ease;
            -ms-transition: all .5s ease;
            transition: all .5s ease;
            cursor: pointer;
            position: absolute;
            top: 1px;
            z-index: 1;
            /* 
            use this background transparent to check the value of checkbox 
            background: transparent;
            */
            background: #ffffff;
            -webkit-box-shadow:inset 0px 1px 3px rgba(0,0,0,0.5);
            -moz-box-shadow:inset 0px 1px 3px rgba(0,0,0,0.5);
            box-shadow:inset 0px 1px 3px rgba(0,0,0,0.5);
        }

        .divBox input[type=checkbox]:checked + label {
            background: green;
        }
    </style><!-- checkbox warna -->
    <style type="text/css">
        .table-hover>tbody>tr:hover>td {
          background-color: #E6E6E8;
          color:#000000;
        }
        .cobo { 
            width:1108px; 
            overflow-x:scroll;  
            margin-left:130px; 
            overflow-y:visible;
            padding-bottom:1px;
            padding-right:20px;

        }
        .headcol {
            position:absolute; 
            width:15px; 
            left:30px;
            top:auto;

        }
        .nama {
            position:absolute; 
            width:90px; 
            left:55px;
            top:auto;
        }
        /*.headcol:before {content: 'Row ';}*/
        /*.long { background:yellow; letter-spacing:1em; }*/
    </style>
    <script src="../dist/jquery/jquery.min.js"></script>
    <script type="text/javascript">
      $(window).load(function(){
        $('#myModal').modal('show');
      });
    </script>
<div class="row">
    <?php
        if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
        <div class="col-lg-5">
            <h3> 
                <a href="#pilihbulan" id="0" class="btn btn-warning" data-toggle="modal" data-target="#pilihbulan">
                    <strong> <span class="glyphicon glyphicon-plus"></span> Input Jadwal Kerja </strong>
                </a>
            </h3> 
        </div>
        <div class="col-lg-5">
            <h3> 
                <a href="#pilihjadwal" id="0" class="btn btn-warning" data-toggle="modal" data-target="#pilihjadwal">
                    <strong> <span class="fa  fa-spinner"></span> Lihat Jadwal Kerja </strong>
                </a>
            </h3> 
        </div>
        <?php
        }else{?>
        <div class="col-lg-12" >
            <h3 class="col-lg-6 page-header">Awali Kerja Dengan Doa </h3>
            <h3 class="col-lg-2 col-lg-offset-4 page-header" id="jam"></h3>
        </div>
        <?php
        }
    ?>
    <!-- Modal Pertama -->
    <div class="modal fade" id="pilihbulan" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <form class="form-horizontal" role="form" action="" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">PILIH BULAN</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                      <div class="controls">
                        <input type="text" name="datejadwal" class="form-control input-sm" id="tgljadwal" placeholder="Bulan" required="required">
                      </div>
                    </form> 
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Pilih Bulan</button>
                </div>
            </div> <!-- /.modal-content -->
        </form>
      </div>
    </div>
    <!-- /.modal end -->
    <!-- Modal Lihat jadwal -->
    <?php 
        date_default_timezone_set('Asia/Jakarta');
        $datejadwal  = date("2015-5-3");
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
<table border="1" width="100%" bordercolor="#111111" style="border-style:solid; border-width:1; border-collapse: collapse; padding-left:4; padding-right:4; padding-top:1; padding-bottom:1" >
        <tr>
            <th colspan="2" style="padding-right:25px; background:#292933;" align="center">tanggal</th>
            <?php
            for ($x = 1; $x <= $jum_tgl; $x++) {
                $tanggal=''.$tahun.'-'.$bulan.'-'.$x.'';
                $tanggaltampil = (haritiga($tanggal,'-'));
                ?>
            <th colspan="3" style="text-align: center;"><b><?php echo $tanggaltampil; ?><br><?php echo $x; ?></b></th>
            <?php
            }
            ?>
        </tr>
        <tr>
            <th align="center" style="padding-right : 16px; padding-left:5px;">#</th>
            <th align="center" style=" text-align:center; padding-right:20px; padding-left:20px;">Crew</th>
            <?php
                for ($x = 1; $x <= $jum_tgl; $x++) {
                    $warna = "background:#ECECEC; color:#000000;";
                    if($x % 2 == 0){
                    $warna = "";
                    }
                        ?>
                        <td id="<?php $x; ?>" align="center" style="<?php echo $warna ;?>">1</td>
                        <td id="<?php $x; ?>" align="center" style="<?php echo $warna ;?>">2</td>
                        <td id="<?php $x; ?>" align="center" style="<?php echo $warna ;?>">3</td>  
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
            $jenengawal=str_word_count($nama, 1);
                $warna = "background:#292933; color:#ffffff;";
                if($no % 2 == 0){
                $warna = "background:#ECECEC; color:#000000;";
                }?>
                <tr>
                    <th align="center" style="padding-right : 16px; padding-left:5px;"><?php echo $no;?></th>
                    <th align="left" style="padding-left:5px;"> <?php echo $jenengawal[0]; ?></th>
                    <?php
                        for ($x = 1; $x <= $jum_tgl; $x++) {

                            $shift1=mysql_query("SELECT * FROM jadwal where nama='$nama' and day(tgl)='$x' and shift='1'");
                            $data=mysql_fetch_array($shift1);
                            if(!empty($data))
                            {
                            echo "<td style='background:#292933;'></td>";
                            }else{
                                echo "<td></td>";
                            }

                            $shift2=mysql_query("SELECT * FROM jadwal where nama='$nama' and day(tgl)='$x' and shift='2'");
                            $data=mysql_fetch_array($shift2);
                            if(!empty($data))
                            {
                            echo "<td style='background:#292933;'></td>";
                            }else{
                                echo "<td></td>";
                            }

                            $shift3=mysql_query("SELECT * FROM jadwal where nama='$nama' and day(tgl)='$x' and shift='3'");
                            $data=mysql_fetch_array($shift3);
                            if(!empty($data))
                            {
                            echo "<td style='background:#292933;'></td>";
                            }else{
                                echo "<td></td>";
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
                    <button type="button" data-dismiss="modal">Close</button>
                </div>
            </div> <!-- /.modal-content -->
        </form>
      </div>
    </div>
    <!-- /.modal end -->

    <?php if (isset($_POST["datejadwal"])) : ?>
    <!-- Modal Kedua -->
    <div class="modal fade" id="myModal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog2">
        <form class="form-horizontal" role="form" action="prosesabsen.php" method="post">
            <div class="modal-content">
                    <?php
                        $datejadwal  =$_POST['datejadwal'];
                        $bulan =date('m', strtotime(str_replace(' ','-', $datejadwal)));
                        $wulan =date('F', strtotime(str_replace(' ','-', $datejadwal)));
                        $tahun =date('Y', strtotime(str_replace(' ','-', $datejadwal)));
                        $jum_tgl=jumlah_hari($bulan, $tahun);
                    ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Form Jadwal Kerja <?php echo "".(WulanIndo($bulan))." ".$tahun.""; ?></h4>
                </div>
                <div class="modal-body">
                <div class="row">
                    <table border="1" width="100%" bordercolor="#111111" style="border-style:solid; border-width:1; border-collapse: collapse; padding-left:4; padding-right:4; padding-top:1; padding-bottom:1" >
                            <tr>
                                <th colspan="2" style="padding-right:25px; background:#292933;" align="center">tanggal</th>
                                <?php
                                for ($x = 1; $x <= $jum_tgl; $x++) {
                                    $tanggal=''.$tahun.'-'.$bulan.'-'.$x.'';
                                    $tanggaltampil = (haritiga($tanggal,'-'));
                                    ?>
                                <th colspan="3" style="text-align: center;"><b><?php echo $tanggaltampil; ?><br><?php echo $x; ?></b></th>
                                <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <th align="center" style="padding-right : 16px; padding-left:5px;">#</th>
                                <th align="center" style=" text-align:center; padding-right:20px; padding-left:20px;">Crew</th>
                                <?php
                                    for ($x = 1; $x <= $jum_tgl; $x++) {
                                        $warna = "background:#ECECEC; color:#000000;";
                                        if($x % 2 == 0){
                                        $warna = "";
                                        }
                                            ?>
                                            <td id="<?php $x; ?>" align="center" style="<?php echo $warna ;?>">1</td>
                                            <td id="<?php $x; ?>" align="center" style="<?php echo $warna ;?>">2</td>
                                            <td id="<?php $x; ?>" align="center" style="<?php echo $warna ;?>">3</td>  
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
                                $jenengawal=str_word_count($nama, 1);
                                    $warna = "background:#292933; color:#ffffff;";
                                    if($no % 2 == 0){
                                    $warna = "background:#ECECEC; color:#000000;";
                                    }?>
                                    <tr>
                                        <th align="center" style="padding-right : 16px; padding-left:5px;"><?php echo $no;?></th>
                                        <th align="left" style="padding-left:5px;"> <?php echo $jenengawal[0]; ?></th>
                                        <?php
                                            for ($x = 1; $x <= $jum_tgl; $x++) {

                                                $shift1=mysql_query("SELECT * FROM jadwal where nama='$nama' and day(tgl)='$x' and shift='1'");
                                                $data=mysql_fetch_array($shift1);
                                                if(!empty($data))
                                                {
                                                echo "<td style='background:#292933;'></td>";
                                                }else{
                                                    echo "<td></td>";
                                                }

                                                $shift2=mysql_query("SELECT * FROM jadwal where nama='$nama' and day(tgl)='$x' and shift='2'");
                                                $data=mysql_fetch_array($shift2);
                                                if(!empty($data))
                                                {
                                                echo "<td style='background:#292933;'></td>";
                                                }else{
                                                    echo "<td></td>";
                                                }

                                                $shift3=mysql_query("SELECT * FROM jadwal where nama='$nama' and day(tgl)='$x' and shift='3'");
                                                $data=mysql_fetch_array($shift3);
                                                if(!empty($data))
                                                {
                                                echo "<td style='background:#292933;'></td>";
                                                }else{
                                                    echo "<td></td>";
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
                    <br>
                </div>
                <div class="row">
                    <div class="cobo" >
                        <table class="table table-bordered table-condensed table-hover" >
                                <tr>
                                    <th colspan="2" class="nama" style="padding-right:25px" align="center">tanggal</th>
                                    <?php
                                    for ($x = 1; $x <= $jum_tgl; $x++) {
                                        $tanggal=''.$tahun.'-'.$bulan.'-'.$x.'';
                                        $tanggaltampil = (getday($tanggal,'-'));
                                        ?>
                                    <th colspan="3" style="text-align: center;"><b><?php echo $tanggaltampil; ?><br><?php echo $x; ?></b></th>
                                    <?php
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <th class="headcol" style="padding-right : 16px;">#</th>
                                    <th class="nama" align="center" style=" align="center" padding-right:25px">Crew</th>
                                    <?php
                                        for ($x = 1; $x <= $jum_tgl; $x++) {
                                            $warna = "background:#CDCDD1; color:#000000;";
                                            if($x % 2 == 0){
                                            $warna = "background:#ECECEC; color:#000000;";
                                            }
                                                ?>
                                                <td id="<?php $x; ?>" align="center" style="<?php echo $warna ;?> padding-left : 6px;">1</td>
                                                <td id="<?php $x; ?>" align="center" style="<?php echo $warna ;?>">2</td>
                                                <td id="<?php $x; ?>" align="center" style="<?php echo $warna ;?>">3</td>  
                                        <?php
                                        }
                                    ?>
                                </tr>
                                <?php
                                    $no = '0';
                                    $result = mysql_query("SELECT * FROM pegawai where aktif='1' and visible='1'");
                                    while($row=mysql_fetch_array($result))
                                    {
                                    $no++;
                                    $nama = $row['nama'];
                                    $idpegawai = $row['idpegawai'];
                                    $jenengawal=str_word_count($nama, 1);
                                        $warna = "background:#292933; color:#ffffff;";
                                        if($no % 2 == 0){
                                        $warna = "background:#ECECEC; color:#000000;";
                                        }?>
                                        <tr>
                                            <th class="headcol" style="padding-right : 16px;"><?php echo $no;?></th>
                                            <th class="nama" style="padding-left : 8px;"> <?php echo $jenengawal[0]; ?></th>
                                            <?php
                                                for ($x = 1; $x <= $jum_tgl; $x++) {?>
                                                <td style="padding-left : 6px;">
                                                    <div class="divBox">
                                                        <input type="checkbox"  id="<?php echo "".$idpegawai."".$x."";?>shift1" value="<?php echo "".$x." 1 ".$jenengawal[0].""; ?>" name="<?php echo "".$idpegawai."shift1".$x.""; ?>" />
                                                        <label for="<?php echo "".$idpegawai."".$x."";?>shift1"></label>
                                                    </div>  
                                                </td>
                                                <td>
                                                    <div class="divBox">
                                                        <input type="checkbox" id="<?php echo "".$idpegawai."".$x."";?>shift2" value="<?php echo "".$x." 2 ".$jenengawal[0].""; ?>" name="<?php echo "".$idpegawai."shift2".$x.""; ?>"/>
                                                        <label for="<?php echo "".$idpegawai."".$x."";?>shift2"></label>
                                                    </div>          
                                                </td>
                                                <td>
                                                    <div class="divBox">
                                                        <input type="checkbox" id="<?php echo "".$idpegawai."".$x."";?>shift3" value="<?php echo "".$x." 3 ".$jenengawal[0].""; ?>" name="<?php echo "".$idpegawai."shift3".$x.""; ?>" />
                                                        <label for="<?php echo "".$idpegawai."".$x."";?>shift3"></label>
                                                    </div>  
                                                </td>
                                                <?php
                                                }
                                            ?>
                                        </tr>
                                    <?php 
                                    }
                                    mysql_free_result($result);
                                ?>
                        </table>
                    </div>   
                </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="proses" value="jadwaldua">
                    <input type="hidden" name="jum_tgl" value="<?php echo $jum_tgl; ?>">
                    <input type="hidden" name="bulan" value="<?php echo $bulan;?>">
                    <input type="hidden" name="tahun" value="<?php echo $tahun;?>">
                    <button type="button" onclick=""  class="col-md-3 col-md-offset-3 btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="col-md-3 col-md-offset-2 btn btn-warning">Simpan Jadwal</button>
                </div>
            </div> <!-- /.modal-content -->
        </form>
      </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <?php else : ?>
    <!-- Do other stuff here -->
    <?php endif; ?>
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
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" style=" text-align: left ;">Shift</label>
                                        <div class="col-sm-8 ">
                                            <select class ="form-control" name="shift" required="required">
                                                <option selected disabled value="">Pilih Shift Kerja</option>
                                                <option value="1">SATU (09.00-17.00)</option>
                                                <option value="2">DUA (13.00-21.00)</option>
                                                <option value="3">TIGA (16.00-21.30)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Username</label>
                                        <div class="col-sm-8 ">
                                            <input type="text" name="username" class="form-control" placeholder="Username" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Password</label>
                                        <div class="col-sm-8 ">
                                            <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-9">
                                            <button type="submit" class="btn btn-outline btn-default">
                                                <span class="fa fa-sign-out" aria-hidden="true"></span> Masuk
                                            </button>
                                        </div>
                                  </div>
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
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Username</label>
                                        <div class="col-sm-8 col-md-offset-1">
                                            <input type="text" name="username" class="form-control" placeholder="Username" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Password</label>
                                        <div class="col-sm-8 ">
                                            <input type="password" name="password" class="form-control" placeholder="password" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-9">
                                            <button type="submit" class="btn btn-outline btn-default">
                                                <span class="fa fa-sign-in" aria-hidden="true"></span> Pulang
                                            </button>
                                        </div>
                                  </div>
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
                                <td align="center"><?php echo $row['shift'];?></td>
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

