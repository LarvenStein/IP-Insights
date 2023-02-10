<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
   integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
   integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
   crossorigin=""></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP-Insights</title>
</head>
<body>
    <header>
    <h1>IP-Insights GeoIP</h1>
    <form method="get">
        <?php
        error_reporting(0);
        echo '
        <input type="text" id="query" name="query" value="'.$_GET['query'].'" placeholder="IP Adress or Domain"><button type="submit" class="search">Search</button>
        ';
        ?>
    </form>
    <br>
    </header>
    <script src="ping.js"></script>
    <br>
<?php
    if(!isset($_GET['query'])) {
        $query = $_SERVER['REMOTE_ADDR'];
    } else {
        $query = $_GET['query'];
        
    }

        $ipdata = [];
        
        if (str_contains($query, ':')) {
            $query = explode(':', $_GET['query'])[0];
        } 

        $ipdatajson = file_get_contents('http://ip-api.com/json/'.$query.'?fields=28569599');
        $ipdata = json_decode($ipdatajson, true);

        if($ipdata['hosting'] == 'true') {
            $datacenter = '✔';
        } else {
            $datacenter = '✘';
        }
        if($ipdata['mobile'] == 'true') {
            $mobile = '✔';
        } else {
            $mobile = '✘';
        }
        if($ipdata['proxy'] == 'true') {
            $vpn = '✔';
        } else {
            $vpn = '✘';
        }

        if($ipdata['status'] == 'success') {

        echo "
<div class='center'>
        <h3>The IP address &#34;".$ipdata['query']."&#34; belongs to this region:</h3>
        <div id='map'></div>
        </div>
        <script>
        var map = L.map('map').setView([".$ipdata['lat'].", ".$ipdata['lon']."], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
        }).addTo(map);
        L.marker([".$ipdata['lat'].", ".$ipdata['lon']."]).addTo(map)
        .bindPopup('<table><tr><td></td><td><b>".$ipdata['query']."</b></td></tr><tr><td><i>City:</i></td><td>".$ipdata['city']."</td></tr><tr><td><i>Region:</i></td><td>".$ipdata['regionName']." (".$ipdata['region'].")</td></tr><tr><td><i>Country: </i></td><td>".$ipdata['country']." (".$ipdata['countryCode'].")</td></tr><tr><td><i>Time zone: </i></td><td>".$ipdata['timezone']."</td></tr><tr><td><i>ISP:</i></td><td>".$ipdata['isp']."</td></tr><tr><td><i>Datacenter: </i></td><td>".$datacenter."</td></tr><tr><td><i>Mobile: </i></td><td>".$mobile."</td></tr></table>')
        .openPopup();
        </script>

        <div class='center'>
         <h2>Detailed information</h2>
         <div class='exactinfo'>
         <table>
             <tr>
                 <td><i>Search: </i></td>
                 <td></td>
                 <td> ".$query."</td>
             </tr>
             <tr>
             <td><i>IP: </i></td>
             <td></td>
             <td> ".$ipdata['query']."</td>
             </tr>
            <tr>
             <td><i>PING: </i></td>
             <td></td>
             <td><span id='ping' class='testping' onclick='testping(&#34;".$query."&#34;)'>Test Ping</span></td>
             </tr>
             <tr>
             <td><i>LAT/LON: </i></td>
             <td></td>
             <td> ".$ipdata['lat']."/".$ipdata['lon']."</td>
             </tr>
             <tr>
             <td><i>City: </i></td>
             <td></td>
             <td> ".$ipdata['city']."</td>
             </tr>
             <tr>
             <td><i>Postcode: </i></td>
             <td></td>
             <td> ".$ipdata['zip']."</td>
         </tr>
         <tr>
         <td><i>Region: </i></td>
         <td></td>
         <td> ".$ipdata['regionName']." (".$ipdata['region'].")</td>
         </tr>
         <tr>
         <td><i>Country: </i></td>
         <td></td>
         <td> ".$ipdata['country']." (".$ipdata['countryCode'].")</td>
         </tr>
         <tr>
         <td><i>Continent: </i></td>
         <td></td>
         <td> ".$ipdata['continent']." (".$ipdata['continentCode'].")</td>
         </tr>
         <tr>
         <td><i>Currency</i></td>
         <td></td>
         <td> ".$ipdata['currency']."</td>
         </tr>
         <tr>
         <td><i>Time zone: </i></td>
         <td></td>
         <td> ".$ipdata['timezone']."</td>
         </tr>
         <tr>
         <td><i>ISP</i></td>
         <td></td>
         <td> ".$ipdata['isp']."</td>
         </tr>
         <tr>
         <td><i>Organization</i></td>
         <td></td>
         <td> ".$ipdata['org']."</td>
         </tr>
         <tr>
         <td><i>AS number</i></td>
         <td></td>
         <td> ".$ipdata['as']."</td>
         </tr>
         <tr>
         <td><i>VPN/Proxy</i></td>
         <td></td>
         <td> ".$vpn."</td>
         </tr>
         <tr>
         <td><i>Mobile: </i></td>
         <td></td>
         <td> ".$mobile."</td>
         </tr>
         <tr>
         <td><i>Data center: </i></td>
         <td></td>
         <td> ".$datacenter."</td>
         </tr>
         </table>
         </div>
         </div>

        ";
    } else {
        echo '<div class="center"><h3>Deine Anfrage ist Fehlgeschlagen!</h3></div>';
    }
        
   

    echo '
    <div class="center">
    ';
        include 'footer.php';
?> 
    </div> 
</body>
</html>