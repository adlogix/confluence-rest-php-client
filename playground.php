<?php
use Adlogix\ConfluenceClient\ClientBuilder;
use Adlogix\ConfluenceClient\Security\QueryParamAuthentication;

require_once 'vendor/autoload.php';


/**
 * See the 'installed' webhook on how to recover this payload.
 *
 * The sharedSecret is given by the application we installed the add-on to,
 * this is needed to sign our request and to validate the requests from the application.
 */
if (file_exists('payload.json')) {
    $payload = json_decode(file_get_contents('payload.json'));
    $sharedSecret = $payload->sharedSecret;
    $baseUrl = $payload->baseUrl . '/';
}


$authenticationMethod = new QueryParamAuthentication('eu.adlogix.confluence-client', $sharedSecret);
/** @var \Adlogix\ConfluenceClient\Client $client */
$client = ClientBuilder::create($baseUrl, $authenticationMethod)
    ->setDebug(true)
    ->build();


$response = $client->sendRawApiRequest('GET', 'space');
var_dump($response->getBody()->getContents());

echo "\r\n\r\n=====================================================================================================================================================================================================\r\n\r\n";
$response = $client->downloadAttachment('download/attachments/197288/Seller%20Admin%20logo%20stats.png?api=v2');
var_dump($response->getBody()->getContents());
