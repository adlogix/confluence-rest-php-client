# Confluence REST API PHP Client

An Object Oriented wrapper for Confluence, written PHP5

## Requirements

* PHP >= 5.5.0

## Installation

```json
{
    "require": {
        "adlogix-ondemand/confluence-rest-php-client": "dev-master"
    },
    {
      "type": "vcs",
      "url": "git@bitbucket.org:adlogix-ondemand/confluence-rest-php-client.git"
    }
}
```

## Playground

You'll probably want to fiddle with this client, we can understand that, but you'll need to setup your computer to use the /!\ [atlassian-plugin-sdk](). Just kidding, if you have docker installed, you just have to run `docker-compose up -d` to setup your own test environment.
**The first launch can take 30+ minutes.** After that Confluence will sit on your computer so it will be much faster to launch. To check the advancement of the Confluence deployment run `docker-compose logs confluence`.

So now that everything is up and running you have some servers that runs. If you use [jwilder/nginx-proxy]() and setup you hosts (or use [dnsmasq]()) accordingly:

* Confluence, running at http://confluence.dev/confluence
* Our PHP server, responding at http://atlassianconnect.dev

### Initial config.

In order to use confluence and be able to make REST calls to it's API we have some config to do:

1. Go to Confluence's [General Configuration](http://confluence.dev/confluence/admin/viewgeneralconfig.action) page and set the server base url to http://confluence.dev/confluence
2. Go to [Manage Add-ons](http://confluence.dev/confluence/plugins/servlet/upm) page
3. Click on _Upload add-on_
4. Put _http://atlassianconnect.dev/index.php?action=descriptor_ in the field and click upload



## Basic usage of `confluence-rest-php-client` client

Based on [AtlassianConnect documentation](https://developer.atlassian.com/static/connect/docs/latest/guides/introduction.html) just with just with read access implemented

