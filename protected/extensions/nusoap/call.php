<html>
<head>
<title>ThaiCreate.Com PHP & UTF-8</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
</head>
<?php
// header('Content-Type: text/html; charset=utf-8');
require_once "lib/nusoap.php";
// This is your Web service server WSDL URL address
$wsdl = "https://hris.parliament.go.th/service/WebserviceServer.php?wsdl";

// Create client object
$client = new nusoap_client($wsdl, 'wsdl');
$err = $client->getError();
if ($err) {
   // Display the error
   echo '<h2>Constructor error</h2>' . $err;
   // At this point, you know the call that follows will fail
   exit();
}

// Call the hello method
$result1=$client->call('PerProfilePublic', array('User'=>'hrd','Password'=>'hrd2561','PerId'=>9));
echo '<pre>';
print_r($result1).'\n';
?>
</body>
</html> 