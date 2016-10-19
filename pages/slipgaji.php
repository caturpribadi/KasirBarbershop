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
    $bulankasbon = date('m', strtotime(str_replace(' ','-', $sebelumnya)));
    $wulan =date('F', strtotime(str_replace(' ','-', $date)));
    $tahun =date('Y', strtotime(str_replace(' ','-', $date)));
 }else{
    unset($_POST['cari']);
    $today=date('Y-m-1');
    $sebelumnya = date("Y-m-1", strtotime("$today -1 month"));
	$selanjutnya = date("Y-m-1", strtotime("$today +1 month"));
    $tgl=date('Y-m-d');
	$bulan =date('m', strtotime(str_replace(' ','-', $tgl)));
	$bulankasbon = date('m', strtotime(str_replace(' ','-', $sebelumnya)));
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
		</script></head>
	<body>
		<div class="row">
			<div class="col-lg-12">
	
			 <h3 class="page-header">Slip Gaji Bulan <?php echo "".(WulanIndo($bulan))." ".$tahun.""; ?>
				<a href="print/slipgajixls.php?bulan=<?php echo $bulan; ?>&wulan=<?php echo $wulan; ?>&tahun=<?php echo $tahun; ?>" class="btn btn-outline btn-default col-sm-offset-6"><i class="fa fa-print" style="font-size:150%;"></i> Save Excel</a>
			</h3>
			
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
<div class="">
    <?php
        $nomor = '0';
        //$result2 = mysql_query("SELECT * FROM pegawai where aktif='1' and visible='1'");
        $result2 = mysql_query("SELECT nama,level FROM gaji a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' group by a.nama");
       
        while($row2=mysql_fetch_array($result2))
        {
            $nomor++;
            $nama = ucwords($row2['nama']);
            $level = ucwords($row2['level']);
            ?>	
       		<div class="col-lg-4">
				<div class="well well-lg">
					<table border="0">
						<tr>
							<td valign="top">
								<table border="0">
									<tr>
										<td colspan="5" align="center">
											<img class="img-responsive col-lg-12" src="../dist/gambar/logotempat.png" />										</td>
									</tr>
									<tr>
										<td colspan="5" align="center">
											<strong></strong>										</td>
									</tr>
									<tr>
										<td colspan="5" align="center" style="padding-top:10px;">
											<strong><?php echo "".(WulanIndo($bulan))." ".$tahun.""; ?></strong>										</td>
									</tr>
									<tr>
										<td colspan="5" style="padding-top:10px;">
											<b>Nama : <?php echo $nama;?></b> <br>
											<strong>Level : <?php echo $level;?></strong>										</td>
										<td width="25">&nbsp;</td>
								  	</tr>
									<tr>
										<td colspan="5" align="center" style="padding-top:15px;padding-bottom:10px;"><strong> Rincian Gaji</strong></td>
					  				</tr>
									<tr>
									  <td colspan="2">Gaji Pokok</td>
									  <td width="283">&nbsp;</td>
									  <td width="25"></td>
									  <?php
										$result=mysql_query("SELECT sum(pokok) as pokok FROM gaji a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
										$pokok = mysql_fetch_array($result);
										mysql_free_result($result);
										$gajipokok=$pokok['pokok'];
									  ?>
									  <td align="right" style="padding-right:7px;"><?php echo number_format($gajipokok,0,',','.') ?></td>
					  				</tr>
									<tr>
									  	<td colspan="2">Bonus</td>
										<td></td>
										<td></td>
									  <?php
										$result=mysql_query("SELECT sum(bonus) as bonus FROM gaji a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
										$bonus = mysql_fetch_array($result);
										mysql_free_result($result);
										$gajibonus=$bonus['bonus'];
									  ?>
										<td align="right" style="padding-right:7px;"><?php echo number_format($gajibonus,0,',','.') ?></td>
									</tr>
									<tr>
									  	<td colspan="2">Over Time</td>
										<td></td>
										<td></td>
									  <?php
										$result=mysql_query("SELECT sum(overtime) as overtime FROM gaji a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
										$overtime = mysql_fetch_array($result);
										mysql_free_result($result);
										$gajiovertime=$overtime['overtime'];
									  ?>
										<td align="right" style="padding-right:7px;"><?php echo number_format($gajiovertime,0,',','.') ?></td>
									</tr>

						            <tr>
						              <td colspan="2">Tunjangan</td>
						              <td>&nbsp;</td>
						              <td></td>
						              <td align="right" style="padding-right:7px;">&nbsp;</td>
					              	</tr>
			                        <tr>
			                          <td width="41">&nbsp;</td>
			                          <td colspan="2">Makan</td>
			                          <td></td>
									  <?php
										$result=mysql_query("SELECT sum(makan) as makan FROM gaji a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
										$makan = mysql_fetch_array($result);
										mysql_free_result($result);
										$gajimakan=$makan['makan'];
									  ?>			                          
			                          <td align="right" style="padding-right:7px;"><?php echo number_format($gajimakan,0,',','.') ?></td>
		                          	</tr>
			                        <tr>
			                          <td>&nbsp;</td>
			                          <td colspan="2">Transport</td>
			                          <td></td>
									  <?php
										$result=mysql_query("SELECT sum(transport) as transport FROM gaji a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
										$transport = mysql_fetch_array($result);
										mysql_free_result($result);
										$gajitransport=$transport['transport'];
									  ?>			                          
			                          <td align="right" style="padding-right:7px;"><?php echo number_format($gajitransport,0,',','.') ?></td>
		                          	</tr>
			                        <tr>
			                          <td>&nbsp;</td>
			                          <td colspan="2">Pulsa</td>
			                          <td></td>
									  <?php
										$result=mysql_query("SELECT sum(pulsa) as pulsa FROM gaji a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
										$pulsa = mysql_fetch_array($result);
										mysql_free_result($result);
										$gajipulsa=$pulsa['pulsa'];
									  ?>			                          
			                          <td align="right" style="padding-right:7px;"><?php echo number_format($gajipulsa,0,',','.') ?></td>
		                          	</tr>

			                        <tr>
			                          <td>&nbsp;</td>
			                          <td colspan="2">Hari Raya</td>
			                          <td></td>
									  <?php
										$result=mysql_query("SELECT sum(hariraya) as hariraya FROM gaji a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
										$hariraya = mysql_fetch_array($result);
										mysql_free_result($result);
										$gajihariraya=$hariraya['hariraya'];
									  ?>			           
			                          <td align="right" style="padding-right:7px;"><?php echo number_format($gajihariraya,0,',','.') ?></td>
		                          	</tr>
			                        <tr>
			                          <td>&nbsp;</td>
			                          <td colspan="2">Kesehatan</td>
			                          <td></td>
									  <?php
										$result=mysql_query("SELECT sum(kesehatan) as kesehatan FROM gaji a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
										$kesehatan = mysql_fetch_array($result);
										mysql_free_result($result);
										$gajikesehatan=$kesehatan['kesehatan'];
									  ?>			                          
			                          <td align="right" style="padding-right:7px;"><?php echo number_format($gajikesehatan,0,',','.') ?></td>
		                          	</tr>
                                    <tr>
                                      <td>&nbsp;</td>
                                      <td colspan="2">Nikah</td>
                                      <td></td>
									  <?php
										$result=mysql_query("SELECT sum(nikah) as nikah FROM gaji a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
										$nikah = mysql_fetch_array($result);
										mysql_free_result($result);
										$gajinikah=$nikah['nikah'];
									  ?>                                      
                                      <td align="right" style="padding-right:7px;"><?php echo number_format($gajinikah,0,',','.') ?></td>
                                  	</tr>
                                    <tr>
                                      <td>&nbsp;</td>
                                      <td colspan="2">DukaCita</td>
                                      <td></td>
									  <?php
										$result=mysql_query("SELECT sum(dukacita) as dukacita FROM gaji a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
										$dukacita = mysql_fetch_array($result);
										mysql_free_result($result);
										$gajidukacita=$dukacita['dukacita'];
									  ?>                                      
                                      <td align="right" style="padding-right:7px;"><?php echo number_format($gajidukacita,0,',','.') ?></td>
                                    </tr>

									<tr valign="top">
										<td colspan="5" style="padding-top:10px;">
											<img class="img-responsive col-lg-9 col-md-offset-3" src="../dist/gambar/garis2.png" />										</td>
									</tr>
									<tr #919191>
									  <td>&nbsp;</td>
									  <td width="117">&nbsp;</td>
									  <td>Total Gaji</td>
									  <td>&nbsp;</td>
									  <?php
									  	$gajitotal = $gajipokok + $gajibonus + $gajimakan + $gajitransport + $gajihariraya + $gajikesehatan + $gajinikah + $gajidukacita
									  ?>
									  <td align="right" style="padding-right:7px;"><?php echo number_format($gajitotal,0,',','.') ?></td>
								  	</tr>
									<tr #919191>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td>Kasbon</td>
									  <td>&nbsp;</td>
									  <?php
										$result=mysql_query("SELECT sum(kasbon) as kasbon FROM gaji a inner join pengeluaran b on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
										$kasbon = mysql_fetch_array($result);
										mysql_free_result($result);
										$gajikasbon=$kasbon['kasbon'];
									  ?> 
									  <td align="right" style="padding-right:8px;"><?php echo number_format($gajikasbon,0,',','.') ?></td>
								  </tr>
									<tr #919191>
									  <td colspan="5" style="padding-right:0px;">
                                      <img class="img-responsive col-lg-9 col-md-offset-3" src="../dist/gambar/garis2.png" />                                      </td>
								  </tr>
									<tr #919191>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td>Gaji Diterima</td>
									  <td>&nbsp;</td>
									  <?php
									  	$gajiterima = $gajitotal - $gajikasbon
									  ?>
									  <td align="right" style="padding-right:7px;"><?php echo number_format($gajiterima,0,',','.') ?></td>
								  </tr>
									<tr #919191>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td align="right" style="padding-right:7px;">&nbsp;</td>
								  </tr>
									<tr #919191>
									  <td colspan="5" align="center">Pedan, &nbsp; &nbsp; <?php echo "".(WulanIndo($bulan))." ".$tahun.""; ?></td>
								  </tr>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td align="right" style="padding-right:7px;">&nbsp;</td>
								  </tr>

									<tr #919191>
									  	<td colspan="5" align="center" style="padding-top:17px;"><u>Hendra Bone<u></td>
									</tr>
									<tr #919191>
									  
								  </tr>
									<tr>
									  	<td colspan="5" align="center"><i>Manager<i></td>
									</tr>
								</table> 
							</td> 
						</tr>
					</table>
				</div>
			</div>
            <?php
        }
        mysql_free_result($result2);
    ?>
</div>

	</body>
</html>