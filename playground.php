<?php
use Adlogix\ConfluenceClient\ClientBuilder;
use Adlogix\ConfluenceClient\Security\QueryParamAuthentication;
use Adlogix\ConfluenceClient\Tests\Helper\Payload;

require_once 'vendor/autoload.php';


/**
 * See the 'installed' webhook on how to recover this payload.
 *
 * The sharedSecret is given by the application we installed the add-on to,
 * this is needed to sign our request and to validate the requests from the application.
 */
$payload = new Payload('payload.json');


$authenticationMethod = new QueryParamAuthentication('eu.adlogix.confluence-client',  $payload->getSharedSecret());
/** @var \Adlogix\ConfluenceClient\Client $client */
$client = ClientBuilder::create($payload->getBaseUrl(), $authenticationMethod)
    ->setDebug(true)
    ->build();


$response = $client->sendRawApiRequest('GET', 'space');
echo $response->getBody()->getContents();

echo "\r\n\r\n=======================================================================================================" .
    "==============================================================================================\r\n\r\n";

$response = $client->downloadAttachment('download/attachments/197288/Seller%20Admin%20logo%20stats.png?api=v2');
echo $response->getBody()->getContents();
