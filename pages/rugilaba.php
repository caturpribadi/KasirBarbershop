<?php
include 'ceklevel.php';
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
<?php
include 'koneksi.php';
?>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Laporan Rugi Laba</h3>
	</div>
</div>

<div class="row">
	<div class="col-xs-8">
		<form action="rugilaba" method="post">
			<div class="form-group" style="">
				<div class="col-xs-8 col-sm-3">
					<input type="text" name="date" class="form-control input-sm" id="tgllaporan" placeholder="Bulan" required="required"></div>
				<input name="cari" type="submit" value="Cari"/>
			</div>
		</form>
	</div>
</div>
<?php
if(isset($_POST['cari']))
{
$date  =$_POST['date'];
$bulan =date('m', strtotime(str_replace(' ','-', $date)));
$wulan =date('F', strtotime(str_replace(' ','-', $date)));
$tahun =date('Y', strtotime(str_replace(' ','-', $date)));
//echo $bulan;
echo "<br>"; ?>
<div class="row">
	<div class="col-lg-2 col-sm-offset-10">
		<a href="print/rugilabaxls.php?bulan=<?php echo $bulan; ?>&wulan=<?php echo $wulan; ?>&tahun=<?php echo $tahun; ?>" class="btn btn-outline btn-default"><i class="fa fa-print" style="font-size:150%;"></i> Save Excel</a>
	</div>
</div>
<br>
<table border="0">
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
				<tr valign="top">
					<td colspan="4">
						<img src="../dist/gambar/garis.png" width="312" height="4"/>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<strong>Pendapatan Jasa</strong>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="15"></td>
					<td width="155">
						<strong>Nama</strong>
					</td>
					<td width="43" align="left">
						<strong>qty</strong>
					</td>
					<td align="right" style="padding-right:7px;">
						<strong>Total</strong>
					</td>
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
					<td colspan="4">
						<div style="border-bottom: thick double #919191; "></div>
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
				<tr valign="top">
					<td colspan="4">
						<img src="../dist/gambar/garis.png" width="312" height="4"/>
					</td>
				</tr>
				<tr>
					<td colspan="3">
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
						<div style="border-bottom: thick double #919191; "></div>
					</td>
				</tr>
				<tr #919191>
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
					<td colspan="4">
						<img src="../dist/gambar/garis.png" width="312" height="4"/>
					</td>
				</tr>
				<tr style="background:#000000; color:#FFFFFF">
					<td><strong>TOTAL PENDAPATAN</strong></td>
					<td align="right" style="padding-right:7px;">
						<strong><?php echo number_format($pendapatantotal,0,',','.') ?></strong>
					</td>
				</tr>
			</table> <!--Total Pendapatan end -->
		</td> <!--Kolom Pendapatan end -->

		<td>
			<img src="../dist/gambar/garis.png" width="20" height="3"/>
		</td> <!--Kolom Space -->

		<td valign="top">
			<table border="0">
				<tr>
					<td colspan="4" align="center">
						<strong>LAPORAN PENGELUARAN</strong>
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
					<td colspan="4">
						<img src="../dist/gambar/garis.png" width="312" height="4"/>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<strong>Biaya Tetap</strong>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="15">&nbsp;</td>
					<td><strong>Keterangan</strong></td>
					<td>&nbsp;</td>
					<td align="right" style="padding-right:7px;"><strong>Total</strong></td>
				</tr>
					<?php
						$no = '0';
						$result = mysql_query("SELECT a.tgl,c.nama,sum(b.total) as total
								FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
								inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.tetap is not null
								and month(a.tgl)='$bulan' and year(a.tgl)='$tahun'
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
				<tr>
					<td colspan="4">
						<div style="border-bottom: thick double #919191; "></div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><strong>Sub Total</strong></td>
					<td>&nbsp;</td>
					<td align="right" style="padding-right:7px;"><strong><?php echo number_format($totaltetap,0,',','.') ?></strong>
					</td>
				</tr>
			</table> <!--Biaya Tetap End -->
			<table border="0">
				<tr valign="top">
					<td colspan="4">
						<img src="../dist/gambar/garis.png" width="312" height="4"/>
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
				<tr>
					<td colspan="4">
						<div style="border-bottom: thick double #919191; "></div>
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
					<td colspan="4">
						<img src="../dist/gambar/garis.png" width="312" height="4"/>
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
				<tr>
					<td colspan="4">
						<div style="border-bottom: thick double #919191; "></div>
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
					<td colspan="4">
						<img src="../dist/gambar/garis.png" width="312" height="4"/>
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
				<tr>
					<td colspan="4">
						<div style="border-bottom: thick double #919191; "></div>
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
					<td colspan="4">
						<img src="../dist/gambar/garis.png" width="312" height="4"/>
					</td>
				</tr>
				<tr style="background:#000000; color:#FFFFFF">
					<td><strong>TOTAL PENGELUARAN</strong></td>
					<td align="right" style="padding-right:7px;"><strong><?php echo number_format($pengeluarantotal,0,',','.') ?></strong></td>
				</tr>
			</table> <!--Total Pengeluaran end -->
			<br>
			<br>
		</td> <!--Kolom Pengeluaran end -->

		<td>
			<img src="../dist/gambar/garis.png" width="20" height="3"/>
		</td> <!--Kolom Space -->

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
					<td colspan="4">
						<img src="../dist/gambar/garis.png" width="312" height="4"/>
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
				<tr>
					<td colspan="4">
						<div style="border-bottom: thick double #919191; "></div>
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
					<td colspan="4">
						<img src="../dist/gambar/garis.png" width="312" height="4"/>
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
				<tr>
					<td colspan="4">
						<div style="border-bottom: thick double #919191; "></div>
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
					<td colspan="4">
						<img src="../dist/gambar/garis.png" width="312" height="4"/>
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
<?php
}else{
	unset($_POST['cari']);
}
?></body>
</html>