<?php
	include 'ceklevel.php';
include '../koneksi.php';
	include '../../dist/DateToIndo.php';
$bulan=$_GET['bulan'];
$wulan=$_GET['wulan'];
$tahun=$_GET['tahun'];
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=SlipGaji_$wulan.xls");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
    <?php
        $nomor = '0';
        $result2 = mysql_query("SELECT * FROM pegawai where aktif='1' and visible='1'");
       
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
										<strong> Ataz Barbershop </strong>
									</td>	
								</tr>
								<tr>
									<td colspan="5" align="center">
										<strong>PEDAN</strong>
									</td>
								</tr>
								<tr>
									<td colspan="5" align="center" style="padding-top:10px;">
										<strong><?php echo "".(WulanIndo($bulan))." ".$tahun."."; ?></strong>
									</td>
								</tr>
								<tr>
									<td colspan="4" style="padding-top:10px;">
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
									</td>
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
							      </td>
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
								<tr>
									<td colspan="5" align="center"></td>
								</tr>
								<tr>
									<td colspan="5" align="center"></td>
								</tr>
								<tr>
									<td colspan="5" align="center"></td>
								</tr>
								<tr #919191>
								  	<td colspan="5" align="center" style="padding-top:17px;"><u>Hendra Bone</u>
								  	</td>
								</tr>
								<tr>
									<td colspan="5" align="center"><i>Manager</i></td>
								</tr>
								<tr>
									<td colspan="5" align="center"></td>
								</tr>
								<tr>
									<td colspan="5" align="center"></td>
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
</body>
</html>