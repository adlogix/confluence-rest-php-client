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

namespace Adlogix\ConfluenceClient;


use Adlogix\ConfluenceClient\Exception\ExceptionWrapper;
use Adlogix\ConfluenceClient\HttpClient\HttpClientInterface;
use Adlogix\ConfluenceClient\Service\AuthenticationService;
use Adlogix\ConfluenceClient\Service\ContentService;
use Adlogix\ConfluenceClient\Service\DescriptorService;
use Adlogix\ConfluenceClient\Service\ServiceInterface;
use Adlogix\ConfluenceClient\Service\SpaceService;
use GuzzleHttp\Exception\RequestException;
use JMS\Serializer\SerializerInterface;

/**
 * Class Client
 * @package Adlogix\ConfluenceClient
 * @author  Cedric Michaux <cedric@adlogix.eu>
 *
 * @method SpaceService spaces
 * @method ContentService pages
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
     * @param HttpClientInterface $httpClient
     * @param SerializerInterface $serializer
     */
    public function __construct(
        HttpClientInterface $httpClient,
        SerializerInterface $serializer
    ) {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
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
                return new SpaceService($this->serializer, $this->httpClient);

            case 'content':
            case 'contents':
                return new ContentService($this->serializer, $this->httpClient);

            default:
                throw new \InvalidArgumentException(sprintf('Undefined service instance called: %s', $name));
        }
    }

    /**
     * @param string $method
     * @param string $uri
     * @param null   $json
     * @param array  $options
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    public function sendRawApiRequest($method, $uri, $json = null, array $options = [])
    {
        try {
            return $this->httpClient->apiRequest($method, $uri, $json, $options);

        } catch (RequestException $exception) {
            throw ExceptionWrapper::wrap($exception, $this->serializer);
        }
    }


    /**
     * @param string $url
     *
     * @param array  $options
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    public function downloadAttachment($url, $options = [])
    {
        try {
            $url = str_replace(" ", "%20", $url);
            return $this->httpClient->attachmentRequest($url, $options);
        } catch (RequestException $exception) {
            throw ExceptionWrapper::wrap($exception, $this->serializer);
        }
    }
}
