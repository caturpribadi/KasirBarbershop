<?php
	include 'ceklevel.php';
	include 'koneksi.php';
	include '../dist/DateToIndo.php';
?>
<?php
if(isset($_POST['cari']))
{
    $date  =$_POST['date'];
    $sebelumnya = date("Y-m-1", strtotime("$date -1 month"));
	$selanjutnya = date("Y-m-1", strtotime("$date +1 month"));
    $bulanwingi =date('m', strtotime(str_replace(' ','-', $sebelumnya)));
    $tahunwingi =date('Y', strtotime(str_replace(' ','-', $sebelumnya)));

    $bulan =date('m', strtotime(str_replace(' ','-', $date)));
    $wulan =date('F', strtotime(str_replace(' ','-', $date)));
    $tahun =date('Y', strtotime(str_replace(' ','-', $date)));
 }else{
    unset($_POST['cari']);
    $today=date('Y-m-1');
    $sebelumnya = date("Y-m-1", strtotime("$today -1 month"));
	$selanjutnya = date("Y-m-1", strtotime("$today +1 month"));
    $bulanwingi =date('m', strtotime(str_replace(' ','-', $sebelumnya)));
    $tahunwingi =date('Y', strtotime(str_replace(' ','-', $sebelumnya)));
    $tgl=date('Y-m-d');
	$bulan =date('m', strtotime(str_replace(' ','-', $tgl)));
	$tahun =date('Y', strtotime(str_replace(' ','-', $tgl)));
	$wulan =date('F', strtotime(str_replace(' ','-', $tgl)));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div class="row">
	    <div class="col-lg-12" >
	        <h3 class="page-header">Tabel Budget dan Realisasi <?php echo"".(WulanIndo($bulan))." ".$tahun.""; ?></h3>
	    </div>
	</div>
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
	<div class="row">
	<form name="form1" method="post" action="prosee.php">
		<div class="panel panel-default">	
		<div class="panel-body">
		    <div class="col-md-6">
		        <div class="">

		            <div class="panel-body">
		                <div class="">
		                    <table class="table table-striped table-bordered table-hover" id="fixed_header" style="table-layout: fixed;">
		                        <thead>
		                            <tr>
		                            	<th class="col-sm-1">#</th>
		                                <th class="col-md-7" align="center">Biaya Tetap</th>
		                                <th class="col-md-4">Budget</th>
		                                <th class="col-md-4">Realisasi</th>
		                                <th class="col-md-2">Del</th>
		                            </tr>
		                        </thead>
		                        <tbody>
			                        <?php
			                        $no = '0';
			                        $result = mysql_query("SELECT * FROM biaya where tetap='1' and idbiaya <> 40");
			                        while($row=mysql_fetch_array($result))
			                        {
			                        $no++;
			                        $idbiaya = $row['idbiaya'];
			                        $nama = $row['nama'];
			                        	$resultbudget = mysql_query("SELECT a.iddetail_budget,a.iddetail_budget,sum(a.total) as total FROM detail_budget a inner join budget b on a.budget_idbudget=b.idbudget
											and a.biaya_idbiaya='$idbiaya' and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' group by a.biaya_idbiaya");
											$budget = mysql_fetch_array($resultbudget);
											mysql_free_result($resultbudget);
											$iddetail=$budget['iddetail_budget'];
											$totalbudget=$budget['total'];

			                        	$resultbiaya = mysql_query("SELECT sum(a.total) as total FROM detail_pengeluaran a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran
											and a.biaya_idbiaya='$idbiaya' and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' group by a.biaya_idbiaya");
											$biaya = mysql_fetch_array($resultbiaya);
											mysql_free_result($resultbiaya);
											$totalbiaya=$biaya['total'];				                        			                        	

			                        ?>
			                            <tr>
			                                <td><?php echo $no; ?></td>
			                                <td><?php echo $nama;?></td>
			                                <td align="right"><?php echo number_format($totalbudget,0,',','.');?></td>
			                                <td align="right"><?php echo number_format($totalbiaya,0,',','.');?></td>
			                                <td align="center">
			                                    <A HREF="prosesbudget.php?id=<?php echo $iddetail; ?>&proses=delbudgetsimpan" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")'>
			                                        <i class="fa fa-trash-o"></i>
			                                    </A>
			                                </td>
			                            </tr>
			                        <?php 
			                        }
			                        mysql_free_result($result);
			                        ?>
		                        </tbody>
		                    </table>
		                    <table class="table table-striped table-bordered table-hover" id="fixed_header" style="table-layout: fixed;">
		                        <thead>
		                            <tr>
		                            	<th class="col-sm-1">#</th>
		                                <th class="col-md-7" align="center">Biaya Belanja</th>
		                                <th class="col-md-4">Budget</th>
		                                <th class="col-md-4">Realisasi</th>
		                                <th class="col-md-2">Del</th>
		                            </tr>
		                        </thead>
		                        <tbody>
			                        <?php
			                        $no = '0';
			                        $result = mysql_query("SELECT * FROM biaya where belanja='1'");
			                        while($row=mysql_fetch_array($result))
			                        {
			                        $no++;
			                        $idbiaya = $row['idbiaya'];
			                        $nama = $row['nama'];
			                        	$resultbudget = mysql_query("SELECT a.iddetail_budget,sum(a.total) as total FROM detail_budget a inner join budget b on a.budget_idbudget=b.idbudget
											and a.biaya_idbiaya='$idbiaya' and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' group by a.biaya_idbiaya");
											$budget = mysql_fetch_array($resultbudget);
											mysql_free_result($resultbudget);
											$iddetail=$budget['iddetail_budget'];
											$totalbudget=$budget['total'];

			                        	$resultbiaya = mysql_query("SELECT sum(a.total) as total FROM detail_pengeluaran a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran
											and a.biaya_idbiaya='$idbiaya' and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' group by a.biaya_idbiaya");

											$biaya = mysql_fetch_array($resultbiaya);
											mysql_free_result($resultbiaya);
											$totalbiaya=$biaya['total'];
					                        			                        	

			                        ?>
			                            <tr>
			                                <td><?php echo $no; ?></td>
			                                <td><?php echo $nama;?></td>
			                                <td align="right"><?php echo number_format($totalbudget,0,',','.');?></td>
			                                <td align="right"><?php echo number_format($totalbiaya,0,',','.');?></td>
                                			<td align="center">
			                                    <A HREF="prosesbudget.php?id=<?php echo $iddetail; ?>&proses=delbudgetsimpan" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")'>
			                                        <i class="fa fa-trash-o"></i>
			                                    </A>
			                                </td>

			                            </tr>
			                        <?php 
			                        }
			                        mysql_free_result($result);
			                        ?>
		                        </tbody>
		                    </table>
		                    <table class="table table-striped table-bordered table-hover" id="fixed_header" style="table-layout: fixed;">
		                        <thead>
		                            <tr>
		                            	<th class="col-sm-1">#</th>
		                                <th class="col-md-7">Biaya Lain-Lain</th>
		                                <th class="col-md-4">Budget</th>
		                                <th class="col-md-4">Realisasi</th>
		                                <th class="col-md-2">Del</th>
		                            </tr>
		                        </thead>
		                        <tbody>
			                        <?php
			                        $no = '0';
			                        $result = mysql_query("SELECT * FROM biaya where lain='1'");
			                        while($row=mysql_fetch_array($result))
			                        {
			                        $no++;
			                        $idbiaya = $row['idbiaya'];
			                        $nama = $row['nama'];
			                        	$resultbudget = mysql_query("SELECT a.iddetail_budget,sum(a.total) as total FROM detail_budget a inner join budget b on a.budget_idbudget=b.idbudget
											and a.biaya_idbiaya='$idbiaya' and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' group by a.biaya_idbiaya");
											$budget = mysql_fetch_array($resultbudget);
											mysql_free_result($resultbudget);
											$iddetail=$budget['iddetail_budget'];
											$totalbudget=$budget['total'];

			                        	$resultbiaya = mysql_query("SELECT sum(a.total) as total FROM detail_pengeluaran a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran
											and a.biaya_idbiaya='$idbiaya' and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' group by a.biaya_idbiaya");

											$biaya = mysql_fetch_array($resultbiaya);
											mysql_free_result($resultbiaya);
											$totalbiaya=$biaya['total'];
					                        			                        	

			                        ?>
			                            <tr>
			                                <td><?php echo $no; ?></td>
			                                <td><?php echo $nama;?></td>
			                                <td align="right"><?php echo number_format($totalbudget,0,',','.');?></td>
			                                <td align="right"><?php echo number_format($totalbiaya,0,',','.');?></td>
                                			<td align="center">
			                                    <A HREF="prosesbudget.php?id=<?php echo $iddetail; ?>&proses=delbudgetsimpan" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")'>
			                                        <i class="fa fa-trash-o"></i>
			                                    </A>
			                                </td>

			                            </tr>
			                        <?php 
			                        }
			                        mysql_free_result($result);
			                        ?>
		                        </tbody>
		                    </table>
		            <div class="panel panel-red">
		            <div class="panel-heading">
					  Kalkulasi
		            </div>
		            <div class="panel-body">
		                    <table class="table table-striped table-bordered table-hover" id="fixed_header" style="table-layout: fixed;">
		                        <thead>
		                            <tr>
		                                <th class="col-md-3" align="center">Budget</th>
		                                <th class="col-md-3" align="center">Realisasi</th>
		                            </tr>
		                        </thead>
		                        <tbody>
			                        <?php

			                        	$resultbudget = mysql_query("SELECT a.iddetail_budget,sum(a.total) as total FROM detail_budget a inner join budget b on a.budget_idbudget=b.idbudget and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' ");
											$budget = mysql_fetch_array($resultbudget);
											mysql_free_result($resultbudget);
											$iddetail=$budget['iddetail_budget'];
											$totalbudget=$budget['total'];
			                        	$resultbiaya = mysql_query("SELECT sum(a.total) as total FROM detail_pengeluaran a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and a.biaya_idbiaya <> 40 and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' ");
											$biaya = mysql_fetch_array($resultbiaya);
											mysql_free_result($resultbiaya);
											$totalbiaya=$biaya['total'];
			                        ?>
			                            <tr>
			                                <td align="right"><?php echo number_format($totalbudget,0,',','.');?></td>
			                                <td align="right"><?php echo number_format($totalbiaya,0,',','.');?></td>
			                            </tr>
		                        </tbody>
		                    </table>
		                    <table class="table table-striped table-bordered table-hover" id="fixed_header" style="table-layout: fixed;">
		                        <thead>
		                            <tr>
		                            <th class="col-md-6" align="center">Pendapatan Bln Kemarin</th>
		                                <th class="col-md-6" align="center">Perkiraan Laba Bln Ini</th>
		                            </tr>
		                        </thead>
		                        <tbody>
			                        <?php
			                        	$resultjasa = mysql_query("SELECT sum(b.total) as totaljasa
											FROM transaksi a inner join trxjasa b on a.idtransaksi=b.transaksi_idtransaksi
											inner join paket c on b.paket_idpaket=c.idpaket
											where month(a.tgl)='$bulanwingi' and year(a.tgl)='$tahunwingi'");
											$jasa = mysql_fetch_array($resultjasa);
											mysql_free_result($resultjasa);
											$totaljasa=$jasa['totaljasa'];

			                        	$resultbarang = mysql_query("SELECT sum(b.total) as totalbarang
											FROM transaksi a inner join trxbarang b on a.idtransaksi=b.transaksi_idtransaksi
											inner join barang c on b.barang_idbarang=c.idbarang
											where month(a.tgl)='$bulanwingi' and year(a.tgl)='$tahunwingi'");
											$barang = mysql_fetch_array($resultbarang);
											mysql_free_result($resultbarang);
											$totalbarang=$barang['totalbarang'];
											$totalpendapatan = $totaljasa + $totalbarang;
											$laba = $totalpendapatan - $totalbudget;

			                        ?>
			                            <tr>
			                                <td align="right"><?php echo number_format($totalpendapatan,0,',','.');?></td>
			                                <td align="right"><?php echo number_format($laba,0,',','.');?></td>
			                            </tr>
		                        </tbody>
		                    </table>
		            </div>
		        </div></div>
		            </div>
		        </div> 
		    </div>		
		    <div class="col-md-6">
		        <div class="">
		            <div class="panel-body">
		                <div class="">
		                    <table class="table table-striped table-bordered table-hover" id="fixed_header" style="table-layout: fixed;">
		                        <thead>
		                            <tr>
		                            	<th class="col-sm-1">#</th>
		                                <th class="col-md-7">Biaya Perlengkapan</th>
		                                <th class="col-md-4">Budget</th>
		                                <th class="col-md-4">Realisasi</th>
		                                <th class="col-md-2">Del</th>
		                            </tr>
		                        </thead>
		                        <tbody>
			                        <?php
			                        $no = '0';
			                        $result = mysql_query("SELECT * FROM biaya where perlengkapan='1'");
			                        while($row=mysql_fetch_array($result))
			                        {
			                        $no++;
			                        $idbiaya = $row['idbiaya'];
			                        $nama = $row['nama'];
			                        	$resultbudget = mysql_query("SELECT a.iddetail_budget,sum(a.total) as total FROM detail_budget a inner join budget b on a.budget_idbudget=b.idbudget
											and a.biaya_idbiaya='$idbiaya' and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' group by a.biaya_idbiaya");
											$budget = mysql_fetch_array($resultbudget);
											mysql_free_result($resultbudget);
											$iddetail=$budget['iddetail_budget'];
											$totalbudget=$budget['total'];

			                        	$resultbiaya = mysql_query("SELECT sum(a.total) as total FROM detail_pengeluaran a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran
											and a.biaya_idbiaya='$idbiaya' and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' group by a.biaya_idbiaya");

											$biaya = mysql_fetch_array($resultbiaya);
											mysql_free_result($resultbiaya);
											$totalbiaya=$biaya['total'];
					                        			                        	

			                        ?>
			                            <tr>
			                                <td><?php echo $no; ?></td>
			                                <td><?php echo $nama;?></td>
			                                <td align="right"><?php echo number_format($totalbudget,0,',','.');?></td>
			                                <td align="right"><?php echo number_format($totalbiaya,0,',','.');?></td>
                                			<td align="center">
			                                    <A HREF="prosesbudget.php?id=<?php echo $iddetail; ?>&proses=delbudgetsimpan" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")'>
			                                        <i class="fa fa-trash-o"></i>
			                                    </A>
			                                </td>

			                            </tr>
			                        <?php 
			                        }
			                        mysql_free_result($result);
			                        ?>
		                        </tbody>
		                    </table>
		                </div>
		            </div>
		        </div> 	 
		    </div>

		    <input type="hidden" name="proses" value="backup">
 
		</div>
 		</div>	
	</form>
	</div>
	<div class="row">
		<br>
	</div>

</body>
</html>