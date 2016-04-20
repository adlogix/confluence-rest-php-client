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

/**
 * Class Descriptor
 * The descriptor is the description of your add-on.
 *
 * @see https://developer.atlassian.com/static/connect/docs/latest/modules/
 *      
 * You can validate it's output there:
 * @see https://atlassian-connect-validator.herokuapp.com/validate
 *
 * @package Adlogix\Confluence\Client\Entity\Connect
 * @author  Cedric Michaux <cedric@adlogix.eu>
 */
class Descriptor implements DescriptorInterface
{
    /**
     * @var string
     */
    private $authentication;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $enableLicensing;
    
    /**
     * @var array
     */
    private $lifecycle;

    /**
     * @var DescriptorLink
     */
    private $links;
    
    
    /**
     * @var string
     */
    private $name;


    /**
     * @var DescriptorVendor
     */
    private $vendor;

    /**
     * @var array
     */
    private $scopes;

    /**
     * {@inheritdoc}
     */
    public function __construct($baseUrl, $key)
    {
        if(strlen($key) >= 80){
            throw new \InvalidArgumentException('Atlassian requires that the application key is less than or equals to 80 characters');
        }

        if(preg_match('/^[a-zA-Z0-9-._]+$/', $key) !== 1){
            throw new \InvalidArgumentException('Invalid character : The application key may only contain characters including ".", "_", "-" and alphanumeric characters');
        }

        $this->baseUrl = $baseUrl;
        $this->key = $key;

        $this->lifecycle = new DescriptorLifecycle();
        $this->links = new DescriptorLink();
    }


    /**
     * @return string
     */
    public function getAuthentication()
    {
        return $this->authentication;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthentication(DescriptorAuthentication $authentication)
    {
        $this->authentication = $authentication;
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
     * @return Descriptor
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return Descriptor
     */
    public function setKey($key)
    {
        $this->key = $key;
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
     * @return Descriptor
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnableLicensing()
    {
        return $this->enableLicensing;
    }

    /**
     * @param boolean $enableLicensing
     *
     * @return Descriptor
     */
    public function setEnableLicensing($enableLicensing)
    {
        $this->enableLicensing = $enableLicensing;
        return $this;
    }

    /**
     * @return array
     */
    public function getLifecycle()
    {
        return $this->lifecycle;
    }

    /**
     * @param DescriptorLifecycle $lifecycle
     *
     * @return Descriptor
     */
    public function setLifecycle(DescriptorLifecycle $lifecycle)
    {
        $this->lifecycle = $lifecycle;
        return $this;
    }

    /**
     * @return DescriptorLink
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param DescriptorLink $links
     *
     * @return Descriptor
     */
    public function setLinks($links)
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Descriptor
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return DescriptorVendor
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param DescriptorVendor $vendor
     *
     * @return Descriptor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
        return $this;
    }

    /**
     * @param array $scopes
     *
     * @return Descriptor
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
        return $this;
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }


}
