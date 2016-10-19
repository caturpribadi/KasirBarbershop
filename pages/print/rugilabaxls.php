<?php
include '../koneksi.php';
$bulan=$_GET['bulan'];
$wulan=$_GET['wulan'];
$tahun=$_GET['tahun'];
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=RugiLaba_$wulan.xls");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Rugi Laba</title>
</head>

<body>
	<center><h3>Laporan Rugi Laba Bulan <?php echo "$wulan $tahun"; ?></h3></center>
        <table border="0">
            <tr>
                <td valign="top">
                    <table border="0">
                        <tr>
                            <td colspan="4" align="center">
                                <strong>LAPORAN PENDAPATAN</strong>                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <strong>Ataz Barbershop</strong>                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <strong><?php echo "".$wulan." ". $tahun."";?></strong>                            </td>
                        </tr>
                        <tr valign="top">
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">                              <strong>Pendapatan Jasa</strong></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            <strong>Nama</strong>                            </td>
                            <td width="43" align="left">
                                <strong>qty</strong>                            </td>
                            <td align="right" style="padding-right:7px;">
                                <strong>Total</strong>                            </td>
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
                                        <td colspan="2"><?php echo $row['nama'];?></td>
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
                            <td colspan="2">Free Pangkas</td>
                            <td><?php echo $jmlfree; ?></td>
                            <td align="right" style="padding-right:7px;">0</td>
                            <?php
                                }
                            ?>
                        </tr>
                        <tr valign="top">
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr #919191>
                            <td width="15">&nbsp;</td>
                            <td width="155">
                                <strong>Sub Total</strong>                            </td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;">
                                <strong><?php echo number_format($totaljasa,0,',','.') ?></strong>                            </td>
                        </tr>
                    </table> 
                    <!--Pendapatan Jasa end -->
                    <table border="0">
                        <tr valign="top">
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">  <strong>Pendapatan Barang</strong> </td>
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
                                        <td colspan="2"><?php echo $row['nama'];?></td>
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
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr #919191>
                            <td width="15">&nbsp;</td>
                            <td width="155"><strong>Sub Total</strong></td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;">
                                <strong><?php echo number_format($totalbarang,0,',','.') ?></strong>                            </td>
                        </tr>
                    </table> 
                    <!--Pendapatan Barang end -->
                    <table border="0">
                        <?php
                            $pendapatantotal=$totalbarang+$totaljasa;
                        ?>
                        <tr valign="top">
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>
                            </td>
                        </tr>
                        <tr style="background:#000000; color:#FFFFFF">
                            <td width="164"><strong>TOTAL PENDAPATAN</strong></td>
                      <td width="72" align="right" style="padding-right:7px;">
                                                           </td>
                      <td width="72" align="right" style="padding-right:7px;">
                                                           </td>
                      <td width="72" align="right" style="padding-right:7px;">
                                <strong><?php echo number_format($pendapatantotal,0,',','.') ?></strong>                            </td>
                      </tr>
                    </table> <!--Total Pendapatan end -->
                </td> <!--Kolom Pendapatan end -->

                <td>
                    
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
                                <strong>Ataz Barbershop</strong>                                        </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <strong><?php echo "".$wulan." ". $tahun."";?></strong>                                     </td>
                        </tr>
                        <tr valign="top">
                            <td colspan="4" style="padding-top:10px;">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <strong>Biaya Tetap</strong>                                        </td>
                            <td >&nbsp;</td>
                      </tr>
                            <?php
                                $no = '0';
                                $result = mysql_query("SELECT c.idbiaya,a.tgl,c.nama,sum(b.total) as total
                                        FROM pengeluaran a inner join detail_pengeluaran b on a.idpengeluaran=b.pengeluaran_idpengeluaran
                                        inner join biaya c on b.biaya_idbiaya=c.idbiaya and c.tetap is not null
                                        and month(a.tgl)='$bulan' and year(a.tgl)='$tahun'
                                        group by c.nama ORDER BY idbiaya");
                                $totaltetap = '0';
                                while($row=mysql_fetch_array($result))
                                {
                                    ?>  
                                    <tr>
                                        
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
                                      
                                      <td><?php echo $row['keterangan'];?></td>
                                      <td align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
                                      <td align="right" style="padding-right:7px;">&nbsp;</td>
                                    </tr>
                                    <?php 
                                }
                                mysql_free_result($result);
                            ?>
                        <tr valign="top">
                            <td colspan="5">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><strong>Sub Total</strong></td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;"><strong><?php echo number_format($totaltetap,0,',','.') ?></strong>                                        </td>
                        </tr>
                    </table> 
            <!--Biaya Tetap End -->
                    <table border="0">
                        <tr valign="top">
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Biaya Perlengkapan</strong></td>
                            <td>&nbsp;</td>
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
                                        <td colspan="2"><?php echo $row['nama'];?></td>
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
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr>
                            <td width="15">&nbsp;</td>
                            <td><strong>Sub Total</strong></td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;"><strong><?php echo number_format($totalperlengkapan,0,',','.') ?></strong></td>
                        </tr>
                    </table>
                    <!--Biaya Perlengkapan End -->
                    <table border="0">
                        <tr valign="top">
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Biaya Belanja</strong></td>
                            <td>&nbsp;</td>
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
                                        <td colspan="2"><?php echo $row['nama'];?></td>
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
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr>
                            <td width="15">&nbsp;</td>
                            <td><strong>Sub Total</strong></td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;"><strong><?php echo number_format($totalbelanja,0,',','.') ?></strong></td>
                        </tr>
                    </table>
                    <!--Biaya Belanja End -->
                    <table border="0">
                        <tr valign="top">
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Biaya Lain-Lain</strong></td>
                            <td>&nbsp;</td>
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
                                        <td colspan="2"><?php echo $row['keterangan'];?></td>
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
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr>
                            <td width="15">&nbsp;</td>
                            <td><strong>Sub Total</strong></td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;"><strong><?php echo number_format($totallain,0,',','.') ?></strong></td>
                        </tr>
                    </table>
                    <!--Biaya Lain End -->
                    <table border="0">
                        <?php
                            $pengeluarantotal=$totaltetap+$totalperlengkapan+$totalbelanja+$totallain;
                        ?>
                        <tr valign="top">
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>
                            </td>
                        </tr>
                        <tr style="background:#000000; color:#FFFFFF">
                            <td><strong>TOTAL PENGELUARAN</strong></td>
                          <td align="right" style="padding-right:7px;"></td>
                            <td></td>
                            <td align="right" style="padding-right:7px;"><strong><?php echo number_format($pengeluarantotal,0,',','.') ?></strong></td>
                        </tr>
                    </table> <!--Total Pengeluaran end -->
                    <br>
                    <br>
                </td> <!--Kolom Pengeluaran end -->

                <td>
                    <img src="../../dist/gambar/garis.png" width="20" height="3"/>
                </td> <!--Kolom Space -->

                <td valign="top">
                    <table border="0">
                        <tr>
                            <td colspan="4" align="center">
                                <strong>LAPORAN Rugi Laba</strong>                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <strong>Ataz Barbershop</strong>                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <strong><?php echo "".$wulan." ". $tahun."";?></strong>                            </td>
                        </tr>
                        <tr valign="top">
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">                              <strong>Pendapatan</strong> </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">Jasa</td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;"><?php echo number_format($totaljasa,0,',','.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Barang</td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;"><?php echo number_format($totalbarang,0,',','.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr>
                        	<td width="19">&nbsp;</td>
                            <td>Sub Total</td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;"><strong><?php echo number_format($pendapatantotal,0,',','.') ?></strong></td>
                        </tr>
                  </table> 
                    <!--Tabel Pendapatan total end -->
                    <table border="0">
                        <tr valign="top">
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">                          <strong>Pengeluaran</strong> </td>
                            <td width="24">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">Biaya Tetap</td>
                            <td width="6">&nbsp;</td>
                            <td align="right" style="padding-right:7px;"><?php echo number_format($totaltetap,0,',','.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Biaya Perlengkapan</td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;"><?php echo number_format($totalperlengkapan,0,',','.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Biaya Belanja</td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;"><?php echo number_format($totalbelanja,0,',','.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Lain-Lain</td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;"><?php echo number_format($totallain,0,',','.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>                            </td>
                        </tr>
                        <tr>
                            <td width="19">&nbsp;</td>
                            <td width="102">Sub Total</td>
                            <td>&nbsp;</td>
                            <td align="right" style="padding-right:7px;"><strong><?php echo number_format($pengeluarantotal,0,',','.') ?></strong></td>
                        </tr>
                    </table> 
                    <!--Tabel Pengeluaran total end -->
                    <table border="0">
                        <?php 
                            $rugilaba=$pendapatantotal-$pengeluarantotal
                        ?>
                        <tr valign="top">
                            <td colspan="4">
                                <div style="border-bottom: thick double #919191; "></div>
                            </td>
                        </tr>
                        <tr style="background:#000000; color:#FFFFFF">
                            <td>
                                <strong>RUGI LABA</strong>
                            </td>
                            <td align="right" style="padding-right:7px;"></td>
                            <td></td>
                          <td><strong><?php echo number_format($rugilaba,0,',','.') ?></strong></td>
                        </tr>
                    </table> <!--Rugi laba end -->
                </td><!--Kolom Rugi Laba end -->
            </tr>
        </table>
</body>
</html>


<?php
exit()
?>