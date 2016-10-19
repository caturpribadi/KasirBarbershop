<?php
date_default_timezone_set('Asia/Jakarta');

$iki = date('Y-m-d H:i:s');
$now= date_create($iki);
//$datang = date_create('2015-04-13 10:00:30');
$teko = $_REQUEST ["Datang"];
$datang= date_create($teko);
//$lamalogin = UbahDetikJadiTimer(DateDiff("s",$datang,$now));
$durasi = date_diff($datang, $now);
$seconds=$durasi->s;
$detik = date('s',strtotime('1986-01-03 17:20:'.$seconds.''));
$minutes=$durasi->i;
$menit = date('i',strtotime('1986-01-03 17:'.$minutes.':02'));
$hours=$durasi->h;


echo $hours;
echo ":";
echo $menit;
echo ":";
echo $detik;

//echo $iki;
?>