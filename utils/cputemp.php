<?php
$sens_outpt = [];
exec("python3 cputemp.py", $sens_outpt);
/*foreach($sens_outpt as $str){
    echo $str . "<br />";
}
$temp_subs1 = array();
preg_match('/\+([0-9.]+)°C/', $sens_outpt[3], $temp_subs1);
$temp_subs2 = array();
preg_match('/\+([0-9.]+)°C/', $sens_outpt[5], $temp_subs2);
*/

//$core_temps = [floatval($temp_subs1[1]), floatval($temp_subs2[1])];

echo $sens_outpt[0];
//echo json_encode($core_temps);
//echo $core_temps[0] . "°C <br />";
//echo $core_temps[1] . "°C <br />";

?>
