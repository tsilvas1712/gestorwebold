<?php

$client = new http\Client;
$request = new http\Client\Request;

$body = new http\Message\Body;
$body->append('<?xml version="1.0"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.commons.rico.ativos.com.br/"><soapenv:Header/><soapenv:Body><ser:listarFases><ndg>0000000928254653</ndg></ser:listarFases></soapenv:Body></soapenv:Envelope>');

$request->setRequestUrl('https://webservice.ativossa.com.br/rico-webservice/FaseService');
$request->setRequestMethod('POST');
$request->setBody($body);

$request->setQuery(new http\QueryString([
  'wsdl' => ''
]));

$request->setHeaders([
  'content-type' => 'application/xml',
  'authorization' => 'Basic amFxdWVsaW5lLmJhcnJldG86QXRpdm9zQDY2'
]);

$client->enqueue($request)->send();
$response = $client->getResponse();

echo $response->getBody();



