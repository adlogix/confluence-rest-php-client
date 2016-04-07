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


use Adlogix\Confluence\Client\Entity\Connect\SecurityContext;
use Adlogix\Confluence\Client\HttpClient\HttpClientInterface;
use Adlogix\Confluence\Client\Security\AuthenticationInterface;
use Adlogix\Confluence\Client\Service\AuthenticationService;
use Adlogix\Confluence\Client\Service\DescriptorService;
use Adlogix\Confluence\Client\Service\PageService;
use Adlogix\Confluence\Client\Service\ServiceInterface;
use Adlogix\Confluence\Client\Service\SpaceService;
use JMS\Serializer\SerializerInterface;

/**
 * Class Client
 * @package Adlogix\Confluence\Client
 * @author  Cedric Michaux <cedric@adlogix.eu>
 *
 * @method SpaceService spaces
 * @method PageService pages
 * @method DescriptorService descriptor
 * @method AuthenticationService autentication
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
     * @var AuthenticationInterface
     */
    private $authentication;


    /**
     * Client constructor.
     *
     * @param HttpClientInterface $httpClient
     * @param SerializerInterface $serializer
     * @param AuthenticationInterface $authentication
     */
    public function __construct(
        HttpClientInterface $httpClient,
        SerializerInterface $serializer,
        AuthenticationInterface $authentication
    ) {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
        $this->authentication = $authentication;
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

            case 'page':
            case 'pages':
                $service = new PageService($this->serializer, $this->httpClient);
                break;

            case 'descriptor':
                $service = new DescriptorService($this->serializer, $this->authentication);
                break;
            
            case 'authentication':
                $service = new AuthenticationService($this->serializer, $this->authentication);
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


    public function sendRawRequest($method, $uri, $json = null, array $options = [])
    {
        return $this->httpClient->request($method, $uri, $json, $options);
    }
}
