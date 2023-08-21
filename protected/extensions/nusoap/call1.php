<?php
require_once "lib/nusoap.php";
// This is your Web service server WSDL URL address
$wsdl = "http://localhost:8080/nusoap/index.php?wsdl";

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
$result1=$client->call('hello', array('username'=>'John'));
print_r($result1).'\n';
?>