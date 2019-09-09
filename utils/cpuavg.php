<?php
$outpt = [];
exec("mpstat 1 1 -o JSON", $outpt);
//exec("top -bn1 | grep 'Cpu(s)' | sed 's/.*, *\\([0-9.]*\\)%* id.*/\\1/'",$outpt);
foreach($outpt as $line){
	echo $line;
}
//echo 100-floatval($outpt[0]);
?>
