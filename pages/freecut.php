<?php
include 'koneksi.php';
include 'cek.php';
?>


<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Data Member yang Free Cut</h3>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Member
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="prosestransaksi.php" method="post">
                    <div class="form-group">
                        <div class="col-xs-3 col-md-offset-9">
                            <input type="text" name="tgl" class="form-control input-sm" id="tglpemasukan" placeholder="Tanggal Harus di isi" required="required">
                        </div>
                    </div>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="member">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="col-md-1">N.M</th>
                                    <th class="col-md-3">Nama</th>
                                    <th>Jumlah Nota</th>
                                    <th >Bonus Pangkas</th>
                                    <th >Digunakan</th>
                                    <th >Panel</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = '0';
                                $result = mysql_query("SELECT b.idmember,b.freepangkas,b.nomember,b.bonus,b.nama,count(*) as jumlah
                                            FROM transaksi a inner join member b on a.member_idmember=b.idmember
                                            and b.visible=1
                                            and a.tot_trxjasa not like 0 
                                            group by nama");
                                while($row=mysql_fetch_array($result))
                                {
                                    $bonus = $row['bonus'];
                                $no++
                                ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $row['nomember'];?></td>
                                    <td><?php echo $row['nama'];?></td>
                                    <td><?php echo $row['jumlah'];?></td>
                                    <td><?php echo $row['bonus'];?></td>
                                    <td><?php echo $row['freepangkas'];?></td>
                                    <td align="center">
                                        <?php 
                                            if ($bonus>'0') {?>
                                            <input name="proses" type="hidden" value="freecut">
                                            <button type="submit" name="idmember" class="btn btn-danger btn-xs" value="<?php echo $row['idmember'] ?>">
                                                Gunakan
                                            </button>
                                        <?php
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php 
                                }
                                mysql_free_result($result);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div> <!-- end panel body -->
        </div><!-- end panel -->
    </div>
</div>

