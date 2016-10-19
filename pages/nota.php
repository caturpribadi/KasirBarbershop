<?php
     require 'koneksi.php';
     include 'cek.php';
?>



<table border="0">
  <tr>
    <td colspan="6" align="center"><img src="../dist/gambar/garis.png" width="300" height="3" /></td>
  </tr>
  <tr>
    <td style="padding-bottom:10px;" colspan="6" align="center"><b>NOTA</b></td>
  </tr>
  <tr>
    <?php 
        $result=mysql_query("SELECT * from transaksi order by idtransaksi desc limit 1");
        $transaksi = mysql_fetch_array($result);
        mysql_free_result($result);
        $nota     =$transaksi['nota'];
        $tgl      =$transaksi['tgl'];
        $idmember =$transaksi['member_idmember'];
        $tot_trxjasa=$transaksi['tot_trxjasa'];
        $tot_trxbarang=$transaksi['tot_trxbarang'];
        $subtotal=$transaksi['total'];
        $date = date('d.m.y',strtotime($tgl));
    ?>
    <td>No.Nota</td>
    <td>:</td>
    <td colspan="2"><?php echo $nota; ?></td>
    <td>Shift :</td>
    <td><?php echo $transaksi['shift'];?></td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>:</td>
    <td colspan="2"><?php echo $date; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
  if (!empty($idmember)) { 
        $result=mysql_query("SELECT nama from member where idmember='$idmember'");
        $member = mysql_fetch_array($result);
        mysql_free_result($result);
  ?>
  <tr>
    <td>Kepada</td>
    <td>:</td>
    <td colspan="3"><?php echo $member['nama'];?></td>
    <td>&nbsp;</td>
  </tr>
  <?php
    }else{ ?>
  <tr>
    <td>Kepada</td>
    <td>:</td>
    <td colspan="2"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
    }
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>item</td>
    <td align="right">harga</td>
    <td align="center" width="40">qty</td>
    <td align="center">total</td>
  </tr>
<?php
  if ($tot_trxjasa!='0') { 
     $result = mysql_query("SELECT c.nama,b.harga,b.qty,b.total FROM transaksi a inner join trxjasa b on a.idtransaksi=b.transaksi_idtransaksi
            inner join paket c on b.paket_idpaket=c.idpaket and a.nota='$nota'");
        while($row=mysql_fetch_array($result))
    { ?>
    <tr>
        <td></td>
        <td>&nbsp;</td>
        <td><?php echo $row['nama'];?></td>
        <td align="right"><?php echo number_format($row['harga'],0,',','.') ?></td>
        <td align="center"><?php echo $row['qty'];?></td>
        <td align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
    </tr>
    <?php 
    }
    mysql_free_result($result);
    }
?>

<?php
  if ($tot_trxbarang!='0') { 
     $result = mysql_query("SELECT c.nama,b.harga,b.qty,b.total FROM transaksi a inner join trxbarang b on a.idtransaksi=b.transaksi_idtransaksi
            inner join barang c on b.barang_idbarang=c.idbarang and a.nota='$nota'");
        while($row=mysql_fetch_array($result))
    { ?>
    <tr>
        <td></td>
        <td>&nbsp;</td>
        <td><?php echo $row['nama'];?></td>
        <td align="right"><?php echo number_format($row['harga'],0,',','.') ?></td>
        <td align="center"><?php echo $row['qty'];?></td>
        <td align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
    </tr>
    <?php 
    }
    mysql_free_result($result);
    }
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="center">Sub Total</td>
    <td align="right"><strong><?php echo number_format($subtotal,0,',','.') ?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

