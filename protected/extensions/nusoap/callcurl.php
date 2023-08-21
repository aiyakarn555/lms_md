<?php
$wsdl = 'https://hris.parliament.go.th/service/WebserviceServer.php?wsdl';
$client = new SoapClient($wsdl); 
$methodName = 'PerProfilePublic'; 
$params = array('User'=>'hrd','Password'=>'hrd2561','PerId'=>9); 
$soapAction = 'https://hris.parliament.go.th/service/WebserviceServer.php/PerProfilePublic'; 
$objectResult = $client->__soapCall($methodName, array('parameters' => $params), array('soapaction' => $soapAction)); 
var_dump($objectResult) ;