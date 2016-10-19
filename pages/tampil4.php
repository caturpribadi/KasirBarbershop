<?php
date_default_timezone_set('Asia/Jakarta');
include 'koneksi.php';
$iki = date('Y-m-d H:i:s');
$now= date_create($iki);
$datang = date_create('2015-04-13 10:00:30');
//$teko = $_REQUEST ["Datang"];
//$datang= date_create($teko);
//$lamalogin = UbahDetikJadiTimer(DateDiff("s",$datang,$now));
$durasi = date_diff($datang, $now);
$seconds=$durasi->s;
$detik = date('s',strtotime('1986-01-03 17:20:'.$seconds.''));
$minutes=$durasi->i;
$menit = date('i',strtotime('1986-01-03 17:'.$minutes.':02'));
$hours=$durasi->h;


echo $hours;
echo ":";
echo $menit;
echo ":";
echo $detik."<br>";

//echo $iki;
?>

<?php
	function jumlah_hari($bulan=0, $tahun=0) {
	 
	    $bulan = $bulan > 0 ? $bulan : date("m");
	    $tahun = $tahun > 0 ? $tahun : date("Y");
	 
	    switch($bulan) {
	        case 1:
	        case 3:
	        case 5:
	        case 7:
	        case 8:
	        case 10:
	        case 12:
	            return 31;
	            break;
	        case 4:
	        case 6:
	        case 9:
	        case 11:
	            return 30;
	            break;
	        case 2:
	            return $tahun % 4 == 0 ? 29 : 28;
	            break;
	    }
	}
	 
	// menampilkan jumlah hari pada bulan dan tahun saat ini
	echo jumlah_hari();
	echo "<br>";
	 
	// menampilkan jumlah hari pada bulan pebruari tahun ini
	echo jumlah_hari(2);
	echo "<br>";
	 
	// menampilkan jumlah hari pada bulan pebruari tahun 2000
    $date=date('Y-m-d');
    $bulan = date("m", strtotime("$date"));
    $tahun  = date("Y", strtotime("$date"));
	$jum_tgl=jumlah_hari(3, $tahun);
	echo "<br>";
?>
    <!-- Bootstrap Core CSS -->
    <link href="../dist/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../dist/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../dist/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- jQuery  -->
    <script src="../dist/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../dist/bootstrap/js/bootstrap.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../dist/DataTables/jquery.dataTables.min.js"></script>
    <script src="../dist/datatables-plugins/dataTables.bootstrap.min.js"></script>


<style type="text/css">
    .divBox {
        width: 15px;
        height: 15px;
        background: #ddd;

        position: relative;
        -webkit-box-shadow: 0px 1px 3px rgba(0,0,0,0.5);
        -moz-box-shadow: 0px 1px 3px rgba(0,0,0,0.5);
        box-shadow: 0px 1px 3px rgba(0,0,0,0.5);
    }

    .divBox label {
        display: block;
        width: 15px;
        height: 15px;
        -webkit-transition: all .5s ease;
        -moz-transition: all .5s ease;
        -o-transition: all .5s ease;
        -ms-transition: all .5s ease;
        transition: all .5s ease;
        cursor: pointer;
        position: absolute;
        top: 1px;
        z-index: 1;
        /* 
        use this background transparent to check the value of checkbox 
        background: transparent;
        */
        background: #ffffff;
        -webkit-box-shadow:inset 0px 1px 3px rgba(0,0,0,0.5);
        -moz-box-shadow:inset 0px 1px 3px rgba(0,0,0,0.5);
        box-shadow:inset 0px 1px 3px rgba(0,0,0,0.5);
    }

    .divBox input[type=checkbox]:checked + label {
        background: green;
    }
</style>
<style type="text/css">
    .cobo { 
        width:1108px; 
        overflow-x:scroll;  
        margin-left:117px; 
        overflow-y:visible;
        padding-bottom:1px;
        padding-right:20px;

    }
    .headcol {
        position:absolute; 
        width:15px; 
        left:30px;
        top:auto;

    }
    .nama {
        position:absolute; 
        width:90px; 
        left:55px;
        top:auto;
    }
    /*.headcol:before {content: 'Row ';}*/
    /*.long { background:yellow; letter-spacing:1em; }*/
</style>
<style type="text/css">
	.table-hover>tbody>tr:hover>td {
	  background-color: #E6E6E8;
	  color:#000000;
	}
</style>
<br><br>
<form class="form-horizontal" role="form" action="prosesabsen.php" method="post">
    <div class="col-lg-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                Data Paket Ataz Barbershop
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
				<div class="cobo" >
			        <table class="table table-bordered table-condensed table-hover" >
			                <tr>
		                        <th colspan="2" class="nama" style="padding-right:25px" align="center">tanggal</th>
		                        <?php
                                for ($x = 1; $x <= $jum_tgl; $x++) {?>
                                <th colspan="3" style="text-align: center;"><b>senin <br><?php echo $x; ?></b></th>
                                <?php
                                }
		                        ?>
			                </tr>
			                <tr>
			                	<th class="headcol" style="padding-right : 16px;">#</th>
			                    <th class="nama" align="center" style=" align="center" padding-right:25px">Crew</th>
		                        <?php
	                                for ($x = 1; $x <= $jum_tgl; $x++) {
			                            $warna = "background:#CDCDD1; color:#000000;";
			                            if($x % 2 == 0){
			                            $warna = "background:#ECECEC; color:#000000;";
			                            }
	                                        ?>
	                                        <td id="<?php echo $x; ?>" align="center" style="<?php echo $warna ;?> padding-left : 6px;">1</td>
	                                        <td id="<?php echo $x; ?>" align="center" style="<?php echo $warna ;?>">2</td>
	                                        <td id="<?php echo $x; ?>" align="center" style="<?php echo $warna ;?>">3</td>  
	                                <?php
	                                }
		                        ?>
			                </tr>
			                <?php
			                    $no = '0';
			                    $result = mysql_query("SELECT * FROM pegawai");
			                    while($row=mysql_fetch_array($result))
			                    {
			                    $no++;
			                    $nama = $row['nama'];
			                    $idpegawai = $row['idpegawai'];
			                    $jenengawal=str_word_count($nama, 1);
			                    	$warna = "background:#292933; color:#ffffff;";
					                if($no % 2 == 0){
					                $warna = "background:#ECECEC; color:#000000;";
					                }?>
			                        <tr>
			                        	<th class="headcol" style="padding-right : 16px;"><?php echo $no;?></th>
			                            <th class="nama" style="padding-left : 8px;"> <?php echo $jenengawal[0]; ?></th>
			                            <?php
			                                for ($x = 1; $x <= $jum_tgl; $x++) {?>
			                                <td style="padding-left : 6px;">
		                                        <div class="divBox">
		                                            <input type="checkbox"  id="<?php echo "".$idpegawai."".$x."";?>shift1" value="<?php echo "".$x." 1 ".$jenengawal[0].""; ?>" name="<?php echo "".$x."".$idpegawai."shift1"; ?>" />
		                                            <label for="<?php echo "".$idpegawai."".$x."";?>shift1"></label>
		                                        </div>  
			                                </td>
			                                <td>
		                                        <div class="divBox">
		                                            <input type="checkbox" id="<?php echo "".$idpegawai."".$x."";?>shift2" value="<?php echo "".$x." 2 ".$jenengawal[0].""; ?>" name="<?php echo "".$x."".$idpegawai."shift2"; ?>"/>
		                                            <label for="<?php echo "".$idpegawai."".$x."";?>shift2"></label>
		                                        </div>          
			                                </td>
			                                <td>
		                                        <div class="divBox">
		                                            <input type="checkbox" id="<?php echo "".$idpegawai."".$x."";?>shift3" value="<?php echo "".$x." 3 ".$jenengawal[0].""; ?>" name="<?php echo "".$x."".$idpegawai."shift3"; ?>" />
		                                            <label for="<?php echo "".$idpegawai."".$x."";?>shift3"></label>
		                                        </div>  
			                                </td>
			                              	<?php
			                            	}
			                        	?>
			                        </tr>
			                    <?php 
			                    }
			                    mysql_free_result($result);
			                ?>
			                <tr><td colspan="2" class="nama"><input type="submit" value="simpan"></td></tr>
			        </table>
			    </div>
        	</div>
        <!-- /.panel -->
    	</div>
	</div>
<input type="hidden" name="proses" value="jadwaldua">
</form>

