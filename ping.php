<?php
header('Content-Type: text/plain');

if(isset($_GET['ip'])) {
    $valid = file_get_contents('http://ip-api.com/line/'.$_GET['ip'].'?fields=16384');
    if(str_contains($valid, 'success')) {
        $ping = exec("bash /www/wwwroot/ip.steinlarve.de/ping.sh ".$_GET['ip']);
        echo str_replace("OK","",$ping);
    } else {
        echo "Invalid IP/Domain";
    }
} else {
    echo "Specify a target via the ip parameter.";
}
