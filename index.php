<?php
use Adlogix\ConfluenceClient\ClientBuilder;
use Adlogix\ConfluenceClient\Entity\Descriptor;
use Adlogix\ConfluenceClient\Security\QueryParamAuthentication;
use Adlogix\ConfluenceClient\Tests\Helper\Payload;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once 'vendor/autoload.php';


/**
 * See the 'installed' webhook on how to recover this payload.
 *
 * The sharedSecret is given by the application we installed the add-on to,
 * this is needed to sign our request and to validate the requests from the application.
 */

$payload = new Payload('payload.json');
$applicationKey = 'eu.adlogix.confluence-client';


$authenticationMethod = new QueryParamAuthentication($applicationKey, $payload->getSharedSecret());
$client = ClientBuilder::create($payload->getBaseUrl(), $authenticationMethod)
    ->build();


/**
 * Since Confluence needs to reach our application to post some information, like the sharedSecret, we have to define some routes.
 * At time of writing Confluence refuses to contact us if the route contains .php so we need to prettify our URLS.
 * Our sample is not the best way to do it, but it's just for the demo.
 */


$app = new Application();
$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));

/**
 * Our sample descriptor is available at http://confluence-client.dev/descriptor.json
 *
 * This is the bare minimal descriptor to be defined.
 *
 * You can validate your descriptor
 * @see https://atlassian-connect-validator.herokuapp.com/validate
 */
$app->get('/descriptor.json', function (Request $request) use ($applicationKey) {

    /*
     * We have to construct the correct URL in order to confluence be able to contact us
     * And the scheme MUST be https in order to confluence accept it.
     */
    $host = $request->getHttpHost();
    $scheme = $request->getScheme();

    if (preg_match('/\.ngrok\.io/', $host)) {
        $scheme = 'https';
    }

    $descriptor = new Descriptor($scheme . '://' . $host, $applicationKey);

    $descriptor->addScope(Descriptor::SCOPE_READ)
        ->setLifecycleWebhooks(
            '/installed',
            '/enabled'
        );

    return $descriptor->getJson();
});

/**
 * When we install our add-on into any atlassian app, they will contact us at the URL we define in the 'installed' lifecycle.
 * They will give us a payload containing the sharedSecret we'll need to use to sign our request.
 * For the demo we just save the content to a file.
 */
$app->post('/installed', function (Request $request) {

    $payload = $request->getContent();
    file_put_contents('payload.json', $payload);

    /**
     * Be sure to send a 200 OK response, or the app will tell you that your plugin can't be installed.
     */
    return new Response('OK', 200);
});


/**
 * Even if the documentation tell's you the only needed webhook is the installed one,
 * they won't let you enable the add-on unless you define the route to you 'enabled' webhook.
 */
$app->post('/enabled', function () {
    /**
     * Be sure to send a 200 OK response, or the app will tell you that your plugin can't be enabled.
     */
    return new Response('OK', 200);
});

//Catch all route to run our test code
$app->match('/api/{url}', function ($url) use ($client) {
    $response = $client->sendRawApiRequest('GET', $url);
    $content = $response->getBody()->getContents();
    return new Response($content, $response->getStatusCode());

})->assert('url', '.+');

$app->match('/image/{url}', function ($url) use ($client) {
    $response = $client->downloadAttachment($url);
    $content = $response->getBody()->getContents();
    return new Response($content, $response->getStatusCode(), $response->getHeaders());
})->assert('url', '.+');

$app->match('/', function (Application $app) {
    return $app['twig']->render("index.html.twig");
});

$app->run();
