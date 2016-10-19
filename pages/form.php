<?php

namespace form;



/**
* Form Untuk pemasukan Jasa pada halaman pemasukan
*/
class PemasukanJasa 
{
    function pemasukan()
    {
		?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Paket</label>
                                        <div class="col-sm-8 ">
                                            <select class ="form-control" name="paket" required="required">
                                                <option selected disabled value="">Pilih Paket</option>
                                                <?php
                                                $result=mysql_query("SELECT * from paket where visible='1' ORDER BY nama");
                                                while($cp = mysql_fetch_array($result))
                                                {?>
                                                <option value="<?php echo $cp['idpaket']; ?>"><?php echo $cp['nama'] ; ?></option>
                                                <?php
                                                }
                                                mysql_free_result($result);?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">QTY</label>
                                        <div class="col-sm-8 ">
                                            <input type="number" name="qty" class="form-control" placeholder="Jumlah" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-9">
                                            <button type="submit" class="btn btn-outline btn-default">
                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah
                                            </button>
                                        </div>
                                    </div>
		<?php
    }
}

/**
* Form Untuk pemasukan Barang pada halaman pemasukan
*/
class PemasukanBarang
{
	
	function pemasukan()
	{
		?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Produk</label>
                    <div class="col-sm-8 col-md-offset-1">
                        <select class ="form-control" name="barang" required="required">
                            <option selected disabled value="">Pilih Produk</option>
                            <?php
                            $result=mysql_query("SELECT * from barang where visible='1' ORDER BY nama");
                            while($cp = mysql_fetch_array($result))
                            {?>
                            <option value="<?php echo $cp['idbarang']; ?>"><?php echo $cp['nama'] ; ?></option>
                            <?php
                            }
                            mysql_free_result($result);?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">QTY</label>
                    <div class="col-sm-8 ">
                        <input type="number" name="qty" class="form-control" placeholder="Jumlah" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-9">
                        <button type="submit" class="btn btn-outline btn-default">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah
                        </button>
                    </div>
                </div>
        <?php
	}
}

/**
*  Form Untuk Presensi Kedatangan pada halaman Presensi
*/
class PresensiDatang
{
	
	function datang()
	{
		?>
            <div class="form-group">
                <label class="col-sm-3 control-label" style=" text-align: left ;">Shift</label>
                <div class="col-sm-8 ">
                    <select  id="color_me" class ="form-control" name="shift" required="required">
                        <option selected disabled value="">Pilih Shift Kerja</option>
                        <option class="form-control satu" value="1"><b>Satu (09.00-17.00)</b></option>
                        <option class="form-control dua" value="2"><b>Dua (13.00-21.00)</b></option>
                        <option class="form-control tiga"value="3"><b>Tiga (16.00-21.00)</b></option>
                        <option class="form-control empat" value="4"><b>Satu + Tiga (09.00-21.00)</b></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" style=" text-align: left ;">Username</label>
                <div class="col-sm-8 ">
                    <input type="text" name="username" class="form-control" placeholder="Username" required="required">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" style=" text-align: left ;">Password</label>
                <div class="col-sm-8 ">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-9">
                    <button type="submit" class="btn btn-outline btn-default">
                        <span class="fa fa-sign-out" aria-hidden="true"></span> Masuk
                    </button>
                </div>
            </div>
        <?php
	}
}

/**
* Form Untuk Presensi Pulang pada Halaman Presensi
*/
class PresensiPulang
{
	
	function pulang()
	{
		?>
            <div class="form-group">
                <label class="col-sm-2 control-label">Username</label>
                <div class="col-sm-8 col-md-offset-1">
                    <input type="text" name="username" class="form-control" placeholder="Username" required="required">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Password</label>
                <div class="col-sm-8 ">
                    <input type="password" name="password" class="form-control" placeholder="password" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-9">
                    <button type="submit" class="btn btn-outline btn-default">
                        <span class="fa fa-sign-in" aria-hidden="true"></span> Pulang
                    </button>
                </div>
            </div>
		<?php
	}
}