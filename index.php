<!DOCTYPE html>
<html lang="de">
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
    <title>IP Lookup</title>
</head>
<body>
<div class="center">
    <h1>IP Lookup</h1>
    <form method="get">
        <input type="text" id="query" name="query" placeholder="IP Adresse oder Domain"><button type="submit" class="search">Suchen</button>
    </form>
    <br>
</div>
<?php
    if(isset($_GET['query'])) {

        $ipdata = [];
        
        $ipdatajson = file_get_contents('http://ip-api.com/json/'.$_GET['query'].'?fields=28569599');
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

        echo "
        <div class='center'>
        <h3>Die IP Adresse &#34;".$ipdata['query']."&#34; gehört zu dieser Region:</h3>
        <div id='map'></div>
        </div>
        <script>
        var map = L.map('map').setView([".$ipdata['lat'].", ".$ipdata['lon']."], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
        }).addTo(map);
        L.marker([".$ipdata['lat'].", ".$ipdata['lon']."]).addTo(map)
        .bindPopup('<table><tr><td></td><td><b>".$ipdata['query']."</b></td></tr><tr><td><i>Stadt:</i></td><td>".$ipdata['city']." (".$ipdata['zip'].")</td></tr><tr><td><i>Region:</i></td><td>".$ipdata['regionName']." (".$ipdata['region'].")</td></tr><tr><td><i>Land: </i></td><td>".$ipdata['country']." (".$ipdata['countryCode'].")</td></tr><tr><td><i>Zeitzone: </i></td><td>".$ipdata['timezone']."</td></tr><tr><td><i>ISP:</i></td><td>".$ipdata['isp']."</td></tr><tr><td><i>Datacenter: </i></td><td>".$datacenter."</td></tr><tr><td><i>Mobil: </i></td><td>".$mobile."</td></tr></table>')
        .openPopup();
        </script>

        <div class='center'>
        <h2>Genaue Informationen</h2>
        <div class='exactinfo'>
        <table>
            <tr>
                <td><i>Suche: </i></td>
                <td></td>
                <td> ".$_GET['query']."</td>
            </tr>
            <tr>
            <td><i>IP: </i></td>
            <td></td>
            <td> ".$ipdata['query']."</td>
            </tr>
            <tr>
            <td><i>LAT/LON: </i></td>
            <td></td>
            <td> ".$ipdata['lat']."/".$ipdata['lon']."</td>
            </tr>
            <tr>
            <td><i>Stadt: </i></td>
            <td></td>
            <td> ".$ipdata['city']."</td>
            </tr>
            <tr>
            <td><i>Postleitzahl: </i></td>
            <td></td>
            <td> ".$ipdata['zip']."</td>
        </tr>
        <tr>
        <td><i>Region: </i></td>
        <td></td>
        <td> ".$ipdata['regionName']." (".$ipdata['region'].")</td>
        </tr>
        <tr>
        <td><i>Land: </i></td>
        <td></td>
        <td> ".$ipdata['country']." (".$ipdata['countryCode'].")</td>
        </tr>
        <tr>
        <td><i>Kontinent: </i></td>
        <td></td>
        <td> ".$ipdata['continent']." (".$ipdata['continentCode'].")</td>
        </tr>
        <tr>
        <td><i>Währung</i></td>
        <td></td>
        <td> ".$ipdata['currency']."</td>
        </tr>
        <tr>
        <td><i>Zeitzone: </i></td>
        <td></td>
        <td> ".$ipdata['timezone']."</td>
        </tr>
        <tr>
        <td><i>ISP</i></td>
        <td></td>
        <td> ".$ipdata['isp']."</td>
        </tr>
        <tr>
        <td><i>Organisation</i></td>
        <td></td>
        <td> ".$ipdata['org']."</td>
        </tr>
        <tr>
        <td><i>AS Nummer</i></td>
        <td></td>
        <td> ".$ipdata['as']."</td>
        </tr>
        <tr>
        <td><i>VPN/Proxy </i></td>
        <td></td>
        <td> ".$vpn."</td>
        </tr>
        <tr>
        <td><i>Mobile: </i></td>
        <td></td>
        <td> ".$mobile."</td>
        </tr>
        <tr>
        <td><i>Datacenter: </i></td>
        <td></td>
        <td> ".$datacenter."</td>
        </tr>
        </table>
        </div>
        </div>

        ";
        
    } else {
        
        $ipdata = [];
        $domain = $_SERVER['REMOTE_ADDR'];
        
        $ipdatajson = file_get_contents('http://ip-api.com/json/'.$domain.'?fields=28569599');
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

        echo "
        <div class='center'>
        <h3>Deine IP Adresse (".$ipdata['query'].") gehört zu dieser Region:</h3>
        <div id='map'></div>
        </div>
        <script>
        var map = L.map('map').setView([".$ipdata['lat'].", ".$ipdata['lon']."], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
        }).addTo(map);
        L.marker([".$ipdata['lat'].", ".$ipdata['lon']."]).addTo(map)
        .bindPopup('<table><tr><td></td><td><b>".$ipdata['query']."</b></td></tr><tr><td><i>Stadt:</i></td><td>".$ipdata['city']." (".$ipdata['zip'].")</td></tr><tr><td><i>Region:</i></td><td>".$ipdata['regionName']." (".$ipdata['region'].")</td></tr><tr><td><i>Land: </i></td><td>".$ipdata['country']." (".$ipdata['countryCode'].")</td></tr><tr><td><i>Zeitzone: </i></td><td>".$ipdata['timezone']."</td></tr><tr><td><i>ISP:</i></td><td>".$ipdata['isp']."</td></tr><tr><td><i>Datacenter: </i></td><td>".$datacenter."</td></tr><tr><td><i>Mobil: </i></td><td>".$mobile."</td></tr></table>')
        .openPopup();
        </script>

        <div class='center'>
        <h2>Genaue Informationen</h2>
        <div class='exactinfo'>
        <table>
            <tr>
                <td><i>Suche: </i></td>
                <td></td>
                <td>Deine IP (".$ipdata['query'].")</td>
            </tr>
            <tr>
            <td><i>IP: </i></td>
            <td></td>
            <td> ".$ipdata['query']."</td>
            </tr>
            <tr>
            <td><i>LAT/LON: </i></td>
            <td></td>
            <td> ".$ipdata['lat']."/".$ipdata['lon']."</td>
            </tr>
            <tr>
            <td><i>Stadt: </i></td>
            <td></td>
            <td> ".$ipdata['city']."</td>
            </tr>
            <tr>
            <td><i>Postleitzahl: </i></td>
            <td></td>
            <td> ".$ipdata['zip']."</td>
        </tr>
        <tr>
        <td><i>Region: </i></td>
        <td></td>
        <td> ".$ipdata['regionName']." (".$ipdata['region'].")</td>
        </tr>
        <tr>
        <td><i>Land: </i></td>
        <td></td>
        <td> ".$ipdata['country']." (".$ipdata['countryCode'].")</td>
        </tr>
        <tr>
        <td><i>Kontinent: </i></td>
        <td></td>
        <td> ".$ipdata['continent']." (".$ipdata['continentCode'].")</td>
        </tr>
        <tr>
        <td><i>Währung</i></td>
        <td></td>
        <td> ".$ipdata['currency']."</td>
        </tr>
        <tr>
        <td><i>Zeitzone: </i></td>
        <td></td>
        <td> ".$ipdata['timezone']."</td>
        </tr>
        <tr>
        <td><i>ISP</i></td>
        <td></td>
        <td> ".$ipdata['isp']."</td>
        </tr>
        <tr>
        <td><i>Organisation</i></td>
        <td></td>
        <td> ".$ipdata['org']."</td>
        </tr>
        <tr>
        <td><i>AS Nummer</i></td>
        <td></td>
        <td> ".$ipdata['as']."</td>
        </tr>
        <tr>
        <td><i>VPN/Proxy </i></td>
        <td></td>
        <td> ".$vpn."</td>
        </tr>
        <tr>
        <td><i>Mobile: </i></td>
        <td></td>
        <td> ".$mobile."</td>
        </tr>
        <tr>
        <td><i>Datacenter: </i></td>
        <td></td>
        <td> ".$datacenter."</td>
        </tr>
        </table>
        </div>
        </div>

        ";
        
    }
?>
</body>
</html>