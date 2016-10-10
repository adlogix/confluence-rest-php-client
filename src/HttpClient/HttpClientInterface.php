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

namespace Adlogix\ConfluenceClient\HttpClient;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

/**
 * Interface HttpClientInterface
 * @package Adlogix\ConfluenceClient\HttpClient
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
interface HttpClientInterface
{

    /**
     * HttpClient constructor.
     *
     * @param array                $options
     * @param ClientInterface|null $client
     */
    public function __construct(array $options = [], ClientInterface $client = null);

    /**
     * Send a GET request.
     *
     * @param string $uri Request path
     * @param array  $options
     *
     * @return Response
     */
    public function get($uri, array $options = []);

    /**
     * @param string $uri
     * @param string $json
     * @param array  $options
     *
     * @return Response
     */
    public function post($uri, $json, array $options = []);

    /**
     * @param string $uri
     * @param string $json
     * @param array  $options
     *
     * @return Response
     */
    public function put($uri, $json, array $options = []);

    /**
     * @param string $uri
     * @param array  $options
     *
     * @return Response
     */
    public function delete($uri, array $options = []);

    /**
     * @param string      $method
     * @param string      $uri
     * @param string|null $json
     * @param array       $options
     *
     * @return Response
     */
    public function apiRequest($method, $uri, $json = null, array $options = []);

    /**
     * @param string $uri
     *
     * @param array  $options
     *
     * @return Response
     */
    public function attachmentRequest($uri, array $options = []);
}
