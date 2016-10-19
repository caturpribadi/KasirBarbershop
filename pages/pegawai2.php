<head>


</head>
<?php
include 'koneksi.php';
include '../dist/DateToIndo.php';
include 'cek.php';



if (!isset($_GET['idpgw'])) {
    $nama='';
    $tgllahir='';
    $no_hp='';
    $alamat='';
    $baru='1';
}else{
    $baru='0';
    $kd_pgw = $_GET['idpgw'];
    $result = mysql_query("SELECT * FROM pegawai where idpegawai='$kd_pgw'");
        $pegawai = mysql_fetch_array($result);
        mysql_free_result($result);
    $nama=$pegawai['nama'];
    $tgl_lahir=$pegawai['tgl_lahir'];
    $tgllahir =date('d/m/Y', strtotime($tgl_lahir));
    $no_hp=$pegawai['no_hp'];
    $alamat=$pegawai['alamat'];
}

if (!isset($_GET['iduser'])) {
    $namauser='';
    $username='';
    $password='';
    $level='';
    $userbaru='1';
}else{
    $baru='0';
    $kd_user = $_GET['iduser'];
    $result = mysql_query("SELECT * FROM user where iduser='$kd_user'");
        $user = mysql_fetch_array($result);
        mysql_free_result($result);
    $username=$user['username'];
    $password=$user['password'];
    $level=$user['level'];
}
?>


<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Data Crew Ataz Barbershp</h3>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
<?php
    if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                Input Crew
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="prosesataz.php" method="post">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Nama</label>
                        <div class="col-sm-7">
                            <?php 
                            if (empty($nama)) {?>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" required="required" >
                                <?php
                            }else{?>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" required="required" value="<?php echo $nama;?>" readonly/>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Tgl Lahir</label>
                        <div class="col-sm-7">
                            <input type="text" name="tgl_lahir" class="form-control" id="tgllahir" placeholder="Tanggal Lahir" required="required" value="<?php echo $tgllahir;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">No Hp</label>
                        <div class="col-sm-7">
                            <input type="number" name="no_hp" class="form-control" placeholder="No Handphone" required="required" data-validation-number-message="tsdf" value="<?php echo $no_hp;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Alamat</label>
                        <div class="col-sm-7">
                            <textarea id="alamat" name="alamat" required="required"><?php echo $alamat ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-4">
                            <button type="submit" class="btn btn-warning">Simpan</button>
                        </div>
                  </div>
                  <?php
                    if ($baru=='1') {?>
                        <input type="hidden" name="proses" value="pegawai"><?php
                    }else{?>
                        <input type="hidden" name="idpegawai" value="<?php echo $kd_pgw; ?>">
                        <input type="hidden" name="proses" value="updatepegawai"><?php                      
                    }
                  ?>
                </form>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <?php
    }
?>
    <!-- /.col-lg-6 (nested) -->
    <div class="col-lg-8">
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
                                <th>Name</th>
                                <th>No Hape</th>
                                <th>Tgl Lahir</th>
                                <th class="col-md-4">Alamat</th>
                                <?php
                                    if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
                                    <th class="col-md-1">Panel</th>
                                    <?php
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = '0';
                        $result = mysql_query("select*from pegawai where visible='1'");
                        while($row=mysql_fetch_array($result))
                        {
                            $tgl = $row['tgl_lahir'];
                        $no++
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row['nama'];?></td>
                                <td><?php echo $row['no_hp'];?></td>
                                <td><?php echo(DateToIndo($tgl));?></td>
                                <td><?php echo $row['alamat'];?></td>
                                <?php
                                    if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
                                    <td align="center">
                                        <A HREF="index.php?cp=pegawai&idpgw=<?php echo $row['idpegawai'] ?>&proses=pegawai" id="<?php echo $row['idpegawai'] ?>" title="Edit">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </A> |
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

<?php
    if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Input Hak Akses Aplikasi
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="prosesataz.php" method="post">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Nama</label>
                            <div class="col-sm-7">
                                <?php 
                                if (empty($namauser)) {?>
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" required="required" >
                                    <?php
                                }else{?>
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" required="required" value="<?php echo $namauser;?>" readonly/>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Username</label>
                            <div class="col-sm-7">
                                <input type="text" name="username" class="form-control" placeholder="username" required="required" value="<?php echo $username;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-7">
                                <input type="text" name="password" class="form-control" placeholder="password" required="required" value="<?php echo $password;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Level</label>
                            <div class="col-sm-7">
                                <select class ="form-control" name="shift">
                                    <option selected value="">Jabatan</option>
                                    <option value="Barberman ataz">Barberman</option>
                                    <option value="Kramasman Atas">Kramasman</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-4">
                                <button type="submit" class="btn btn-warning">Simpan</button>
                            </div>
                      </div>
                      <?php
                        if ($baru=='1') {?>
                            <input type="hidden" name="proses" value="pegawai"><?php
                        }else{?>
                            <input type="hidden" name="idpegawai" value="<?php echo $kd_pgw; ?>">
                            <input type="hidden" name="proses" value="updatepegawai"><?php                      
                        }
                      ?>
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 (nested) -->
        <div class="col-lg-8">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Data Pengguna Aplikasi
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <table class="table table-striped table-bordered table-hover" id="pegawai">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>User</th>
                                    <th>Password</th>
                                    <th>Posisi</th>
                                    <?php
                                        if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
                                        <th>Panel</th>
                                        <?php
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = '0';
                            $result = mysql_query("SELECT * from user where visible='1'");
                            while($row=mysql_fetch_array($result))
                            {
                            $no++
                            ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $row['nama'];?></td>
                                    <td><?php echo $row['username'];?></td>
                                    <td><?php echo $row['password'];?></td>
                                    <td><?php echo $row['level'];?></td>
                                    <?php
                                        if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
                                        <td align="center">
                                            <A HREF="index.php?cp=pegawai&iduser=<?php echo $row['iduser'] ?>" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </A> |
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
    <?php
    }
?>
