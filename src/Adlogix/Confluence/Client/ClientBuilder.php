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

use Adlogix\Confluence\Client\HttpClient\HttpClient;
use Adlogix\GuzzleAtlassianConnect\Middleware\ConnectMiddleware;
use Adlogix\GuzzleAtlassianConnect\Security\AuthenticationInterface;
use GuzzleHttp\HandlerStack;
use JMS\Serializer\SerializerBuilder;


/**
 * Class ClientBuilder
 * @package Adlogix\Confluence\Client
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class ClientBuilder
{

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var AuthenticationInterface
     */
    private $authentication;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var boolean
     */
    private $debug;


    /**
     * @param string                  $baseUri
     * @param AuthenticationInterface $authenticationMethod
     *
     * @return ClientBuilder
     */
    public static function create($baseUri, AuthenticationInterface $authenticationMethod)
    {
        return new static($baseUri, $authenticationMethod);
    }

    /**
     * ClientBuilder constructor.
     *
     * @param                                                        $baseUri
     * @param AuthenticationInterface                                $authentication
     */
    private function __construct($baseUri, AuthenticationInterface $authentication)
    {
        $this->authentication = $authentication;

        if (empty($baseUri)) {
            throw new \InvalidArgumentException("The baseUri cannot be empty");
        }
        $this->baseUri = $baseUri;
    }

    /**
     * @return Client
     */
    public function build()
    {
        $this->serializer = $this->serializer ?: $this->buildDefaultSerializer();
        $stack = HandlerStack::create();
        $stack->push(new ConnectMiddleware($this->authentication, $this->baseUri));
        

        return new Client(
            new HttpClient([
                'base_uri' => $this->baseUri,
                'handler' => $stack,
                'debug' => $this->debug
            ]),
            $this->serializer,
            $this->authentication
        );
    }

    /**
     * @param SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    /**
     * @param boolean $debug
     *
     * @return $this
     */
    public function setDebug($debug)
    {
        $this->debug = (bool)$debug;
        return $this;
    }

    private function buildDefaultSerializer()
    {
        return SerializerBuilder::create()
            ->addMetadataDir(__DIR__ . '/Resources/serializer', __NAMESPACE__)
            ->addDefaultHandlers()
            ->build();
    }
}
