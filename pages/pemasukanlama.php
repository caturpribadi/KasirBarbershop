<?php  
include 'koneksi.php';
include 'cek.php';
$idtransaksitemp = $_GET['skac'];
if(empty($idtransaksitemp)){
date_default_timezone_set("Asia/Jakarta");
$tgl=date('Y-m-d');
$query=mysql_query("INSERT INTO transaksi_temp(tgl) VALUES ('$tgl')");
    $result = mysql_query("SELECT max(idtransaksi_temp) as ID FROM transaksi_temp;");
    $transaksitemp = mysql_fetch_array($result);
    mysql_free_result($result);
    $idtransaksitemp = $transaksitemp['ID'];
 header("Location: index.php?cp=pemasukan&skac=$idtransaksitemp");
}
?> 
<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Halaman Pamasukan</h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <table border="0">
        <tr>
            <td valign="top">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tambahkan Paket
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" >
                            <form class="form-horizontal" role="form" action="prosestransaksi.php" method="post">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Paket</label>
                                    <div class="col-sm-8 ">
                                        <select class ="form-control" name="paket" required="required">
                                            <option selected disabled value="">Pilih Paket</option>
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
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">QTY</label>
                                    <div class="col-sm-8 ">
                                        <input type="number" name="qty" class="form-control" placeholder="Jumlah" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-9">
                                        <button type="submit" class="btn btn-outline btn-default">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah
                                        </button>
                                    </div>
                              </div>
                              <input type="hidden" name="idtransaksitemp" value="<?php echo $idtransaksitemp; ?>">
                              <input type="hidden" name="proses" value="paket">
                            </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </td>
            <td rowspan="2" valign="top">
                <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Pemasukan Ataz Barbershop
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <form class="form-horizontal" role="form" action="prosestransaksi.php" method="post">
                                        <div class="form-group">
                                            <label for="nota" class="col-xs-2 control-label">Nota </label>
                                            <div class="col-xs-4">
                                                <?php
                                                    $result=mysql_query("select MAX(RIGHT(nota,5)) as kd_max from transaksi"); 
                                                    $cp = mysql_fetch_array($result);
                                                    $awal=((int)$cp['kd_max'])+1;
                                                    $kd = sprintf("%05s", $awal);
                                                    $no_nota="PDN".$kd;
                                                    mysql_free_result($result);
                                                ?>
                                                <input type="text" name="nota" class="form-control input-sm" id="nota"  value="<?php echo $no_nota; ?>" readonly>
                                            </div>
                                            <label for="tanggal" class="col-xs-2 control-label">Tanggal </label>
                                            <div class="col-xs-4">
                                                <input type="text" name="tgl" class="form-control input-sm" id="tglpemasukan"  required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-2 control-label">Member</label>
                                            <div class="col-xs-4 ">
                                                <select class ="form-control" data-placeholder="- Pilih Member -"  id="membertrx" name="member" required="required">
                                                    <option selected value="0"></option>
                                                    <?php
                                                    $result=mysql_query("select * from member where visible='1'");
                                                    while($cp = mysql_fetch_array($result))
                                                    {?>
                                                    <option value="<?php echo $cp['idmember']; ?>"><?php echo $cp['nama'] ; ?></option>
                                                    <?php
                                                    }
                                                    mysql_free_result($result);?>
                                                </select>
                                            </div>
                                            <label class="col-xs-2 control-label">Shift</label>
                                            <div class="col-xs-4 ">
                                                <select class ="form-control" name="shift" required="required">
                                                    <option selected disabled value="">Shift</option>
                                                    <option value="1">SATU</option>
                                                    <option value="2">DUA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-xs-2 col-sm-offset-6 control-label">Total</label>
                                            <div class="col-sm-4 ">
                                                <?php
                                                    $result = mysql_query("SELECT sum(total) as tot_jasa FROM trxjasa_temp where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
                                                    $trxjasa_temp = mysql_fetch_array($result);
                                                    mysql_free_result($result);
                                                    $tot_jasa = $trxjasa_temp['tot_jasa'];

                                                    $result = mysql_query("SELECT sum(total) as tot_barang FROM trxbarang_temp where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
                                                    $trxbarang_temp = mysql_fetch_array($result);
                                                    mysql_free_result($result);
                                                    $tot_barang = $trxbarang_temp['tot_barang'];
                                                    $total = $tot_jasa + $tot_barang
                                                ?>
                                                <input type="number" name="tot_transaksi" class="form-control" placeholder="Total" required="required" value="<?php echo number_format($total,0,',','.') ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Paket</label>
                                            <div class="col-sm-9">
                                            <?php
                                                $result = mysql_query("SELECT transaksi_temp_idtransaksi_temp as ID FROM trxjasa_temp where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
                                                $trxjasa_temp = mysql_fetch_array($result);
                                                mysql_free_result($result);
                                                $test1 = $trxjasa_temp['ID'];
                                                if (!empty($test1)) {
                                                    ?>
                                                <div class="table-responsive table-bordered">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th><strong>Harga</strong></th>
                                                                <td class="col-md-2"><strong>QTY</strong></td>
                                                                <th><strong>Total</strong></th>
                                                                <td class="col-md-1"><strong>Del</strong></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            $no = '0';
                                                            $result = mysql_query("SELECT a.idtrxjasa_temp,b.nama,a.harga,a.qty,a.total,a.transaksi_temp_idtransaksi_temp 
                                                                    FROM trxjasa_temp a inner join paket b on a.paket_idpaket=b.idpaket and a.transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
                                                            while($row=mysql_fetch_array($result))
                                                            {
                                                            $no++
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $no; ?></td>
                                                                <td><?php echo $row['nama'];?></td>
                                                                <td><?php echo $row['harga'];?></td>
                                                                <td><?php echo $row['qty'];?></td>
                                                                <td><?php echo number_format($row['total'],0,',','.') ?></td>
                                                                <td align="center">
                                                                    <A HREF="prosestransaksi.php?id=<?php echo $row['idtrxjasa_temp'] ?>&skac=<?php echo $idtransaksitemp ; ?>&proses=paket" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")'>
                                                                        <i class="fa fa-times"></i>
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
                                                <?php
                                                }
                                            ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Produk</label>
                                            <div class="col-sm-9">
                                            <?php
                                                $result = mysql_query("SELECT transaksi_temp_idtransaksi_temp as ID FROM trxbarang_temp where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
                                                $trxjasa_temp = mysql_fetch_array($result);
                                                mysql_free_result($result);
                                                $test = $trxjasa_temp['ID'];
                                                if (!empty($test)) {
                                                    ?>
                                                <div class="table-responsive table-bordered">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th><strong>Harga</strong></th>
                                                                <td class="col-md-2"><strong>QTY</strong></td>
                                                                <th><strong>Total</strong></th>
                                                                <td class="col-md-1"><strong>Del</strong></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            $no = '0';
                                                            $result = mysql_query("SELECT a.idtrxbarang_temp,b.nama,a.harga,a.qty,a.total,a.transaksi_temp_idtransaksi_temp 
                                                                    FROM trxbarang_temp a inner join barang b on a.barang_idbarang=b.idbarang and a.transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
                                                            while($row=mysql_fetch_array($result))
                                                            {
                                                            $no++
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $no; ?></td>
                                                                <td><?php echo $row['nama'];?></td>
                                                                <td><?php echo $row['harga'];?></td>
                                                                <td><?php echo $row['qty'];?></td>
                                                                <td><?php echo number_format($row['total'],0,',','.') ?></td>
                                                                <td align="center">
                                                                    <A HREF="prosestransaksi.php?id=<?php echo $row['idtrxbarang_temp'] ?>&skac=<?php echo $idtransaksitemp ; ?>&proses=barang" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")'>
                                                                        <i class="fa fa-times"></i>
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
                                                <?php
                                                }
                                            ?>
                                            </div>
                                        </div>
                                        <?php 
                                        if (!empty($test1) or !empty($test)) {?>
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-warning">
                                                    <span class="fa fa-download" aria-hidden="true"> </span>Simpan
                                                </button>
                                            </div>
                                        </div>
                                        <?php 
                                        }
                                        ?>
                                      <input type="hidden" name="tot_jasa" value="<?php echo $tot_jasa; ?>">
                                      <input type="hidden" name="tot_barang" value="<?php echo $tot_barang; ?>">
                                      <input type="hidden" name="idtransaksitemp" value="<?php echo $idtransaksitemp; ?>">
                                      <input type="hidden" name="proses" value="pemasukan">
                                    </form>
                                </div>
                            </div>
                        </div><!-- panel-body end-->
                    </div> <!-- /.panel end -->
                </div> 
            </td>
        </tr>
        <tr>
            <td valign="top">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tambahkan Pembelian Produk
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" >
                            <form class="form-horizontal" role="form" action="prosestransaksi.php" method="post">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Produk</label>
                                    <div class="col-sm-8 col-md-offset-1">
                                        <select class ="form-control" name="barang" required="required">
                                            <option selected disabled value="">Pilih Produk</option>
                                            <?php
                                            $result=mysql_query("select * from barang where visible='1'");
                                            while($cp = mysql_fetch_array($result))
                                            {?>
                                            <option value="<?php echo $cp['idbarang']; ?>"><?php echo $cp['nama'] ; ?></option>
                                            <?php
                                            }
                                            mysql_free_result($result);?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">QTY</label>
                                    <div class="col-sm-8 ">
                                        <input type="number" name="qty" class="form-control" placeholder="Jumlah" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-9">
                                        <button type="submit" class="btn btn-outline btn-default">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah
                                        </button>
                                    </div>
                              </div>
                              <input type="hidden" name="idtransaksitemp" value="<?php echo $idtransaksitemp; ?>">
                              <input type="hidden" name="proses" value="barang">
                            </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

