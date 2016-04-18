<?php
require_once 'vendor/autoload.php';


use Adlogix\Confluence\Client\ClientBuilder;
use Adlogix\Confluence\Client\Entity\Connect\Descriptor;
use Adlogix\Confluence\Client\Entity\Connect\DescriptorLifecycle;
use Adlogix\Confluence\Client\Entity\Connect\SecurityContext;
use Adlogix\Confluence\Client\Security\Authentication\JwtHeaderAuthentication;
use GuzzleHttp\Psr7\Uri;

/**
 * The Lifecycle is mandatory since Confluence needs to contact the application.
 * So you need to implement those endpoints. Minimal is to send a 200 OK header.
 * When Confluence calls those webhooks, it will send you a payload with some information.
 * @see https://developer.atlassian.com/static/connect/docs/latest/modules/lifecycle.html
 *
 * Installed => called when the plugin is installed on an instance
 * Enabled => called when the plugin is enabled on an instance. If you don't supply that the plugin is installable but can't be enabled
 */
$lifecycle = new DescriptorLifecycle();
$lifecycle
    ->setInstalled('/installed')
    ->setEnabled('/enabled');


/**
 * The descriptor is the description of your plugin.
 * This one is the minimum to have read access on Confluence.
 * The authentication method will be set depending on the authentication you pass at the client builder later
 *
 * @see https://developer.atlassian.com/static/connect/docs/latest/modules/
 *
 * You can validate it's output there:
 * @see https://atlassian-connect-validator.herokuapp.com/validate
 */
$descriptor = new Descriptor(
    "http://atlassianconnect.dev/",
    'dev.mypluginkey'
);

$descriptor->setLifecycle($lifecycle)
    ->setScopes([
        'read'
    ]);

/**
 * The Security Context is that payload you received upon installation.
 * It is needed to be able to sign the Authentication Token
 */
$securityContext = new SecurityContext();

/**
 * The only needed information is the shared secret.
 */
if (file_exists('payload.json')) {
    $payload = json_decode(file_get_contents('payload.json'));
    $securityContext->setSharedSecret($payload->sharedSecret);
}

/**
 * Actually building our client.
 */
$client = ClientBuilder::create(
    'http://confluence.dev/confluence',
    new JwtHeaderAuthentication(
        $securityContext,
        $descriptor
    )
)
    ->setDebug(true)
    ->build();


$url = new Uri(@$_SERVER['REQUEST_URI']);
switch ($url->getPath()) {
    case '/descriptor.json':
        // Show our descriptor
        echo $client->descriptor()->get();
        break;

    case '/installed':
        //Installation webhook
        file_put_contents('payload.json', file_get_contents('php://input'));
        http_response_code(200);
        echo 'OK';
        break;

    case '/enabled':
        //Enabled webhook.
        http_response_code(200);
        echo 'OK';
        break;

    default:
        // When no action is given, just run test code.
        try {
            var_dump($client->spaces()->all());
        } catch (ApiException $ex) {
            var_dump($ex->getApiError());
        }

        break;
}

