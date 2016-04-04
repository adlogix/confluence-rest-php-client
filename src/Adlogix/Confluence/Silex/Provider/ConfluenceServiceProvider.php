<?php
/*
 * This file is part of the Adlogix package.
 *
 * (c) Allan Segebarth <allan@adlogix.eu>
 * (c) Jean-Jacques Courtens <jjc@adlogix.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Adlogix\Confluence\Silex\Provider;

use Adlogix\Confluence\Service\Confluence;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class ConfluenceServiceProvider
 * @package Adlogix\Confluence\Silex\Provider
 * @author Cedric Michaux <cedric@adlogix.eu>
 */
class ConfluenceServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['confluence'] = $app->share(function ($app) {

            if (!isset($app['confluence.uri'])) {
                throw new \Exception('Parameter confluence.uri should be defined');
            }


            $login = !empty($app['confluence.login']) ? $app['confluence.login'] : null;

            $pass = !empty($app['confluence.password']) ? $app['confluence.password'] : null;

            $confluenceService = new Confluence($app['confluence.uri'], $login, $pass);

            return $confluenceService;
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}
