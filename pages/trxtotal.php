<?php
include 'koneksi.php';
include 'ceklevel.php';
include '../dist/DayToIndo.php';
?>

    <script type="text/javascript">
        function ToggleShowHideTable(VX, YX){
            if (document.getElementById(VX).style.display == 'none'){
                document.getElementById(VX).style.display = '';
                document.getElementById(YX).innerHTML = '<i class="glyphicon glyphicon-minus-sign text-danger" style="font-size:150%;"></i>';
            }else{
                document.getElementById(VX).style.display = 'none';
                document.getElementById(YX).innerHTML = '<i class="glyphicon glyphicon-plus-sign text-success" style="font-size:150%;"></i>';
            }
        }
    </script>

<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Laporan Total Pendapatan</h3>
    </div>
</div>
<div class="row">
    <form action="" method="post">
    <div class="form-group" style="">
         <div class="col-xs-2">
            <input type="text" name="tglawal" class="form-control input-sm" id="tgllahir" placeholder="Tgl Awal">
        </div>

         <div class="col-xs-2">
            <input type="text" name="tglakhir" class="form-control input-sm" id="tglakhir" placeholder="Tgl Akhir" required="required">
        </div>

        <div class="col-xs-2">
            <select class ="form-control" name="shift">
                <option selected value=""> Shift</option>
                <option value="1">Shift 1</option>
                <option value="3">Shift 3</option>
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
    $idshift      =$_POST['shift'];
    $tglawal      =date('Y-m-d', strtotime(str_replace('/','-', $tanggalawal)));
    $tglakhir     =date('Y-m-d', strtotime(str_replace('/','-', $tanggalakhir)));

    if (empty($tanggalawal) and empty($tanggalakhir)) {
        ?>
            <script language="javascript">
            alert("Tanggal Akhir Harus Diisi !! ");
            document.location="indek.php?cp=trxbarang";
            </script>
        <?php
    }elseif (empty($tanggalakhir)) {
        ?>
            <script language="javascript">
            alert("Tanggal Akhir Harus Diisi !! ");
            document.location="indek.php?cp=trxbarang";
            </script>
        <?php
    }elseif (empty($tanggalawal)) {
        if (empty($idshift)) {
            $result=mysql_query("SELECT sum(a.tot_trxbarang) as tot_barang,sum(a.tot_trxjasa) as tot_jasa,sum(a.total) as tot_transaksi FROM transaksi a
                    left join member b on a.member_idmember=b.idmember where tgl='$tglakhir' ORDER BY a.nota");
            $subtotal = mysql_fetch_array($result);
            mysql_free_result($result);
            $tot_barang    =$subtotal['tot_barang'];
            $tot_jasa      =$subtotal['tot_jasa'];
            $tot_transaksi =$subtotal['tot_transaksi'];
            $result=mysql_query("SELECT a.idtransaksi,a.tgl,a.nota,a.tot_trxbarang,a.tot_trxjasa,a.total,a.shift,b.nama FROM transaksi a
                    left join member b on a.member_idmember=b.idmember where tgl='$tglakhir' ORDER BY a.nota");
        }else{
            $result=mysql_query("SELECT sum(a.tot_trxbarang) as tot_barang,sum(a.tot_trxjasa) as tot_jasa,sum(a.total) as tot_transaksi FROM transaksi a
                    left join member b on a.member_idmember=b.idmember where tgl='$tglakhir' and a.shift='$idshift' ORDER BY a.nota");
            $subtotal = mysql_fetch_array($result);
            mysql_free_result($result);
            $tot_barang    =$subtotal['tot_barang'];
            $tot_jasa      =$subtotal['tot_jasa'];
            $tot_transaksi =$subtotal['tot_transaksi'];
            $result=mysql_query("SELECT a.idtransaksi,a.tgl,a.nota,a.tot_trxbarang,a.tot_trxjasa,a.total,a.shift,b.nama FROM transaksi a
                    left join member b on a.member_idmember=b.idmember where tgl='$tglakhir' and a.shift='$idshift' ORDER BY a.nota");
        }
    }else{//iki sing di pake
        if (empty($idshift)) {
            $result=mysql_query("SELECT sum(a.tot_trxbarang) as tot_barang,sum(a.tot_trxjasa) as tot_jasa,sum(a.total) as tot_transaksi FROM transaksi a
                    left join member b on a.member_idmember=b.idmember where a.tgl between '$tglawal' and '$tglakhir' ORDER BY a.nota");
            $subtotal = mysql_fetch_array($result);
            mysql_free_result($result);
            $tot_barang    =$subtotal['tot_barang'];
            $tot_jasa      =$subtotal['tot_jasa'];
            $tot_transaksi =$subtotal['tot_transaksi'];
            $result=mysql_query("SELECT a.idtransaksi,a.tgl,a.nota,a.tot_trxbarang,a.tot_trxjasa,a.total,a.shift,b.nama FROM transaksi a
                    left join member b on a.member_idmember=b.idmember where a.tgl between '$tglawal' and '$tglakhir' ORDER BY a.nota");
        }else{
            $result=mysql_query("SELECT sum(a.tot_trxbarang) as tot_barang,sum(a.tot_trxjasa) as tot_jasa,sum(a.total) as tot_transaksi FROM transaksi a
                    left join member b on a.member_idmember=b.idmember where a.shift='$idshift' and a.tgl between '$tglawal' and '$tglakhir' ORDER BY a.nota");
            $subtotal = mysql_fetch_array($result);
            mysql_free_result($result);
            $tot_barang    =$subtotal['tot_barang'];
            $tot_jasa      =$subtotal['tot_jasa'];
            $tot_transaksi =$subtotal['tot_transaksi'];
            $result=mysql_query("SELECT a.idtransaksi,a.tgl,a.nota,a.tot_trxbarang,a.tot_trxjasa,a.total,a.shift,b.nama FROM transaksi a
                    left join member b on a.member_idmember=b.idmember where a.shift='$idshift' and a.tgl between '$tglawal' and '$tglakhir' ORDER BY a.nota");
        }
    }

?>
    <div class="row">
        <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                       Laporan Penjualan <?php echo "".$tanggalawal." - ".$tanggalakhir.""; ?>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="pegawai">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Nota</th>
                                        <th>Total Barang</th>
                                        <th>Total Jasa</th>
                                        <th>Total</th>
                                        <th>Shift</th>
                                        <th>Member</th>
                                        <th class="col-md-1" align="center">Detail</th>
                                        <?php
                                            if (($_SESSION['levelataz']) == "owner ataz") { ?>
                                            <th>Del</th>
                                            <?php
                                            }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $nomor = '0';
                                    while($row=mysql_fetch_array($result))
                                    {
                                    $nomor++;
                                    $nota=$row['nota'];
                                    $tanggal=$row['tgl'];
                                    //$tanggaltampil =date("d-m-Y",strtotime($tanggal));
                                    $tanggaltampil = (getday($tanggal,'-'));
                                    ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $tanggaltampil; ?></td>
                                        <td><?php echo $row['nota'];?></td>
                                        <td align="right"><?php echo number_format($row['tot_trxbarang'],0,',','.') ?></td>
                                        <td align="right"><?php echo number_format($row['tot_trxjasa'],0,',','.') ?></td>
                                        <td align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
                                        <td align="center"><?php echo $row['shift'];?></td>
                                        <td><?php echo $row['nama'];?></td>
                                        <td align="center"><button style="border:none; background : transparent; outline:none;" id="bubu<?php echo $row['nota'];?>" href="#" onClick="ToggleShowHideTable('barisnota<?php echo $row['nota'];?>', 'bubu<?php echo $row['nota'];?>');"><i class="glyphicon glyphicon-plus-sign text-success" style="font-size:150%;"></i></button></td>
                                        <?php
                                            if (($_SESSION['levelataz']) == "owner ataz") { ?>
                                            <td align="center">
                                                <A HREF="prosestransaksi.php?idtransaksi=<?php echo $row['idtransaksi'] ?>&proses=delnota" onclick='return confirm("Hapus <?php echo $row['nota']?> ?")'>
                                                    <i class="fa fa-trash-o"></i>
                                                </A>
                                            </td>
                                            <?php
                                            }
                                        ?>
                                    </tr>
                                    <tr align="center" id='barisnota<?php echo $row['nota'];?>' style="display:none">
                                        <td colspan="9" align="center">
                                            <div class="col-lg-8 col-md-offset-2">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-condensed table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <td><strong>Nama</strong></td>
                                                                <td><strong>Qty</strong></td>
                                                                <td align="right"><strong>Harga</strong></td>
                                                                <td align="right"><strong>Total</strong></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                <?php
                                                                    $no = '0';
                                                                    $result2 = mysql_query("SELECT c.nama,b.qty,b.harga,b.total FROM transaksi a inner join trxjasa b on a.idtransaksi=b.transaksi_idtransaksi and a.nota='$nota'
                                                                                            inner join paket c on b.paket_idpaket=c.idpaket");
                                                                    $record= mysql_num_rows ($result2); 
                                                                    while($row2=mysql_fetch_array($result2))
                                                                    {
                                                                        $no++;
                                                                        //$count=count($row2['nama']);
                                                                        $warna = "info";
                                                                        if($no % 2 == 0){
                                                                        $warna = "";
                                                                        }?>
                                                                        <tr class="<?php echo $warna ;?>">
                                                                            <td><?php echo $no; ?></td>
                                                                            <td><?php echo $row2['nama'];?></td>
                                                                            <td><?php echo $row2['qty'];?></td>
                                                                            <td align="right"><?php echo number_format($row2['harga'],0,',','.') ?></td>
                                                                            <td align="right"><?php echo number_format($row2['total'],0,',','.') ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    mysql_free_result($result2);
                                                                ?>

                                                                <?php
                                                                    $no=$record;
                                                                    $result2 = mysql_query("SELECT c.nama,b.qty,b.harga,b.total FROM transaksi a inner join trxbarang b on a.idtransaksi=b.transaksi_idtransaksi and a.nota='$nota'
                                                                                            inner join barang c on b.barang_idbarang=c.idbarang");
                                                                    while($row2=mysql_fetch_array($result2))
                                                                    {
                                                                        $no++;
                                                                        $warna = "info";
                                                                        if($no % 2 == 0){
                                                                        $warna = "";
                                                                        }?>
                                                                        <tr class="<?php echo $warna ;?>">
                                                                            <td><?php echo $no; ?></td>
                                                                            <td><?php echo $row2['nama'];?></td>
                                                                            <td><?php echo $row2['qty'];?></td>
                                                                            <td align="right"><?php echo number_format($row2['harga'],0,',','.') ?></td>
                                                                            <td align="right"><?php echo number_format($row2['total'],0,',','.') ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    mysql_free_result($result2);
                                                                ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr><!-- Baris Detail -->

                                    <?php 
                                    }
                                    mysql_free_result($result);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="well">
                        <table>
                            <tr>
                                <td>Sub Total Barang</td>
                                <td>:</td>
                                <td align="right"><strong><?php echo number_format($tot_barang,0,',','.');?></strong></td>
                            </tr>
                            <tr>
                                <td>Sub Total Jasa</td>
                                <td>:</td>
                                <td align="right"><strong><?php echo number_format($tot_jasa,0,',','.');?></strong></td>
                            </tr>
                            <tr>
                                <td>Sub Total Transaksi</td>
                                <td>:</td>
                                <td align="right"><strong><?php echo number_format($tot_transaksi,0,',','.');?></strong></td>
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


