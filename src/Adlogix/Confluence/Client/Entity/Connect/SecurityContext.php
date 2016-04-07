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

namespace Adlogix\Confluence\Client\Entity\Connect;


class SecurityContext
{

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $clientKey;

    /**
     * @var string
     */
    private $publicKey;


    /**
     * @var string
     */
    private $sharedSecret;

    /**
     * @var string
     */
    private $serverVersion;

    /**
     * @var string
     */
    private $pluginsVersion;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $productType;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $serviceEntitlementNumber;

    /**
     * @var string
     */
    private $eventType;

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return SecurityContext
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientKey()
    {
        return $this->clientKey;
    }

    /**
     * @param string $clientKey
     *
     * @return SecurityContext
     */
    public function setClientKey($clientKey)
    {
        $this->clientKey = $clientKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param string $publicKey
     *
     * @return SecurityContext
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
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
     * @return SecurityContext
     */
    public function setSharedSecret($sharedSecret)
    {
        $this->sharedSecret = $sharedSecret;
        return $this;
    }

    /**
     * @return string
     */
    public function getServerVersion()
    {
        return $this->serverVersion;
    }

    /**
     * @param string $serverVersion
     *
     * @return SecurityContext
     */
    public function setServerVersion($serverVersion)
    {
        $this->serverVersion = $serverVersion;
        return $this;
    }

    /**
     * @return string
     */
    public function getPluginsVersion()
    {
        return $this->pluginsVersion;
    }

    /**
     * @param string $pluginsVersion
     *
     * @return SecurityContext
     */
    public function setPluginsVersion($pluginsVersion)
    {
        $this->pluginsVersion = $pluginsVersion;
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
     * @return SecurityContext
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @param string $productType
     *
     * @return SecurityContext
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return SecurityContext
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getServiceEntitlementNumber()
    {
        return $this->serviceEntitlementNumber;
    }

    /**
     * @param string $serviceEntitlementNumber
     *
     * @return SecurityContext
     */
    public function setServiceEntitlementNumber($serviceEntitlementNumber)
    {
        $this->serviceEntitlementNumber = $serviceEntitlementNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param string $eventType
     *
     * @return SecurityContext
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
        return $this;
    }
}
