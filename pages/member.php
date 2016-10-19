<?php
include 'koneksi.php';
include 'cek.php';
include '../dist/DateToIndo.php';
?>
<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Data Member</h3>
    </div>
</div>
<div class="row">
    <!-- Button trigger modal -->
    <div class="col-lg-6">
        <h3> 
            <a href="#dialog-barang" id="0" class="btn btn-warning" data-toggle="modal" data-target="#responsive">
                <strong> <span class="glyphicon glyphicon-plus"></span> Tambah Member </strong>
            </a>
        </h3> 
    </div>
    <!-- Modal -->
    <div class="modal fade" id="responsive" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <form class="form-horizontal" role="form" action="prosesataz.php" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Input Member Baru</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No Member</label>
                        <div class="col-md-2">
                            <input type="number" name="kode1" class="form-control" placeholder="11" value="11" readonly>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="kode2" class="form-control" placeholder="0315" value="0315" readonly>
                        </div>
                        <div class="col-sm-3">
                            <?php
                                $result=mysql_query("select MAX(RIGHT(nomember,4)) as kd_max from member"); 
                                $cp = mysql_fetch_array($result);
                                $awal=((int)$cp['kd_max'])+1;
                                $kd = sprintf("%04s", $awal);
                                $no_nota="PDN".$kd;
                                mysql_free_result($result);
                            ?>
                            <input type="number" name="kode3" class="form-control" placeholder="number" value="<?php echo $kd; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-7">
                            <input type="text" name="nama" class="form-control" placeholder="Nama" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">tgl Lahir</label>
                        <div class="col-sm-7">
                            <input type="text" name="tgl_lahir" class="form-control" id="tgllahir" placeholder="Tanggal Lahir" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">No Hp</label>
                        <div class="col-sm-7">
                            <input type="number" name="no_hp" class="form-control" placeholder="No Handphone" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                        <div class="col-sm-7">
                            <input type="text" name="alamat" class="form-control" placeholder="Alamat" required="required">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="col-md-3 col-md-offset-3 btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="col-md-3 col-md-offset-2 btn btn-warning">Save changes</button>
                </div>
                <input type="hidden" name="proses" value="member">
            </div> <!-- /.modal-content -->
        </form>
      </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Member
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-respo">
                    <table class="table table-striped table-bordered table-hover" id="member">
                        <thead>
                            <tr>
                                <th >#</th>
                                <th class="col-md-1">N.M</th>
                                <th class="col-md-4">Name</th>
                                <th>No Hape</th>
                                <th class="col-md-2">Tgl Lahir</th>
                                <th>Age</th>
                                <th class="col-md-5">Alamat</th>
                                <th >Del</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = '0';
                        $result = mysql_query("select*,YEAR(CURDATE()) - YEAR(tgl_lahir) AS umur from member where visible='1'");
                        while($row=mysql_fetch_array($result))
                        {
                            $tgl = $row['tgl_lahir'];
                            //$tanggallahir = date('j F Y',strtotime($tgl));
                        $no++
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row['nomember']?></td>
                                <td><?php echo $row['nama'];?></td>
                                <td><?php echo $row['no_hp'];?></td>
                                <td><?php echo(DateToIndo($tgl));?></td>
                                <td align="center"><?php echo $row['umur'];?></td>
                                <td><?php echo $row['alamat'];?></td>
                                <td align="center">
                                    <A HREF="prosesataz.php?id=<?php echo $row['idmember'] ?>&proses=member" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")'>
                                        <i class="fa fa-trash-o"></i>
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
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>




