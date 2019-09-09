<?php
function printServiceStatus($service){
        $service_arg = escapeshellarg($service);
        $outpt = [];
        $outpt2 = [];
        exec("systemctl is-active ".$service_arg, $outpt);
        $status = $outpt[0];
        exec("systemctl is-enabled ".$service_arg." 2>&1", $outpt2);
//        echo "$service : $outpt2[0]";
        $print_enabled = false;
        $enabled = "";
        //echo "systemctl is-enabled ( $service ): ";
        //print_r($outpt2);
        if(trim($outpt2[0]) == "disabled"){
			$enabled = "disabled";
			$print_enabled = true;
		} elseif(strpos($outpt2[0], "No such file") != false) {
			$enabled = "non-existent";
			$print_enabled = true;
        }
?>
<div class="service-status">
<span class="service-name"><?php echo $service; ?></span> : <span class="service-status-info <?php echo $status; ?>"><?php echo $status; ?></span>
<?php if($print_enabled) { ?>
<span class="service-status-info <?php echo $enabled; ?>"><?php echo $enabled; ?></span>
<?php } ?>
</div><br/>
<?php
}
?>

<?php

function printCommandOutput($cmd, $safe=true){ // Warning ! Very unsafe ! Do not allow any use of this function to any user
    $user = [];
    exec('whoami', $user);
    $hostname = [];
    exec('cat /etc/hostname', $hostname);
    $hostname = $hostname[0];
    $user = $user[0];
	if($safe){
		$cmd = escapeshellcmd($cmd);
	}
        $outpt = [];
        exec($cmd." 2>&1", $outpt);
?>
<div class="command-output">
<span class="shell-output"><?php echo "$ $cmd"/*"[".$user."@".$hostname."]$ ".$cmd;*/ ?><br style="margin-bottom:3px;"/>
<?php
foreach($outpt as $res){
        echo str_replace(["\t", " "], "&nbsp;", $res) . "<br/>";
}
?>
</span><br/>
</div><br/>
<?php
}
?>
