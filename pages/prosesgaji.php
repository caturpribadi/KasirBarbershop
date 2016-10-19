<?php
date_default_timezone_set('Asia/Jakarta');
include 'koneksi.php';
include 'cek.php';

if (!empty($_POST["detailgaji"])) {
	$idpengeluarantemp =$_POST['idpengeluarantemp'];
	$idpegawai  = $_POST['idpegawai'];
	$idbiaya  = $_POST['idbiaya'];
	$jenisbiaya  = $_POST['jenisbiaya'];
	$nama  = $_POST['nama'];
	$level  = $_POST['level'];
	$total  = $_POST['total'];
	$jenisgaji=$_POST['detailgaji'];
	switch ($jenisgaji) 
	{
		case 'pokok':
            $result=mysql_query("INSERT INTO gaji_temp(pokok,nama,level,jenis,total,pengeluaran_temp_idpengeluaran_temp) 
            VALUES ('$total','$nama','$level','Pokok','$total','$idpengeluarantemp')");
            header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
			break;
		case 'bonus':
            $result=mysql_query("INSERT INTO gaji_temp(bonus,nama,level,jenis,total,pengeluaran_temp_idpengeluaran_temp) 
            VALUES ('$total','$nama','$level','Bonus','$total','$idpengeluarantemp')");
            header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
			break;
		case 'overtime':
            $result=mysql_query("INSERT INTO gaji_temp(overtime,nama,level,jenis,total,pengeluaran_temp_idpengeluaran_temp) 
            VALUES ('$total','$nama','$level','Overtime','$total','$idpengeluarantemp')");
            header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
			break;
		case 'makan':
            $result=mysql_query("INSERT INTO gaji_temp(makan,nama,level,jenis,total,pengeluaran_temp_idpengeluaran_temp) 
            VALUES ('$total','$nama','$level','Makan','$total','$idpengeluarantemp')");
            header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
			break;
		case 'transport':
            $result=mysql_query("INSERT INTO gaji_temp(transport,nama,level,jenis,total,pengeluaran_temp_idpengeluaran_temp) 
            VALUES ('$total','$nama','$level','Transport','$total','$idpengeluarantemp')");
            header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
			break;
		case 'hariraya':
            $result=mysql_query("INSERT INTO gaji_temp(hariraya,nama,level,jenis,total,pengeluaran_temp_idpengeluaran_temp) 
            VALUES ('$total','$nama','$level','Hari Raya','$total','$idpengeluarantemp')");
            header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
			break;
		case 'kesehatan':
            $result=mysql_query("INSERT INTO gaji_temp(kesehatan,nama,level,jenis,total,pengeluaran_temp_idpengeluaran_temp) 
            VALUES ('$total','$nama','$level','Kesehatan','$total','$idpengeluarantemp')");
            header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
			break;
		case 'nikah':
            $result=mysql_query("INSERT INTO gaji_temp(nikah,nama,level,jenis,total,pengeluaran_temp_idpengeluaran_temp) 
            VALUES ('$total','$nama','$level','Nikah','$total','$idpengeluarantemp')");
            header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
			break;
		case 'dukacita':
            $result=mysql_query("INSERT INTO gaji_temp(dukacita,nama,level,jenis,total,pengeluaran_temp_idpengeluaran_temp) 
            VALUES ('$total','$nama','$level','Duka Cita','$total','$idpengeluarantemp')");
            header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
			break;
		case 'kasbon':
            $result=mysql_query("INSERT INTO gaji_temp(kasbon,nama,level,jenis,total,pengeluaran_temp_idpengeluaran_temp) 
            VALUES ('$total','$nama','$level','Kasbon','$total','$idpengeluarantemp')");
            header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
			break;
		case 'pulsa':
            $result=mysql_query("INSERT INTO gaji_temp(pulsa,nama,level,jenis,total,pengeluaran_temp_idpengeluaran_temp) 
            VALUES ('$total','$nama','$level','Pulsa','$total','$idpengeluarantemp')");
            header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
			break;
		default:
     	echo "ra ketemu";
			break;
	}
} elseif (!empty($_POST["simpangaji"])) {
	$shift =$_POST['shift'];
	$user =$_POST['user'];
	$tgl =$_POST['tgl'];
	$tanggal         =date('Y-m-d', strtotime(str_replace('/','-', $tgl)));
	$bulan = date('m',strtotime($tanggal));
	$tahun = date('Y',strtotime($tanggal));
	$subtotal =$_POST['total'];
	$total = preg_replace('/[^0-9]/', '', $subtotal);	
	$idpengeluarantemp =$_POST['idpengeluarantemp'];

	$result2=mysql_query("SELECT sum(pokok) as pokok,nama FROM gaji_temp where pengeluaran_temp_idpengeluaran_temp='$idpengeluarantemp'");
	$cekpokoktemp = mysql_fetch_array($result2);
	mysql_free_result($result2);
	$pokoktemp=$cekpokoktemp['pokok'];
	$nama=$cekpokoktemp['nama'];
	
		if (!empty($pokoktemp)) {
		$result2=mysql_query("SELECT sum(kasbon) as sudahkasbon FROM gaji a inner join pengeluaran b
		on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
		$cekkasbon = mysql_fetch_array($result2);
		mysql_free_result($result2);
		$sudahkasbon=$cekkasbon['sudahkasbon'];
		if ($sudahkasbon > 0) {
			$pokokfix = $pokoktemp - $sudahkasbon;
			$totalsemua = $total - $sudahkasbon;
		}else{
			$pokokfix = $pokoktemp;
			$totalsemua = $total;
		}
		    $result=mysql_query("INSERT INTO pengeluaran(tgl,total,shift,user) 
		            VALUES ('$tanggal','$totalsemua','$shift','$user')");

			$result=mysql_query("SELECT max(idpengeluaran) as idpengeluaran from pengeluaran");
			$pengeluaran = mysql_fetch_array($result);
			mysql_free_result($result);
			$idpengeluaran=$pengeluaran['idpengeluaran'];

		    $result=mysql_query("INSERT INTO cashflow(tgl,keluar,pengeluaran_idpengeluaran) 
		            VALUES ('$tanggal','$totalsemua','$idpengeluaran')");
		}else{
		    $result=mysql_query("INSERT INTO pengeluaran(tgl,total,shift,user) 
		            VALUES ('$tanggal','$totalsemua','$shift','$user')");

			$result=mysql_query("SELECT max(idpengeluaran) as idpengeluaran from pengeluaran");
			$pengeluaran = mysql_fetch_array($result);
			mysql_free_result($result);
			$idpengeluaran=$pengeluaran['idpengeluaran'];

		    $result=mysql_query("INSERT INTO cashflow(tgl,keluar,pengeluaran_idpengeluaran) 
		            VALUES ('$tanggal','$totalsemua','$idpengeluaran')");
		}

	$result=mysql_query("SELECT pokok,bonus,overtime,makan,transport,hariraya,kesehatan,nikah,dukacita,kasbon,pulsa,total,nama,level,jenis FROM gaji_temp where pengeluaran_temp_idpengeluaran_temp='$idpengeluarantemp'");
	while($gaji_temp=mysql_fetch_array($result))
	{
	$pokok     =$gaji_temp['pokok'];
	$bonus     =$gaji_temp['bonus'];
	$overtime  =$gaji_temp['overtime'];
	$makan     =$gaji_temp['makan'];
	$transport =$gaji_temp['transport'];
	$hariraya  =$gaji_temp['hariraya'];
	$kesehatan =$gaji_temp['kesehatan'];
	$nikah     =$gaji_temp['nikah'];
	$dukacita  =$gaji_temp['dukacita'];
	$kasbon    =$gaji_temp['kasbon'];
	$pulsa    =$gaji_temp['pulsa'];
	$total     =$gaji_temp['total'];
	$nama      =$gaji_temp['nama'];
	$level     =$gaji_temp['level'];
	$jenis     =$gaji_temp['jenis'];
	$ket       =$nama." ".$jenis;

if (!empty($pokok)) {
			$result2=mysql_query("SELECT sum(kasbon) as sudahkasbon FROM gaji a inner join pengeluaran b
			on a.pengeluaran_idpengeluaran=b.idpengeluaran and month(b.tgl)='$bulan' and year(b.tgl)='$tahun' and a.nama='$nama'");
		$cekkasbon = mysql_fetch_array($result2);
		mysql_free_result($result2);
		$sudahkasbon=$cekkasbon['sudahkasbon'];

		if ($sudahkasbon > 0) {
			$pokokfix = $pokok;
			$totalfix = $pokok - $sudahkasbon;
			//$pokokfix = $sudahkasbon + $pokok;
		}else{
			$pokokfix = $pokok;
			$totalfix = $total;
		}
} else{
	$pokokfix = $pokok;
	$totalfix = $total;

}



	$gaji=mysql_query("INSERT INTO gaji(pokok,bonus,overtime,makan,transport,hariraya,kesehatan,nikah,dukacita,kasbon,pulsa,total,nama,level,jenis,pengeluaran_idpengeluaran)
							VALUES ('$pokokfix','$bonus','$overtime','$makan','$transport','$hariraya','$kesehatan','$nikah','$dukacita','$kasbon','$pulsa','$totalfix','$nama','$level','$jenis','$idpengeluaran')");
			$detailpengeluaran=mysql_query("INSERT INTO detail_pengeluaran(keterangan,total,jenis,biaya_idbiaya,pengeluaran_idpengeluaran)
							VALUES ('$ket','$totalfix','tetap','2','$idpengeluaran')");

/*	if (!empty($kasbon)) {
			$detailpengeluaran=mysql_query("INSERT INTO detail_pengeluaran(keterangan,total,jenis,biaya_idbiaya,pengeluaran_idpengeluaran)
							VALUES ('$ket','$total','kasbon','2','$idpengeluaran')");
	}else{
			$detailpengeluaran=mysql_query("INSERT INTO detail_pengeluaran(keterangan,total,jenis,biaya_idbiaya,pengeluaran_idpengeluaran)
							VALUES ('$ket','$total','tetap','2','$idpengeluaran')");
	} */


	}
	mysql_free_result($result);



            $delete1=mysql_query("DELETE FROM gaji_temp ");
            $delete2=mysql_query("DELETE FROM pengeluaran_temp ");

            header("Location: index.php?cp=pegawai");

	echo $shift."<br>";
	echo $user."<br>";
	echo $tanggal."<br>";
	echo $total."<br>";




}
else{
$id=$_GET['id'];
$idpengeluarantemp=$_GET['skac'];
$idpegawai=$_GET['pegawai'];
     		$delete="Delete from gaji_temp Where idgaji_temp='$id'"; 
			mysql_query($delete) or die ("Error tu"); 
			header("Location: index.php?cp=inputgaji&skac=$idpengeluarantemp&pegawai=$idpegawai");
}

?>