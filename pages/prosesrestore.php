<?php
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');
if (!empty($_POST["proses"])) {
    $proses=$_POST['proses'];
    switch ($proses) {
      case 'backup':

      if (empty($_POST['checkbox'])) {
          echo '<script language="javascript">alert("Tabel Belum Dipilih"); document.location="index.php?cp=prosesbackup&backup=backup";</script>';
      }else{
        // membaca tabel-tabel yang dipilih dari form
        $tabel = $_POST['checkbox'];

        // proses untuk menggabung nama-nama tabel yang dipilih
        // sehingga menjadi sebuah string berbentuk 'tabel1 tabel2 tabel3 ...'

        $listTabel = "";
        foreach($tabel as $namatabel)
        {
          $listTabel .= $namatabel." ";
        }

        //pada drive local
        $dumpfile = "D:AtazBackUp\\". $dbName . "_TGL" . date("d-m-Y") . "_JAM" . date("H-i") . ".sql";

        //pada directori web
        //$dumpfile = "frestore/". $dbName . "_" . date("d-m-Y") . ".sql";
        exec("E://xampp/mysql/bin/mysqldump --opt --host=$dbHost --user=$dbUser --password=$dbPass $dbName $listTabel> $dumpfile");
        ?>
          <script language="javascript">
            alert("Backup Selesai");
            document.location="index.php?cp=prosesbackup&backup=backup";
          </script>

        <?php
        exit();   
      }
        break;
      case 'restore':
        if($_FILES['datafile']['name'] == "") {
        echo '<script language="javascript">alert("Tidak Ada File"); document.location="index.php?cp=prosesbackup&restore=restore";</script>';
        }else{
          $fileName = $_FILES['datafile']['name'];
          $dir ="frestore/".$fileName."";
          // proses upload file
          move_uploaded_file($_FILES['datafile']['tmp_name'], $dir);
          // menjalankan command restore di shell via PHP
          exec("E:\\xampp\\mysql\\bin\\mysql -u$dbUser -p$dbPass $dbName < $dir");
          /*
          // membentuk string command untuk restore
          // di sini diasumsikan letak file mysql.exe terletak di direktori C:\AppServ\MySQL\bin
          $string = "C:\AppServ\MySQL\bin\mysql -u".$dbUser." -p".$dbPass." ".$dbName." < ".$fileName;
          // menjalankan command restore di shell via PHP
          exec($string);*/
          unlink($dir);// hapus file dump yang diupload
          /*
          session_start(); //to ensure you are using same session
          session_destroy(); //destroy the session
          header("location:login.php"); //to redirect back to "index.php" after logging out */
          echo '<script language="javascript">alert("Restore Selesai"); document.location="index.php?cp=prosesbackup&restore=restore";</script>';
          exit();
        }
        break;
      default:
      echo "ra ketemu";
        # code...
        break;
    }
}
?>

