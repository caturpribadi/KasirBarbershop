<?php
include  "koneksi.php";
include 'ceklevel.php';
include '../dist/DateToIndo.php';
include '../dist/JmlHari.php';
include '../dist/NamaHari.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Edit Jadwal</title>

    <script src="../dist/jquery/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#editjadwal').dataTable( {
                responsive: true,
                "scrollY":        "100px",
                "scrollCollapse": true,
                "paging":         false,
                "autoWidth": true
            } );
        } );
    </script>

<script type="text/javascript">
        $(document).ready(function() {
            $('#fixed_header').DataTable({
                    "paging":false,
                    "scrollY": "200px",
                    "scrollX": false,
                    "info": true,
                    "ordering": false,
                    "searching": true
                });
        } );
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#selecctall').click(function(event) {  //on click 
            if(this.checked) { // check select status
                $('.checkbox1').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
            }else{
                $('.checkbox1').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });         
            }
        });
        
    });
</script>


</head>
<body>



<?php

    //$date  =$_GET["editbulan"];
$date = $_REQUEST ["editbulan"];
    $bulan =date('m', strtotime(str_replace(' ','-', $date)));
    $wulan =date('F', strtotime(str_replace(' ','-', $date)));
    $tahun =date('Y', strtotime(str_replace(' ','-', $date)));
    $jum_tgl=jumlah_hari($bulan, $tahun);

$result = mysql_query("SELECT * FROM jadwal where bulan='$bulan' and tahun='$tahun' order by tgl");
$count=mysql_num_rows($result);     //menghitung jumlah baris dari query diatas
if (empty($count)) {
    echo '<script language="javascript">alert("Tidak ada jadwal"); document.location="index.php?cp=presensi";</script>';
}else{?>
     <br>                  
    <div class="row">
        <div class="col-md-12">
        <table width="100%" bordercolor="#111111" style="border-style:solid; border-width:1; border-collapse: collapse; padding-left:4; padding-right:4; padding-top:1; padding-bottom:1" >
                <tr style="border:1px solid #000000;border-collapse:collapse;">
                    <td colspan="2" style="padding-right:25px; border:1px solid #CCC;border-collapse:collapse;" align="center">
                        <a href="print/jadwalxls.php?bulan=<?php echo $bulan; ?>&wulan=<?php echo $wulan; ?>&tahun=<?php echo $tahun; ?>" ><i class="fa fa-print" style="font-size:150%;"></i> Print</a>
                    </td>
                    <?php
                    for ($x = 1; $x <= $jum_tgl; $x++) {
                        $warna = "background:#CACACA; color:#000000;";
                        if($x % 2 == 0){
                        $warna = "";
                        }
                        $tanggal=''.$tahun.'-'.$bulan.'-'.$x.'';
                        $tanggaltampil = (haritiga($tanggal,'-'));
                        ?>
                    <th style="text-align: center;border-right: thin solid black;<?php echo $warna ;?>"><b><?php echo $x; ?><br><?php echo $tanggaltampil; ?></b></th>
                    <?php
                    }
                    ?>
                </tr>

                <?php
                    $no = '0';
                    $result = mysql_query("SELECT nama FROM jadwal where bulan='$bulan' and tahun='$tahun' group by nama");
                    while($row=mysql_fetch_array($result))
                    {
                    $no++;
                    $nama = $row['nama'];
                    $jenengawal1 = ucwords($row['nama']);
                    $jenengawal =str_word_count($jenengawal1, 1);
                    
                        $warna = "background:#292933; color:#ffffff;";
                        if($no % 2 == 0){
                        $warna = "background:#ECECEC; color:#000000;";
                        }?>
                        <tr style="border:1px solid #000000;border-collapse:collapse;">
                            <th align="center" style="padding-right : 16px; padding-left:5px;"><?php echo $no;?></th>
                            <th align="left" style="padding-left:5px;border-right: thin solid black;"> <?php echo $jenengawal[0]; ?></th>
                            <?php
                                for ($x = 1; $x <= $jum_tgl; $x++) {

                                    $shift1=mysql_query("SELECT * FROM jadwal where nama='$nama' and day(tgl)='$x' and bulan='$bulan' and tahun='$tahun'");
                                    $data=mysql_fetch_array($shift1);
                                    $count=mysql_num_rows($shift1);
                                    $shifttampil=$data['shift'];
                                    if ($count > 1) {
                                        echo "<td align='center' style='border-right: thin solid black; text-align:center;'><b>1+3</b></td>";
                                    }elseif ($count < 1) {
                                        echo "<td align='center' style='background:#FFA2D0; border-right: thin solid black;'></td>";
                                    }else{
                                        echo "<td style='border-right: thin solid black;text-align:center;'><b>$shifttampil</b></td>";
                                    }
                                 }
                            ?>
                        </tr>
                    <?php 
                    }
                    mysql_free_result($result);
                ?>
        </table>                                   
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Jadwal Shift <?php echo "Bulan ".$wulan." ".$tahun."" ;?>
                </div>
                <div class="panel-body">
                <div class="">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                                <th align="center" style="padding-right : 16px; padding-left:5px;">#</th>
                                <th align="center" style=" text-align:center; padding-right:20px; padding-left:20px;">Crew</th>
                                <th align="center" style="padding-right : 16px; padding-left:5px;">Jumlah Shift</th>
                        </tr>
                        <?php
                                $no = '0';
                                $result = mysql_query("SELECT nama,count(nama) as jumlah_shift FROM jadwal where bulan='$bulan' and tahun='$tahun' group by nama");
                                while($row=mysql_fetch_array($result))
                                {
                                $no++;
                                $nama = $row['nama'];
                                $jenengawal1 = ucwords($row['nama']);
                                $jenengawal=str_word_count($jenengawal1, 1);?>
                                <tr>
                                        <th align="center" style="padding-right : 16px; padding-left:5px;"><?php echo $no;?></th>
                                        <th align="left" style="padding-left:5px;"> <?php echo $jenengawal[0]; ?></th>
                                        <td align="center"><strong><?php echo $row['jumlah_shift']; ?></strong></td>
                                </tr>
                                <?php 
                                }
                                mysql_free_result($result);?>
                    </table>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Jadwal Shift <?php echo "Bulan ".$wulan." ".$tahun."" ;?>
                </div>
                <div class="panel-body">
                    <div class="">
                    <form name="form1" method="post" action="">
                        <table class="table table-striped table-bordered table-hover" id="fixed_header" style="table-layout: fixed;">
                            <thead>
                                <tr>
                                    <th class="col-md-1"><input type="checkbox" name="all" id="selecctall" /> All</th>
                                    <th class="col-md-3">Tanggal</th>
                                    <th class="col-md-3">Nama</th>
                                    <th class="col-md-1">Shift</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = mysql_query("SELECT * FROM jadwal where bulan='$bulan' and tahun='$tahun' order by tgl");
                                $count=mysql_num_rows($result);     //menghitung jumlah baris dari query diatas
                                while($rows=mysql_fetch_array($result)){        //melakukan perulangan while dan menampilkan data dari database
                                    $tanggal = $rows['tgl'];
                                    $namahari = (getday($tanggal,'-'));
                                    $tanggaltampil =date("d-m-Y",strtotime($tanggal));
                                    ?>
                                    <tr>
                                        <td align="center"><input class="checkbox1" name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $rows['idjadwal']; ?>"></td>
                                        <td><?php echo "".$namahari." / ".$tanggaltampil.""; ?></td>
                                        <td><?php echo $rows['nama']; ?></td>
                                        <td><?php echo $rows['shift']; ?></td>

                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <div align="center">
                        <button type="submit" class="btn btn btn-warning" name="delete" type="submit" id="delete" value="Delete" onClick="return confirm('Yakin?');">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus
                        </button>   
                        </div>
                        <input type="hidden" name="editbulan" value="<?php echo $date;?>">
                    </form>  
                    </div>
                </div>
            </div> 
        </div>
    </div>    
    <?php
    }
?> 


   
<?php
    //cek apakah tombol delete diklik
    if(isset($_POST['delete'])){
        if(isset($_POST['checkbox'])){
        $date = $_POST['editbulan'];
        $jml = count($_POST['checkbox']);       //menghitung berapa data yang dicentang
        $pilih = $_POST['checkbox'];
        echo $jml."<br>";
        if($jml > 0){       //jika ada data yang dicentang
            for($i=0;$i<$jml;$i++){       //melakukan perulangan for
                $del_id = $pilih[$i];    //mengambil id dari tiap-tiap data yang dicentang
                $delete = mysql_query("DELETE FROM jadwal Where idjadwal='$del_id'") or die(mysql_error()); 
                //$sql = "DELETE FROM jadwal WHERE idjadwal='$del_id'";      //query delete
                //$result2 = mysql_query($sql);        //menjalankan query delete diatas
                //echo $del_id;
                //echo $pilih[$i]."<br>";
            }
            if($delete){    //jika data berhasil dihapus
                echo '<script language="javascript">document.location="index.php?cp=jadwaledit&editbulan='.$date.'";</script>';
                //echo '<script language="javascript">alert("Berhasil menghapus '.$jml.' data"); document.location="index.php?cp=editjadwal&editbulan='.$date.'";</script>';
            }else{      //jika gagal menghapus data
                echo 'Gagal';
            }
        }else{
            echo "tidak ada pilihan";
        }

        }else{
            echo '<script language="javascript">document.location="index.php?cp=jadwaledit&editbulan='.$date.'";</script>';
            //echo '<script language="javascript">alert("Tidak Ada Yang Dihapus"); document.location="index.php?cp=editjadwal&editbulan='.$date.'";</script>';
        }

    }else{
    unset($_POST['delete']);
    }
?>

</body>
</html>