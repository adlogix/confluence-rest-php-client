<?php


use Adlogix\Confluence\Client\ClientBuilder;
use Adlogix\Confluence\Client\Security\ConnectJwtAuthentication;
use JMS\Serializer\SerializerBuilder;

require_once 'vendor/autoload.php';

require_once 'config.default.php';
@require_once 'config.local.php';

$descriptor = json_encode(
    [
        "key" => "eu.adlogix.adsdaq.doc",
        "name" => "Adsdaq Doc",
        "description" => "Show confluence doc into Adsdaq",
        "baseUrl" => "http://doc.adsdaq.dev/",
        "vendor" => [
            "name" => "Adlogix",
            "url" => "https://www.adlogix.eu"
        ],
        "version" => "0.1",
        "scopes" => [
            "read"
        ],
        "lifecycle" => [
            "installed" => '/installed',
            "enabled" => '/enabled'
        ]
]);


$serializer = SerializerBuilder::create()
    ->addMetadataDir(__DIR__ . '/src/Adlogix/Confluence/Client/Resources/serializer', 'Adlogix\Confluence\Client')
    ->addDefaultHandlers()
    ->build();


$payload = file_get_contents('payload.json');
$securityContext = $serializer->deserialize($payload, 'Adlogix\Confluence\Client\Entity\Connect\SecurityContext',
    'json');
$descriptor = $serializer->deserialize($descriptor, 'Adlogix\Confluence\Client\Entity\Connect\Descriptor', 'json');


$client = ClientBuilder::create(
    'http://confluence.dev/confluence',
    new ConnectJwtAuthentication(
        $securityContext,
        $descriptor
    )
)
    ->setDebug(true)
    ->build();

$authentication = $client->authentication();
$token = $authentication->getToken();
try {
    //$response = $spaces->all();
    //var_dump($authentication);
    var_dump($token);


    var_dump($token->sign(false));
    var_dump($client->spaces()->all());

    var_dump($client->spaces()->byKey('ds'));

} catch (ApiException $ex) {
    var_dump($ex->getApiError());
}
