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

namespace Adlogix\Confluence\Client\HttpClient;

/**
 * Class HttpClient
 * @package Adlogix\Confluence\Client\HttpClient
 * @author Cedric Michaux <cedric@adlogix.eu>
 */
class HttpClient implements HttpClientInterface
{

    /**
     * {@inheritdoc}
     */
    public function get($uri, array $options = [])
    {
        // TODO: Implement get() method.
    }

    /**
     * {@inheritdoc}
     */
    public function post($uri, $json, array $options = [])
    {
        // TODO: Implement post() method.
    }

    /**
     * {@inheritdoc}
     */
    public function put($uri, $json, array $options = [])
    {
        // TODO: Implement put() method.
    }

    /**
     * {@inheritdoc}
     */
    public function patch($uri, $json, array $options = [])
    {
        // TODO: Implement patch() method.
    }

    /**
     * {@inheritdoc}
     */
    public function delete($uri, array $options = [])
    {
        // TODO: Implement delete() method.
    }

    /**
     * {@inheritdoc}
     */
    public function request($method, $uri, $json = null, array $options = [])
    {
        // TODO: Implement request() method.
    }
}
