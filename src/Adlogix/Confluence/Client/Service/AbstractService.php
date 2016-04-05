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

namespace Adlogix\Confluence\Client\Service;

use Adlogix\Confluence\Client\Exception\ExceptionWrapper;
use Adlogix\Confluence\Client\HttpClient\HttpClientInterface;
use GuzzleHttp\Exception\RequestException;
use JMS\Serializer\SerializerInterface;

/**
 * Class AbstractService
 * @package Adlogix\Confluence\Client\Service
 * @author Cedric Michaux <cedric@adlogix.eu>
 */
class AbstractService implements ServiceInterface
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * AbstractService constructor.
     * @param HttpClientInterface $httpClient
     * @param SerializerInterface $serializer
     */
    public function __construct(HttpClientInterface $httpClient, SerializerInterface $serializer)
    {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
    }

    protected function get($uri, array $options = [])
    {
        try {
            $response = $this->httpClient
                ->get($uri, $options);

            return $response->getBody()
                ->getContents();
            
        } catch (RequestException $exception) {
            throw ExceptionWrapper::wrap($exception, $this->serializer);
        }
    }

}
