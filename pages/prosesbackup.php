<?php
include 'koneksi.php';
date_default_timezone_set("Asia/Jakarta");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
    <script src="../dist/jquery/jquery.min.js"></script>
<!-- CheckAll -->
	<script type="text/javascript">
	    $(document).ready(function() {
	        $('#selecctall').click(function(event) {  //on click 
	            if(this.checked) { // check select status
	                $('.checkbox1').each(function() { //loop through each checkbox
	                    this.checked = true;  //select all checkboxes with class "checkbox1"               
	                });
	                $('.checkbox2').each(function() { //loop through each checkbox
	                    this.checked = true;  //select all checkboxes with class "checkbox1"               
	                });	                
	            }else{
	                $('.checkbox1').each(function() { //loop through each checkbox
	                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
	                }); 
	                $('.checkbox2').each(function() { //loop through each checkbox
	                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
	                });
	                $('.selecctallA').each(function() { //loop through each checkbox
	                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
	                }); 
	                $('.selecctallB').each(function() { //loop through each checkbox
	                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
	                });
	            }
	        });
	        $('#selecctallA').click(function(event) {  //on click 
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
	        $('#selecctallB').click(function(event) {  //on click 
	            if(this.checked) { // check select status
	                $('.checkbox2').each(function() { //loop through each checkbox
	                    this.checked = true;  //select all checkboxes with class "checkbox1"               
	                });
	            }else{
	                $('.checkbox2').each(function() { //loop through each checkbox
	                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
	                }); 
	            }
	        });
	    });
	</script>
<!-- Checkall End -->
<!-- Efek animasi -->
	<style type="text/css">
		.glyphicon-refresh-animate {
	    -animation: spin .7s infinite linear;
	    -webkit-animation: spin2 .7s infinite linear;
		}

		@-webkit-keyframes spin2 {
		    from { -webkit-transform: rotate(0deg);}
		    to { -webkit-transform: rotate(360deg);}
		}

		@keyframes spin {
		    from { transform: scale(1) rotate(0deg);}
		    to { transform: scale(1) rotate(360deg);}
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('catur').onclick = function() {
		    document.getElementById("catur2").style.display = '';
		   document.getElementById("catur").style.display = 'none';

		};
		} );
	</script>
<!-- Efek animasi End-->
</head>
<body>
<?php
if (isset($_GET['backup']))
{?>
	<div class="row">
	    <div class="col-lg-12" >
	        <h3 class="page-header">Export DataBase Ataz Barbershop</h3>
	    </div>
	</div>
	<!--
<table border='1'>
<?php
$jum='7';
for ($n = 1; $n<=$jum; $n++) {
	echo "<tr>";
	for ($i = $n; $i<=21; $i=($i + $jum)){
	 echo "<td>$i</td>";
	}
	echo "</tr>";
}?>
</table>
-->
	<div class="row">
	<form name="form1" method="post" action="prosesrestore.php">
		<div class="panel panel-default">	
		<div class="panel-body">
		    <div class="col-md-6">
		        <div class="panel panel-success">
		            <div class="panel-heading">
						Select Dinamis Tabel DB 
		            </div>
		            <div class="panel-body">
		                <div class="">
		                    <table class="table table-striped table-bordered table-hover" id="fixed_header" style="table-layout: fixed;">
		                        <thead>
		                            <tr>
		                            	<th class="col-sm-1">#</th>
		                                <th class="col-md-2"><input type="checkbox" name="all" class="selecctallA" id="selecctallA" /> All</th>
		                                <th class="col-md-8">Tabel Database</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                            <?php
		                            $no = '0';
		                            $result = mysql_query("SHOW TABLES");
		                            $count=mysql_num_rows($result);     //menghitung jumlah baris dari query diatas
		                            $jum=$count/3;
		                            while($row=mysql_fetch_array($result)){        //melakukan perulangan while dan menampilkan data dari database
		                             
		                            if ($row['0']=='user' or $row['0']=='pegawai'
		                            	or $row['0']=='detail_pengeluaran_temp'
		                            	or $row['0']=='barang'
		                            	or $row['0']=='pengeluaran_temp'
		                            	or $row['0']=='trxbarang_temp'
		                            	or $row['0']=='trxjasa_temp'
		                            	or $row['0']=='transaksi_temp'
		                            	or $row['0']=='paket'
		                            	or $row['0']=='member'
		                            	or $row['0']=='jadwal'
		                            	or $row['0']=='biaya'
		                            	or $row['0']=='gaji'
		                            	or $row['0']=='gaji_temp'
		                            	or $row['0']=='jasa'
		                            	or $row['0']=='budget'
		                            	or $row['0']=='budget_temp'
		                            	or $row['0']=='detail_budget_temp'
		                            	or $row['0']=='detail_budget'
		                            	) {
		                                # code...
		                            }else{
		                            	$no++; 
		                                ?>
		                            <tr>
		                                <td><?php echo $no; ?></td>
		                                <td><input class="checkbox1" name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $row[0]; ?>"></td>
		                                <td><?php echo $row[0]; ?></td>
		                            </tr>
		                                <?php
		                                }
		                            }mysql_free_result($result);
		                            ?>
		                        </tbody>
		                    </table>
		                </div>
		            </div>
		        </div> 
		    </div>		
		    <div class="col-md-6">
		        <div class="panel panel-default">
		            <div class="panel-heading">
					  <strong>Select Statis Tabel DB</strong>	 
		            </div>
		            <div class="panel-body">
		                <div class="">
		                    <table class="table table-striped table-bordered table-hover" id="fixed_header" style="table-layout: fixed;">
		                        <thead>
		                            <tr>
		                            	<th class="col-sm-1">#</th>
		                                <th class="col-md-2"><input type="checkbox" name="all" class="selecctallB" id="selecctallB" /> All</th>
		                                <th class="col-md-8">Tabel Database</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                            <?php
		                            $no = '0';
		                            $result = mysql_query("SHOW TABLES");
		                            $count=mysql_num_rows($result);     //menghitung jumlah baris dari query diatas
		                            $jum=$count/3;
		                            while($row=mysql_fetch_array($result)){        //melakukan perulangan while dan menampilkan data dari database
		                             
		                            if ($row['0']=='user' or $row['0']=='absensi'
		                            	or $row['0']=='cashflow'
		                            	or $row['0']=='detail_pengeluaran'
		                            	or $row['0']=='pengeluaran_temp'
		                            	or $row['0']=='trxbarang_temp'
		                            	or $row['0']=='trxjasa_temp'
		                            	or $row['0']=='transaksi_temp'
		                            	or $row['0']=='freepangkas'
		                            	or $row['0']=='pengeluaran'
		                            	or $row['0']=='transaksi'
		                            	or $row['0']=='trxbarang'
		                            	or $row['0']=='trxjasa'
		                            	or $row['0']=='biaya'
		                            	or $row['0']=='gaji_temp'
		                            	or $row['0']=='detail_pengeluaran_temp'
		                            	or $row['0']=='budget_temp'
		                            	or $row['0']=='detail_budget_temp'

		                            	) {
		                                # code...
		                            }else{
		                            	$no++; 
		                                ?>
		                            <tr>
		                                <td><?php echo $no; ?></td>
		                                <td><input class="checkbox2" name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $row[0]; ?>"></td>
		                                <td><?php echo $row[0]; ?></td>
		                            </tr>
		                                <?php
		                                }
		                            }mysql_free_result($result);
		                            ?>
		                        </tbody>
		                    </table>
		                </div>
		            </div>
		        </div> 
			<div class="col-md-12">
				<div align="center">
				<div class="row">
	                <div class="col-sm-4 col-sm-offset-2">
	                	<label><input type="checkbox" name="all" id="selecctall" />	Select All</label>              
	                </div>					
				</div>
				<div class="row">
	                <div style="display:;" id="catur">
	                    <button class="col-md-4 col-md-offset-2 btn btn-default"><span class=" fa fa-download"></span><strong> Export</strong></button>
	                </div>
	                <div style="display:none;" id="catur2">
						<button class="col-md-4 col-md-offset-2 btn btn-warning"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span><strong> Loading...</strong></button>
					</div> 					
				</div>
			    </div>
			</div>	 
		    </div>

		    <input type="hidden" name="proses" value="backup">
 
		</div>
 		</div>	
	</form>
	</div>
	<div class="row">
		<br>
	</div>
	<?php
}else
{ ?>
	<div class="row">
	    <div class="col-lg-12" >
	        <h3 class="page-header">Import DataBase Ataz Barbershop</h3>
	    </div>
	</div>
	<div class="row">
	    <div class="col-lg-4">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                Import DB Form
	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body">
	                <form class="form-horizontal" role="form" action="prosesrestore.php" method="post" enctype="multipart/form-data">
	                    <div class="form-group">
	                        <label class="col-sm-4 control-label">DB Name</label>
	                        <div class="col-sm-7">
	                            <input type="text" name="nama" class="form-control" placeholder="Nama Barang" required="required" value="AtazBarbershop" readonly/>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputEmail3" class="col-sm-4 control-label">File Sql</label>
	                        <div class="col-sm-7">
	                            <input name="datafile" type="file" title="Masukan File Sql" data-filename-placement="inside" class="btn btn-outline btn-primary">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <div style="display:;" id="catur">
	                            <button class="col-sm-offset-5 col-sm-4 btn btn-default"><span class=" fa fa-upload"></span> Restore</button>
	                        </div>
	                        <div style="display:none;" id="catur2">
								<button class="col-sm-offset-5 col-sm-4 btn btn-warning"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...</button>
							</div>
	                  </div>
	                  		<input type='hidden' name='MAX_FILE_SIZE' value='20000000'>
	                        <input type="hidden" name="proses" value="restore">
	                </form>
	            </div>
	        </div>
	    </div>	
	</div>
 <?php
}
?>
</body>
</html>