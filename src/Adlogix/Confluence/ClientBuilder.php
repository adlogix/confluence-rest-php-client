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

namespace Adlogix\Confluence;


use Adlogix\Confluence\HttpClient\Middleware\AuthenticationMiddleware;
use Adlogix\Confluence\Security\AuthenticationInterface;
use GuzzleHttp\HandlerStack;

/**
 * Class ClientBuilder
 * @package Adlogix\Confluence
 * @author Cedric Michaux <cedric@adlogix.eu>
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
     * @var
     */
    private $serializer;

    /**
     * @var boolean
     */
    private $debug;


    /**
     * @param string $baseUri
     * @param AuthenticationInterface $authentication
     * @return ClientBuilder
     */
    public static function create($baseUri, AuthenticationInterface $authentication)
    {
        return new static($baseUri, $authentication);
    }


    public function __construct($baseUri, AuthenticationInterface $authentication)
    {
        $this->authentication = $authentication;
        
        if (empty($baseUri)) {
            throw new \InvalidArgumentException("The baseUri cannot be empty");
        }
        $this->baseUri = $baseUri;
    }

    public function build()
    {

        $this->serializer = $this->serializer ?: $this->buildDefaultSerializer();

        $stack = HandlerStack::create();

        $stack->push(new AuthenticationMiddleware($this->authentication));


    }


    public function setSerializer($serializer)
    {
        $this->serializer = $serializer;
    }


    /**
     * @param boolean $debug
     * @return $this
     */
    public function setDebug($debug)
    {
        $this->debug = (bool)$debug;
        return $this;
    }

    private function buildDefaultSerializer()
    {

    }
}
