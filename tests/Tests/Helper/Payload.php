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


namespace Adlogix\ConfluenceClient\Tests\Helper;


/**
 * Class Payload
 * @package Adlogix\ConfluenceClient\Tests\Helper
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class Payload
{

    /**
     * @var array
     */
    private $payload = [];

    /**
     * @var string
     */
    private $sharedSecret = '';

    /**
     * @var string
     */
    private $baseUrl = '';

    public function __construct($file)
    {
        if (file_exists($file)) {
            $this->payload = json_decode(file_get_contents('payload.json'));
            $this->sharedSecret = $this->payload->sharedSecret;
            $this->baseUrl = $this->payload->baseUrl . '/';
        }
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     *
     * @return Payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return string
     */
    public function getSharedSecret()
    {
        return $this->sharedSecret;
    }

    /**
     * @param string $sharedSecret
     *
     * @return Payload
     */
    public function setSharedSecret($sharedSecret)
    {
        $this->sharedSecret = $sharedSecret;
        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     *
     * @return Payload
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }
}
