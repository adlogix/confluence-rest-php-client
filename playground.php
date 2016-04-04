<?php


use Adlogix\Confluence\Client\ClientBuilder;
use Adlogix\Confluence\Client\Security\BasicAuthentication;

require_once 'vendor/autoload.php';

$client = ClientBuilder::create(
  'https://adlogix.jira.com/wiki/rest/api/',
  new BasicAuthentication('test', 'test')
)
  ->setDebug(true)
  ->build();

// CPE Service
$products = $client->products();


try {

    var_dump($response);
} catch (ApiException $ex) {
    var_dump($ex->getApiError());
}
