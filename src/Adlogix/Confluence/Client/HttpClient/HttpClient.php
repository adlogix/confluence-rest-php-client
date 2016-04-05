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

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Class HttpClient
 * @package Adlogix\Confluence\Client\HttpClient
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class HttpClient implements HttpClientInterface
{

    /**
     * @var Client
     */
    private $client;

    /**
     * HttpClient constructor.
     *
     * @param array                $options
     * @param ClientInterface|null $client
     */
    public function __construct(
        array $options = [],
        ClientInterface $client = null
    ) {
        $this->client = $client ?: new Client($options);
    }

    /**
     * {@inheritdoc}
     */
    public function get($uri, array $options = [])
    {
        return $this->request('GET', $uri, null, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function request($method, $uri, $json = null, array $options = [])
    {
        if(!empty($json)){
            $options['body'] = $json;
            $options['headers']['content-type'] = 'application/json';
        }

        return $this->client->request($method, $uri, $options);
    }
}
