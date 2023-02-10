<!DOCTYPE html>
<html lang="en">
<head>
        <link rel="stylesheet" href="../style.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>IP Lookup | Traceroute</title>
</head>
<body>
<script src="tr.js" defer></script>
<header>
<h1>IP-Insights Traceroute</h1>
<form method="get">
        <?php
            error_reporting(0);
        echo '
        <input type="text" id="query" name="query" value="'.$_GET['query'].'" placeholder="IP Adress or Domain"><button type="submit" class="search"">Search</button>
        ';
        ?>
</form>
<br>
</header>
<div class="center">

<div>
    <div id="tr" >
        

    <?php
            error_reporting(0);

    if(strlen($_GET['query']) <= 2) {
        echo '<b>Sorry, your request failed!</b>';
} else {
        if(isset($_GET['query'])) {
                $query = $_GET['query'];
        } else {
                $query = $_SERVER['REMOTE_ADDR'];
        }
        if (str_contains($query, ':')) {
            $query = explode(':', $query)[0];
        } else {
            $query = $query;
        }

        $statusdata = file_get_contents('http://ip-api.com/json/'.$query.'?fields=16384');

        $statusdata_decode = json_decode($statusdata, true);

        if($statusdata_decode['status'] == 'success') {
        echo '
                <h3>Tracerouting to '.$_GET['query'].'</h3>

        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Lightness_rotate_36f_cw.gif" height="150px">
    </div>';
    } else {
                echo '<b>Sorry, your request failed!</b>';

    }
}
        echo '<div class="center">';
        include '../footer.php';
?> 
</div>
</div>
</div>   
</body>
</html>