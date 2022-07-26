<!DOCTYPE html>
<html lang="de">
<head>
        <link rel="stylesheet" href="../style.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>IP Lookup | Whois</title>
</head>
<body>
<header>
<h1>IP Lookup WHOIS</h1>
<form method="get">
        <?php
        echo '
        <input type="text" id="query" name="query" value="'.$_GET['query'].'" placeholder="IP Adresse oder Domain"><button type="submit" class="search">Suchen</button>
        ';
        ?>
</form>
<br>
</header>
<div class="center">
        <?php
        echo '<h3>Whois Anfrage für '.$_GET['query'].':</h3>';
        ?>
</div>
<div class="center2">
        <div>
<?php
include './vendor/autoload.php';
use Unirest\Request;
require_once 'vendor/mashape/unirest-php/src/Unirest.php';
require_once('./vendor/autoload.php');
require_once 'vendor/autoload.php';
require_once('./keys.php');

if(strlen($_GET['query']) <= 2) {
        echo '<b>Deine Anfrage ist leider Fehlgeschlagen!</b>';
} else {
        if(isset($_GET['query'])) {
                $query = $_GET['query'];
        } else {
                $query = $_SERVER['REMOTE_ADDR'];
        }

        $statusdata = file_get_contents('http://ip-api.com/json/'.$query.'?fields=16384');

        $statusdata_decode = json_decode($statusdata, true);

        if($statusdata_decode['status'] == 'success') {
                $customer_id = whoisID();
                $api_key = whoisKey();
            
                Unirest\Request::auth($customer_id, $api_key);
                $headers = array("Accept" => "application/json");
                $url = "https://jsonwhoisapi.com/api/v1/whois?identifier=".$query."";
                $response = Unirest\Request::get($url, $headers);
            
            
                foreach($response->body->nameservers as $ns){
                    $nameserver .= $ns . "\n";
                }
                foreach($response->body->contacts->owner as $owner){
                    $ownercontact = $owner;
                }
                foreach($response->body->contacts->admin as $admin){
                    $admincontact = $admin;
                }
                foreach($response->body->contacts->tech as $tech){
                    $techcontact = $tech;
                }
            
            
                $whoismessage = '
            Name: '.$response->body->name.'<br>
            Created: '.$response->body->created.'<br>
            Changed: '.$response->body->changed.'<br>
            Expires: '.$response->body->expires.'<br>
            Dnssec: '.$response->body->dnssec.'<br>
            Registerd: '.$response->body->registered.'<br>
            Status: '.$response->body->status.'<br>
            <br>
            ==Nameservers==<br>
            '.$nameserver.'<br>
            <br>
            ==Registrar==<br>
            ID: '.$response->body->registrar->id.'<br>
            Name: '.$response->body->registrar->name.'<br>
            Email: '.$response->body->registrar->email.'<br>
            URL: '.$response->body->registrar->url.'<br>
            Phone: '.$response->body->registrar->phone.'<br>
            <br>
            ==Owner Contact==<br>
            Handle: '.$ownercontact->handle.'<br>
            Type: '.$ownercontact->type.'<br>
            Name: '.$ownercontact->name.'<br>
            Organization: '.$ownercontact->organization.'<br>
            E-Mail: '.$ownercontact->email.'<br>
            Adress: '.$ownercontact->adress.'<br>
            Zip Code: '.$ownercontact->zipcode.'<br>
            City: '.$ownercontact->city.'<br>
            State: '.$ownercontact->state.'<br>
            Country: '.$ownercontact->country.'<br>
            Phone: '.$ownercontact->phone.'<br>
            Fax: '.$ownercontact->fax.'<br>
            Created: '.$ownercontact->created.'<br>
            Changed: '.$ownercontact->changed.'<br>
            <br>
            ==Admin Contact==<br>
            Handle: '.$admincontact->handle.'<br>
            Type: '.$admincontact->type.'<br>
            Name: '.$admincontact->name.'<br>
            Organization: '.$admincontact->organization.'<br>
            E-Mail: '.$admincontact->email.'<br>
            Adress: '.$admincontact->adress.'<br>
            Zip Code: '.$admincontact->zipcode.'<br>
            City: '.$admincontact->city.'<br>
            State: '.$admincontact->state.'<br>
            Country: '.$admincontact->country.'<br>
            Phone: '.$admincontact->phone.'<br>
            Fax: '.$admincontact->fax.'<br>
            Created: '.$admincontact->created.'<br>
            Changed: '.$admincontact->changed.'<br>
            <br>
            ==Tech Contact==<br>
            Handle: '.$techcontact->handle.'<br>
            Type: '.$techcontact->type.'<br>
            Name: '.$techcontact->name.'<br>
            Organization: '.$techcontact->organization.'<br>
            E-Mail: '.$techcontact->email.'<br>
            Adress: '.$techcontact->adress.'<br>
            Zip Code: '.$techcontact->zipcode.'<br>
            City: '.$techcontact->city.'<br>
            State: '.$techcontact->state.'<br>
            Country: '.$techcontact->country.'<br>
            Phone: '.$techcontact->phone.'<br>
            Fax: '.$techcontact->fax.'<br>
            Created: '.$techcontact->created.'<br>
            Changed: '.$techcontact->changed.'<br>
            
                ';

                echo $whoismessage;
        } else {
                echo '<b>Deine Anfrage ist leider Fehlgeschlagen!</br>';
                die;
        }
}

echo '
    <div class="center">
    ';
        include '../footer.php';
?> 
</div>
    </div> 
</div>   
</body>
</html>
