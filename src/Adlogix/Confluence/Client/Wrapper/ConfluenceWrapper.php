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

namespace Adlogix\Confluence\Client\Wrapper;

use Adlogix\Confluence\Exception\UserException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;

/**
 * Class ConfluenceWrapper
 * @package Adlogix\Confluence\Wrapper
 * @author Cedric Michaux <cedric@adlogix.eu>
 */
class ConfluenceWrapper
{

    /**
     * @var Client
     */
    private $client;

    /**
     * ConfluenceWrapper constructor.
     *
     * @param             $baseUrl
     * @param string|null $user
     * @param string|null $pass
     */
    public function __construct($baseUrl, $user = null, $pass = null)
    {

        $params = [
            'base_uri' => $baseUrl
        ];

        if (empty($user)) {
            throw new \InvalidArgumentException('User needs to be defined');
        }
        if (empty($pass)) {
            throw new \InvalidArgumentException('Password needs to be defined');
        }

        if (!empty($user) && !empty($pass)) {
            $params['auth'] = [$user, $pass, 'basic'];
        }

        $this->client = new Client($params);

    }

    /**
     *
     */
    public function getSpaces()
    {

        try {
            $response = $this->client->get('space');

            if (200 != $response->getStatusCode()) {
                throw new \LogicException(sprintf('Got code %s. Was expecting 200', $response->getStatusCode()),
                    $response->getStatusCode());
            }

            $content = json_decode($response->getBody());

            return $content;
        } catch (ClientException $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }

    }

    /**
     * @param        $requestUri
     * @param string $httpMethod
     * @param        $headers
     * @param        $body
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendRequest(
        $requestUri,
        $httpMethod = 'GET',
        array $headers = [],
        $body = null
    ) {
        $request = new Request($httpMethod, $requestUri, $headers, $body);
        return $this->client->send($request);
    }
}
