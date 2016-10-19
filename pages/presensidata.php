<?php
include  "koneksi.php";
include 'ceklevel.php';
include '../dist/DayToIndo.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script src="../dist/jquery/jquery.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            $('#example').dataTable( {
                responsive: true,
                       "paging"   : false,
                 "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                                $("td:first", nRow).html(iDisplayIndex +1);
                               return nRow;
                            },
            } );
        } );
    </script>
</head>
<body>

<div class="row">
    <div class="col-lg-12" >
        <h3 class="page-header">Tabel Presensi Karyawan</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12"> 
        <div class="col-xs-8">
            <form class="form-horizontal" role="form" action="presensidata" method="post">
                <div class="form-group">
                    <div class="col-xs-5">
                        <input type="text" name="date" class="form-control input-sm" id="tgllaporan" placeholder="Bulan" required="required">
                    </div>
                    <div class="col-xs-">
                        <button type="submit" class="btn btn-outline btn-default" name="cari" id="cari" onClick="">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
if(isset($_POST['cari']))
{
    $date  =$_POST['date'];
    $bulan =date('m', strtotime(str_replace(' ','-', $date)));
    $wulan =date('F', strtotime(str_replace(' ','-', $date)));
    $tahun =date('Y', strtotime(str_replace(' ','-', $date)));
    ?>  
<div class="row">
    <div class="col-lg-2 col-sm-offset-10">
        <a href="print/presensixls.php?bulan=<?php echo $bulan; ?>&wulan=<?php echo $wulan; ?>&tahun=<?php echo $tahun; ?>" class="btn btn-outline btn-default"><i class="fa fa-print" style="font-size:150%;"></i> Save Excel</a>
    </div>
</div>
<br>
    <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                Data Presensi Ataz Barbershop
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Jumlah Jadwal</th>
                                <td><strong>Kehadiran</strong></td>
                                <td><strong>Terlambat</strong></td>
                                <td><strong>% Kehadiran</strong></td>
                                <td><strong>% Keterlambatan</strong></td>
                                <td><strong>% Disiplin</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = '0';
                        $result = mysql_query("SELECT user,count(tgl) as kehadiran FROM absensi where  durasi>'00:02:00' and month(tgl)='$bulan' and year(tgl)='$tahun' and sudahpulang='1' group by user");
                        while($row=mysql_fetch_array($result))
                        {
                            $no++;
                            $warna = "info";
                            $user =$row['user'];
                            $kehadiran =$row['kehadiran'];

                                $jumshift=mysql_query("SELECT count(nama) as jumlah_shift FROM jadwal where nama='$user' and bulan='$bulan' and tahun='$tahun' group by nama");
                                $data=mysql_fetch_array($jumshift);
                                mysql_free_result($jumshift);
                                if (empty($data)) {
                                    $jumlah_shift='1';
                                    $jumlah_shiftjadwal='0';
                                }else{
                                    $jumlah_shift=$data['jumlah_shift'];
                                    $jumlah_shiftjadwal=$data['jumlah_shift'];
                                }

                            $perkehadiran =round((($kehadiran*100)/$jumlah_shift),2);
                            if($no % 2 == 0){
                            $warna = "";
                            }?>
                            <?php 
                            $result2 = mysql_query("SELECT user,count(telat) as telat FROM absensi where telat>'00:00:00' and user='$user' and sudahpulang='1' and month(tgl)='$bulan' and year(tgl)='$tahun'");
                            while ($row2=mysql_fetch_array($result2)) {


                                $telat=$row2['telat'];
                                $pertelat =round((($telat*100)/$jumlah_shift),2);
                                $tertib=$kehadiran-$telat;
                                $pertertib=round((($tertib*100)/$kehadiran),2);

                            ?>
                            <tr class="<?php //echo $warna ;?>">
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row['user'];?></td>
                                <td><?php echo $jumlah_shiftjadwal;?></td>
                                <td><?php echo $row['kehadiran'];?></td>
                                <td><?php echo $row2['telat'];?></td>
                                <td><?php echo $perkehadiran." %" ?></td>
                                <td><?php echo $pertelat." %";?></td>
                                 <td><?php echo $pertertib." %";?></td>
                            </tr>
                                <?php
                                }mysql_free_result($result2);
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


    <div class="row">
        <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    Table Data Presensi <?php echo "bulan ".$wulan." ".$tahun."" ;?>
                </div> <!--panel-heading end -->
                <div class="panel-body">
                    <div class="table-respon">
                        <table class="table table-striped table-bordered table-hover" id="example"  width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Crew</th>
                                    <th>Shift</th>
                                    <th>Datang</th>
                                    <th>Pulang</th>
                                    <th>Durasi</th>
                                    <th>Telat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = '0';
                                    //$sumpendapatan='0';
                                    $pedapatankotor='';
                                    //$result = mysql_query("SELECT tgl,sum(masuk) as masuk,sum(keluar) as keluar FROM cashflow where month(tgl)='$bulan' and year(tgl)='$tahun' group by tgl");
                                    $result = mysql_query("SELECT * FROM absensi where month(tgl)='$bulan' and year(tgl)='$tahun' and sudahpulang='1'");
                                    while($row =mysql_fetch_array($result)) {
                                    $no++;
                                    $tanggal=$row['tgl'];
                                    $telat = $row['telat'];
                                    $nottelat= '00:00:00';
                                    $tanggaltampil = (getday($tanggal,'-'));
                                    $datang=$row['datang'];
                                    $datangtampil =date("H:i",strtotime($datang));
                                    $pulang=$row['pulang'];
                                    $pulangtampil =date("H:i",strtotime($pulang));
                                    $start_date = new DateTime($datang);

                                    $since_start = $start_date->diff(new DateTime($pulang));
                                    $jam = $since_start->h;
                                    $minutes = $since_start->i; //satu digit
                                    $menit = date('i',strtotime('1986-01-03 17:'.$minutes.':02')); //rubah dua digit


                                    /*$t1 = StrToTime ($pulang);
                                    $t2 = StrToTime ($datang);
                                    $detik = $t1 - $t2;
                                    $hour = floor(($t1 - $t2) / 3600);
                                    $minutes = floor(($t1 - $t2) / 60);*/
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $tanggaltampil;?></td>
                                        <td><?php echo $row['user'];?></td>
                                        <td align="center"><?php echo $row['shift'];?></td>
                                        <td align="center"><?php echo $datangtampil ?></td>
                                        <td align="center"><?php echo $pulangtampil ?></td>
                                        <td align="center"><?php echo "".$jam.":".$menit."";?></td>
                                        <?php 
                                            if ($telat>$nottelat) {?>
                                                <td align="right"><?php echo $telat ?></td>
                                               <?php 
                                            }else{?>
                                                <td align="right"></td>
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
                    </div><!-- Table end -->
                </div>
            </div><!-- /.panel end -->
        </div>
    </div>
    <?php
}else{
    unset($_POST['cari']);
}
?>
</body>
</html>