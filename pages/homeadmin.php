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
    $bulan =date('m', strtotime(str_replace(' ','-', $date)));
    $wulan =date('F', strtotime(str_replace(' ','-', $date)));
    $tahun =date('Y', strtotime(str_replace(' ','-', $date)));
 }else{
    unset($_POST['cari']);
    $today=date('Y-m-1');
    $sebelumnya = date("Y-m-1", strtotime("$today -1 month"));
	$selanjutnya = date("Y-m-1", strtotime("$today +1 month"));
    $tgl=date('Y-m-d');
	$bulan =date('m', strtotime(str_replace(' ','-', $tgl)));
	$tahun =date('Y', strtotime(str_replace(' ','-', $tgl)));
	$wulan =date('F', strtotime(str_replace(' ','-', $tgl)));
}
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
				<h3 class="page-header">Data Bulan <?php echo"".(WulanIndo($bulan))." ".$tahun.""; ?></h3>
			</div>
		</div>
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
		<div class="row">
			<div class="col-lg-4">
				<div class="well well-lg">
					<table>
						<tr>
							<td valign="top">
								<table border="0">
									<tr>
										<td colspan="4" align="center">
											<strong>LAPORAN PENDAPATAN</strong>
										</td>
									</tr>
									<tr>
										<td colspan="4" align="center">
											<strong>Ataz Barbershop</strong>
										</td>
									</tr>
									<tr>
										<td colspan="4" align="center">
											<strong><?php echo "".$wulan." ". $tahun."";?></strong>
										</td>
									</tr>
									<tr>
										<td colspan="3" style="padding-top:10px;">
											<strong>Pendapatan Jasa</strong>
										</td>
										<td>&nbsp;</td>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT b.paket_idpaket,c.nama,sum(b.qty) as qty,sum(b.total) as total
													FROM transaksi a inner join trxjasa b on a.idtransaksi=b.transaksi_idtransaksi
													inner join paket c on b.paket_idpaket=c.idpaket
													where month(a.tgl)='$bulan' and year(a.tgl)='$tahun'
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
							           	$result=mysql_query("SELECT tgl,sum(freepangkas) as freepangkas FROM freepangkas where month(tgl)='$bulan' and year(tgl)='$tahun'");
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
								</table> <!--Pendapatan Jasa end -->
								<table border="0">

									<tr>
										<td colspan="3" style="padding-top:10px;">
											<strong>Pendapatan Barang</strong>
										</td>
										<td>&nbsp;</td>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT b.barang_idbarang,c.nama,sum(b.qty) as qty,sum(b.total) as total
													FROM transaksi a inner join trxbarang b on a.idtransaksi=b.transaksi_idtransaksi
													inner join barang c on b.barang_idbarang=c.idbarang
													where month(a.tgl)='$bulan' and year(a.tgl)='$tahun'
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
									<tr style="background:#000000; color:#FFFFFF;">
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
			<div class="col-lg-4">
				<div class="well well-lg">
					<table>
						<tr>
							<td valign="top">
								<table border="0">
									<tr>
										<td colspan="5" align="center">
											<strong>LAPORAN PENGELUARAN</strong>										</td>
									</tr>
									<tr>
										<td colspan="5" align="center">
											<strong>Ataz Barbershop</strong>										</td>
									</tr>
									<tr>
										<td colspan="5" align="center">
											<strong><?php echo "".$wulan." ". $tahun."";?></strong>										</td>
									</tr>
									<tr valign="top">
										<td colspan="5" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />										</td>
									</tr>
									<tr>
										<td colspan="4">
											<strong>Biaya Tetap</strong>										</td>
										<td width="111">&nbsp;</td>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT c.idbiaya,a.tgl,c.nama,sum(b.total) as total
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													and b.jenis='tetap'
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.tetap is not null
													and month(a.tgl)='$bulan' and year(a.tgl)='$tahun'
													group by c.nama ORDER BY idbiaya");
											$totaltetap = '0';
											while($row=mysql_fetch_array($result))
											{
												?>	
												<tr>
													<td width="15">&nbsp;</td>
													<td colspan="3"><?php echo $row['nama'];?></td>
													<td align="right" style="padding-right:7px;"><?php echo number_format($row['total'],0,',','.') ?></td>
												</tr>
												<?php 
									        	$totaltetap += $row['total'];
									        }
									        mysql_free_result($result);
										?>

										<?php
											$result = mysql_query("SELECT b.keterangan,b.total FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
											 where b.biaya_idbiaya='40' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun'");
											while($row=mysql_fetch_array($result))
											{
												?>	
												<tr>
												  <td>&nbsp;</td>
												  <td width="75">&nbsp;</td>
												  <td width="283"><?php echo $row['keterangan'];?></td>
												  <td width="48" align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
												  <td align="right" style="padding-right:7px;">&nbsp;</td>
								   				</tr>
												<?php 
									        }
									        mysql_free_result($result);
										?>
									<tr valign="top">
										<td colspan="5">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis2.png" />										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td colspan="2"><strong>Sub Total</strong></td>
										<td>&nbsp;</td>
										<td align="right" style="padding-right:7px;"><strong><?php echo number_format($totaltetap,0,',','.') ?></strong>										</td>
									</tr>
								</table> 
              <!--Biaya Tetap End -->
								<table border="0">
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<td colspan="3"><strong>Biaya Perlengkapan</strong></td>
										<td>&nbsp;</td>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT a.tgl,c.nama,sum(b.total) as total
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.perlengkapan is not null
													and month(a.tgl)='$bulan' and year(a.tgl)='$tahun'
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
								</table><!--Biaya Perlengkapan End -->
								<table border="0">
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<td colspan="3"><strong>Biaya Belanja</strong></td>
										<td>&nbsp;</td>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT a.tgl,c.nama,sum(b.total) as total
													FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
													inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.belanja is not null
													and month(a.tgl)='$bulan' and year(a.tgl)='$tahun'
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
								</table><!--Biaya Belanja End -->
								<table border="0">
									<tr valign="top">
										<td colspan="4" style="padding-top:10px;">
											<img class="img-responsive col-lg-12" src="../dist/gambar/garis.png" />
										</td>
									</tr>
									<tr>
										<td colspan="3"><strong>Biaya Lain-Lain</strong></td>
										<td>&nbsp;</td>
									</tr>
										<?php
											$no = '0';
											$result = mysql_query("SELECT b.keterangan,b.total FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran and b.biaya_idbiaya='16' and month(a.tgl)='$bulan' and year(a.tgl)='$tahun'");
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
									<tr style="background:#000000; color:#FFFFFF">
										<td><strong>TOTAL PENGELUARAN</strong></td>
										<td align="right" style="padding-right:7px;"><strong><?php echo number_format($pengeluarantotal,0,',','.') ?></strong></td>
									</tr>
								</table> <!--Total Pengeluaran end -->
							</td> <!--Kolom Pengeluaran end -->
						</tr>
					</table>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="well well-lg">
					<table>
						<tr>
							<td valign="top">
								<table border="0">
									<tr>
										<td colspan="4" align="center">
											<strong>LAPORAN Rugi Laba</strong>
										</td>
									</tr>
									<tr>
										<td colspan="4" align="center">
											<strong>Ataz Barbershop</strong>
										</td>
									</tr>
									<tr>
										<td colspan="4" align="center">
											<strong><?php echo "".$wulan." ". $tahun."";?></strong>
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
									<tr style="background:#000000; color:#FFFFFF">
										<td>
											<strong>RUGI LABA</strong>
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
		</div>
	</body>
</html>