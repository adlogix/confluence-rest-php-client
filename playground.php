<?php


use Adlogix\Confluence\Client\ClientBuilder;
use Adlogix\Confluence\Client\Security\BasicAuthentication;

require_once 'vendor/autoload.php';

require_once 'config.default.php';
@require_once 'config.local.php';

$client = ClientBuilder::create(
    'https://confluence.dev/confluence/rest/api/',
    new BasicAuthentication($config['username'], $config['password'])
)
    ->setDebug(true)
    ->build();

// CPE Service
$spaces = $client->spaces();


try {
    $response = $spaces->all();
    var_dump($response);
} catch (ApiException $ex) {
    var_dump($ex->getApiError());
}
