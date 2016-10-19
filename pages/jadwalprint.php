<?php
date_default_timezone_set('Asia/Jakarta');
include 'koneksi.php';
include 'cek.php';
include '../dist/DateToIndo.php';
include '../dist/JmlHari.php';
include '../dist/NamaHari.php';

if(isset($_POST['cari']))
{
    $date  =$_POST['date'];
    $sebelumnya = date("Y-m-1", strtotime("$date -1 month"));
    $selanjutnya = date("Y-m-1", strtotime("$date +1 month"));
    $bulan =date('m', strtotime(str_replace(' ','-', $date)));
    $wulan =date('F', strtotime(str_replace(' ','-', $date)));
    $tahun =date('Y', strtotime(str_replace(' ','-', $date)));
     $jum_tgl=jumlah_hari($bulan, $tahun);
 }else{
    unset($_POST['cari']);
    $today=date('Y-m-1');
    $sebelumnya = date("Y-m-1", strtotime("$today -1 month"));
    $selanjutnya = date("Y-m-1", strtotime("$today +1 month"));
    $tgl=date('Y-m-d');
    $bulan =date('m', strtotime(str_replace(' ','-', $tgl)));
    $tahun =date('Y', strtotime(str_replace(' ','-', $tgl)));
    $wulan =date('F', strtotime(str_replace(' ','-', $tgl)));
     $jum_tgl=jumlah_hari($bulan, $tahun);
}
?>
<html>

<head>
<meta http-equiv="Content-Language" content="id">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Print Jadwal</title>

<script>
    function ngeprint() {
            window.print();
    }
</script>
</head>

<body onload="ngeprint()">
<h3>Jadwal Kerja Bulan <?php echo "".(WulanIndo($bulan))." ".$tahun.""; ?></h3>
<br>
<br>
        <div class="row">
            <div class="col-md-12"> 
                <div class="col-sm-8">
                    <form role="form" action="" method="post" class="navbar-form pull-left">
                        <input type="hidden" name="date" value="<?php echo $sebelumnya; ?>">
                        <button type="submit" class="btn btn-outline btn-default" name="cari" id="cari">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Sebelumnya
                        </button>
                    </form>
                </div>
                <div class="col-xs-2 col-sm-offset-2">
                    <form role="form" action="" method="post" class="navbar-form pull-left">
                        <input type="hidden" name="date" value="<?php echo $selanjutnya; ?>">
                        <button type="submit" class="btn btn-outline btn-default" name="cari" id="cari">
                            Selanjutnya <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
<br>
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

                            $shift1=mysql_query("SELECT * FROM jadwal where nama='$nama' and day(tgl)='$x' and bulan='$bulan' and tahun='$tahun' and shift='1'");
                            $data=mysql_fetch_array($shift1);
                            if(!empty($data))
                            {
                                ?><td style="text-align:left;"><img src="../dist/gambar/biru.png" /></td><?php
                            }else{
                                echo "<td></td>";
                            }

                            $shift2=mysql_query("SELECT * FROM jadwal where nama='$nama' and day(tgl)='$x' and bulan='$bulan' and tahun='$tahun' and shift='2'");
                            $data=mysql_fetch_array($shift2);
                            if(!empty($data))
                            {
                                ?><td style="text-align:left;" ><img src="../dist/gambar/abu.png" /></td><?php
                            }else{
                                echo "<td></td>";
                            }

                            $shift3=mysql_query("SELECT * FROM jadwal where nama='$nama' and day(tgl)='$x' and bulan='$bulan' and tahun='$tahun' and shift='3'");
                            $data=mysql_fetch_array($shift3);
                            if(!empty($data))
                            {
                                ?><td style="text-align:left;" ><img src="../dist/gambar/merah.png" /></td><?php
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
</body>

</html>
