<?php
include '../koneksi.php';
include '../../dist/DateToIndo.php';
include '../../dist/JmlHari.php';
include '../../dist/NamaHari.php';
$bulan=$_GET['bulan'];
$wulan=$_GET['wulan'];
$tahun=$_GET['tahun'];
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Jadwal_$wulan.xls");

 $jum_tgl=jumlah_hari($bulan, $tahun);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<center><h3>Jadwal Crew <?php echo "$wulan $tahun"; ?></h3></center>

    <table width="100%" bordercolor="#111111" style="border-style:solid; border-width:1; border-collapse: collapse; padding-left:4; padding-right:4; padding-top:1; padding-bottom:1" >
            <tr style="border:1px solid #000000;border-collapse:collapse;">
                <th colspan="2" style="padding-right:25px; border:1px solid #CCC;border-collapse:collapse;" align="center">Crew</th>
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
    <table>
        <tr>
            <td>
                <table border='1'>
                    <thead>
                        <tr>
                            <td colspan='3'>Jumlah Shift</td>
                        </tr>
                        <tr>
                            <td>#</td>
                            <td>Nama</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
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
                                    <td align="center" style="padding-right : 16px; padding-left:5px;"><?php echo $no;?></td>
                                    <td align="left" style="padding-left:5px;"> <?php echo $jenengawal[0]; ?></td>
                                    <td align="center"><?php echo $row['jumlah_shift']; ?></td>
                            </tr>
                            <?php 
                            }
                            mysql_free_result($result);?>
                    </tbody>
                </table>
            </td>
            <td></td>
            <td>
      
            </td>
        </tr>
    </table>
</body>
</html>

<?php
exit()
?>