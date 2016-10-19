<?php
include 'koneksi.php';
include 'ceklevel.php';
if (!empty($_POST["proses"])) {
    $proses=$_POST['proses']; 
	switch($proses)
	{
		case 'pemasukan':
			$idtransaksitemp =$_POST['idtransaksitemp'];
			$nota            =$_POST['nota'];
			$shift           =$_POST['shift'];
			$idpegawai       =$_POST['idpegawai'];
			$tot_trxjasa     =$_POST['tot_jasa'];
			$tot_trxbarang   =$_POST['tot_barang'];
			$tgl             =$_POST['tgl'];
			$tanggal         =date('Y-m-d', strtotime(str_replace('/','-', $tgl)));
			$idmember        =$_POST['member'];
			$subtotal   =$_POST['tot_transaksi'];
			$tot_transaksi = preg_replace('/[^0-9]/', '', $subtotal);
			
			if ($idmember=='0') {
				$result=mysql_query("INSERT INTO transaksi(tgl,nota,tot_trxbarang,tot_trxjasa,total,shift,pegawai_idpegawai) 
						VALUES ('$tanggal','$nota','$tot_trxbarang','$tot_trxjasa','$tot_transaksi','$shift','$idpegawai')");
						$result=mysql_query("SELECT max(idtransaksi) as idtransaksi from transaksi");
						$transaksi = mysql_fetch_array($result);
						mysql_free_result($result);
						$idtransaksi=$transaksi['idtransaksi'];

				$result=mysql_query("INSERT INTO cashflow(tgl,masuk,transaksi_idtransaksi) 
						VALUES ('$tanggal','$tot_transaksi','$idtransaksi')");

						$result=mysql_query("SELECT qty,harga,total,paket_idpaket FROM trxjasa_temp where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
						while($trxjasa_temp=mysql_fetch_array($result))
						{
						$qty=$trxjasa_temp['qty'];
						$harga=$trxjasa_temp['harga'];
						$total=$trxjasa_temp['total'];
						$paket_idpaket=$trxjasa_temp['paket_idpaket'];
						$trxjasa=mysql_query("INSERT INTO trxjasa(qty,harga,total,paket_idpaket,transaksi_idtransaksi)
												VALUES ('$qty','$harga','$total','$paket_idpaket','$idtransaksi')");
						
						}
						mysql_free_result($result);


						$result=mysql_query("SELECT qty,harga,total,barang_idbarang FROM trxbarang_temp where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
						while($trxbarang_temp=mysql_fetch_array($result))
						{
						$qty=$trxbarang_temp['qty'];
						$harga=$trxbarang_temp['harga'];
						$total=$trxbarang_temp['total'];
						$barang_idbarang=$trxbarang_temp['barang_idbarang'];
						$trxbarang=mysql_query("INSERT INTO trxbarang(qty,harga,total,barang_idbarang,transaksi_idtransaksi)
												VALUES ('$qty','$harga','$total','$barang_idbarang','$idtransaksi')");
						
						}
						mysql_free_result($result);

						/* multi user belum ketemu logicnya 
						$delete1=mysql_query("DELETE FROM trxjasa_temp where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
						$delete2=mysql_query("DELETE FROM trxbarang_temp where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
						$delete2=mysql_query("DELETE FROM transaksi_temp where idtransaksi_temp='$idtransaksitemp'"); */

						/* singgle user */
						$delete1=mysql_query("DELETE FROM trxjasa_temp");
						$delete2=mysql_query("DELETE FROM trxbarang_temp");
						$delete3=mysql_query("DELETE FROM transaksi_temp");
						include 'notareload.php';
						//header("Location: index.php?cp=freecut"); 
			}else{
				if ($tot_trxjasa=='') {
					$result=mysql_query("INSERT INTO transaksi(tgl,nota,tot_trxbarang,tot_trxjasa,total,shift,member_idmember,pegawai_idpegawai) 
					VALUES ('$tanggal','$nota','$tot_trxbarang','$tot_trxjasa','$tot_transaksi','$shift','$idmember','$idpegawai')");

					$result=mysql_query("SELECT max(idtransaksi) as idtransaksi from transaksi");
					$transaksi = mysql_fetch_array($result);
					mysql_free_result($result);
					$idtransaksi=$transaksi['idtransaksi'];

					$result=mysql_query("INSERT INTO cashflow(tgl,masuk,transaksi_idtransaksi) 
							VALUES ('$tanggal','$tot_transaksi','$idtransaksi')");

					$result=mysql_query("SELECT qty,harga,total,paket_idpaket FROM trxjasa_temp 
									where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
					while ($trxjasa_temp=mysql_fetch_array($result)) {
						$qty=$trxjasa_temp['qty'];
						$harga=$trxjasa_temp['harga'];
						$total=$trxjasa_temp['total'];
						$paket_idpaket=$trxjasa_temp['paket_idpaket'];
						$trxjasa=mysql_query("INSERT INTO trxjasa(qty,harga,total,paket_idpaket,transaksi_idtransaksi)
									VALUES ('$qty','$harga','$total','$paket_idpaket','$idtransaksi')");
					}
					mysql_free_result($result);

					$result=mysql_query("SELECT qty,harga,total,barang_idbarang FROM trxbarang_temp 
									where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
					while ($trxbarang_temp=mysql_fetch_array($result)) {
						$qty=$trxbarang_temp['qty'];
						$harga=$trxbarang_temp['harga'];
						$total=$trxbarang_temp['total'];
						$barang_idbarang=$trxbarang_temp['barang_idbarang'];
						$trxbarang=mysql_query("INSERT INTO trxbarang(qty,harga,total,barang_idbarang,transaksi_idtransaksi)
									VALUES ('$qty','$harga','$total','$barang_idbarang','$idtransaksi')");
	
					}
					mysql_free_result($result);

					/* multi user belum ketemu logicnya 
					$delete1=mysql_query("DELETE FROM trxjasa_temp where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
					$delete2=mysql_query("DELETE FROM trxbarang_temp where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
					$delete2=mysql_query("DELETE FROM transaksi_temp where idtransaksi_temp='$idtransaksitemp'"); */

					/* singgle user */
					$delete1=mysql_query("DELETE FROM trxjasa_temp");
					$delete2=mysql_query("DELETE FROM trxbarang_temp");
					$delete3=mysql_query("DELETE FROM transaksi_temp");
					include 'notareload.php';
					//header("Location: index.php?cp=pemasukan"); 
				}else{
					$result=mysql_query("INSERT INTO transaksi(tgl,nota,tot_trxbarang,tot_trxjasa,total,shift,member_idmember) 
					VALUES ('$tanggal','$nota','$tot_trxbarang','$tot_trxjasa','$tot_transaksi','$shift','$idmember')");

					$result=mysql_query("SELECT max(idtransaksi) as idtransaksi from transaksi");
					$transaksi = mysql_fetch_array($result);
					mysql_free_result($result);
					$idtransaksi=$transaksi['idtransaksi'];
					
					$result=mysql_query("INSERT INTO cashflow(tgl,masuk,transaksi_idtransaksi) 
							VALUES ('$tanggal','$tot_transaksi','$idtransaksi')");

					$result=mysql_query("SELECT qty,harga,total,paket_idpaket FROM trxjasa_temp 
									where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
					while ($trxjasa_temp=mysql_fetch_array($result)) {
						$qty=$trxjasa_temp['qty'];
						$harga=$trxjasa_temp['harga'];
						$total=$trxjasa_temp['total'];
						$paket_idpaket=$trxjasa_temp['paket_idpaket'];
						$trxjasa=mysql_query("INSERT INTO trxjasa(qty,harga,total,paket_idpaket,transaksi_idtransaksi)
									VALUES ('$qty','$harga','$total','$paket_idpaket','$idtransaksi')");
					}
					mysql_free_result($result);

					$result=mysql_query("SELECT qty,harga,total,barang_idbarang FROM trxbarang_temp 
									where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
					while ($trxbarang_temp=mysql_fetch_array($result)) {
						$qty=$trxbarang_temp['qty'];
						$harga=$trxbarang_temp['harga'];
						$total=$trxbarang_temp['total'];
						$barang_idbarang=$trxbarang_temp['barang_idbarang'];
						$trxbarang=mysql_query("INSERT INTO trxbarang(qty,harga,total,barang_idbarang,transaksi_idtransaksi)
									VALUES ('$qty','$harga','$total','$barang_idbarang','$idtransaksi')");
	
					}
					mysql_free_result($result);

					$result=mysql_query("SELECT count(*) as jumlah FROM transaksi a inner join member b on a.member_idmember=b.idmember
                                    	and b.visible=1 and b.idmember='$idmember' and a.tot_trxjasa not like 0 group by nomember");
					$counter=mysql_fetch_array($result);
					mysql_free_result($result);
					$jumlahnota =$counter['jumlah'];
					$hitung     =$jumlahnota/3;
					$bonus      =floor($hitung);

					$result=mysql_query("SELECT freepangkas from member where idmember='$idmember'");
					$freepangkas = mysql_fetch_array($result);
					mysql_free_result($result);
					$freepangkas=$freepangkas['freepangkas'];
					$bonusbaru=$bonus-$freepangkas;

   					$update=mysql_query("update member set bonus='$bonusbaru' where idmember='$idmember'");

					/* multi user belum ketemu logicnya 
					$delete1=mysql_query("DELETE FROM trxjasa_temp where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
					$delete2=mysql_query("DELETE FROM trxbarang_temp where transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
					$delete2=mysql_query("DELETE FROM transaksi_temp where idtransaksi_temp='$idtransaksitemp'"); */

					/* singgle user */
					$delete1=mysql_query("DELETE FROM trxjasa_temp");
					$delete2=mysql_query("DELETE FROM trxbarang_temp");
					$delete3=mysql_query("DELETE FROM transaksi_temp");
					include 'notareload.php';
					//header("Location: index.php?cp=pemasukan"); 
				}			
			}

			break;
		case 'paket':
			$idpaket = $_POST['paket'];
			$qty = $_POST['qty'];
			$idtransaksitemp = $_POST['idtransaksitemp'];
			if ($qty<=0) {
				?>
					<script language="javascript">
						alert("Kesalahan input qty!!");
						document.location="index.php?cp=pemasukan&skac=<?php echo $idtransaksitemp ?>";
					</script>
				<?php
			}else
			{
				$result=mysql_query("SELECT idtrxjasa_temp as ada FROM trxjasa_temp where paket_idpaket='$idpaket' and transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
				$trxpaket_temp = mysql_fetch_array($result);
				mysql_free_result($result);
				$ada=$trxpaket_temp['ada'];
				if (!empty($ada)) {
					?>
						<script language="javascript">
							alert("Item sudah di pilih!!");
							document.location="index.php?cp=pemasukan&skac=<?php echo $idtransaksitemp ?>";
						</script>
					<?php
				}else{
					$result=mysql_query("SELECT harga FROM paket where idpaket='$idpaket'");
					$paket = mysql_fetch_array($result);
					mysql_free_result($result);
					$harga=$paket['harga'];
					$total=$harga*$qty;
					$result=mysql_query("INSERT INTO trxjasa_temp(qty,harga,total,paket_idpaket,transaksi_temp_idtransaksi_temp) 
							VALUES ('$qty','$harga','$total','$idpaket','$idtransaksitemp')");
					header("Location: index.php?cp=pemasukan&skac=$idtransaksitemp");
				}
			}

			break;
		case 'barang':
			$idbarang = $_POST['barang'];
			$qty = $_POST['qty'];
			$idtransaksitemp = $_POST['idtransaksitemp'];
			if ($qty<=0) {
				?>
					<script language="javascript">
						alert("Kesalahan input qty!!");
						document.location="index.php?cp=pemasukan&skac=<?php echo $idtransaksitemp ?>";
					</script>
				<?php
			}else
			{
				$result=mysql_query("SELECT idtrxbarang_temp as ada FROM trxbarang_temp where barang_idbarang='$idbarang' and transaksi_temp_idtransaksi_temp='$idtransaksitemp'");
				$trxbarang_temp = mysql_fetch_array($result);
				mysql_free_result($result);
				$ada=$trxbarang_temp['ada'];
				if (!empty($ada)) {
					?>
						<script language="javascript">
							alert("Item sudah di pilih!!");
							document.location="index.php?cp=pemasukan&skac=<?php echo $idtransaksitemp ?>";
						</script>
					<?php
				}else
				{
					$result=mysql_query("SELECT harga FROM barang where idbarang='$idbarang'");
					$barang = mysql_fetch_array($result);
					mysql_free_result($result);
					$harga=$barang['harga'];
					$total=$harga*$qty;
					$result=mysql_query("INSERT INTO trxbarang_temp(qty,harga,total,barang_idbarang,transaksi_temp_idtransaksi_temp) 
							VALUES ('$qty','$harga','$total','$idbarang','$idtransaksitemp')");
					header("Location: index.php?cp=pemasukan&skac=$idtransaksitemp");
				}

			}
			# code...
			break;
     	case 'freecut':
				$tgl      =$_POST['tgl'];
				$tanggal  =date('Y-m-d', strtotime(str_replace('/','-', $tgl)));
				$idmember =$_POST['idmember'];
				$jumlah   ='1';

				$result=mysql_query("INSERT INTO freepangkas(tgl,freepangkas,member_idmember) 
						VALUES ('$tanggal','$jumlah','$idmember')");

				$result=mysql_query("SELECT bonus,freepangkas from member where idmember='$idmember'");
				$member = mysql_fetch_array($result);
				mysql_free_result($result);
				$bonus=$member['bonus'];
				$freepangkas=$member['freepangkas'];

				$bonusbaru=$bonus-1;
				$freepangkasbaru=$freepangkas+1;

	     		$update=mysql_query("update member set bonus='$bonusbaru',freepangkas='$freepangkasbaru' where idmember='$idmember'");
				header("Location: index.php?cp=freecut"); 
     		break;
     	default:
     	echo "ra ketemu";
     		break;
	}
}else{  
    $proses=$_GET['proses'];
    switch ($proses) {
    	case 'paket':
    	    $id=$_GET['id'];
     		$idtransaksitemp=$_GET['skac'];
     		$delete="Delete from trxjasa_temp Where idtrxjasa_temp='$id'"; 
			mysql_query($delete) or die ("Error tu"); 
			header("Location: index.php?cp=pemasukan&skac=$idtransaksitemp");
    		# code...
    		break;
    	case 'barang':
    		$id=$_GET['id'];
    		$idtransaksitemp=$_GET['skac'];

     		$delete="Delete from trxbarang_temp Where idtrxbarang_temp='$id'"; 
			mysql_query($delete) or die ("Error tu"); 
			header("Location: index.php?cp=pemasukan&skac=$idtransaksitemp");
    		# code...
    		break;
    	case 'delnota':
    		$idtransaksi=$_GET['idtransaksi'];
     		//$delete1="DELETE FROM cashflow Where transaksi_idtransaksi='$idtransaksi'"; 
     		//$delete="DELETE FROM trxjasa Where transaksi_idtransaksi='$idtransaksi'"; 
     		//$delete3="DELETE FROM trxbarang Where transaksi_idtransaksi='$idtransaksi'"; 
     		//$delete4="Delete from transaksi Where idtransaksi='$idtransaksi'";
			//mysql_query($delete) or die ("Error tu"); 
			$delete1 = mysql_query("DELETE FROM cashflow Where transaksi_idtransaksi='$idtransaksi'") or die(mysql_error());
			$delete2 = mysql_query("DELETE FROM trxjasa Where transaksi_idtransaksi='$idtransaksi'") or die(mysql_error());
			$delete3 = mysql_query("DELETE FROM trxbarang Where transaksi_idtransaksi='$idtransaksi'") or die(mysql_error());
			$delete4 = mysql_query("DELETE FROM transaksi Where idtransaksi='$idtransaksi'") or die(mysql_error());
                    ?>
                        <script language="javascript">
                            alert("Nota Berhasil dihapus!!");
                            document.location="index.php?cp=trxtotal";
                        </script>
                    <?php
    		break;
    	default:
    		# code...
    		break;
    }
}
?>