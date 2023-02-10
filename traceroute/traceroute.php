<?php


error_reporting(-1);
    header('Content-Type: text/plain');
    if(!isset($_GET["query"])) {
        die('missing "query" parameter');
    }
    $dest_url = htmlspecialchars($_GET["query"]);
    
    $result =  shell_exec("traceroute ".$dest_url);
    print_r ($result);
?>
