<?php
include '../koneksi.php';
$bulan=$_GET['bulan'];
$wulan=$_GET['wulan'];
$tahun=$_GET['tahun'];
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Biaya_$wulan.xls");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
		<center><h3>Laporan Biaya Bulan <?php echo "$wulan $tahun"; ?></h3></center>

        <table border='1'>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = '0';
                    $result = mysql_query("SELECT b.iddetail_pengeluaran,a.tgl,b.keterangan as ket,b.jenis,b.total,c.nama FROM pengeluaran a inner join detail_pengeluaran b 
                        on a.idpengeluaran=b.pengeluaran_idpengeluaran inner join biaya c on b.biaya_idbiaya=c.idbiaya where month(tgl)='$bulan' and year(tgl)='$tahun' order by tgl");
                    $totalbiaya = '0';
                    while($row=mysql_fetch_array($result))
                    {
                        $tanggal=$row['tgl'];
                        $tanggaltampil =date("d-m-Y",strtotime($tanggal));
                    $no++
                    ?>
                    <tr>
                        <td><?php echo $tanggaltampil;?></td>
                        <td><?php echo $row['jenis'] ?></td>
                        <td><?php echo $row['nama'] ?></td>
                        <td ><?php echo $row['ket'] ?></td>
                        <td align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
                    </tr>
                    <?php 
                    $totalbiaya += $row['total'];
                    }
                    mysql_free_result($result);
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" style="text-align:center">Total</th>
                    <th><?php echo number_format($totalbiaya,0,',','.') ?></th>
                </tr>
            </tfoot>
        </table>
</body>
</html>

<?php
exit()
?>