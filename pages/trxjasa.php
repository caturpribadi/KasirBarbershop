<?php
include 'koneksi.php';
include 'ceklevel.php';
?>

<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Laporan Paket</h3>
    </div>
</div>
<div class="row">
    <form action="trxjasa" method="post">
    <div class="form-group" style="">
         <div class="col-xs-2">
            <input type="text" name="tglawal" class="form-control input-sm" id="tgllahir" placeholder="Tgl Awal">
        </div>

         <div class="col-xs-2">
            <input type="text" name="tglakhir" class="form-control input-sm" id="tglakhir" placeholder="Tgl Akhir" required="required">
        </div>

        <div class="col-xs-2">
            <select class ="form-control" name="paket">
                <option selected value="">Jenis Paket</option>
                <?php
                $result=mysql_query("select * from paket where visible='1'");
                while($cp = mysql_fetch_array($result))
                {?>
                <option value="<?php echo $cp['idpaket']; ?>"><?php echo $cp['nama'] ; ?></option>
                <?php
                }
                mysql_free_result($result);?>
            </select>
        </div>
           <input name="cari" type="submit" value="Cari" />
    </div>
    </form>
</div>


<?php
if(isset($_POST['cari']))
{
    $tanggalawal  =$_POST['tglawal'];
    $tanggalakhir =$_POST['tglakhir'];
    $idpaket     =$_POST['paket'];
    $tglawal      =date('Y-m-d', strtotime(str_replace('/','-', $tanggalawal)));
    $tglakhir     =date('Y-m-d', strtotime(str_replace('/','-', $tanggalakhir)));

    if (empty($tanggalawal) and empty($tanggalakhir)) {
        ?>
            <script language="javascript">
            alert("Tanggal Akhir Harus Diisi !! ");
            document.location="indek.php?cp=trxjasa";
            </script>
        <?php
    }elseif (empty($tanggalakhir)) {
        ?>
            <script language="javascript">
            alert("Tanggal Akhir Harus Diisi !! ");
            document.location="indek.php?cp=trxjasa";
            </script>
        <?php
    }elseif (empty($tanggalawal)) {
        if (empty($idpaket)) {
            $result=mysql_query("SELECT sum(a.qty) as qty,sum(a.total) as subtotal FROM trxjasa a inner join transaksi b on a.transaksi_idtransaksi=b.idtransaksi inner join paket c on a.paket_idpaket=c.idpaket left join member d on d.idmember=b.member_idmember where tgl='$tglakhir'");
            $subtotal = mysql_fetch_array($result);
            mysql_free_result($result);
            $tot_qty=$subtotal['qty'];
            $tot_paket=$subtotal['subtotal'];
            $result=mysql_query("SELECT a.qty,a.harga,a.total,b.tgl,b.nota,c.nama,d.nama as member FROM trxjasa a inner join transaksi b on a.transaksi_idtransaksi=b.idtransaksi inner join paket c on a.paket_idpaket=c.idpaket left join member d on d.idmember=b.member_idmember where tgl='$tglakhir' ORDER BY b.nota");
        }else{
            $result=mysql_query("SELECT sum(a.qty) as qty,sum(a.total) as subtotal FROM trxjasa a inner join transaksi b on a.transaksi_idtransaksi=b.idtransaksi inner join paket c on a.paket_idpaket=c.idpaket left join member d on d.idmember=b.member_idmember where tgl='$tglakhir' and c.idpaket='$idpaket'");
            $subtotal = mysql_fetch_array($result);
            mysql_free_result($result);
            $tot_qty=$subtotal['qty'];
            $tot_paket=$subtotal['subtotal'];
            $result=mysql_query("SELECT a.qty,a.harga,a.total,b.tgl,b.nota,c.nama,d.nama as member FROM trxjasa a inner join transaksi b on a.transaksi_idtransaksi=b.idtransaksi inner join paket c on a.paket_idpaket=c.idpaket left join member d on d.idmember=b.member_idmember where tgl='$tglakhir' and c.idpaket='$idpaket' ORDER BY b.nota");
        }
    }else{
        if (empty($idpaket)) {
            $result=mysql_query("SELECT sum(a.qty) as qty,sum(a.total) as subtotal FROM trxjasa a inner join transaksi b on a.transaksi_idtransaksi=b.idtransaksi inner join paket c on a.paket_idpaket=c.idpaket left join member d on d.idmember=b.member_idmember where tgl between '$tglawal' and '$tglakhir'");
            $subtotal = mysql_fetch_array($result);
            mysql_free_result($result);
            $tot_qty=$subtotal['qty'];
            $tot_paket=$subtotal['subtotal'];
            $result=mysql_query("SELECT a.qty,a.harga,a.total,b.tgl,b.nota,c.nama,d.nama as member FROM trxjasa a inner join transaksi b on a.transaksi_idtransaksi=b.idtransaksi inner join paket c on a.paket_idpaket=c.idpaket left join member d on d.idmember=b.member_idmember where tgl between '$tglawal' and '$tglakhir' ORDER BY b.nota");
        }else{
            $result=mysql_query("SELECT sum(a.qty) as qty,sum(a.total) as subtotal FROM trxjasa a inner join transaksi b on a.transaksi_idtransaksi=b.idtransaksi inner join paket c on a.paket_idpaket=c.idpaket left join member d on d.idmember=b.member_idmember where tgl between '$tglawal' and '$tglakhir' and c.idpaket='$idpaket'");
            $subtotal = mysql_fetch_array($result);
            mysql_free_result($result);
            $tot_qty=$subtotal['qty'];
            $tot_paket=$subtotal['subtotal'];
            $result=mysql_query("SELECT a.qty,a.harga,a.total,b.tgl,b.nota,c.nama,d.nama as member FROM trxjasa a inner join transaksi b on a.transaksi_idtransaksi=b.idtransaksi inner join paket c on a.paket_idpaket=c.idpaket left join member d on d.idmember=b.member_idmember where tgl between '$tglawal' and '$tglakhir' and c.idpaket='$idpaket' ORDER BY b.nota");
        }
    }

?>
    <div class="row">
        <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                       Data Laporan Paket
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="trxmember">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Nota</th>
                                    <th>Nama Paket</th>
                                    <th>qty</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Member</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = '0';
                                while($row=mysql_fetch_array($result))
                                {
                                $no++
                                ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $row['tgl'];?></td>
                                    <td><?php echo $row['nota'];?></td>
                                    <td><?php echo $row['nama'];?></td>
                                    <td align="center"><?php echo $row['qty'];?></td>
                                    <td align="right"><?php echo number_format($row['harga'],0,',','.') ?></td>
                                    <td align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
                                    <td><?php echo $row['member'];?></td>
                                </tr>
                                <?php 
                                }
                                mysql_free_result($result);
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="well">
                        <?php
                            $dateawal = date('j F Y',strtotime($tglawal));
                            $dateakhir = date('j F Y',strtotime($tglakhir));
                            $result=mysql_query("SELECT nama FROM paket where idpaket='$idpaket'");
                            $paket = mysql_fetch_array($result);
                            $namapaket=$paket['nama'];
                            mysql_free_result($result);
                            if (empty($tanggalawal)) {
                                if (empty($idpaket)) { ?>
                                <h5>Penjualan All Paket <b><?php echo $dateakhir; ?></b></h5> <?php
                                }else{ ?>
                                <h5>Penjualan <b><?php echo "".$namapaket." ".$dateakhir.""; ?></b></h5><?php
                                }
                            }else{
                                if (empty($idpaket)) {?>
                                <h5>Penjualan All Paket <b><?php echo " ".$dateawal."</b> s/d  <b>".$dateakhir.""; ?></b></h5><?php
                                }else{?>
                                <h5>Penjualan <b><?php echo "".$namapaket." </b>dari<b> ".$dateawal."</b> s/d  <b>".$dateakhir.""; ?></b></h5><?php

                                }
                            }

                        ?> 
                    <table>
                            <tr>
                                <td>Sub Total QTY</td>
                                <td>:</td>
                                <td align="right"><strong><?php echo $tot_qty;?></strong></td>
                            </tr>
                            <tr>
                                <td>Sub Total Paket</td>
                                <td>:</td>
                                <td align="right"><strong><?php echo number_format($tot_paket,0,',','.');?></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div> <!-- end panel -->
        </div>
    </div>
<?php

}else{
    unset($_POST['cari']);
}
?>
