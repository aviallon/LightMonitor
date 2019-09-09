<?php
include_once("scripts.inc");

$services = array("lighttpd", "httpd", "synapse", "postgresql", "redis", "sshd", "rsyncd", "gitlab.target", "gitlab-workhorse", "gitlab-unicorn", "gitlab-gitaly", "gitlab-backup.service", "gitlab-runner", "minecraft-server", "mcpe-server", "pacman-dbupdate.timer", "dovecot", "postfix");
foreach($services as $service){
    printServiceStatus($service);
}
?>
