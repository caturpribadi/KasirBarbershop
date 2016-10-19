<?php
set_time_limit(0);
date_default_timezone_set('Asia/Jakarta');
include 'koneksi.php';
include 'cek.php';


if (!empty($_POST["proses"])) {
    $proses=$_POST['proses']; 
	switch($proses)
	{
		case 'jadwal':
			$jum_tgl      =$_POST['jum_tgl'];
			$bulan      =$_POST['bulan'];
			$tahun      =$_POST['tahun'];
			$datejadwal      =$_POST['jadwalinput'];

			foreach ($_POST as $kunci => $isi)
			{
				$pos = strpos($kunci, 'shift');
				if ($pos) {
					preg_match('/(?P<tgl>\d+) (?P<shift>\d+) (?P<name>\w+)/', $isi, $pisah);
					$tgl = "".$tahun."-".$bulan."-".$pisah['tgl']."";
					$nama = $pisah['name'];
					$shift = $pisah['shift'];
					$result=mysql_query("INSERT INTO jadwal(tgl,nama,shift,bulan,tahun) 
									VALUES ('$tgl','$nama','$shift','$bulan','$tahun')");
							header("Location: index.php?cp=jadwalinput&jadwalinput=$datejadwal");
					/*echo $nama."<br>";
					echo $shift."<br>";
					echo $isi."<br>";
					echo $tgl."<br>";
					echo "<br>";*/
				}else{
					header("Location: index.php?cp=jadwalinput&jadwalinput=$datejadwal");
				}
			}

			break;
		case 'member':
			$nama      =$_POST['nama'];
			$tgl       =$_POST['tgl_lahir'];
			$tgl_lahir2 =date("Y-m-d",strtotime($tgl));
			$tgl_lahir =date('Y-m-d', strtotime(str_replace('/','-', $tgl)));
			$no_hp     =$_POST['no_hp'];
			$alamat    =$_POST['alamat'];
			$kode1     =$_POST['kode1'];
			$kode2     =$_POST['kode2'];
			$kode3	   =$_POST['kode3'];
			$number = $kode1."".$kode2."".$kode3;
			$result=mysql_query("INSERT INTO member(nomember,nama,tgl_lahir,no_hp,alamat) 
					VALUES ('$number','$nama','$tgl_lahir','$no_hp','$alamat')");
			header("Location: index.php?cp=member");
			echo $number."<br>";
			echo $nama."<br>";
			echo $tgl_lahir."<br>";
			echo $tgl."<br>";
			break;
		case 'datang':
			$username = $_POST['username'];
			$password = $_POST['password'];
			$shift = $_POST['shift'];
			$jamdatang = date('Y-m-d H:i:s');
            $tgl = date("Y-m-d", strtotime("$jamdatang"));

            if ($shift=='1') {
            	$shiftcatat = '1';
            	$toleransi = date('Y-m-d H:i:s',strtotime(''.$tgl.' 09:16:00'));
            	if ($toleransi < $jamdatang) {
            		$t1= date_create($toleransi);
            		$t2= date_create($jamdatang);
            		$hitungtelat = date_diff($t1, $t2);
            		$minutes=$hitungtelat->i;
            		$hours=$hitungtelat->h;
					$telat   = date('H:i:s',strtotime('1986-01-03 '.$hours.':'.$minutes.':00'));
            	}else{
            		$telat ='';
            	}
            }elseif ($shift=='2') {
            	$shiftcatat = '2';
            	$toleransi = date('Y-m-d H:i:s',strtotime(''.$tgl.' 13:16:00'));
            	if ($toleransi < $jamdatang) {
            		$t1= date_create($toleransi);
            		$t2= date_create($jamdatang);
            		$hitungtelat = date_diff($t1, $t2);
            		$minutes=$hitungtelat->i;
            		$hours=$hitungtelat->h;
					$telat   = date('H:i:s',strtotime('1986-01-03 '.$hours.':'.$minutes.':00'));
            	}else{
            		$telat = '';
            	}
            }elseif ($shift=='3'){
            	$shiftcatat = '3';
            	$toleransi = date('Y-m-d H:i:s',strtotime(''.$tgl.' 16:16:00'));
            	if ($toleransi < $jamdatang) {
            		$t1= date_create($toleransi);
            		$t2= date_create($jamdatang);
            		$hitungtelat = date_diff($t1, $t2);
            		$minutes=$hitungtelat->i;
            		$hours=$hitungtelat->h;
					$telat   = date('H:i:s',strtotime('1986-01-03 '.$hours.':'.$minutes.':00'));
            	}else{
            		$telat = '';
            	}
            }else{
            	$toleransi = date('Y-m-d H:i:s',strtotime(''.$tgl.' 09:16:00'));
            	if ($toleransi < $jamdatang) {
            		$t1= date_create($toleransi);
            		$t2= date_create($jamdatang);
            		$hitungtelat = date_diff($t1, $t2);
            		$minutes=$hitungtelat->i;
            		$hours=$hitungtelat->h;
					$telat   = date('H:i:s',strtotime('1986-01-03 '.$hours.':'.$minutes.':00'));
            	}else{
            		$telat ='';
            	}	
            }

			if (empty ($username) or empty ($password)){
				?>
					<script language="javascript">
						alert("Data Belum Lengkap !!");
						document.location="index.php?cp=presensi";
					</script>
				<?php
			}else{
				$result=mysql_query("SELECT * FROM pegawai WHERE username = '$username' and aktif='1'");
				$pengguna = mysql_fetch_array($result);
				mysql_free_result($result);
				if ($password == $pengguna['password']) {
					$jeneng=$pengguna['nama'];
					$jenengawal=str_word_count($jeneng, 1);
					$user = $jenengawal[0];
					$result=mysql_query("SELECT * FROM absensi WHERE user = '$user' and sudahpulang='0'");
					$data=mysql_fetch_array($result);
					mysql_free_result($result);
					if (!empty($data)) {
						?>
							<script language="javascript">
								alert("Sudah Absen!!");
								document.location="index.php?cp=presensi";
							</script>
						<?php
					}else{
						echo $telat;

						if ($shift=='4') {
							echo "papat";
							for ($ganjil = 1; $ganjil <= 4; $ganjil++) {
							if ($ganjil % 2 == 1) {
							$result=mysql_query("INSERT INTO absensi(tgl,datang,user,shift,telat) 
								VALUES ('$tgl','$jamdatang','$user','$ganjil','$telat')");
							header( 'Location:index.php?cp=presensi' );	
							 }
							}
						}else{
						$result=mysql_query("INSERT INTO absensi(tgl,datang,user,shift,telat) 
							VALUES ('$tgl','$jamdatang','$user','$shift','$telat')");
						header( 'Location:index.php?cp=presensi' );	
						}
					}
				}else{?>
					<script language="javascript">
						alert("Username dan Password tidak Cucok!!");
						document.location="index.php?cp=presensi";
					</script>
					<?php
				}
			}
			break;
		case 'pulang':
			$username = $_POST['username'];
			$password = $_POST['password'];
			$jampulang = date('Y-m-d H:i:s');
            $tgl = date("Y-m-d", strtotime("$jampulang"));

			if (empty ($username) or empty ($password))
			{
			?>
				<script language="javascript">
					alert("Data Belum Lengkap !!");
					document.location="index.php?cp=presensi";
				</script>
			<?php
			}else{
				$result=mysql_query("SELECT * FROM pegawai WHERE username = '$username' and aktif='1'");
				$pengguna = mysql_fetch_array($result);
				mysql_free_result($result);
				if ($password == $pengguna['password']) {
					$jeneng=$pengguna['nama'];
					$jenengawal=str_word_count($jeneng, 1);
					$user = $jenengawal[0];

				$result=mysql_query("SELECT datang FROM absensi WHERE user='$user' and sudahpulang='0'");
				$absensi = mysql_fetch_array($result);
				mysql_free_result($result);	
				$datang = $absensi['datang'];
				$start_date = new DateTime($datang);

                $since_start = $start_date->diff(new DateTime($jampulang));
                $jam = $since_start->h;
                $minutes = $since_start->i; //satu digit
                $menit = date('i',strtotime('1986-01-03 17:'.$minutes.':02')); //rubah dua digit
                $durasi = "".$jam.":".$menit.":00";

				$update=mysql_query("UPDATE absensi set pulang='$jampulang',sudahpulang='1',durasi='$durasi' where user='$user' and sudahpulang='0' ");
				header("Location: index.php?cp=presensi");
				}else{?>
					<script language="javascript">
						alert("Username dan Password tidak Cucok!!");
						document.location="index.php?cp=presensi";
					</script>
					<?php
				}
			}

			break;
     	default:
     	echo "ra ketemu";
     		# code...
     		break;
	}
}else{  
    $proses=$_GET['proses'];
    switch ($proses) {
    	case 'jadwal':
    		$id=$_GET['idjadwal'];
    		//echo $id;
    		$delete = mysql_query("DELETE FROM jadwal Where idjadwal='$id'") or die(mysql_error()); 
    		//$update=mysql_query("update jadwal set shift='2' where idjadwal='$id'");
    		header("Location: index.php?cp=jadwal");
    		# code...
    		break;
    	case 'pegawai':
    		$id=$_GET['id'];
    		$update=mysql_query("update pegawai set visible='0',aktif='0' where idpegawai='$id'");
    		header("Location: index.php?cp=pegawai");
    		# code...
    		break;
    	case 'paket':
    	    $id=$_GET['id'];
    		$update=mysql_query("update paket set visible='0' where idpaket='$id'");
    		header("Location: index.php?cp=paket");
    		# code...
    		break;
    	case 'jasa':
    		$id=$_GET['id'];
    		$update=mysql_query("update jasa set visible='0' where idjasa='$id'");
    		header("Location: index.php?cp=jasa");
    		# code...
    		break;
    	case 'barang':
    		$id=$_GET['id'];
    		$update=mysql_query("update barang set visible='0' where idbarang='$id'");
    		header("Location: index.php?cp=barang");
    		# code...
    		break;
    	default:
    		# code...
    		break;
    }
}

?>