<?php  
date_default_timezone_set('Asia/Jakarta');
include 'ceklevel.php';
include 'koneksi.php';

$idbudgettemp = $_GET['skac'];
if(empty($idbudgettemp)){
date_default_timezone_set("Asia/Jakarta");
$tgl=date('Y-m-d');
$query=mysql_query("INSERT INTO budget_temp(tgl) VALUES ('$tgl')");
    $result = mysql_query("SELECT max(idbudget_temp) as ID FROM budget_temp;");
    $budgettemp = mysql_fetch_array($result);
    mysql_free_result($result);
    $idbudgettemp = $budgettemp['ID'];
 header("Location: index.php?cp=budget&skac=$idbudgettemp");
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
<script type="text/javascript">
    function FilterPrint(){
        document.body.style.cursor='auto';
        var ValueJenisItem = document.getElementById("jenis").value;
    if (ValueJenisItem == 'kosong'){
            document.getElementById("barisTetap").style.display = 'none';
            document.getElementById("barisPerlengkapan").style.display = 'none';
            document.getElementById("barisBelanja").style.display = 'none';
            document.getElementById("barisLain").style.display = 'none';
            document.getElementById("barisTotal").style.display = 'none';
        } else if (ValueJenisItem == 'tetap'){
            document.getElementById("barisTetap").style.display = '';
            document.getElementById("barisPerlengkapan").style.display = 'none';
            document.getElementById("barisBelanja").style.display = 'none';
            document.getElementById("barisLain").style.display = 'none';
            document.getElementById("barisTotal").style.display = '';
        } else if (ValueJenisItem == 'perlengkapan'){
            document.getElementById("barisTetap").style.display = 'none';
            document.getElementById("barisPerlengkapan").style.display = '';
            document.getElementById("barisBelanja").style.display = 'none';
            document.getElementById("barisLain").style.display = 'none';
            document.getElementById("barisTotal").style.display = '';
            document.getElementById("barisGaji").style.display = 'none';
            document.getElementById("pegawai").required = false;
            document.getElementById("private").required = false;
        }  else if (ValueJenisItem == 'belanja'){
            document.getElementById("barisTetap").style.display = 'none';
            document.getElementById("barisPerlengkapan").style.display = 'none';
            document.getElementById("barisBelanja").style.display = '';
            document.getElementById("barisLain").style.display = 'none';
            document.getElementById("barisTotal").style.display = '';
            document.getElementById("barisGaji").style.display = 'none';
            document.getElementById("pegawai").required = false;
            document.getElementById("private").required = false;
        } else {
            document.getElementById("barisTetap").style.display = 'none';
            document.getElementById("barisPerlengkapan").style.display = 'none';
            document.getElementById("barisBelanja").style.display = 'none';
            document.getElementById("barisLain").style.display = '';
            document.getElementById("barisTotal").style.display = '';
            document.getElementById("barisGaji").style.display = 'none';
            document.getElementById("pegawai").required = false;
            document.getElementById("private").required = false;
        };
    }
</script>

<script type="text/javascript">
        function FilterGaji(){
            //document.body.style.cursor='auto';
            //var ValueGaji = document.getElementById("idbiaya").value;
            var ValueTetap = parseInt(document.getElementById("idtetap").value);
        if (ValueTetap ==2){

                document.getElementById("barisPrivate").style.display = 'none';
                document.getElementById("pegawai").required = true;
                document.getElementById("private").required = false;
            } else if(ValueTetap ==40){

                document.getElementById("barisPrivate").style.display = '';
                document.getElementById("pegawai").required = false;
                document.getElementById("private").required = true;
            }
             else {

                document.getElementById("barisPrivate").style.display = 'none';
                document.getElementById("pegawai").required = false;
                document.getElementById("private").required = false;
            };
        }
</script>

<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Halaman Budget </h3>
    </div>
</div>

        <div class="col-lg-12">
            <h3> 
                <a href="showbudget" id="0" class="btn btn-warning">
                    <span class="fa fa-pencil"></span> <b>Show Budget</b>
                </a>
            </h3> 
        </div>

<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                Tambah Biaya
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" >
                <form class="form-horizontal" role="form" action="prosesbudget.php" method="post">
                    <div class="form-group">
                         <div class="col-sm-8 col-md-offset-2">
                            <select class ="form-control" name="jenis" id="jenis" required="required" onchange="FilterPrint();">
                                <option selected value="kosong">Pilih Jenis</option>
                                <option value="tetap">Biaya Tetap</option>
                                <option value="perlengkapan">Biaya Perlengkapan</option>
                                <option value="belanja">Biaya Belanja Barang</option>
                                <option value="lain-lain">Biaya Lain-Lain</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;" id="barisTetap">
                         <div class="col-sm-8 col-md-offset-2">
                            <select class ="form-control" name="idbiaya" id="idtetap" onchange="FilterGaji();">
                                <option selected disabled value="">Pilih Biaya</option>
                                <?php
                                $result=mysql_query("SELECT * FROM biaya where tetap is not null and idbiaya <> 40 order by nama");
                                while($cp = mysql_fetch_array($result))
                                {?>
                                <option value="<?php echo $cp['idbiaya']; ?>"><?php echo $cp['nama'] ; ?></option>
                                <?php
                                }
                                mysql_free_result($result);?>
                            </select>
                         </div>
                    </div>
                    <div class="form-group"  style="display:none;" id="barisPrivate">
                         <div class="col-sm-8 col-md-offset-2">
                            <input type="text" name="private" id="private" class="form-control" placeholder="Keterangan"> 
                         </div>
                    </div>


                    <div class="form-group" style="display:none;" id="barisPerlengkapan">
                         <div class="col-sm-8 col-md-offset-2">
                            <select class ="form-control" name="idbiaya">
                                <option selected disabled value="">Pilih Biaya</option>
                                <?php
                                $result=mysql_query("SELECT * FROM biaya where perlengkapan is not null and visible='1' order by nama");
                                while($cp = mysql_fetch_array($result))
                                {?>
                                <option value="<?php echo $cp['idbiaya']; ?>"><?php echo $cp['nama'] ; ?></option>
                                <?php
                                }
                                mysql_free_result($result);?>
                            </select>
                         </div>
                    </div>
                    <div class="form-group" style="display:none;" id="barisBelanja">
                         <div class="col-sm-8 col-md-offset-2">
                            <select class ="form-control" name="idbiaya">
                                <option selected disabled value="">Pilih Biaya</option>
                                <?php
                                $result=mysql_query("SELECT * FROM biaya where belanja is not null and visible='1' order by nama");
                                while($cp = mysql_fetch_array($result))
                                {?>
                                <option value="<?php echo $cp['idbiaya']; ?>"><?php echo $cp['nama'] ; ?></option>
                                <?php
                                }
                                mysql_free_result($result);?>
                            </select>
                         </div>
                    </div>
                    <div class="form-group" style="display:none;" id="barisLain">
                         <div class="col-sm-8 col-md-offset-2">
                            <input type="text" name="keterangan" class="form-control" placeholder="Keterangan">
                         </div>
                    </div>
                    <div class="form-group" style="display:none;" id="barisTotal">
                        <div class="col-sm-8 col-md-offset-2">
                            <input type="number" name="total" id="total" class="form-control" placeholder="Total" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-9">
                            <button type="submit" class="btn btn-outline btn-default" name="tambah" id="tambah" onClick="addTableRow($('#myTable')); hitTotal()">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="idbudgettemp" value="<?php echo $idbudgettemp; ?>">
                    <input type="hidden" name="proses" value="budget">
                </form>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.col-lg-6 (nested) -->
    <div class="col-lg-7">
        <div class="panel panel-success">
            <div class="panel-heading">
                Input Budget Ataz Barbershop
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="prosesbudget.php" method="post">
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
                                <input type="text" name="tgl" class="form-control input-sm" id="tgllaporan" placeholder="Bulan" required="required">
                            <?php
                            }else{?>
                                <input type="text" name="tgl" class="form-control" value="<?php echo $tgl ;?>" readonly>
                            <?php
                            }
                        ?>
                        </div>
                        <div class="col-xs-4 col-xs-offset-1 ">
                            <?php
                                $result=mysql_query("SELECT sum(total) as total FROM detail_budget_temp where budget_temp_idbudget_temp='$idbudgettemp'"); 
                                $cp = mysql_fetch_array($result);
                                mysql_free_result($result);
                            ?>
                            <input type="text" name="total" class="form-control" placeholder="Total" value="<?php echo number_format($cp['total'],0,',','.') ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                                <?php
                                    $result = mysql_query("SELECT a.iddetail_budget_temp as ID, a.keterangan,a.total,a.jenis,b.nama 
                                                            FROM detail_budget_temp a inner join biaya b on a.biaya_idbiaya=b.idbiaya
                                                            and b.tetap is not null and a.budget_temp_idbudget_temp='$idbudgettemp'");
                                    $detailbudget_temp = mysql_fetch_array($result);
                                    mysql_free_result($result);
                                    $testtetap = $detailbudget_temp['ID'];
                                    if (!empty($testtetap)) {
                                ?>
                            <label class="col-sm-3 control-label">Tetap</label>
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
                                        $result = mysql_query("SELECT a.iddetail_budget_temp as ID,a.total,a.jenis,concat(b.nama,' ',a.keterangan) as nama FROM detail_budget_temp a inner join biaya b on a.biaya_idbiaya=b.idbiaya and b.tetap is not null and a.budget_temp_idbudget_temp='$idbudgettemp'");
                                        while($row=mysql_fetch_array($result))
                                        {
                                        $no++
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td width="265"><?php echo $row['nama'];?></td>
                                            <td width="50" align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
                                            <td align="center">
                                                <A HREF="prosesbudget.php?id=<?php echo $row['ID'] ?>&skac=<?php echo $idbudgettemp ; ?>&proses=delbudget" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")'>
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
                    <div class="form-group">
                        <div class="col-sm-12">
                                    <?php
                                        $result = mysql_query("SELECT a.iddetail_budget_temp as ID, a.keterangan,a.total,a.jenis,b.nama 
                                                                FROM detail_budget_temp a inner join biaya b on a.biaya_idbiaya=b.idbiaya
                                                                and b.perlengkapan is not null and a.budget_temp_idbudget_temp='$idbudgettemp'");
                                        $detailbudget_temp = mysql_fetch_array($result);
                                        mysql_free_result($result);
                                        $testperlengkapan = $detailbudget_temp['ID'];
                                        if (!empty($testperlengkapan)) {
                                    ?>
                                    <label for="inputEmail3" class="col-sm-3 control-label">Perlengkapan</label>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <?php
                                                $no = '0';
                                                $result = mysql_query("SELECT a.iddetail_budget_temp as ID, a.keterangan,a.total,a.jenis,b.nama 
                                                            FROM detail_budget_temp a inner join biaya b on a.biaya_idbiaya=b.idbiaya
                                                            and b.perlengkapan is not null and a.budget_temp_idbudget_temp='$idbudgettemp'");
                                                while($row=mysql_fetch_array($result))
                                                {
                                                $no++
                                            ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td width="265"><?php echo $row['nama'];?></td>
                                                <td width="50" align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
                                                <td align="center">
                                                    <A HREF="prosesbudget.php?id=<?php echo $row['ID'] ?>&skac=<?php echo $idbudgettemp ; ?>&proses=delbudget" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")'>
                                                        <i class="fa fa-times"></i>
                                                    </A>
                                                </td>
                                            </tr>
                                            <?php 
                                            }
                                            mysql_free_result($result);
                                            ?>
                                        </table>
                                    </div>
                                    <?php
                                        }
                                    ?>
                        </div>
                    </div> <!--perlengkapan end -->
                    <div class="form-group">
                        <div class="col-sm-12">
                            <?php
                                $result = mysql_query("SELECT a.iddetail_budget_temp as ID, a.keterangan,a.total,a.jenis,b.nama 
                                                        FROM detail_budget_temp a inner join biaya b on a.biaya_idbiaya=b.idbiaya
                                                        and b.belanja is not null and a.budget_temp_idbudget_temp='$idbudgettemp'");
                                $detailbudget_temp = mysql_fetch_array($result);
                                mysql_free_result($result);
                                $testbelanja = $detailbudget_temp['ID'];
                                if (!empty($testbelanja)) {
                            ?>
                            <label for="inputEmail3" class="col-sm-3 control-label">Belanja</label>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <?php
                                        $no = '0';
                                        $result = mysql_query("SELECT a.iddetail_budget_temp as ID, a.keterangan,a.total,a.jenis,b.nama 
                                                    FROM detail_budget_temp a inner join biaya b on a.biaya_idbiaya=b.idbiaya
                                                    and b.belanja is not null and a.budget_temp_idbudget_temp='$idbudgettemp'");
                                        while($row=mysql_fetch_array($result))
                                        {
                                        $no++
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td width="265"><?php echo $row['nama'];?></td>
                                        <td width="50" align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
                                        <td align="center">
                                            <A HREF="prosesbudget.php?id=<?php echo $row['ID'] ?>&skac=<?php echo $idbudgettemp ; ?>&proses=delbudget" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")'>
                                                <i class="fa fa-times"></i>
                                            </A>
                                        </td>
                                    </tr>
                                    <?php 
                                    }
                                    mysql_free_result($result);
                                    ?>
                                </table>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div> <!--belanja end -->
                    <div class="form-group">
                        <div class="col-sm-12">
                            <?php
                                $result = mysql_query("SELECT a.iddetail_budget_temp as ID, a.keterangan,a.total,a.jenis,b.nama 
                                                        FROM detail_budget_temp a inner join biaya b on a.biaya_idbiaya=b.idbiaya
                                                        and b.lain is not null and a.budget_temp_idbudget_temp='$idbudgettemp'");
                                $detailbudget_temp = mysql_fetch_array($result);
                                mysql_free_result($result);
                                $testlain = $detailbudget_temp['ID'];
                                if (!empty($testlain)) {
                            ?>
                            <label for="inputEmail3" class="col-sm-3 control-label">Lain-Lain</label>
                            <div class="table-responsive">
                                <table class="table table-striped" border="0">
                                    <?php
                                        $no = '0';
                                        $result = mysql_query("SELECT a.iddetail_budget_temp as ID, a.keterangan,a.total,a.jenis,b.nama 
                                                    FROM detail_budget_temp a inner join biaya b on a.biaya_idbiaya=b.idbiaya
                                                    and b.lain is not null and a.budget_temp_idbudget_temp='$idbudgettemp'");
                                        while($row=mysql_fetch_array($result))
                                        {
                                        $no++
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td width="265"><?php echo $row['keterangan'];?></td>
                                        <td width="50" align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
                                        <td align="center">
                                            <A HREF="prosesbudget.php?id=<?php echo $row['ID'] ?>&skac=<?php echo $idbudgettemp ; ?>&proses=delbudget" onclick='return confirm("Hapus <?php echo $row['nama']?> ?")'>
                                                <i class="fa fa-times"></i>
                                            </A>
                                        </td>
                                    </tr>
                                    <?php 
                                    }
                                    mysql_free_result($result);
                                    ?>
                                </table>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div> <!--lain-lain end -->
                    <?php 
                        if (!empty($testtetap) or !empty($testperlengkapan) or !empty($testbelanja) or !empty($testlain)) {?>
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
                    <input type="hidden" name="idbudgettemp" value="<?php echo $idbudgettemp; ?>">
                    <input type="hidden" name="proses" value="simpanbudget">
                </form>
            </div>
        </div>
    </div>
</div>


