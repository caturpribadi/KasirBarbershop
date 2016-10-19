<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>

<?php
include  "koneksi.php";
include 'ceklevel.php';
include '../dist/DayToIndo.php';
?>

<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Tabel Cash Flow</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12"> 
        <div class="col-xs-8">
            <form class="form-horizontal" role="form" action="cashflow" method="post">
                <div class="form-group">
                    <div class="col-xs-5">
                        <input type="text" name="date" class="form-control input-sm" id="tgllaporan" placeholder="Bulan" required="required">
                    </div>
                    <div class="col-xs-">
                        <button type="submit" class="btn btn-outline btn-default" name="cari" id="cari" onClick="">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                        </button>
                    </div>
                </div>
            </form>
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
    <div class="col-lg-2 col-sm-offset-10">
        <a href="print/cashflowxls.php?bulan=<?php echo $bulan; ?>&wulan=<?php echo $wulan; ?>&tahun=<?php echo $tahun; ?>" class="btn btn-outline btn-default"><i class="fa fa-print" style="font-size:150%;"></i> Save Excel</a>
    </div>
</div>
<br>    
    <div class="row">
        <div class="col-lg-10" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    Table Cash Flow <?php echo "bulan ".$wulan." ".$tahun."" ;?>
                </div> <!--panel-heading end -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="">
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
                                    //$tanggaltampil =date("d-m-Y",strtotime($tanggal));
                                    $tanggaltampil = (getday($tanggal,'-'));
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