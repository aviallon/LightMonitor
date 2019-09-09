<?php include_once("utils/scripts.inc"); ?> <!DOCTYPE html> <html> <head> <title>Monitoring console - lesviallon.fr</title> <script defer src="zepto.min.js"></script> <script defer type="text/javascript" src="flotr2.min.js"></script> <link rel="stylesheet" type="text/css" href="style.css"/> <meta name="viewport" content="width=device-width"> <meta charset="utf-8"/> </head> <body> <h3>General</h3> <?php
$cmds = array("uname -a", "date +'%c'", "pacman -Qu", "ps -eo pcpu,pid,user,args | sort -k 1 -r | head -5", "df -h / /data");
foreach($cmds as $cmd){
	printCommandOutput($cmd, false);
}
?> <h3>CPU temperatures :</h3> <div id="temps"> <?php
$sens_outpt = [];
exec("python3 utils/cputemp.py", $sens_outpt);
$res = json_decode($sens_outpt[0], true);
foreach($res as $cpu => $temp){
?> <div class="cpu-temp"><?php echo $cpu; ?> : <span id="cpu-<?php echo $cpu; ?>"><?php echo $temp; ?>°C</span></div><br/> <?php
}
?> </div> <div id="temp_graph" class="graph"> </div> <h3>CPU usage :</h3> <div> <?php
$outpt = [];
exec("top -bn1 | grep 'Cpu(s)' | sed 's/.*, *\\([0-9.]*\\)%* id.*/\\1/'",$outpt);
echo 'Average : <span id="cpuavg">'.$outpt[0]."%</span><br/>";
?> </div> <div id="cpuavg_graph" class="graph"> </div> <h3>Service statuses:</h3> <div id="serviceinfo"> <?php
include("utils/serviceinfo.php")
?> </div> <script defer>var temp_graph=document.getElementById("temp_graph"),startTemps=(new Date).getTime(),cputemps=[],graphTemps,xminTemps=0,xmaxTemps=60;var cpuavg_graph=document.getElementById("cpuavg_graph"),startAvg=(new Date).getTime(),cpuavg=[],graphAvg,xminAvg=0,xmaxAvg=60;function update_graph(vals,graph,container,datas,start,xmin,xmax,ymax){var offset=((new Date).getTime()-start)/1000;while(datas.length<vals.length){datas.push({data:[],label:vals[datas.length].name,lines:{fill:true}});}$.each(vals,function(i,val){datas[i].data.push([offset,val.val]);if(datas[i].data[0][0]+xmax<offset){datas[i].data.shift();xmin=datas[i].data[0][0];}});graph=Flotr.draw(container,datas,{yaxis:{max:ymax,min:0},xaxis:{max:xmax+xmin,min:xmin,title:"Time (s)",showLabels:true}});}function update_temps(){$.getJSON('utils/cputemp.php',function(data){temps=[];$.each(data,function(i,field){$("#cpu-"+i).html(field+"°C");temps.push({name:i,val:field});});update_graph(temps,graphTemps,temp_graph,cputemps,startTemps,xminTemps,xmaxTemps,60);});}function update_cpuavg(){$.getJSON('utils/cpuavg.php',function(data){var load=100-(data.sysstat.hosts[0].statistics[0]["cpu-load"][0].idle);$("#cpuavg").html(load+'%');update_graph([{name:"Average Load",val:load}],graphAvg,cpuavg_graph,cpuavg,startAvg,xminAvg,xmaxAvg,100);});}function update_serviceinfo(){$.get('utils/serviceinfo.php',function(data){$("#serviceinfo").html(data);});}window.setInterval(update_serviceinfo,10000);window.setInterval(update_cpuavg,1000);window.setInterval(update_temps,1000);</script> </body> </html> 
