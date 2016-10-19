<?php
function getday($tgl,$sep){
        $sepparator = $sep; //separator. contoh: '-', '/'
        $parts = explode($sepparator, $tgl);
        $d = date("l", mktime(0, 0, 0, $parts[1], $parts[2], $parts[0]));
        $tgl2 =date("d-m-Y",strtotime($tgl));
        if ($d=='Monday'){
            //return 'Senin';
            return "Senin";
        }elseif($d=='Tuesday'){
            //return 'Selasa';
            return "Selasa";
        }elseif($d=='Wednesday'){
            //return 'Rabu';
            return "Rabu";
        }elseif($d=='Thursday'){
            //return 'Kamis';
            return "Kamis";
        }elseif($d=='Friday'){
            //return 'Jumat';
            return "Jumat";
        }elseif($d=='Saturday'){
            //return 'Sabtu';
            return "Sabtu";
        }elseif($d=='Sunday'){
            //return 'Minggu';
            return "Minggu";
        }else{
            return 'ERROR!';
        }
    }

function haritiga($tgl,$sep){
        $sepparator = $sep; //separator. contoh: '-', '/'
        $parts = explode($sepparator, $tgl);
        $d = date("l", mktime(0, 0, 0, $parts[1], $parts[2], $parts[0]));
        $tgl2 =date("d-m-Y",strtotime($tgl));
        if ($d=='Monday'){
            //return 'Senin';
            return "Sen";
        }elseif($d=='Tuesday'){
            //return 'Selasa';
            return "Sel";
        }elseif($d=='Wednesday'){
            //return 'Rabu';
            return "Rab";
        }elseif($d=='Thursday'){
            //return 'Kamis';
            return "Kam";
        }elseif($d=='Friday'){
            //return 'Jumat';
            return "Jum";
        }elseif($d=='Saturday'){
            //return 'Sabtu';
            return "Sab";
        }elseif($d=='Sunday'){
            //return 'Minggu';
            return "Mng";
        }else{
            return 'ERROR!';
        }
    }
?>