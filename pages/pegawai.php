<head>
 <script src="../dist/jquery/jquery.min.js"></script>

 <script type="text/javascript">
    $(document).on("click", ".open-AddBookDialog", function () {
         var id = $(this).data('id');
         var nama = $(this).data('nama');
         var no_hp = $(this).data('no_hp');
         var tgllahir = $(this).data('tgl_lahir');
         var alamat = $(this).data('alamat');
         var posisi = $(this).data('posisi');
         var username = $(this).data('username');
         var password = $(this).data('password');
         $(".modal-body #idpegawai").val( id );
         $(".modal-body #nama").val( nama );
         $(".modal-body #no_hp").val( no_hp );
         $(".modal-body #tgllahir").val( tgllahir );
         $(".modal-body #alamat").val( alamat );
         $(".modal-body #posisi").val( posisi );
         $(".modal-body #username").val( username );
         $(".modal-body #password").val( password );
         $(".modal-body #nama").attr('readonly',true);
    });
 </script>
 <style type="text/css">
  .modal-dialog {
    width: 980px;
    margin: 30px auto;
  }
  .modal-dialog2 {
    width: 300px;
    margin: 30px auto;
  }
 </style>
</head>
<?php
include 'koneksi.php';
include '../dist/DateToIndo.php';
include 'cek.php';
?>


<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Data Crew Ataz Barbershop</h3>
    </div>
</div>

<div class="row">
    <!-- Button trigger modal -->
    <?php
        if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
        <div class="col-lg-8">
            <h3> 
                <a href="#responsive" id="0" class="btn btn-warning col-lg-3" data-toggle="modal" data-target="#responsive">
                    <strong> <span class="glyphicon glyphicon-plus"></span> Tambah Crew </strong>
                </a>
                <a href="#inputgaji" id="0" class="col-md-3 col-md-offset-1 btn btn-warning" data-toggle="modal" data-target="#inputgaji">
                    <span class="fa fa-pencil"></span> <b>Input Gaji</b>
                </a>
                <a href="slipgaji" id="0" class="col-md-3 col-md-offset-1 btn btn-warning">
                    <span class="fa fa-pencil"></span> <b>Slip Gaji</b>
                </a>
            </h3> 
        </div>
        <?php
        }
    ?>
    <!-- Modal -->
    <div class="modal fade" id="responsive" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <form class="form-horizontal" role="form" action="prosesataz.php" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Input Member </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-7">
                            <input type="text" name="nama" id="nama" class="form-control " placeholder="Nama" value=""  required="required"> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">tgl Lahir</label>
                        <div class="col-sm-7">
                            <input type="text" name="tgl_lahir" class="form-control" id="tgllahir" placeholder="Tanggal Lahir" value="" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">No Hp</label>
                        <div class="col-sm-7">
                            <input type="number" name="no_hp" id="no_hp" class="form-control" placeholder="No Handphone" value="" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                        <div class="col-sm-7">
                            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat" value="" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Level</label>
                        <div class="col-sm-7">
                            <input type="text" name="posisi" id="posisi" class="form-control" placeholder="Posisi" value="" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-7">
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-7">
                            <input type="text" name="password" id="password" class="form-control" placeholder="Password" value="" required="required">
                        </div>
                    </div>
                   <div class="form-group">
                        <div class="col-sm-7">
                            <input type="hidden" name="idpegawai" id="idpegawai" class="form-control" placeholder="Password" value="" required="required">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="javascript:window.location.reload()"  class="col-md-3 col-md-offset-3 btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="col-md-3 col-md-offset-2 btn btn-warning">Save changes</button>
                </div>
                <input type="hidden" name="proses" value="pegawai">
            </div> <!-- /.modal-content -->
        </form>
      </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal Pertama Edit (jadwal Edit) -->
    <div class="modal fade" id="inputgaji" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog2">
        <form class="form-horizontal" role="form" action="inputgaji" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">PILIH Karyawan</h4>
                </div>
                <div class="modal-body">
                    <div class="controls">
                           <select class ="form-control" name="pegawai" id="pegawai" required="required">
                                <option selected value="">Nama pegawai</option>
                                <?php
                                $result=mysql_query("SELECT * FROM pegawai where visible='1'");
                                while($cp = mysql_fetch_array($result))
                                {?>
                                <option value="<?php echo $cp['idpegawai'];?>"><?php echo $cp['nama'] ; ?></option>
                                <?php
                                }
                                mysql_free_result($result);?>
                            </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Select</button>
                </div>
            </div> <!-- /.modal-content -->
        </form>
      </div>
    </div>
    <!-- Modal Pertama Edit End -->
</div>
<br>
<div class="row">
    <!-- /.col-lg-6 (nested) -->
    <div class="col-lg-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                Data Crew
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive table-bordered">
                    <table class="table table-striped table-bordered table-hover" id="pegawai">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="col-md-2">Name</th>
                                <th>No Hape</th>
                                <th class="col-md-2">Tgl Lahir</th>
                                <th class="col-md-4">Alamat</th>
                                <th>Level</th>
                                <?php
                                    if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
                                <th>Username</th>
                                <th>Password</th>
                                    <th>Panel</th>
                                    <?php
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = '0';
                        $result = mysql_query("SELECT * FROM pegawai where aktif='1' and visible='1'");
                        while($row=mysql_fetch_array($result))
                        {
                            $tgl = $row['tgl_lahir'];
                            $tgllahir =date('d/m/Y', strtotime($tgl));
                        $no++
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row['nama'];?></td>
                                <td><?php echo $row['no_hp'];?></td>
                                <td><?php echo(DateToIndo($tgl));?></td>
                                <td><?php echo $row['alamat'];?></td>
                                <td><?php echo $row['level'];?></td>
                                <?php
                                    if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
                                <td><?php echo $row['username'];?></td>
                                <td><?php echo $row['password'];?></td>
                                    <td align="center">
    <a data-toggle="modal" title="Edit"
    data-id="<?php echo $row['idpegawai'] ?>" 
    data-nama="<?php echo $row['nama'] ?>" 
    data-no_hp="<?php echo $row['no_hp'] ?>" 
    data-tgl_lahir="<?php echo $tgllahir; ?>" 
    data-alamat="<?php echo $row['alamat'] ?>" 
    data-posisi="<?php echo $row['level'] ?>" 
    data-username="<?php echo $row['username'] ?>" 
    data-password="<?php echo $row['password'] ?>" 
    class="open-AddBookDialog" href="#responsive"><i class="fa fa-pencil-square-o"></i>
    </a> |
                                        <A HREF="prosesataz.php?id=<?php echo $row['idpegawai'] ?>&proses=pegawai" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")' title="Delete">
                                            <i class="fa fa-trash-o"></i>
                                        </A>
                                    </td>
                                    <?php
                                    }
                                ?>
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
    <!-- /.col-lg-6 (nested) -->
</div>



