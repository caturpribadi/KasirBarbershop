<?php
include 'koneksi.php';
include 'cek.php';
//$proses=$_POST['proses'];

if (!empty($_POST["proses"])) {
    $proses=$_POST['proses']; 
    switch($proses)
    {
        case 'biaya':
	        if (empty($_POST['keterangan'])) {
				$jenis             =$_POST['jenis'];
				$idbiaya           =$_POST['idbiaya'];
				$total             =$_POST['total'];
				$idpengeluarantemp =$_POST['idpengeluarantemp'];
                $pegawai           =$_POST['pegawai'];
                $jenisgaji         =$_POST['detailgaji'];
                $detailgaji        =$pegawai." ".$jenisgaji;
                $private           =$_POST['private'];
                /*echo $jenis."<br>";
                echo $idbiaya."<br>";
                echo $total."<br>";
                echo $idpengeluarantemp."<br>";
                echo $pegawai."<br>";
                echo $detailgaji."<br>";
                echo $private."<br>";*/
               if ($total<=0) {
                    ?>
                        <script language="javascript">
                            alert("Jumlah Salah!!");
                            document.location="index.php?cp=biaya&skac=<?php echo $idpengeluarantemp ?>";
                        </script>
                    <?php
                }else{
                    $result=mysql_query("SELECT iddetail_pengeluaran_temp as ada FROM detail_pengeluaran_temp where biaya_idbiaya='$idbiaya' and pengeluaran_temp_idpengeluaran_temp='$idpengeluarantemp'");
                    $trxbiaya_temp = mysql_fetch_array($result);
                    mysql_free_result($result);
                    $ada=$trxbiaya_temp['ada'];
                    if (!empty($ada)) {
                        ?>
                            <script language="javascript">
                                alert("Biaya Sudah Dipilih!!");
                                document.location="index.php?cp=biaya&skac=<?php echo $idpengeluarantemp ?>";
                            </script>
                        <?php
                    }else{
                        if (empty($private)) {
                            if (empty($jenisgaji)) {
                            $result=mysql_query("INSERT INTO detail_pengeluaran_temp(keterangan,total,jenis,biaya_idbiaya,pengeluaran_temp_idpengeluaran_temp) 
                            VALUES ('$pegawai','$total','$jenis','$idbiaya','$idpengeluarantemp')");
                            header("Location: index.php?cp=biaya&skac=$idpengeluarantemp");
                            }else{
                                echo "iki gaji";
                            }
                        }else{
                        $result=mysql_query("INSERT INTO detail_pengeluaran_temp(keterangan,total,jenis,biaya_idbiaya,pengeluaran_temp_idpengeluaran_temp) 
                            VALUES ('$private','$total','$jenis','$idbiaya','$idpengeluarantemp')");
                            header("Location: index.php?cp=biaya&skac=$idpengeluarantemp");            
                        }

                    }
                }
	        }else{
                $idbiaya    ='16';
                $keterangan =$_POST['keterangan'];
                $total      =$_POST['total'];
                $jenis      =$_POST['jenis'];
	            $idpengeluarantemp =$_POST['idpengeluarantemp'];

   	            $result=mysql_query("INSERT INTO detail_pengeluaran_temp(keterangan,total,jenis,biaya_idbiaya,pengeluaran_temp_idpengeluaran_temp) 
	                    VALUES ('$keterangan','$total','$jenis','$idbiaya','$idpengeluarantemp')");
	            header("Location: index.php?cp=biaya&skac=$idpengeluarantemp");
	        }
            break;
        case 'pengeluaran':
			$idpengeluarantemp =$_POST['idpengeluarantemp'];
			$tgl             =$_POST['tgl'];
            $shift =$_POST['shift'];
            $user =$_POST['user'];
			$tanggal         =date('Y-m-d', strtotime(str_replace('/','-', $tgl)));
            $subtotal     =$_POST['total'];
            $total = preg_replace('/[^0-9]/', '', $subtotal);

            $result=mysql_query("INSERT INTO pengeluaran(tgl,total,shift,user) 
                    VALUES ('$tanggal','$total','$shift','$user')");

			$result=mysql_query("SELECT max(idpengeluaran) as idpengeluaran from pengeluaran");
			$pengeluaran = mysql_fetch_array($result);
			mysql_free_result($result);
			$idpengeluaran=$pengeluaran['idpengeluaran'];

            $result=mysql_query("INSERT INTO cashflow(tgl,keluar,pengeluaran_idpengeluaran) 
                    VALUES ('$tanggal','$total','$idpengeluaran')");

			$result=mysql_query("SELECT keterangan,total,jenis,biaya_idbiaya FROM detail_pengeluaran_temp where pengeluaran_temp_idpengeluaran_temp='$idpengeluarantemp'");
			while($detailpengeluaran_temp=mysql_fetch_array($result))
			{
			$ket     =$detailpengeluaran_temp['keterangan'];
			$total   =$detailpengeluaran_temp['total'];
			$jenis   =$detailpengeluaran_temp['jenis'];
			$idbiaya =$detailpengeluaran_temp['biaya_idbiaya'];
			$detailpengeluaran=mysql_query("INSERT INTO detail_pengeluaran(keterangan,total,jenis,biaya_idbiaya,pengeluaran_idpengeluaran)
									VALUES ('$ket','$total','$jenis','$idbiaya','$idpengeluaran')");
			}
			mysql_free_result($result);

            /* Multiuser Belum ketemu logicnya 
        	$delete1=mysql_query("DELETE FROM detail_pengeluaran_temp where pengeluaran_temp_idpengeluaran_temp='$idpengeluarantemp'");
        	$delete2=mysql_query("DELETE FROM pengeluaran_temp where idpengeluaran_temp='$idpengeluarantemp'");*/

            $delete1=mysql_query("DELETE FROM detail_pengeluaran_temp ");
            $delete2=mysql_query("DELETE FROM pengeluaran_temp ");

            header("Location: index.php?cp=biaya");
            break;
        default:
        echo "ra ketemu";
            # code...
            break;
    }
}else{  
    $proses=$_GET['proses'];
    switch ($proses) {
        case 'delbiaya':
    		$id=$_GET['id'];
    		$idpengeluarantemp=$_GET['skac'];

     		$delete="Delete from detail_pengeluaran_temp Where iddetail_pengeluaran_temp='$id'"; 
			mysql_query($delete) or die ("Error tu"); 
			header("Location: index.php?cp=biaya&skac=$idpengeluarantemp");
    		# code...
            break;
        case 'barang':
            $id=$_GET['id'];
            $update=mysql_query("update barang set visible='0' where idbarang='$id'");
            header("Location: http://localhost/ataz/pages/barang");
            # code...
            break;
        case 'delpengeluaran':
            $iddetail_pengeluaran=$_GET['iddetail'];
            $result=mysql_query("SELECT total,pengeluaran_idpengeluaran FROM detail_pengeluaran where iddetail_pengeluaran='$iddetail_pengeluaran'");
            $detailpengeluaran = mysql_fetch_array($result);
            mysql_free_result($result);
            $idpengeluaran=$detailpengeluaran['pengeluaran_idpengeluaran'];
            $totaldetail=$detailpengeluaran['total'];

            $result=mysql_query("SELECT * FROM pengeluaran where idpengeluaran='$idpengeluaran'");
            $pengeluaran = mysql_fetch_array($result);
            mysql_free_result($result);
            $totalpengeluaran=$pengeluaran['total'];

            $newtotal=$totalpengeluaran-$totaldetail;
            $update=mysql_query("UPDATE pengeluaran set total='$newtotal' where idpengeluaran='$idpengeluaran'");
            $update=mysql_query("UPDATE cashflow set keluar='$newtotal' where pengeluaran_idpengeluaran='$idpengeluaran'");
            $delete1 = mysql_query("DELETE FROM detail_pengeluaran Where iddetail_pengeluaran='$iddetail_pengeluaran'") or die(mysql_error());
            $delete2 = mysql_query("DELETE FROM gaji Where pengeluaran_idpengeluaran='$idpengeluaran'") or die(mysql_error());
            //$delete2 = mysql_query("DELETE FROM trxjasa Where transaksi_idtransaksi='$idtransaksi'") or die(mysql_error());
           // $delete3 = mysql_query("DELETE FROM trxbarang Where transaksi_idtransaksi='$idtransaksi'") or die(mysql_error());
            ?>
                <script language="javascript">
                    alert("Biaya Berhasil dihapus!!");
                    document.location="index.php?cp=trxbiaya";
                </script>
            <?php
            break;
        default:
            # code...
            break;
    }
}
?>