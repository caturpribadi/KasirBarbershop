<?php
include '../koneksi.php';
include '../ceklevel.php';
include '../../dist/DayToIndo.php';
$bulan=$_GET['bulan'];
$wulan=$_GET['wulan'];
$tahun=$_GET['tahun'];
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=presensi_$wulan.xls");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<center><h3>Laporan Presensi <?php echo "$wulan $tahun"; ?></h3></center>
    <table>
        <tr>
            <td>
                <table border='1'>
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
                                <td align='right'><?php echo $perkehadiran." %" ?></td>
                                <td align='right'><?php echo $pertelat." %";?></td>
                                <td align='right'><?php echo $pertertib." %";?></td>
                            </tr>
                                <?php
                                }mysql_free_result($result2);
                            }
                        mysql_free_result($result);
                        ?>
                        </tbody>
                </table>      
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>
                <table border="1"  width="100%">
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
                            $result = mysql_query("SELECT * FROM absensi where month(tgl)='$bulan' and year(tgl)='$tahun' and sudahpulang='1' ORDER BY user");
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
                            $minutes = $since_start->i;
                            $menit = date('i',strtotime('1986-01-03 17:'.$minutes.':02'));
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
            </td>
        </tr>
    </table>
</body>
</html>

<?php
exit()
?>