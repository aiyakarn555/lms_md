<?php
require_once "lib/nusoap.php";

// Create the server instance
$server = new soap_server();
$server->configureWSDL('server', 'urn:server');

$server->wsdl->schemaTargetNamespace = 'urn:server';

// SOAP complex type return type (an array/struct)
$server->wsdl->addComplexType(
   'Person',
   'complexType',
   'struct',
   'all',
   '',
   array('id_user' => array('name' => 'id_user',
         'type' => 'xsd:int'))
);

// Register the "hello" method to expose it
$server->register('hello',
         array('username' => 'xsd:string'),   // parameter
         array('return' => 'xsd:string'),     // output
         'urn:server',                        // namespace
         'urn:server#helloServer',            // soapaction
         'rpc',                               // style
         'encoded',                           // use
         'Just say hello');                   // description

// Implement the "hello" method as a PHP function
function hello($username) {
   return 'Hello, '.$username.'!';
}

// Use the request to invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)
   ? $HTTP_RAW_POST_DATA : '';
// $server->service($HTTP_RAW_POST_DATA);
@$server->service(file_get_contents("php://input"));
?>