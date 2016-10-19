<?php
date_default_timezone_set('Asia/Jakarta');
	include 'cek.php';
	include 'koneksi.php';
	include '../dist/DateToIndo.php';
if (!isset($_SESSION['shift'])) {
$shift='4';
} else {
    $shift = $_SESSION['shift'];
}
	$jeneng = $_SESSION['jenengataz'];
	if ($shift=='1') {
	    $shift_tampil='SATU';
	}elseif ($shift=='2') {
	    $shift_tampil='DUA';
	}elseif ($shift=='3') {
	    $shift_tampil='TIGA';
	}else{
	    $shift_tampil='EMPAT';
	}
?>
<?php
if(isset($_POST['cari']))
{
    $date  =$_POST['date'];
    $sebelumnya = date("Y-m-d", strtotime("$date -1 day"));
	$selanjutnya = date("Y-m-d", strtotime("$date +1 day"));
    $day =date('d', strtotime(str_replace(' ','-', $date)));
    $bulan =date('m', strtotime(str_replace(' ','-', $date)));
    $wulan =date('F', strtotime(str_replace(' ','-', $date)));
    $tahun =date('Y', strtotime(str_replace(' ','-', $date)));
 }else{
    unset($_POST['cari']);
    $date=date('Y-m-d');
    $sebelumnya = date("Y-m-d", strtotime("$date -1 day"));
	$selanjutnya = date("Y-m-d", strtotime("$date +1 day"));
    $tgl=date('Y-m-d');
    $day =date('d', strtotime(str_replace(' ','-', $tgl)));
	$bulan =date('m', strtotime(str_replace(' ','-', $tgl)));
	$tahun =date('Y', strtotime(str_replace(' ','-', $tgl)));
	$wulan =date('F', strtotime(str_replace(' ','-', $tgl)));
}
$today=date('Y-m-d');
$duahari = date("Y-m-d", strtotime("$today -2 day"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>Skac Belajar Line chart</title>
		<script>
			function ngeprint() {
			    window.print();
			}
		</script>
	</head>
	<body>
		<div class="row">
			<div class="col-lg-12">
				<h3 class="page-header">Pendapatan Tanggal  <?php echo"".$day." ".(WulanIndo($bulan))." ".$tahun.""; ?></h3>
			</div>
		</div>
<br>
<!-- Row untuk Nav Sebelum and Sedudah -->
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
<!-- Row untuk Nav Sebelum and Sedudah End-->
<br>
<!-- Row Shift satu / Kasir Pagi -->
		<div class="row">
			<!-- Pendapatan -->
			<div class="col-lg-4">
				<div class="well well-lg">
					<table>
						<tr>
							<td valign="top">
								<table border="0">
									<tr>
										<td colspan="4" align="center">
											<strong> </strong>
										</td>
									</tr>
									<tr>
										<td  colspan="2">Kasir Pagi</td>
										<td colspan="2" align="right" style="padding-right:7px;"><?php echo "".$day." ".$wulan." ". $tahun."";?></td>
									</tr>
									<tr>
										<td colspan="4" align="right" style="padding-right:7px;">
											
										</td>
									</tr>
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<?php
							           	$result=mysql_query("SELECT b.paket_idpaket as ada
													FROM transaksi a inner join trxjasa b on a.idtransaksi=b.transaksi_idtransaksi
													inner join paket c on b.paket_idpaket=c.idpaket
													where day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='1'
													group by b.paket_idpaket");
										$paket = mysql_fetch_array($result);
										mysql_free_result($result);
										$ada=$paket['ada'];
										if (!empty($ada)) { ?>
											<td colspan="3" style="padding-top:10px;">
											Pendapatan Jasa
											</td>
											<td>&nbsp;</td>	
										<?php
											}
										?>										
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT b.paket_idpaket,c.nama,sum(b.qty) as qty,sum(b.total) as total
													FROM transaksi a inner join trxjasa b on a.idtransaksi=b.transaksi_idtransaksi
													inner join paket c on b.paket_idpaket=c.idpaket
													where day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='1'
													group by b.paket_idpaket");
											$totaljasa = '0';
											while($row=mysql_fetch_array($result))
											{
												?>
												<tr>
													<td>&nbsp;</td>
													<td><?php echo $row['nama'];?></td>
													<td><?php echo $row['qty'];?></td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
								        		$totaljasa += $row['total'];
								        	}
									        mysql_free_result($result);
								        ?>
									<tr>
										<?php
							           	$result=mysql_query("SELECT tgl,sum(freepangkas) as freepangkas FROM freepangkas where day(tgl)='$day' and month(tgl)='$bulan' and year(tgl)='$tahun'");
										$freepangkas = mysql_fetch_array($result);
										mysql_free_result($result);
										$jmlfree=$freepangkas['freepangkas'];
										if (!empty($jmlfree)) { ?>
										<td>&nbsp;</td>
										<td>Free Pangkas</td>
										<td><?php echo $jmlfree; ?></td>
										<td align="right" style="padding-right:7px;">0</td>
										<?php
											}
										?>
									</tr>
									<?php
										if ($totaljasa>0) {?>
										<tr valign="top">
											<td colspan="4" style="padding-top:10px;">
												<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
											</td>
										</tr>
										<tr #919191>
											<td>&nbsp;</td>
											<td>
												<strong>Sub Total</strong>
											</td>
											<td>&nbsp;</td>
											<td align="right" style="padding-right:7px;">
												<strong><?php echo number_format($totaljasa,0,',','.') ?></strong>
											</td>
										</tr>
										<?php
										}
									?>
								</table> <!--Pendapatan Jasa end -->
								<table border="0">
									<tr>
										<?php
							           	$result=mysql_query("SELECT b.barang_idbarang as ada
													FROM transaksi a inner join trxbarang b on a.idtransaksi=b.transaksi_idtransaksi
													inner join barang c on b.barang_idbarang=c.idbarang
													where day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='1'
													group by b.barang_idbarang");
										$barang = mysql_fetch_array($result);
										mysql_free_result($result);
										$ada=$barang['ada'];
										if (!empty($ada)) { ?>
											<td colspan="3" style="padding-top:10px;">
											 Pendapatan Barang 
											</td>
											<td>&nbsp;</td>
										<?php
											}
										?>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT b.barang_idbarang,c.nama,sum(b.qty) as qty,sum(b.total) as total
													FROM transaksi a inner join trxbarang b on a.idtransaksi=b.transaksi_idtransaksi
													inner join barang c on b.barang_idbarang=c.idbarang
													where day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='1'
													group by b.barang_idbarang");
											$totalbarang = '0';
											while($row=mysql_fetch_array($result))
											{
												?>
												<tr>
													<td width="15">&nbsp;</td>
													<td width="155"><?php echo $row['nama'];?></td>
													<td width="43"><?php echo $row['qty'];?></td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
									        	$totalbarang += $row['total'];
									        }
									        mysql_free_result($result);
										?>
									<?php
									if ($totalbarang>0) {?>
									<tr valign="top">
										<td colspan="4">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
										</td>
									</tr>
									<tr >
										<td>&nbsp;</td>
										<td><strong>Sub Total</strong></td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;">
											<strong><?php echo number_format($totalbarang,0,',','.') ?></strong>
										</td>
									</tr>
									<?php
									 }
									?>
								</table> <!--Pendapatan Barang end -->
								<table border="0">
									<?php
										$pendapatantotal=$totalbarang+$totaljasa;
									?>
									<tr valign="top">
										<td colspan="4" style="padding-top:20px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr >
										<td><strong>TOTAL PENDAPATAN</strong></td>
										<td align="right" style="padding-right:7px;">
											<strong><?php echo number_format($pendapatantotal,0,',','.') ?></strong>
										</td>
									</tr>
								</table> <!--Total Pendapatan end -->
							</td> <!--Kolom Pendapatan end -->
						</tr>
					</table>
				</div>
			</div>
			<!-- Pendapatan End -->

			<!-- Pengeluaran -->
			<div class="col-lg-4">
				<div class="well well-lg">
					<table>
						<tr>
							<td valign="top">
								<table border="0">
									<tr>
										<td colspan="4" align="center">
											<strong> </strong>
										</td>
									</tr>
									<tr>
										<td  colspan="2">Kasir Pagi</td>
										<td colspan="2" align="right" style="padding-right:7px;"><?php echo "".$day." ".$wulan." ". $tahun."";?></td>
									</tr>
									<tr>
										<td colspan="4" align="right" style="padding-right:7px;">

										</td>
									</tr>
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<?php
							           	$result=mysql_query("SELECT a.tgl as ada
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.tetap is not null
													and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='1'
													group by c.nama");
										$paket = mysql_fetch_array($result);
										mysql_free_result($result);
										$ada=$paket['ada'];
										if (!empty($ada)) { ?>
											<td colspan="3">
												Biaya Tetap
											</td>
											<td>&nbsp;</td>
										<?php
											}
										?>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT a.tgl,c.nama,sum(b.total) as total
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.tetap is not null
													and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='1'
													group by c.nama");
											$totaltetap = '0';
											while($row=mysql_fetch_array($result))
											{
												?>	
												<tr>
													<td>&nbsp;</td>
													<td><?php echo $row['nama'];?></td>
													<td>&nbsp;</td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
									        	$totaltetap += $row['total'];
									        }
									        mysql_free_result($result);
										?>
									<?php
										if ($totaltetap>0) {?>
										<tr valign="top">
											<td colspan="4">
												<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td><strong>Sub Total</strong></td>
											<td>&nbsp;</td>
											<td align="right" style="padding-right:7px;"><strong><?php echo number_format($totaltetap,0,',','.') ?></strong>
											</td>
										</tr>
										<?php
										}
									?>
								</table> <!--Biaya Tetap End -->
								<table border="0">
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<?php
							           	$result=mysql_query("SELECT a.tgl as ada
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.perlengkapan is not null
													and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='1'
													group by c.nama");
										$paket = mysql_fetch_array($result);
										mysql_free_result($result);
										$ada=$paket['ada'];
										if (!empty($ada)) { ?>
											<td colspan="3">
												Biaya Perlengkapan
											</td>
											<td>&nbsp;</td>
										<?php
											}
										?>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT a.tgl,c.nama,sum(b.total) as total
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.perlengkapan is not null
													and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='1'
													group by c.nama");
											$totalperlengkapan = '0';
											while($row=mysql_fetch_array($result))
											{
												?>
												<tr>
													<td width="15">&nbsp;</td>
													<td><?php echo $row['nama'];?></td>
													<td>&nbsp;</td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
									        	$totalperlengkapan += $row['total'];
									        }
									        mysql_free_result($result);
										?>
									<?php
										if ($totalperlengkapan>0) {?>
											<tr valign="top">
												<td colspan="4">
													<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td><strong>Sub Total</strong></td>
												<td>&nbsp;</td>
												<td align="right" style="padding-right:7px;"><strong><?php echo number_format($totalperlengkapan,0,',','.') ?></strong></td>
											</tr>
											<?php
										}
									?>
								</table><!--Biaya Perlengkapan End -->
								<table border="0">
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<?php
							           	$result=mysql_query("SELECT a.tgl as ada
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.belanja is not null
													and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='1'
													group by c.nama");
										$paket = mysql_fetch_array($result);
										mysql_free_result($result);
										$ada=$paket['ada'];
										if (!empty($ada)) { ?>
											<td colspan="3">
												Biaya Belanja
											</td>
											<td>&nbsp;</td>
										<?php
											}
										?>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT a.tgl,c.nama,sum(b.total) as total
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.belanja is not null
													and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='1'
													group by c.nama");
											$totalbelanja = '0';
											while($row=mysql_fetch_array($result))
											{
												?>
												<tr>
													<td width="15">&nbsp;</td>
													<td><?php echo $row['nama'];?></td>
													<td>&nbsp;</td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
									        	$totalbelanja += $row['total'];
									        }
									        mysql_free_result($result);
										?>
									<?php
										if ($totalbelanja>0) {?>
											<tr valign="top">
												<td colspan="4">
													<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td><strong>Sub Total</strong></td>
												<td>&nbsp;</td>
												<td align="right" style="padding-right:7px;"><strong><?php echo number_format($totalbelanja,0,',','.') ?></strong></td>
											</tr>
											<?php
										}
									?>
								</table><!--Biaya Belanja End -->
								<table border="0">
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<?php
							           	$result=mysql_query("SELECT b.keterangan as ada
															FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran and b.biaya_idbiaya='16' and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='1'");
										$paket = mysql_fetch_array($result);
										mysql_free_result($result);
										$ada=$paket['ada'];
										if (!empty($ada)) { ?>
											<td colspan="3">
												Biaya Lain-Lain
											</td>
											<td>&nbsp;</td>
										<?php
											}
										?>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT b.keterangan,b.total FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran and b.biaya_idbiaya='16' and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='1'");
											$totallain = '0';
											while($row=mysql_fetch_array($result))
											{
												?>
												<tr>
													<td width="15">&nbsp;</td>
													<td><?php echo $row['keterangan'];?></td>
													<td>&nbsp;</td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
									        	$totallain += $row['total'];
									        }
									        mysql_free_result($result);
										?>
									<?php
										if ($totallain>0) {?>
											<tr valign="top">
												<td colspan="4">
													<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td><strong>Sub Total</strong></td>
												<td>&nbsp;</td>
												<td align="right" style="padding-right:7px;"><strong><?php echo number_format($totallain,0,',','.') ?></strong></td>
											</tr>
											<?php
										}
									?>
								</table><!--Biaya Lain End -->
								<table border="0">
									<?php
							    		$pengeluarantotal=$totaltetap+$totalperlengkapan+$totalbelanja+$totallain;
							    	?>
									<tr valign="top">
										<td colspan="4" style="padding-top:20px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<td><strong>TOTAL PENGELUARAN</strong></td>
										<td align="right" style="padding-right:7px;"><strong><?php echo number_format($pengeluarantotal,0,',','.') ?></strong></td>
									</tr>
								</table> <!--Total Pengeluaran end -->
							</td> <!--Kolom Pengeluaran end -->
						</tr>
					</table>
				</div>
			</div>
			<!-- pengeluaran End -->

			<!-- Total Pendapatan -->
			<div class="col-lg-4">
				<div class="well well-lg">
					<table>
						<tr>
							<td valign="top">
								<table border="0">
									<tr>
										<td colspan="4" align="center">
											<strong> </strong>
										</td>
									</tr>
									<tr>
										<td  colspan="2">Kasir Pagi</td>
										<td colspan="2" align="right" style="padding-right:7px;"><?php echo "".$day." ".$wulan." ". $tahun."";?></td>
									</tr>
									<tr>
										<td colspan="4" align="right" style="padding-right:7px;">
											
										</td>
									</tr>
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<strong>Pendapatan</strong>
										</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Jasa</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><?php echo number_format($totaljasa,0,',','.') ?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Barang</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><?php echo number_format($totalbarang,0,',','.') ?></td>
									</tr>
									<tr valign="top">
										<td colspan="4">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Sub Total</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><strong><?php echo number_format($pendapatantotal,0,',','.') ?></strong></td>
									</tr>
								</table> <!--Tabel Pendapatan total end -->
								<table border="0">
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<strong>Pengeluaran</strong>
										</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Biaya Tetap</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><?php echo number_format($totaltetap,0,',','.') ?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Biaya Perlengkapan</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><?php echo number_format($totalperlengkapan,0,',','.') ?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Biaya Belanja</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><?php echo number_format($totalbelanja,0,',','.') ?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Lain-Lain</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><?php echo number_format($totallain,0,',','.') ?></td>
									</tr>
									<tr valign="top">
										<td colspan="4">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Sub Total</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><strong><?php echo number_format($pengeluarantotal,0,',','.') ?></strong></td>
									</tr>
								</table> <!--Tabel Pengeluaran total end -->
								<table border="0">
									<?php 
										$rugilaba=$pendapatantotal-$pengeluarantotal
									?>
									<tr valign="top">
										<td colspan="4" style="padding-top:20px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr  style="background:#000000; color:#FFFFFF;">
										<td>
											<strong>Total Kasir Pagi</strong>
										</td>
										<td align="right" style="padding-right:7px;">
											<strong><?php echo number_format($rugilaba,0,',','.') ?></strong>
										</td>
									</tr>
								</table> <!--Rugi laba end -->
							</td><!--Kolom Rugi Laba end -->
						</tr>
					</table>
				</div>
			</div>
			<!-- Total Pendapatan End -->
		</div>
<!-- Row Shift satu / Kasir Pagi End-->
<br>
<!-- Row Shift dua / Kasir Sore -->
		<div class="row">
			<!-- Pendapatan -->
			<div class="col-lg-4">
				<div class="well well-lg">
					<table>
						<tr>
							<td valign="top">
								<table border="0">
									<tr>
										<td colspan="4" align="center">
											<strong> </strong>
										</td>
									</tr>
									<tr>
										<td  colspan="2">Kasir Sore</td>
										<td colspan="2" align="right" style="padding-right:7px;"><?php echo "".$day." ".$wulan." ". $tahun."";?></td>
									</tr>
									<tr>
										<td colspan="4" align="right" style="padding-right:7px;">
											
										</td>
									</tr>
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<?php
							           	$result=mysql_query("SELECT b.paket_idpaket as ada
													FROM transaksi a inner join trxjasa b on a.idtransaksi=b.transaksi_idtransaksi
													inner join paket c on b.paket_idpaket=c.idpaket
													where day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='3'
													group by b.paket_idpaket");
										$paket = mysql_fetch_array($result);
										mysql_free_result($result);
										$ada=$paket['ada'];
										if (!empty($ada)) { ?>
											<td colspan="3" style="padding-top:10px;">
											Pendapatan Jasa
											</td>
											<td>&nbsp;</td>	
										<?php
											}
										?>										
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT b.paket_idpaket,c.nama,sum(b.qty) as qty,sum(b.total) as total
													FROM transaksi a inner join trxjasa b on a.idtransaksi=b.transaksi_idtransaksi
													inner join paket c on b.paket_idpaket=c.idpaket
													where day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='3'
													group by b.paket_idpaket");
											$totaljasa = '0';
											while($row=mysql_fetch_array($result))
											{
												?>
												<tr>
													<td>&nbsp;</td>
													<td><?php echo $row['nama'];?></td>
													<td><?php echo $row['qty'];?></td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
								        		$totaljasa += $row['total'];
								        	}
									        mysql_free_result($result);
								        ?>
									<tr>
										<?php
							           	$result=mysql_query("SELECT tgl,sum(freepangkas) as freepangkas FROM freepangkas where day(tgl)='$day' and month(tgl)='$bulan' and year(tgl)='$tahun'");
										$freepangkas = mysql_fetch_array($result);
										mysql_free_result($result);
										$jmlfree=$freepangkas['freepangkas'];
										if (!empty($jmlfree)) { ?>
										<td>&nbsp;</td>
										<td>Free Pangkas</td>
										<td><?php echo $jmlfree; ?></td>
										<td align="right" style="padding-right:7px;">0</td>
										<?php
											}
										?>
									</tr>
									<?php
										if ($totaljasa>0) {?>
										<tr valign="top">
											<td colspan="4" style="padding-top:10px;">
												<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
											</td>
										</tr>
										<tr #919191>
											<td>&nbsp;</td>
											<td>
												<strong>Sub Total</strong>
											</td>
											<td>&nbsp;</td>
											<td align="right" style="padding-right:7px;">
												<strong><?php echo number_format($totaljasa,0,',','.') ?></strong>
											</td>
										</tr>
										<?php
										}
									?>
								</table> <!--Pendapatan Jasa end -->
								<table border="0">
									<tr>
										<?php
							           	$result=mysql_query("SELECT b.barang_idbarang as ada
													FROM transaksi a inner join trxbarang b on a.idtransaksi=b.transaksi_idtransaksi
													inner join barang c on b.barang_idbarang=c.idbarang
													where day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='3'
													group by b.barang_idbarang");
										$barang = mysql_fetch_array($result);
										mysql_free_result($result);
										$ada=$barang['ada'];
										if (!empty($ada)) { ?>
											<td colspan="3" style="padding-top:10px;">
											 Pendapatan Barang 
											</td>
											<td>&nbsp;</td>
										<?php
											}
										?>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT b.barang_idbarang,c.nama,sum(b.qty) as qty,sum(b.total) as total
													FROM transaksi a inner join trxbarang b on a.idtransaksi=b.transaksi_idtransaksi
													inner join barang c on b.barang_idbarang=c.idbarang
													where day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='3'
													group by b.barang_idbarang");
											$totalbarang = '0';
											while($row=mysql_fetch_array($result))
											{
												?>
												<tr>
													<td width="15">&nbsp;</td>
													<td width="155"><?php echo $row['nama'];?></td>
													<td width="43"><?php echo $row['qty'];?></td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
									        	$totalbarang += $row['total'];
									        }
									        mysql_free_result($result);
										?>
									<?php
									if ($totalbarang>0) {?>
									<tr valign="top">
										<td colspan="4">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
										</td>
									</tr>
									<tr >
										<td>&nbsp;</td>
										<td><strong>Sub Total</strong></td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;">
											<strong><?php echo number_format($totalbarang,0,',','.') ?></strong>
										</td>
									</tr>
									<?php
									 }
									?>
								</table> <!--Pendapatan Barang end -->
								<table border="0">
									<?php
										$pendapatantotal=$totalbarang+$totaljasa;
									?>
									<tr valign="top">
										<td colspan="4" style="padding-top:20px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr >
										<td><strong>TOTAL PENDAPATAN</strong></td>
										<td align="right" style="padding-right:7px;">
											<strong><?php echo number_format($pendapatantotal,0,',','.') ?></strong>
										</td>
									</tr>
								</table> <!--Total Pendapatan end -->
							</td> <!--Kolom Pendapatan end -->
						</tr>
					</table>
				</div>
			</div>
			<!-- Pendapatan End-->

			<!-- Pengeluaran -->
			<div class="col-lg-4">
				<div class="well well-lg">
					<table>
						<tr>
							<td valign="top">
								<table border="0">
									<tr>
										<td colspan="4" align="center">
											<strong> </strong>
										</td>
									</tr>
									<tr>
										<td  colspan="2">Kasir Sore</td>
										<td colspan="2" align="right" style="padding-right:7px;"><?php echo "".$day." ".$wulan." ". $tahun."";?></td>
									</tr>
									<tr>
										<td colspan="4" align="right" style="padding-right:7px;">

										</td>
									</tr>
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<?php
							           	$result=mysql_query("SELECT a.tgl as ada
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.tetap is not null
													and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='3'
													group by c.nama");
										$paket = mysql_fetch_array($result);
										mysql_free_result($result);
										$ada=$paket['ada'];
										if (!empty($ada)) { ?>
											<td colspan="3">
												Biaya Tetap
											</td>
											<td>&nbsp;</td>
										<?php
											}
										?>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT a.tgl,c.nama,sum(b.total) as total
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.tetap is not null
													and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='3'
													group by c.nama");
											$totaltetap = '0';
											while($row=mysql_fetch_array($result))
											{
												?>	
												<tr>
													<td>&nbsp;</td>
													<td><?php echo $row['nama'];?></td>
													<td>&nbsp;</td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
									        	$totaltetap += $row['total'];
									        }
									        mysql_free_result($result);
										?>
									<?php
										if ($totaltetap>0) {?>
										<tr valign="top">
											<td colspan="4">
												<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td><strong>Sub Total</strong></td>
											<td>&nbsp;</td>
											<td align="right" style="padding-right:7px;"><strong><?php echo number_format($totaltetap,0,',','.') ?></strong>
											</td>
										</tr>
										<?php
										}
									?>
								</table> <!--Biaya Tetap End -->
								<table border="0">
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<?php
							           	$result=mysql_query("SELECT a.tgl as ada
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.perlengkapan is not null
													and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='3'
													group by c.nama");
										$paket = mysql_fetch_array($result);
										mysql_free_result($result);
										$ada=$paket['ada'];
										if (!empty($ada)) { ?>
											<td colspan="3">
												Biaya Perlengkapan
											</td>
											<td>&nbsp;</td>
										<?php
											}
										?>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT a.tgl,c.nama,sum(b.total) as total
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.perlengkapan is not null
													and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='3'
													group by c.nama");
											$totalperlengkapan = '0';
											while($row=mysql_fetch_array($result))
											{
												?>
												<tr>
													<td width="15">&nbsp;</td>
													<td><?php echo $row['nama'];?></td>
													<td>&nbsp;</td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
									        	$totalperlengkapan += $row['total'];
									        }
									        mysql_free_result($result);
										?>
									<?php
										if ($totalperlengkapan>0) {?>
											<tr valign="top">
												<td colspan="4">
													<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td><strong>Sub Total</strong></td>
												<td>&nbsp;</td>
												<td align="right" style="padding-right:7px;"><strong><?php echo number_format($totalperlengkapan,0,',','.') ?></strong></td>
											</tr>
											<?php
										}
									?>
								</table><!--Biaya Perlengkapan End -->
								<table border="0">
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<?php
							           	$result=mysql_query("SELECT a.tgl as ada
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.belanja is not null
													and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='3'
													group by c.nama");
										$paket = mysql_fetch_array($result);
										mysql_free_result($result);
										$ada=$paket['ada'];
										if (!empty($ada)) { ?>
											<td colspan="3">
												Biaya Belanja
											</td>
											<td>&nbsp;</td>
										<?php
											}
										?>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT a.tgl,c.nama,sum(b.total) as total
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.belanja is not null
													and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='3'
													group by c.nama");
											$totalbelanja = '0';
											while($row=mysql_fetch_array($result))
											{
												?>
												<tr>
													<td width="15">&nbsp;</td>
													<td><?php echo $row['nama'];?></td>
													<td>&nbsp;</td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
									        	$totalbelanja += $row['total'];
									        }
									        mysql_free_result($result);
										?>
									<?php
										if ($totalbelanja>0) {?>
											<tr valign="top">
												<td colspan="4">
													<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td><strong>Sub Total</strong></td>
												<td>&nbsp;</td>
												<td align="right" style="padding-right:7px;"><strong><?php echo number_format($totalbelanja,0,',','.') ?></strong></td>
											</tr>
											<?php
										}
									?>
								</table><!--Biaya Belanja End -->
								<table border="0">
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<?php
							           	$result=mysql_query("SELECT b.keterangan as ada
															FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran and b.biaya_idbiaya='16' and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='3'");
										$paket = mysql_fetch_array($result);
										mysql_free_result($result);
										$ada=$paket['ada'];
										if (!empty($ada)) { ?>
											<td colspan="3">
												Biaya Lain-Lain
											</td>
											<td>&nbsp;</td>
										<?php
											}
										?>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT b.keterangan,b.total FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran and b.biaya_idbiaya='16' and day(a.tgl)='$day' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun' and a.shift='3'");
											$totallain = '0';
											while($row=mysql_fetch_array($result))
											{
												?>
												<tr>
													<td width="15">&nbsp;</td>
													<td><?php echo $row['keterangan'];?></td>
													<td>&nbsp;</td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
									        	$totallain += $row['total'];
									        }
									        mysql_free_result($result);
										?>
									<?php
										if ($totallain>0) {?>
											<tr valign="top">
												<td colspan="4">
													<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td><strong>Sub Total</strong></td>
												<td>&nbsp;</td>
												<td align="right" style="padding-right:7px;"><strong><?php echo number_format($totallain,0,',','.') ?></strong></td>
											</tr>
											<?php
										}
									?>
								</table><!--Biaya Lain End -->
								<table border="0">
									<?php
							    		$pengeluarantotal=$totaltetap+$totalperlengkapan+$totalbelanja+$totallain;
							    	?>
									<tr valign="top">
										<td colspan="4" style="padding-top:20px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<td><strong>TOTAL PENGELUARAN</strong></td>
										<td align="right" style="padding-right:7px;"><strong><?php echo number_format($pengeluarantotal,0,',','.') ?></strong></td>
									</tr>
								</table> <!--Total Pengeluaran end -->
							</td> <!--Kolom Pengeluaran end -->
						</tr>
					</table>
				</div>
			</div>
			<!-- Pengeluaran End-->
			
			<!-- Total Pendapatan -->
			<div class="col-lg-4">
				<div class="well well-lg">
					<table>
						<tr>
							<td valign="top">
								<table border="0">
									<tr>
										<td colspan="4" align="center">
											<strong> </strong>
										</td>
									</tr>
									<tr>
										<td  colspan="2">Kasir Sore</td>
										<td colspan="2" align="right" style="padding-right:7px;"><?php echo "".$day." ".$wulan." ". $tahun."";?></td>
									</tr>
									<tr>
										<td colspan="4" align="right" style="padding-right:7px;">
											
										</td>
									</tr>
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<strong>Pendapatan</strong>
										</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Jasa</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><?php echo number_format($totaljasa,0,',','.') ?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Barang</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><?php echo number_format($totalbarang,0,',','.') ?></td>
									</tr>
									<tr valign="top">
										<td colspan="4">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Sub Total</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><strong><?php echo number_format($pendapatantotal,0,',','.') ?></strong></td>
									</tr>
								</table> <!--Tabel Pendapatan total end -->
								<table border="0">
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<strong>Pengeluaran</strong>
										</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Biaya Tetap</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><?php echo number_format($totaltetap,0,',','.') ?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Biaya Perlengkapan</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><?php echo number_format($totalperlengkapan,0,',','.') ?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Biaya Belanja</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><?php echo number_format($totalbelanja,0,',','.') ?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Lain-Lain</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><?php echo number_format($totallain,0,',','.') ?></td>
									</tr>
									<tr valign="top">
										<td colspan="4">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>Sub Total</td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><strong><?php echo number_format($pengeluarantotal,0,',','.') ?></strong></td>
									</tr>
								</table> <!--Tabel Pengeluaran total end -->
								<table border="0">
									<?php 
										$rugilaba=$pendapatantotal-$pengeluarantotal
									?>
									<tr valign="top">
										<td colspan="4" style="padding-top:20px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr style="background:#000000; color:#FFFFFF;">
										<td>
											<strong>Total Kasir Sore</strong>
										</td>
										<td align="right" style="padding-right:7px;">
											<strong><?php echo number_format($rugilaba,0,',','.') ?></strong>
										</td>
									</tr>
								</table> <!--Rugi laba end -->
							</td><!--Kolom Rugi Laba end -->
						</tr>
					</table>
				</div>
			</div>
			<!-- Total Pendapatan End -->
		</div>
<!-- Row Shift dua / Kasir Sore  End-->
	</body>
</html>