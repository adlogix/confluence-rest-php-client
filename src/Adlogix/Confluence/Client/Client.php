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

namespace Adlogix\Confluence\Client;


use Adlogix\Confluence\Client\Exception\ExceptionWrapper;
use Adlogix\Confluence\Client\HttpClient\HttpClientInterface;
use Adlogix\Confluence\Client\Security\Authentication\AuthenticationInterface;
use Adlogix\Confluence\Client\Service\AuthenticationService;
use Adlogix\Confluence\Client\Service\DescriptorService;
use Adlogix\Confluence\Client\Service\ContentService;
use Adlogix\Confluence\Client\Service\ServiceInterface;
use Adlogix\Confluence\Client\Service\SpaceService;
use GuzzleHttp\Exception\RequestException;
use JMS\Serializer\SerializerInterface;

/**
 * Class Client
 * @package Adlogix\Confluence\Client
 * @author  Cedric Michaux <cedric@adlogix.eu>
 *
 * @method SpaceService spaces
 * @method ContentService pages
 * @method DescriptorService descriptor
 * @method AuthenticationService authentication
 */
class Client
{

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var SerializerInterface
     */
    private $serializer;



    /**
     * Client constructor.
     *
     * @param HttpClientInterface     $httpClient
     * @param SerializerInterface     $serializer
     */
    public function __construct(
        HttpClientInterface $httpClient,
        SerializerInterface $serializer
    ) {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
    }


    /**
     * @param $name
     *
     * @return ServiceInterface
     */
    public function service($name)
    {
        switch ($name) {
            case 'space':
            case 'spaces':
                $service = new SpaceService($this->serializer, $this->httpClient);
                break;

            case 'content':
            case 'contents':
                $service = new ContentService($this->serializer, $this->httpClient);
                break;

            case 'content':
            case 'contents':
                $service = new ContentService($this->serializer, $this->httpClient);
                break;

            default:
                throw new \InvalidArgumentException(sprintf('Undefined service instance called: %s', $name));
        }

        return $service;
    }

    /**
     * @param string $name
     * @param        $args
     *
     * @return ServiceInterface
     */
    public function __call($name, $args)
    {
        return $this->service($name);
    }


    public function sendRawApiRequest($method, $uri, $json = null, array $options = [])
    {
        try {
            return $this->httpClient->request($method, '/rest/api/'.$uri, $json, $options);

        } catch (RequestException $exception) {
            throw ExceptionWrapper::wrap($exception, $this->serializer);
        }
    }


    public function sendRawAttachmentRequest($uri, array $options = [])
    {
        try {
            return $this->httpClient->request("GET", $uri, null, $options);

        } catch (RequestException $exception) {
            throw ExceptionWrapper::wrap($exception, $this->serializer);
        }
    }
}
