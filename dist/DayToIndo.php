<?php
function getday($tgl,$sep){
        $sepparator = $sep; //separator. contoh: '-', '/'
        $parts = explode($sepparator, $tgl);
        $d = date("l", mktime(0, 0, 0, $parts[1], $parts[2], $parts[0]));
        $tgl2 =date("d-m-Y",strtotime($tgl));
        if ($d=='Monday'){
            //return 'Senin';
            return "Senin, ".$tgl2."";
        }elseif($d=='Tuesday'){
            //return 'Selasa';
            return "Selasa, ".$tgl2."";
        }elseif($d=='Wednesday'){
            //return 'Rabu';
            return "Rabu, ".$tgl2."";
        }elseif($d=='Thursday'){
            //return 'Kamis';
            return "Kamis, ".$tgl2."";
        }elseif($d=='Friday'){
            //return 'Jumat';
            return "Jumat, ".$tgl2."";
        }elseif($d=='Saturday'){
            //return 'Sabtu';
            return "Sabtu, ".$tgl2."";
        }elseif($d=='Sunday'){
            //return 'Minggu';
            return "Minggu, ".$tgl2."";
        }else{
            return 'ERROR!';
        }


    }
?>