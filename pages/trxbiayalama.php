<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Skac Belajar Line chart</title>
<script>
    function ngeprint() {
        window.print();
    }
</script>
</head>
<body>

<?php
include  "koneksi.php";
include 'ceklevel.php';
?>

<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Tabel Biaya Bulanan</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12"> 
        <div class="col-xs-8">
            <form class="form-horizontal" role="form" action="trxbiaya" method="post">
                <div class="form-group">
                    <div class="col-xs-5">
                        <input type="text" name="date" class="form-control input-sm" id="tgllaporan" placeholder="Bulan" required="required">
                    </div>
                    <div class="col-xs-3">
                        <input name="cari" type="submit" value="Cari" />
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xs-2 col-sm-offset-2">
            <button type="button" class="btn btn-outline btn-default" name="tambah" id="tambah" onClick="ngeprint()">
                <span class="fa fa-print" aria-hidden="true"></span> Print
            </button>
        </div>
    </div>
</div>

<?php
if(isset($_POST['cari']))
{
$date  =$_POST['date'];
$bulan =date('m', strtotime(str_replace(' ','-', $date)));
$wulan =date('F', strtotime(str_replace(' ','-', $date)));
$tahun =date('Y', strtotime(str_replace(' ','-', $date)));
?>       

    <div class="row">
        <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    Laporan Biaya <?php echo "Bulan ".$wulan." ".$tahun."" ;?>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="member">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th>Total</th>
                                    <?php
                                        if (($_SESSION['levelataz']) == "owner ataz") { ?>
                                        <th>Panel</th>
                                        <?php
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = '0';
                                    $result = mysql_query("SELECT b.iddetail_pengeluaran,a.tgl,b.keterangan as ket,b.jenis,b.total,c.nama FROM pengeluaran a inner join detail_pengeluaran b 
                                        on a.idpengeluaran=b.pengeluaran_idpengeluaran inner join biaya c on b.biaya_idbiaya=c.idbiaya where month(tgl)='$bulan' and year(tgl)='$tahun' order by tgl");
                                    while($row=mysql_fetch_array($result))
                                    {
                                        $tanggal=$row['tgl'];
                                        $tanggaltampil =date("d-m-Y",strtotime($tanggal));
                                    $no++
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $tanggaltampil;?></td>
                                        <td><?php echo $row['jenis'] ?></td>
                                        <td><?php echo $row['nama'] ?></td>
                                        <td ><?php echo $row['ket'] ?></td>
                                        <td align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
                                        <?php
                                            if (($_SESSION['levelataz']) == "owner ataz") { ?>
                                            <td align="center">
                                                <A HREF="prosesbiaya.php?iddetail=<?php echo $row['iddetail_pengeluaran'] ?>&proses=delpengeluaran" onclick='return confirm("Hapus <?php echo $row['nota']?> ?")'>
                                                    <i class="fa fa-trash-o"></i>
                                                </A>
                                            </td>
                                            <?php
                                            }
                                        ?>
                                    </tr>
                                    <?php 
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tbody>
                        </table>
                    </div><!-- Table end -->
                </div>
            </div><!-- /.panel end -->
        </div>
    </div>
<?php
}else{
    unset($_POST['cari']);
}
?>
</body>
</html>

