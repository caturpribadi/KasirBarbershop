<?php
include  "koneksi.php";
include 'ceklevel.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Laporan Biaya Bulanan</title>
    
    <script src="../dist/jquery/jquery.min.js"></script>
    <script type="text/javascript">
        function convertToRupiah(angka){
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return rupiah.split('',rupiah.length-1).reverse().join('');
        }
        $(document).ready(function() {
            $('#example').dataTable( {
                responsive: true,
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
         
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\.]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
         
                    // Total over all pages
                    total = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        },0 );
         
                    // Total over this page
                    pageTotal = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    var total_biaya = convertToRupiah(total);
                    var pageTotal_biaya = convertToRupiah(pageTotal);
                    // Update footer
                    $( api.column( 4 ).footer() ).html(
                        'Rp'+pageTotal_biaya +' ( Rp'+ total_biaya +' total )'
                    );
                }
            } );
        } );
    </script>
</head>
<body>
<body>
    <div class="row">
        <div class="col-lg-12" >
            <h3 class="page-header">Tabel Biaya Bulanan</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"> 
            <div class="col-xs-8">
                <form class="form-horizontal" role="form" action="trxbiaya" method="post">
                    <div class="form-group">
                        <div class="col-xs-5">
                            <input type="text" name="date" class="form-control input-sm" id="tgllaporan" placeholder="Bulan" required="required">
                        </div>
                        <div class="col-xs-3">
                            <input name="cari" type="submit" value="Cari" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
if(isset($_POST['cari'])){
    $date  =$_POST['date'];
    $bulan =date('m', strtotime(str_replace(' ','-', $date)));
    $wulan =date('F', strtotime(str_replace(' ','-', $date)));
    $tahun =date('Y', strtotime(str_replace(' ','-', $date)));
    ?> 
<div class="row">
    <div class="col-lg-2 col-sm-offset-10">
        <a href="print/biayaxls.php?bulan=<?php echo $bulan; ?>&wulan=<?php echo $wulan; ?>&tahun=<?php echo $tahun; ?>" class="btn btn-outline btn-default"><i class="fa fa-print" style="font-size:150%;"></i> Save Excel</a>
    </div>
</div>
<br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Laporan Biaya <?php echo "Bulan ".$wulan." ".$tahun."" ;?>
                </div>
                <div class="panel-body">
                    <div class="">
                        <table class="table table-striped"  id="example"  width="100%">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th>Total</th>
                                    <?php
                                        if (($_SESSION['levelataz']) == "owner ataz") { ?>
                                        <th>Panel</th>
                                        <?php
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="3" style="text-align:right">Total:</th>
                                    <th colspan="2" style="text-align:right"></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                    $no = '0';
                                    $result = mysql_query("SELECT b.iddetail_pengeluaran,a.tgl,b.keterangan as ket,b.jenis,b.total,c.nama FROM pengeluaran a inner join detail_pengeluaran b 
                                        on a.idpengeluaran=b.pengeluaran_idpengeluaran inner join biaya c on b.biaya_idbiaya=c.idbiaya where month(tgl)='$bulan' and year(tgl)='$tahun' order by tgl");
                                    while($row=mysql_fetch_array($result))
                                    {
                                        $tanggal=$row['tgl'];
                                        $tanggaltampil =date("d-m-Y",strtotime($tanggal));
                                    $no++
                                    ?>
                                    <tr>
                                        <td><?php echo $tanggaltampil;?></td>
                                        <td><?php echo $row['jenis'] ?></td>
                                        <td><?php echo $row['nama'] ?></td>
                                        <td ><?php echo $row['ket'] ?></td>
                                        <td align="right"><?php echo number_format($row['total'],0,',','.') ?></td>
                                        <?php
                                            if (($_SESSION['levelataz']) == "owner ataz") { ?>
                                            <td align="center">
                                                <A HREF="prosesbiaya.php?iddetail=<?php echo $row['iddetail_pengeluaran'] ?>&proses=delpengeluaran" onclick='return confirm("Hapus <?php echo "".$row['nama'].", ".$row['ket']."";?> ?")'>
                                                    <i class="fa fa-trash-o"></i>
                                                </A>
                                            </td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}else{
    unset($_POST['cari']);
}
?>
</body>
</html>
    