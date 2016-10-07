<?php
use Adlogix\ConfluenceClient\ClientBuilder;
use Adlogix\ConfluenceClient\Security\HeaderAuthentication;
use Adlogix\ConfluenceClient\Security\QueryParamAuthentication;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

require_once 'vendor/autoload.php';


/**
 * See the 'installed' webhook on how to recover this payload.
 *
 * The sharedSecret is given by the application we installed the add-on to,
 * this is needed to sign our request and to validate the requests from the application.
 */
$sharedSecret = '';
$baseUrl = '';
if (file_exists('payload.json')) {
    $payload = json_decode(file_get_contents('payload.json'));
    $sharedSecret = $payload->sharedSecret;
    $baseUrl = $payload->baseUrl.'/rest/api/';
}


$authenticationMethod = new QueryParamAuthentication('eu.adlogix.confluence-client', $sharedSecret);
$client = ClientBuilder::create($baseUrl, $authenticationMethod)
            ->setDebug(true)
            ->build();



/**
 * Since Confluence needs to reach our application to post some information, like the sharedSecret, we have to define some routes.
 * At time of writing Confluence refuses to contact us if the route contains .php so we need to prettify our URLS.
 * Our sample is not the best way to do it, but it's just for the demo.
 */


$app = new Application();
$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

/**
 * Our sample descriptor is available at http://confluence-client.dev/descriptor.json
 *
 * This is the bare minimal descriptor to be defined.
 *
 * You can validate your descriptor
 * @see https://atlassian-connect-validator.herokuapp.com/validate
 */
$app->get('/descriptor.json', function (Request $request) {

    /*
     * We have to construct the correct URL in order to confluence be able to contact us
     * And the scheme MUST be https in order to confluence accept it.
     */
    $host = $request->getHttpHost();
    $scheme = $request->getScheme();

    if (preg_match('/\.ngrok\.io/', $host)) {
        $scheme = 'https';
    }


    return json_encode([
        'authentication' => [
            'type' => 'jwt'
        ],
        'baseUrl'        => $scheme . '://' . $host,
        'scopes'         => [
            'read'
        ],
        'key'            => 'eu.adlogix.confluence-client',
        'lifecycle'      => [
            'installed' => '/installed',
            'enabled'   => '/enabled'
        ],
    ]);
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
    return new \Symfony\Component\HttpFoundation\Response('OK', 200);
});


/**
 * Even if the documentation tell's you the only needed webhook is the installed one,
 * they won't let you enable the add-on unless you define the route to you 'enabled' webhook.
 */
$app->post('/enabled', function () {
    /**
     * Be sure to send a 200 OK response, or the app will tell you that your plugin can't be enabled.
     */
    return new \Symfony\Component\HttpFoundation\Response('OK', 200);
});

//Catch all route to run our test code
$app->match('/api/{url}', function ($url) use ($client) {
    $client->sendRawRequest('GET', $url);
})->assert('url', '.+');

$app->match('/', function (Application $app) {
   return $app['twig']->render("index.html.twig");
});


$app->run();

//https://adlogixdevelopers.atlassian.net/wiki/download/attachments/197331/Import-ratecard-excel.png?version=1&modificationDate=1459859654044&api=v2
