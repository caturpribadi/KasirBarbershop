
<?php
session_start();
include "koneksi.php";
$username = $_POST['username'];
$password = $_POST['password'];


if (empty ($username) or empty ($password))
{
?>
	<script language="javascript">
		alert("Data Belum Lengkap !!");
		document.location="login.php";
	</script>
<?php
}else{
	$result=mysql_query("SELECT * FROM user WHERE username = '$username'");
	$pengguna = mysql_fetch_array($result);
	mysql_free_result($result);
	if ($password == $pengguna['password']) {
		$jeneng=$pengguna['nama'];
		$level=$pengguna['level'];
		$iduser=$pengguna['iduser'];

		$_SESSION['jenengataz'] = $jeneng;
		$_SESSION['levelataz'] = $level;
		$_SESSION['iduser'] = $iduser;
		header( 'Location: ../index.php' ) ;

	}else{?>
		<script language="javascript">
			alert("Username dan Password tidak Cucok!!");
			document.location="login.php";
		</script>
	<?php
	}

}
?>