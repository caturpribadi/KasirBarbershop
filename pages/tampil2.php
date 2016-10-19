<?php
include  "koneksi.php";
include 'ceklevel.php';

//Draw Calendar
function draw_calendar($month,$year){

    // Draw table for Calendar 
    $calendar = '<table cellpadding="0" cellspacing="0" class="calendar" border="0">';

    // Draw Calendar table headings 
    $headings = array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
    $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

    //days and weeks variable for now ... 
    $running_day = date('w',mktime(0,0,0,$month,1,$year));
    $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
    $days_in_this_week = 1;
    $day_counter = 0;
    $dates_array = array();

    // row for week one 
    $calendar.= '<tr class="calendar-row">';

    // Display "blank" days until the first of the current week 
    for($x = 0; $x < $running_day; $x++):
        $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
        $days_in_this_week++;
    endfor;
$cp='12';
    // Show days.... 
    for($list_day = 1; $list_day <= $days_in_month; $list_day++):
        if($list_day==date('d') && $month==date('n'))
        {
            $currentday='currentday';
        }else
        {
            $currentday='';
        }
        $calendar.= '<td class="calendar-day '.$currentday.'">';
        
            // Add in the day number
            if($list_day<date('d') && $month==date('n'))
            {
                $showtoday='<strong class="overday">'.$list_day.'</strong>';
            }else
            {
                $showtoday=$list_day;
            }


            $calendar.= '<div class="day-number">'.$showtoday.'<br></div>';
                        $no = '0';
                        $sumpendapatan='0';
                        $result = mysql_query("SELECT tgl,sum(masuk) as masuk,sum(keluar) as keluar FROM cashflow where month(tgl)='$month' and year(tgl)='$year' and day(tgl)='$showtoday' group by tgl");
                        while($row =mysql_fetch_array($result)) {
                        $no++;
                        $masuk=$row['masuk'];
                        $keluar=$row['keluar'];
                        //$bersih=$masuk-$keluar;
                        //$sumpendapatan += $masuk;
                        if (empty($pendapatankotor)) {
                            $pendapatankotor=$masuk;
                            $bersih=$pendapatankotor-$keluar;
                        }else{
                            $pendapatankotor =$bersih+$masuk;
                            $bersih=$pendapatankotor-$keluar;
                        }
                        $calendar.="<div style='color:#00FF00;' align='right'>".number_format($masuk,0,',','.')."</div><div style='color:red;' align='right'>".number_format($keluar,0,',','.')."</div><div align='right'>".number_format($bersih,0,',','.')."</div>";
                        }
                        mysql_free_result($result);
        // Draw table end
        $calendar.= '</td>';
        if($running_day == 6):
            $calendar.= '</tr>';
            if(($day_counter+1) != $days_in_month):
                $calendar.= '<tr class="calendar-row">';
            endif;
            $running_day = -1;
            $days_in_this_week = 0;
        endif;
        $days_in_this_week++; $running_day++; $day_counter++;
    endfor;

    // Finish the rest of the days in the week
    if($days_in_this_week < 8):
        for($x = 1; $x <= (8 - $days_in_this_week); $x++):
            $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
        endfor;
    endif;

    // Draw table final row
    $calendar.= '</tr>';

    // Draw table end the table 
    $calendar.= '</table>';
    
    // Finally all done, return result 
    return $calendar;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Membuat Kalendar dengan PHP, HTML dan CSS</title>
    <style>

        @charset "utf-8";
        /* CSS Document */
        html,body,form{ margin:0px; padding:0px; font-family:Ebrima, Arial, Helvetica, sans-serif; font-size:12px; color:#666; empty-cells:hide;}
        table.calendar{border-style: solid; border-width: 1px; border-width:1px; border-color:#666; -moz-box-shadow:0px 0px 4px #CCCCCC; -webkit-box-shadow:0px 0px 4px #CCCCCC; box-shadow:0px 0px 4px #CCCCCC; }
        tr.calendar-row  {  }
        td.calendar-day  { min-height:80px; position:relative; } * html div.calendar-day { height:80px; }
        td.calendar-day:hover  { background:#FFF; -moz-box-shadow:0px 0px 20px #eeeeee inset; -webkit-box-shadow:0px 0px 20px #eeeeee inset; box-shadow:0px 0px 20px #eeeeee inset; cursor:pointer;}
        td.calendar-day-np  { background:#eee; min-height:80px; } * html div.calendar-day-np { height:80px; }
        td.calendar-day-head {font-weight:bold; text-shadow:0px 1px 0px #FFF;color:#666; text-align:center; width:64px; padding:12px 6px; border-bottom:1px solid #CCC; border-top:1px solid #CCC; border-right:1px solid #CCC; background: #ffffff;
        background: -moz-linear-gradient(top,  #ffffff 0%, #ededed 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#ededed));
        background: -webkit-linear-gradient(top,  #ffffff 0%,#ededed 100%);
        background: -o-linear-gradient(top,  #ffffff 0%,#ededed 100%);
        background: -ms-linear-gradient(top,  #ffffff 0%,#ededed 100%);
        background: linear-gradient(to bottom,  #ffffff 0%,#ededed 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 );
        }
        div.day-number{padding:6px; text-align:center; }
        /* shared */
        td.calendar-day, td.calendar-day-np {padding:5px; border-bottom:1px solid #DBDBDB; border-right:1px solid #DBDBDB; font-size:14px;background: #ffffff;
        background: -moz-linear-gradient(top,  #ffffff 0%, #f2f2f2 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#f2f2f2));
        background: -webkit-linear-gradient(top,  #ffffff 0%,#f2f2f2 100%);
        background: -o-linear-gradient(top,  #ffffff 0%,#f2f2f2 100%);
        background: -ms-linear-gradient(top,  #ffffff 0%,#f2f2f2 100%);
        background: linear-gradient(to bottom,  #ffffff 0%,#f2f2f2 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#f2f2f2',GradientType=0 );
        }


        .overday{ color:#164b87; text-shadow:0px 1px 0px #FFF;}
        .currentday{background: #6cb7f3 !important;
        background: -moz-linear-gradient(top,  #6cb7f3 0%, #388be8 100%) !important;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6cb7f3), color-stop(100%,#388be8)) !important;
        background: -webkit-linear-gradient(top,  #6cb7f3 0%,#388be8 100%) !important;
        background: -o-linear-gradient(top,  #6cb7f3 0%,#388be8 100%) !important;
        background: -ms-linear-gradient(top,  #6cb7f3 0%,#388be8 100%) !important;
        background: linear-gradient(to bottom,  #6cb7f3 0%,#388be8 100%) !important;
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6cb7f3', endColorstr='#388be8',GradientType=0 ) !important; color:#FFF  !important; font-weight:bold; -moz-box-shadow:0px 0px 18px #1F68BA inset; -webkit-box-shadow:0px 0px 18px #1F68BA inset; box-shadow:0px 0px 18px #1F68BA inset;
        }
        .currentday:hover{-moz-box-shadow:0px 0px 24px #074080 inset !important; -webkit-box-shadow:0px 0px 24px #074080 inset !important; box-shadow:0px 0px 24px #074080 inset !important;}

    </style>
</head>
<body>

<?php
if(isset($_POST['cari']))
{
    $date  =$_POST['date'];
    $sebelumnya = date("Y-m-1", strtotime("$date -1 month"));
    $selanjutnya = date("Y-m-1", strtotime("$date +1 month"));
    $bulan =date('m', strtotime(str_replace(' ','-', $date)));
    $wulan =date('F', strtotime(str_replace(' ','-', $date)));
    $tahun =date('Y', strtotime(str_replace(' ','-', $date)));
 }else{
    unset($_POST['cari']);
    $today=date('Y-m-1');
    $sebelumnya = date("Y-m-1", strtotime("$today -1 month"));
    $selanjutnya = date("Y-m-1", strtotime("$today +1 month"));
    $tgl=date('Y-m-d');
    $bulan =date('m', strtotime(str_replace(' ','-', $tgl)));
    $tahun =date('Y', strtotime(str_replace(' ','-', $tgl)));
    $wulan =date('F', strtotime(str_replace(' ','-', $tgl)));
}?>



        <div class="row">
            <div class="col-md-12"> 
                <div class="col-sm-8">
                    <form role="form" action="" method="post" class="navbar-form pull-left">
                        <input type="hidden" name="date" value="<?php echo $sebelumnya; ?>">
                        <button type="submit" class="btn btn-outline btn-default" name="cari" id="cari">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Sebelumnya
                        </button>
                    </form>
                </div>
                <div class="col-xs-2 col-sm-offset-2">
                    <form role="form" action="" method="post" class="navbar-form pull-left">
                        <input type="hidden" name="date" value="<?php echo $selanjutnya; ?>">
                        <button type="submit" class="btn btn-outline btn-default" name="cari" id="cari">
                            Selanjutnya <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>


<?php
echo "<h2>".$wulan." ".$tahun."</h2>";
echo draw_calendar($bulan,$tahun); 
?>


</body>
</html>