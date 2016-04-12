<?php
require_once 'vendor/autoload.php';


use Adlogix\Confluence\Client\ClientBuilder;
use Adlogix\Confluence\Client\Security\Authentication\JwtHeaderAuthentication;



$lifecycle = new \Adlogix\Confluence\Client\Entity\Connect\DescriptorLifecycle();
$lifecycle->setInstalled('/playground.php?action=installed')
    ->setEnabled('/playground.php?action=enabled');

$descriptor = new \Adlogix\Confluence\Client\Entity\Connect\Descriptor("http://myconnectplugin.dev/",
    'dev.mypluginkey');

$descriptor->setLifecycle($lifecycle)
    ->setScopes([
        'read'
    ]);

$securityContext = new \Adlogix\Confluence\Client\Entity\Connect\SecurityContext();

if (file_exists('payload.json')) {
    $payload = json_decode(file_get_contents('payload.json'));
    $securityContext->setSharedSecret($payload->sharedSecret);
}

$client = ClientBuilder::create(
    'http://confluence.dev/confluence',
    new JwtHeaderAuthentication(
        $securityContext,
        $descriptor
    )
)
    ->setDebug(true)
    ->build();


$action = (@$_GET['action']) ?: "";
switch ($action) {
    case 'descriptor':
        echo $client->descriptor()->get();
        break;

    case 'installed':
        file_put_contents('payload.json', file_get_contents('php://input'));
        http_response_code(200);
        echo 'OK';
        break;

    case 'enabled':
        http_response_code(200);
        echo 'OK';
        break;

    default:
        try {
            var_dump($client->spaces()->all());
        } catch (ApiException $ex) {
            var_dump($ex->getApiError());
        }

        break;
}

