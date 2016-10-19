<?php
include 'ceklevel.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Skac Belajar Line chart</title>
    <script src="../dist/jquery-1.9.1.min.js"></script>
    <script src="../dist/highcharts/highcharts.js"></script>
    <script src="../dist/highcharts/exporting.js"></script>
    <script type="text/javascript">
        function FilterPrint(){
            document.body.style.cursor='auto';
            var ValueJenisItem = document.getElementById("jenis").value;
        if (ValueJenisItem == ''){
                document.getElementById("barisBulan").style.display = 'none';
                document.getElementById("barisTahun").style.display = 'none';
                document.getElementById("barisBulantahun").style.display = 'none';
                document.getElementById("barisLain").style.display = 'none';
                document.getElementById("barisTotal").style.display = 'none';
            } else if (ValueJenisItem == 'hari'){
                document.getElementById("barisBulan").style.display = '';
                document.getElementById("barisTahun").style.display = '';
                document.getElementById("bulan").required = true;
                document.getElementById("barisBelanja").style.display = 'none';
                document.getElementById("barisLain").style.display = 'none';
                document.getElementById("barisTotal").style.display = '';
            } else {
                document.getElementById("barisBulan").style.display = 'none';
                document.getElementById("bulan").required = false;
                document.getElementById("barisTahun").style.display = '';
                document.getElementById("barisBelanja").style.display = 'none';
                document.getElementById("barisLain").style.display = 'none';
                document.getElementById("barisTotal").style.display = '';
            };
        }
    </script>
</head>
    <body>
        <div class="row">
            <div class="col-lg-12" >
                <h3 class="page-header">Chart Pendapatan</h3>
            </div>
        </div>
        <div class="row">
            <form action="" method="post">
                <div class="col-xs-6 col-sm-3">
                    <select class ="form-control" name="jenis" id="jenis" required="required" onchange="FilterPrint();">
                        <option selected value="">Pilih Tipe</option>
                        <option value="hari">Harian</option>
                        <option value="bulan">Bulanan</option>
                    </select>
                </div>
                <div class="col-xs-6 col-sm-3" style="display:none;" id="barisBulan">
                    <select class ="form-control" name="bulan" id="bulan" required="required" onchange="FilterPrint();">
                        <option selected value="">Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">February </option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col-xs-6 col-sm-3" style="display:none;" id="barisTahun">
                    <select class ="form-control" name="tahun" id="tahun" required="required" onchange="FilterPrint();">
                        <option selected value="">Tahun</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                    </select>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <button type="submit" class="btn btn-outline btn-default" name="cari" id="cari" onClick="">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                    </button>
                </div>
            </form>
        </div>
        <br>

        <?php
            if(isset($_POST['cari']))
            {
                    include 'koneksi.php';
                    $bulan  =$_POST['bulan'];
                    $tahun  =$_POST['tahun'];
                    $bulanchart = date('F',strtotime('1986-'.$bulan.'-03'));

                    if (!empty($bulan)) { ?>
                        <script type="text/javascript">
                           var chart1; // globally available
                                $(document).ready(function() {
                                      chart1 = new Highcharts.Chart({
                                         chart: {
                                            renderTo: 'container',
                                         },
                                        title: {
                                            text: <?php echo "'Data Pendapatan Bulan ".$bulanchart." ".$tahun." '"; ?>,
                                            x: -20 //center
                                        },
                                        subtitle: {
                                            text: 'Source: Ataz Barbershop',
                                            x: -20
                                        },
                                        xAxis: {
                                            title: {
                                                text: 'Tanggal'
                                            },
                                            categories: [
                                            //['1'],['2'],['3'],['4'],['5'],['6'],['7'],['8'],['9'],['10'],['11'],['12'],
                                            <?php
                                                $result = mysql_query("SELECT  day(tgl) as tgl FROM cashflow where month(tgl)='$bulan' and year(tgl)='$tahun' group by tgl");
                                                while($row=mysql_fetch_array($result))
                                                {
                                                    //echo "'".$row['paket']."',";
                                                    echo "['".$row['tgl']."'],";
                                                    //['1'],['2'],['3'],['4'],['5'],['6'],['7'],['8'],['9'],['10'],['11'],['12'],
                                                }
                                                mysql_free_result($result); 
                                            ?>
                                                ]
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Pendapatan (Rp)'
                                            },
                                            plotLines: [{
                                                value: 0,
                                                width: 1,
                                                color: '#808080'
                                            }]
                                        },
                                        tooltip: {
                                            valueSuffix: ''
                                        },
                                        legend: {
                                            layout: 'vertical',
                                            align: 'right',
                                            verticalAlign: 'middle',
                                            borderWidth: 0
                                        },
                                        series: [
                                            {
                                                name: 'Kotor',
                                                color: '#000000',
                                                data: [
                                                    <?php
                                                        $result = mysql_query("SELECT sum(masuk) as total FROM cashflow where month(tgl)='$bulan' and year(tgl)='$tahun' group by tgl");
                                                        while($row=mysql_fetch_array($result))
                                                        {
                                                            echo "[".$row['total']."],";
                                                        }
                                                        mysql_free_result($result);
                                                    ?> 
                                                ]
                                            },

                                           /* {
                                                name: 'Bersih',
                                                color: '#0000FF',
                                                data: [
                                                    <?php
                                                        $sumpendapatan='0';
                                                        $result = mysql_query("SELECT tgl,sum(masuk) as masuk,sum(keluar) as keluar FROM cashflow where month(tgl)='$bulan' and year(tgl)='$tahun' group by tgl");
                                                        while($row=mysql_fetch_array($result))
                                                        {
                                                            $masuk=$row['masuk'];
                                                            $keluar=$row['keluar'];
                                                            $bersih=$masuk-$keluar;
                                                            $sumpendapatan += $bersih;
                                                            echo "[".$bersih."],";
                                                        }
                                                        mysql_free_result($result);
                                                    ?> 
                                                ]
                                            }, 
                                             {
                                                name: 'LabaRugi',
                                                color: '#00FF00',
                                                data: [
                                                    <?php
                                                        $sumpendapatan='0';
                                                        $result = mysql_query("SELECT tgl,sum(masuk) as masuk,sum(keluar) as keluar FROM cashflow where month(tgl)='$bulan' and year(tgl)='$tahun' group by tgl");
                                                        while($row=mysql_fetch_array($result))
                                                        {
                                                            $masuk=$row['masuk'];
                                                            $keluar=$row['keluar'];
                                                            $bersih=$masuk-$keluar;
                                                            $sumpendapatan += $bersih;
                                                            echo "[".$sumpendapatan."],";
                                                        }
                                                        mysql_free_result($result);
                                                    ?> 
                                                ]
                                            },*/
                                        ]
                                    });
                                });
                        </script>
                        <?php
                    }else{ ?>
                        <script type="text/javascript">
                           var chart1; // globally available
                                $(document).ready(function() {
                                      chart1 = new Highcharts.Chart({
                                         chart: {
                                            renderTo: 'container',
                                         },
                                        title: {
                                            text: <?php echo "'Data Pendapatan Tahun ".$tahun." '"; ?>,
                                            x: -20 //center
                                        },
                                        subtitle: {
                                            text: 'Source: Ataz Barbershop',
                                            x: -20
                                        },
                                        xAxis: {
                                            title: {
                                                text: 'Bulan'
                                            },
                                            categories: [
                                            //['1'],['2'],['3'],['4'],['5'],['6'],['7'],['8'],['9'],['10'],['11'],['12'],
                                            <?php
                                                $result = mysql_query("SELECT month(tgl) as bulan FROM transaksi where year(tgl)='$tahun' group by month(tgl)");
                                                while($row=mysql_fetch_array($result))
                                                {
                                                    echo "['".date('M',strtotime('1986-'.$row['bulan'].'-03'))."'],";
                                                }
                                                mysql_free_result($result); 
                                            ?>
                                                ]
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Pendapatan (Rp)'
                                            },
                                            plotLines: [{
                                                value: 0,
                                                width: 1,
                                                color: '#808080'
                                            }]
                                        },
                                        tooltip: {
                                            valueSuffix: ''
                                        },
                                        legend: {
                                            layout: 'vertical',
                                            align: 'right',
                                            verticalAlign: 'middle',
                                            borderWidth: 0
                                        },
                                        series: [
                                            {
                                                name: 'Kotor',
                                                color: '#000000',
                                                data: [
                                                    <?php
                                                        $result = mysql_query("SELECT tgl,sum(total) as total FROM transaksi where year(tgl)='$tahun' group by month(tgl)");
                                                        while($row=mysql_fetch_array($result))
                                                        {
                                                            echo "[".$row['total']."],";
                                                        }
                                                        mysql_free_result($result);
                                                    ?> 
                                                ]
                                            }, 
                                            {
                                                name: 'Bersih',
                                                data: [
                                                    <?php
                                                        $result1 = mysql_query("SELECT month(tgl) as bulan,sum(total) as pendapatan FROM transaksi where year(tgl)='$tahun' group by month(tgl)");
                                                        while($row1 =mysql_fetch_array($result1)) {
                                                        $bulan=$row1['bulan'];
                                                        $pendapatan=$row1['pendapatan'];
                                                            $result2 = mysql_query("SELECT tgl,sum(total) as biaya FROM pengeluaran where year(tgl)='$tahun' and month(tgl)='$bulan' ");
                                                            while($row2 =mysql_fetch_array($result2)){
                                                                $biaya=$row2['biaya'];
                                                                $bersih=$pendapatan-$biaya;
                                                            }
                                                                mysql_free_result($result2);
                                                                echo "[".$bersih."],";
                                                        }
                                                        mysql_free_result($result1);
                                                    ?>

                                                ]
                                            }, 
                                        ]
                                    });
                                });
                        </script>
                    <?php
                    }
                
            }else{
                unset($_POST['cari']);
            }
        ?>
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </body>
</html>