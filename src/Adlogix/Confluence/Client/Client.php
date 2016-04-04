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


use Adlogix\Confluence\Client\HttpClient\HttpClientInterface;
use Adlogix\Confluence\Client\Service\ServiceInterface;
use JMS\Serializer\SerializerInterface;

/**
 * Class Client
 * @package Adlogix\Confluence\Client
 * @author Cedric Michaux <cedric@adlogix.eu>
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
     * @param HttpClientInterface $httpClient
     * @param SerializerInterface $serializer
     */
    public function __construct(HttpClientInterface $httpClient, SerializerInterface $serializer)
    {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
    }


    public function service()
    {

    }

    /**
     * @param string $name
     * @param $args
     * @return ServiceInterface
     */
    public function __call($name, $args)
    {
        return $this->service($name);
    }

}
