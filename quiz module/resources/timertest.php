<?php
     
     //$to_time = strtotime("2014-4-21 3:00:00");
     //date_default_timezone_set('Philippines/Manila');
     echo date('Y/m/d h:i:s', time()) . "<br>";
     $to_time = strtotime(date('Y/m/d h:i:s', time()));
     echo $to_time . "<br>";
     $from_time = strtotime("2014-4-30 12:00:00");
     echo round(abs($to_time - $from_time) / 60,2). " minute";
     
?>