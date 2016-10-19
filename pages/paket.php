<?php
include 'koneksi.php';
include 'cek.php';
if (!isset($_GET['idpkt'])) {
    $nama='';
    $harga='';
    $service1='';
    $service2='';
    $baru='1';
}else{
    $baru='0';
    $kd_pkt = $_GET['idpkt'];
    $result = mysql_query("SELECT * FROM paket where idpaket='$kd_pkt'");
        $paket = mysql_fetch_array($result);
        mysql_free_result($result);
    $nama=$paket['nama'];
    $harga=$paket['harga'];
    $service1=$paket['service1'];
    $service2=$paket['service2'];
    $service3=$paket['service3'];
    $service4=$paket['service4'];
    $service5=$paket['service5'];
}
?>
<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Halaman Paket</h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
<?php
    if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
    <div class="col-sm-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Input Paket
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" >
                <form class="form-horizontal" role="form" action="prosesataz.php" method="post">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <?php 
                            if (empty($nama)) {?>
                                <input type="text" name="nama" class ="form-control" placeholder="Nama Paket" required="required" value="<?php echo $nama;?>">
                                <?php
                            }else{?>
                                <input type="text" name="nama" class ="form-control" placeholder="Nama Paket" required="required" value="<?php echo $nama;?>" readonly/>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12" align="right">
                            <input type="number" name="harga" class ="form-control" placeholder="Harga" required="required" value="<?php echo $harga;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">                           
                            <?php 
                            if (empty($service1)) {?>
                            <select class ="form-control" data-placeholder="Service 1"  id="servicesatu" name="service1" required="required">
                                <option selected value=""></option>
                                <?php
                                $result=mysql_query("select * from jasa where visible='1'");
                                while($cp = mysql_fetch_array($result))
                                {?>
                                <option value="<?php echo $cp['nama']; ?>"><?php echo $cp['nama'] ; ?></option>
                                <?php
                                }
                                mysql_free_result($result);?>
                            </select><?php
                            }else{?>
                                <input type="text" name="service1" class ="form-control" required="required" value="<?php echo $service1;?>" readonly/>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <?php 
                            if (empty($nama)) {?>
                            <select class ="form-control" data-placeholder="Service 2"  id="servicedua" name="service2">
                                <option selected value=""></option>
                                <?php
                                $result=mysql_query("select * from jasa where visible='1'");
                                while($cp = mysql_fetch_array($result))
                                {?>
                                <option value="<?php echo $cp['nama']; ?>"><?php echo $cp['nama'] ; ?></option>
                                <?php
                                }
                                mysql_free_result($result);?>
                            </select><?php
                            }else{?>
                                <input type="text" name="service2" class ="form-control" required="required" value="<?php echo $service2;?>" readonly/>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <?php 
                            if (empty($nama)) {?>
                            <select class ="form-control" data-placeholder="Service 3"  id="servicetiga" name="service3">
                                <option selected value=""></option>
                                <?php
                                $result=mysql_query("select * from jasa where visible='1'");
                                while($cp = mysql_fetch_array($result))
                                {?>
                                <option value="<?php echo $cp['nama']; ?>"><?php echo $cp['nama'] ; ?></option>
                                <?php
                                }
                                mysql_free_result($result);?>
                            </select><?php
                            }else{?>
                                <input type="text" name="service3" class ="form-control" required="required" value="<?php echo $service3;?>" readonly/>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <?php 
                            if (empty($nama)) {?>
                            <select class ="form-control" data-placeholder="Service 4"  id="serviceempat" name="service4">
                                <option selected value=""></option>
                                <?php
                                $result=mysql_query("select * from jasa where visible='1'");
                                while($cp = mysql_fetch_array($result))
                                {?>
                                <option value="<?php echo $cp['nama']; ?>"><?php echo $cp['nama'] ; ?></option>
                                <?php
                                }
                                mysql_free_result($result);?>
                            </select><?php
                            }else{?>
                                <input type="text" name="service4" class ="form-control" required="required" value="<?php echo $service4;?>" readonly/>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <?php 
                            if (empty($nama)) {?>
                            <select class ="form-control" data-placeholder="Service 5"  id="membertrx" name="service5">
                                <option selected value=""></option>
                                <?php
                                $result=mysql_query("select * from jasa where visible='1'");
                                while($cp = mysql_fetch_array($result))
                                {?>
                                <option value="<?php echo $cp['nama']; ?>"><?php echo $cp['nama'] ; ?></option>
                                <?php
                                }
                                mysql_free_result($result);?>
                            </select><?php
                            }else{?>
                                <input type="text" name="service5" class ="form-control" required="required" value="<?php echo $service5;?>" readonly/>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-9">
                            <button type="submit" class="btn btn-warning btn-xs"><i class="fa fa-plus"></i> Simpan Paket</button>
                        </div>
                    </div>
                  <?php
                    if ($baru=='1') {?>
                        <input type="hidden" name="proses" value="paket"><?php
                    }else{?>
                        <input type="hidden" name="idpaket" value="<?php echo $kd_pkt; ?>">
                        <input type="hidden" name="proses" value="updatepaket"><?php                      
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
    <div class="col-lg-9">
        <div class="panel panel-success">
            <div class="panel-heading">
                Data Paket Ataz Barbershop
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Paket</th>
                                <td><strong>Harga</strong></td>
                                <td><strong>Servis 1</strong></td>
                                <td><strong>Servis 2</strong></td>
                                <td><strong>Servis 3</strong></td>
                                <td><strong>Servis 4</strong></td>
                                <td><strong>Servis 5</strong></td>
                                <?php
                                    if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
                                   
                                    <td align="right"><strong>Panel</strong></td>
                                    <?php
                                    }
                                ?>

                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = '0';
                        $result = mysql_query("SELECT * from paket where visible='1' ORDER BY nama");
                        while($row=mysql_fetch_array($result))
                        {
                            $no++;
                            $warna = "info";
                            if($no % 2 == 0){
                            $warna = "";
                            }?>
                            <tr class="<?php //echo $warna ;?>">
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row['nama'];?></td>
                                <td align="right"><?php echo number_format($row['harga'],0,',','.') ?></td>
                                <td><?php echo $row['service1'];?></td>
                                <td><?php echo $row['service2'];?></td>
                                <td><?php echo $row['service3'];?></td>
                                <td><?php echo $row['service4'];?></td>
                                <td><?php echo $row['service5'];?></td>
                                <?php
                                    if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
                                    <td align="center">
                                        <A HREF="index.php?cp=paket&idpkt=<?php echo $row['idpaket'] ?>" title="Edit">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </A> |
                                        <A HREF="prosesataz.php?id=<?php echo $row['idpaket'] ?>&proses=paket" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")' title="Hapus">
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

<div class="row">

</div>
