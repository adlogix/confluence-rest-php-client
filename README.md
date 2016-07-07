# Confluence REST API PHP Client

An Object Oriented wrapper for Confluence, written PHP5

## Requirements

* PHP >= 5.5.0

## Installation

```bash
$ php composer.phar require adlogix/confluence-rest-php-client
```

## Minimal Usage

```PHP

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
$lifecycle->setInstalled('/installed');
    //->setEnabled('/enabled');


/**
 * The descriptor is the description of your plugin.
 * This one is the minimum to have read access on Confluence.
 * The authentication method will be set depending on the authentication you pass at the client builder later
 *
 * @see https://developer.atlassian.com/static/connect/docs/latest/modules/
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
```

## Playground

You'll probably want to fiddle with this client, we can understand that, but you'll need to setup your computer to use the /!\ [atlassian-plugin-sdk](). Just kidding, if you have docker installed, you just have to run `docker-compose up -d` to setup your own test environment.
**The first launch can take 30+ minutes.** After that Confluence will sit on your computer so it will be much faster to launch. To check the advancement of the Confluence deployment run `docker-compose logs confluence`.

So now that everything is up and running you have some servers that runs. If you use [jwilder/nginx-proxy]() and setup you hosts (or use [dnsmasq]()) accordingly:

* Confluence, running at http://confluence.dev/confluence
* Our PHP server, responding at http://atlassianconnect.dev

### Initial config.

In order to use confluence and be able to make REST calls to it's API we have some config to do:

_The default login:password is admin:admin_

1. Go to Confluence's [General Configuration](http://confluence.dev/confluence/admin/viewgeneralconfig.action) page and set the server base url to http://confluence.dev/confluence
2. Go to [Manage Add-ons](http://confluence.dev/confluence/plugins/servlet/upm) page
3. Click on _Upload add-on_
4. Put _http://atlassianconnect.dev/descriptor.json_ in the field and click upload
5. You can now make requests to confluence rest api...

## Basic usage of `confluence-rest-php-client` client

Based on [AtlassianConnect documentation](https://developer.atlassian.com/static/connect/docs/latest/guides/introduction.html) just with just with read access implemented

