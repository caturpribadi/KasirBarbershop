<?php
date_default_timezone_set('Asia/Jakarta');
include 'koneksi.php';
include 'cek.php';
include '../dist/DateToIndo.php';
include '../dist/JmlHari.php';
include '../dist/NamaHari.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
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
</head>
<body>
<?php
    $datejadwal  =$_REQUEST['jadwalinput'];
    $bulan =date('m', strtotime(str_replace(' ','-', $datejadwal)));
    $wulan =date('F', strtotime(str_replace(' ','-', $datejadwal)));
    $tahun =date('Y', strtotime(str_replace(' ','-', $datejadwal)));
    $jum_tgl=jumlah_hari($bulan, $tahun);
?>
        <div class="modal show" id="myModal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog2">
            <form class="form-horizontal" role="form" action="prosesabsen.php" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" onclick="javascript:window.location.href ='presensi';" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Form Jadwal Kerja <?php echo "".(WulanIndo($bulan))." ".$tahun.""; ?></h4>
                    </div>
                    <div class="modal-body">
                    <?php
                    $result = mysql_query("SELECT * FROM jadwal where bulan='$bulan' and tahun='$tahun' order by tgl");
                    $count=mysql_num_rows($result);     //menghitung jumlah baris dari query diatas
                    if (empty($count)) {?>
                    <?php
                    }else{?>
<!-- Tampilan Jadwal -->
                    <div class="row">
                        <div class="col-md-12">
                        <table width="100%" bordercolor="#111111" style="border-style:solid; border-width:1; border-collapse: collapse; padding-left:4; padding-right:4; padding-top:1; padding-bottom:1" >
                                <tr style="border:1px solid #000000;border-collapse:collapse;">
                                    <td colspan="2" style="padding-right:25px; border:1px solid #CCC;border-collapse:collapse;" align="center">
                                        <a href="print/jadwalxls.php?bulan=<?php echo $bulan; ?>&wulan=<?php echo $wulan; ?>&tahun=<?php echo $tahun; ?>" ><i class="fa fa-print" style="font-size:150%;"></i> Print</a>
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
                        </div>
                    </div>
<!-- Tampilan Jadwal End -->
                    <br>
<!-- Tampilan Jumlah Jadwal-->
                    <div class="row">
                        <div class="col-md-4">
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
                                    $jenengawal1 = ucwords($row['nama']);
                                    $jenengawal=str_word_count($jenengawal1, 1);?>
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
                        <br>
                    </div>
<!-- Tampilan jumlah Jadwal End -->
                    <br>
                    <?php
                    }
                    ?>
<!-- Tampilan Input Jadwal-->
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
                                        $result = mysql_query("SELECT * FROM pegawai where aktif='1' and visible='1' ORDER BY nama");
                                        while($row=mysql_fetch_array($result))
                                        {
                                        $no++;
                                        $nama = $row['nama'];
                                        $idpegawai = $row['idpegawai'];
                                        $jenengawal1 = ucwords($row['nama']);
                                        $jenengawal=str_word_count($jenengawal1, 1);
                                        
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
<!-- Tampilan Input Jadwal End -->
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="proses" value="jadwal">
                        <input type="hidden" name="jadwalinput" value="<?php echo $datejadwal;?>">
                        <input type="hidden" name="jum_tgl" value="<?php echo $jum_tgl; ?>">
                        <input type="hidden" name="bulan" value="<?php echo $bulan;?>">
                        <input type="hidden" name="tahun" value="<?php echo $tahun;?>">
                        <button type="button" onclick="javascript:window.location.href ='presensi';" class="col-md-3 col-md-offset-3 btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="col-md-3 col-md-offset-2 btn btn-warning">Simpan Jadwal</button>
                    </div>
                </div> <!-- /.modal-content -->
            </form>
          </div><!-- /.modal-dialog -->
        </div>
</body>
</html>