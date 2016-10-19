
<!-- Navigation -->
<?php
include 'cek.php';
$namaataz = ucwords($_SESSION['jenengataz']);
$levelataz = ucwords($_SESSION['levelataz']);
$navlevel=str_word_count($levelataz, 1);
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <?php
            if ($levelataz == "Owner Ataz" or $levelataz =="Manager Ataz")
            {?>
                <a class="navbar-brand" href="index.php"><img src="../dist/gambar/navadmin.png" /></a>
                <?php
            }else{?>
                <a class="navbar-brand" href="index.php"><img src="../dist/gambar/nav.png" /></a>   
                <?php
            }
        ?>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <?php
            if ($levelataz == "Owner Ataz" or $levelataz =="Manager Ataz")
            {?>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-retweet fa-fw"></i> Export/Import <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-backup">
                <li><a href="index.php?cp=prosesbackup&backup=backup"><i class="fa fa-download fa-fw"></i> Export</a>
                </li>
                <li class="divider"></li>
                <li><a href="index.php?cp=prosesbackup&restore=restore"><i class="fa fa-upload fa-fw"></i> Import</a>
                </li>
            </ul>
        </li>
            <?php
            }
        ?>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <?php echo "".$navlevel[0].""; ?> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> <?php echo "".$namaataz.""; ?></a>
                </li>
                <li class="divider"></li>
                <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
        </li>
    </ul>

    <div class="navbar-default sidebar" role="navigation" >
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <?php
                    if ($levelataz == "Owner Ataz" or $levelataz =="Manager Ataz")
                    {?>
                    <li>
                        <a href="homeadmin"><i class="fa  fa-eye fa-fw"></i> Dashboard Bulanan</a>
                        <a href="home_hariadmin"><i class="fa  fa-eye fa-fw"></i> Dashboard Harian</a>
                        <a href="budget"><i class="fa  fa-eye fa-fw"></i> Budget</a>
                    </li>
                    <?php
                    }else{?>
                    <li>
                        <a href="home"><i class="fa  fa-eye fa-fw"></i> Dashboard</a>
                    </li>  
                    <?php
                    }
                ?>
                <?php
                    if ($levelataz == "Owner Ataz" or $levelataz =="Manager Ataz")
                    {?>
                    <li>
                        <a href="pegawai"><i class="fa fa-android fa-fw"></i> Crew</a>
                    </li>
                  <?php
                    }
                ?>
                <li>
                    <a href="presensi"><i class="fa fa-clock-o fa-fw"></i> Presensi</a>
                </li>
                <li>
                    <a href="member"><i class="fa fa-user fa-fw"></i> Member</a>
                </li>
<!-- Nav Produk -->
                <li>
                    <a href="#"><i class="fa fa-tasks fa-fw"></i> Produk Ataz<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php
                            if ($levelataz == "Owner Ataz" or $levelataz =="Manager Ataz")
                            {?>
                        <li>
                            <a href="jasa">Jasa</a>
                        </li>
                          <?php
                            }
                        ?>
                        <li>
                            <a href="barang">Barang</a>
                        </li>
                        <li>
                            <a href="paket">Paket</a>
                        </li>
                    </ul>
                </li>
<!-- Nav Produk End-->
<!-- Nav Pemasukan -->
                <li>
                    <a href="#"><i class="fa fa-edit fa-fw"></i> Input Transaksi<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php
                            if ($levelataz == "Owner Ataz")
                            {?>
                        <li>
                            <a href="pemasukan">Pemasukan</a>
                        </li>
                        <?php
                        }elseif ($levelataz == "Manager Ataz")
                        {

                        }
                        else{?>
                        <li>
                            <a href="pemasukan">Pemasukan</a>
                        </li>
                        <?php
                            }
                        ?>
                        <li>
                            <a href="biaya">Pengeluaran</a>
                        </li>
                        <li>
                            <a href="freecut">Free HairCut</a>
                        </li>
                    </ul>
                </li>
<!-- Nav Pemasukan End -->  
<!-- Nav Laporan -->
                <?php
                    if ($levelataz == "Owner Ataz" or $levelataz =="Manager Ataz")
                    {?>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i>Laporan Tabel<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="rugilaba2">Rugi Laba</a>
                                </li>
                                <li>
                                    <a href="cashflow2">Cash Flow</a>
                                </li>
                                <li>
                                    <a href="trxtotal">Total</a>
                                </li>
                                <li>
                                    <a href="trxbiaya">Biaya</a>
                                </li>
                                <li>
                                    <a href="presensidata">Presensi</a>
                                </li>
                                <?php
                                    if ($levelataz == "Owner Ataz")
                                    {?>
                                <li>
                                    <a href="trxjasa">Paket</a>
                                </li>
                                <li>
                                    <a href="trxbarang">Barang</a>
                                </li>
                                    <?php
                                    }
                                ?>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o"></i> Laporan Chart<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="chartpendapatan">Pendapatan</a>
                                </li>
                                <li>
                                    <a href="chartqty">Pengunjung</a>
                                </li>
                            </ul>
                        </li>
                    <?php
                    }
                ?>
<!-- Nav Laporan End-->
            </ul>
        </div>
    </div>


</nav>

