<?php
include 'koneksi.php';
include 'cek.php';
//$proses=$_POST['proses'];

if (!empty($_POST["proses"])) {
    $proses=$_POST['proses']; 
	switch($proses)
	{
		case 'pegawai':
			$idpegawai =$_POST['idpegawai'];
			if (empty($idpegawai)) {
			//$nama      =$_POST['nama'];
			$nama      = ucwords($_POST['nama']);
			$tgl       =$_POST['tgl_lahir'];
			$tgl_lahir =date('Y-m-d', strtotime(str_replace('/','-', $tgl)));
			$no_hp     =$_POST['no_hp'];
			$alamat    =$_POST['alamat'];
			$level     =$_POST['posisi'];
			$username  =$_POST['username'];
			$password  =$_POST['password'];
			$result=mysql_query("INSERT INTO pegawai(nama,tgl_lahir,no_hp,alamat,level,username,password) 
					VALUES ('$nama','$tgl_lahir','$no_hp','$alamat','$level','$username','$password')");
			header("Location: index.php?cp=pegawai");
			}else{
			//$nama      =$_POST['nama'];
			$nama      = ucwords($_POST['nama']);
			$tgl       =$_POST['tgl_lahir'];
			$tgl_lahir =date('Y-m-d', strtotime(str_replace('/','-', $tgl)));
			$no_hp     =$_POST['no_hp'];
			$alamat    =$_POST['alamat'];
			$level     =$_POST['posisi'];
			$username  =$_POST['username'];
			$password  =$_POST['password'];
			$update=mysql_query("update pegawai set tgl_lahir='$tgl_lahir',no_hp='$no_hp',alamat='$alamat',level='$level',username='$username',password='$password' where idpegawai='$idpegawai'");
			header("Location: index.php?cp=pegawai");
			}
			break;
		case 'updatepegawai':
			$idpegawai =$_POST['idpegawai'];
			//$nama      =$_POST['nama'];
			$nama      = ucwords($_POST['nama']);
			$tgl       =$_POST['tgl_lahir'];
			$tgl_lahir =date('Y-m-d', strtotime(str_replace('/','-', $tgl)));
			$no_hp     =$_POST['no_hp'];
			$alamat    =$_POST['alamat'];
			$update=mysql_query("update pegawai set tgl_lahir='$tgl_lahir',no_hp='$no_hp',alamat='$alamat' where idpegawai='$idpegawai'");
			header("Location: index.php?cp=pegawai");
			break;
		case 'member':
			//$nama      =$_POST['nama'];
			$nama      = ucwords($_POST['nama']);
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
		case 'paket':
			//$nama     = $_POST['nama'];
			$nama     = strtoupper($_POST['nama']);
			$harga    = $_POST['harga'];
			$service1 = $_POST['service1'];
			$service2 = $_POST['service2'];
			$service3 = $_POST['service3'];
			$service4 = $_POST['service4'];
			$service5 = $_POST['service5'];
			if ($harga<0) {
				?>
					<script language="javascript">
						alert("Kesalahan input qty!!");
						document.location="index.php?cp=paket";
					</script>
				<?php
			}else{
				$result=mysql_query("INSERT INTO paket(nama,harga,service1,service2,service3,service4,service5) 
						VALUES ('$nama','$harga','$service1','$service2','$service3','$service4','$service5')");
				header("Location: index.php?cp=paket");
			}
			break;
		case 'updatepaket':
			$idpaket   =$_POST['idpaket'];
			$harga     =$_POST['harga'];
			if ($harga<=0) {
				?>
					<script language="javascript">
						alert("Kesalahan input qty!!");
						document.location="index.php?cp=paket";
					</script>
				<?php
			}else{
				$update=mysql_query("update paket set harga='$harga' where idpaket='$idpaket'");
				header("Location: index.php?cp=paket");
			}
			break;
		case 'jasa':
			$nama  = ucwords($_POST['nama']);
			$result=mysql_query("INSERT INTO jasa(nama) VALUES ('$nama')");
			header("Location: index.php?cp=jasa");
			# code...
			break;
		case 'barang':
			$nama = ucwords($_POST['nama']);
			$harga= $_POST['harga'];
			if ($harga<=0) {
				?>
					<script language="javascript">
						alert("Kesalahan input qty!!");
						document.location="index.php?cp=barang";
					</script>
				<?php
			}else{
				$result=mysql_query("INSERT INTO barang(nama,harga) VALUES ('$nama','$harga')");
				header("Location: index.php?cp=barang");
			}
			break;
		case 'updatebarang':
			$idbarang  =$_POST['idbarang'];
			$nama      =$_POST['nama'];
			$harga     =$_POST['harga'];
			if ($harga<=0) {
				?>
					<script language="javascript">
						alert("Kesalahan input qty!!");
						document.location="index.php?cp=barang";
					</script>
				<?php
			}else{
				$update=mysql_query("update barang set harga='$harga' where idbarang='$idbarang'");
				header("Location: index.php?cp=barang");
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
    	case 'member':
    		$id=$_GET['id'];
    		$update=mysql_query("update member set visible='0' where idmember='$id'");
    		header("Location: index.php?cp=member");
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