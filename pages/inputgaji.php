<?php  
date_default_timezone_set('Asia/Jakarta');
include 'koneksi.php';
include 'cek.php';
$idpegawai  = $_REQUEST['pegawai'];
$idpengeluarantemp = $_GET['skac'];
if(empty($idpengeluarantemp)){
date_default_timezone_set("Asia/Jakarta");
$tgl=date('Y-m-d');
$query=mysql_query("INSERT INTO pengeluaran_temp(tgl) VALUES ('$tgl')");
    $result = mysql_query("SELECT max(idpengeluaran_temp) as ID FROM pengeluaran_temp;");
    $pengeluarantemp = mysql_fetch_array($result);
    mysql_free_result($result);
    $idpengeluarantemp = $pengeluarantemp['ID'];
 header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
}

$jeneng = $_SESSION['jenengataz'];
$jenengawal=str_word_count($jeneng, 1);
$tgl=date('d/m/Y');
if (!isset($_SESSION['shift'])) {
$shift='4';
} else {
    $shift = $_SESSION['shift'];
}

if ($shift=='1') {
    $shift_tampil='PAGI';
}elseif ($shift=='2') {
    $shift_tampil='DUA';
}elseif ($shift=='3') {
    $shift_tampil='SORE';
}else{
    $shift_tampil='Admin';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Input Gaji dan Kasbon</h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <?php

            $result=mysql_query("SELECT * FROM pegawai WHERE idpegawai='$idpegawai'");
            $pegawai = mysql_fetch_array($result);
            mysql_free_result($result);
            $nama=$pegawai['nama'];
            $level=$pegawai['level'];
    ?>
    <div class="col-sm-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Input Gaji 
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" >
            <form class="form-horizontal" role="form" action="prosesgaji.php" method="post">
            <div class="form-group">
                <div class="col-sm-12">
                <input type="text" name="nama" class ="form-control" required="required" value="<?php echo $nama;?>" readonly/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                <input type="text" name="level" class ="form-control" required="required" value="<?php echo $level;?>" readonly/>
                </div>
            </div>   
            <div class="form-group">
                <div class="col-sm-12">
                    <select class ="form-control" name="detailgaji" id="detailgaji" required="required">
                        <option selected value="">Jenis</option>
                        <option value="pokok">Gaji Pokok</option>
                        <option value="bonus">Bonus</option>
                        <option value="overtime">Over Time</option>
                        <option value="makan">Makan</option>
                        <option value="transport">Transport</option>
                        <option value="hariraya">Hari Raya</option>
                        <option value="kesehatan">Kesehatan</option>
                        <option value="nikah">Nikah</option>
                        <option value="dukacita">Duka Cita</option>
                        <option value="kasbon">Kasbon</option>
                        <option value="pulsa">Pulsa</option>
                    </select>
                </div>
            </div>  
            <div class="form-group">
                <div class="col-sm-12">
                <input type="number" name="total" id="total" class="form-control" placeholder="Total" required="required">
                </div>
            </div> 

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-9">
                            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Tambah</button>
                        </div>
                    </div>  
            <input type="hidden" name="idpengeluarantemp" value="<?php echo $idpengeluarantemp; ?>">
            <input type="hidden" name="idpegawai" value="<?php echo $idpegawai; ?>">
            <input type="hidden" name="idbiaya" value="2">  
            <input type="hidden" name="jenisbiaya" value="tetap">       
            </form>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>

     <div class="col-lg-7">
        <div class="panel panel-success">
            <div class="panel-heading">
                Input Gaji Karyawan 
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="prosesgaji.php" method="post">
                    <div class="form-group">
                        <div class="col-xs-4">
                            <fieldset disabled>
                                <select class ="form-control" name="" required="required">
                                <option value="<?php echo $shift; ?>"><?php echo "".$jenengawal[0]." / ".$shift_tampil."";?></option>
                            <!--<option value="1">SATU</option>
                                <option value="2">DUA</option> -->
                                </select>
                            </fieldset>
                            <input type="hidden" name="shift" value="<?php echo $shift;?>">
                            <input type="hidden" name="user" value="<?php echo $jenengawal[0];?>">
                        </div>
                        <div class="col-xs-3">
                        <?php
                            if (($_SESSION['levelataz']) == "owner ataz" or ($_SESSION['levelataz']) == "manager ataz") { ?>
                                <input type="text" name="tgl" class="form-control input-sm" id="tglakhir" placeholder="Tanggal" required="required">
                            <?php
                            }else{?>
                                <input type="text" name="tgl" class="form-control" value="<?php echo $tgl ;?>" readonly>
                            <?php
                            }
                        ?>
                        </div>
                        <div class="col-xs-4 col-xs-offset-1 ">
                            <?php
                                $result=mysql_query("SELECT sum(total) as total FROM gaji_temp where pengeluaran_temp_idpengeluaran_temp='$idpengeluarantemp'"); 
                                $cp = mysql_fetch_array($result);
                                mysql_free_result($result);
                            ?>
                            <input type="text" name="total" class="form-control" placeholder="Total" value="<?php echo number_format($cp['total'],0,',','.') ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                                <?php
                                    $result = mysql_query("SELECT idgaji_temp as ID
                                                            FROM gaji_temp
                                                            where pengeluaran_temp_idpengeluaran_temp='$idpengeluarantemp'");
                                    $detailpengeluaran_temp = mysql_fetch_array($result);
                                    mysql_free_result($result);
                                    $testtetap = $detailpengeluaran_temp['ID'];
                                    if (!empty($testtetap)) {
                                ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td width="265"><strong>Keterangan</strong></td>
                                            <td width="50"><strong>Total</strong></td>
                                            <td align="center">Del</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $no = '0';
                                        $result = mysql_query("SELECT idgaji_temp as ID,total,jenis FROM gaji_temp p where pengeluaran_temp_idpengeluaran_temp='$idpengeluarantemp'");
                                        while($row=mysql_fetch_array($result))
                                        {
                                        $no++
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td width="265"><?php echo $row['jenis'];?></td>
                                            <td width="50" align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
                                            <td align="center">
                                                <A HREF="prosesgaji.php?id=<?php echo $row['ID'] ?>&skac=<?php echo $idpengeluarantemp ; ?>&pegawai=<?php echo $idpegawai ; ?>" onclick='return confirm("Hapus <?php echo $row['jenis']?> ?")'>
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
                    </div><!--tetap end -->
                    <?php 
                        if (!empty($testtetap)) {?>
                    <div class="form-group">
                        <div class="col-sm-3 col-sm-offset-9">
                            <button type="submit" class="btn btn-warning">
                                <span class="fa fa-download" aria-hidden="true"></span> Simpan
                            </button>
                        </div>
                    </div>
                        <?php 
                        }
                    ?>
                    <input type="hidden" name="idpengeluarantemp" value="<?php echo $idpengeluarantemp; ?>">
                    <input type="hidden" name="simpangaji" value="simpangaji">
                </form>
            </div>
        </div>
    </div>   
</div>

</body>
</html>