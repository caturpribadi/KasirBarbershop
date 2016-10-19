<?php
include '../koneksi.php';
$bulan=$_GET['bulan'];
$wulan=$_GET['wulan'];
$tahun=$_GET['tahun'];
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Cashflow_$wulan.xls");
/*$bulan='03';
$wulan='march';
$tahun='2015';*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<center><h1>Laporan Cash Flow <?php echo "$wulan $tahun"; ?></h1></center>
    <table border='1'>
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Pendapatan Harian</th>
                <th>Pendapatan Kotor</th>
                <th>Biaya</th>
                <th>Pendapatan Bersih</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = '0';
                //$sumpendapatan='0';
                $pedapatankotor='';
                $result = mysql_query("SELECT tgl,sum(masuk) as masuk,sum(keluar) as keluar FROM cashflow where month(tgl)='$bulan' and year(tgl)='$tahun' group by tgl");
                while($row =mysql_fetch_array($result)) {
                $no++;
                $tanggal=$row['tgl'];
                $tanggaltampil =date("d-m-Y",strtotime($tanggal));
                $masuk=$row['masuk'];
                $keluar=$row['keluar'];
                //$bersih=$masuk-$keluar;
                //$sumpendapatan += $masuk;
                if (empty($pendapatankotor)) {
                    $pendapatankotor=$masuk;
                    $bersih=$pendapatankotor-$keluar;
                }else{
                    $pendapatankotor =$bersih+$masuk;
                    $bersih=$pendapatankotor-$keluar;
                }
                //$pendapatankotor +=$bersih;


                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $tanggaltampil;?></td>
                    <td align="right"><?php echo number_format($masuk,0,',','.') ?></td>
                    <td align="right"><?php echo number_format($pendapatankotor,0,',','.') ?></td>
                    <td align="right"><?php echo number_format($row['keluar'],0,',','.') ?></td>
                    <td align="right"><?php echo number_format($bersih,0,',','.') ?></td>
                </tr>
                <?php
                }
                mysql_free_result($result);
            ?>
        </tbody>
    </table>

</body>
</html>

<?php
exit()
?>